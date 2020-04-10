<?php


namespace App\Http\Controllers\Client;


use App\Cart;
use App\Category;
use App\Color;
use App\Comment;
use App\Http\Requests\CartRequest;
use App\Http\Requests\SendFormRequest;
use App\ImageFeedback;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\Repositories\ProductRepository;
use App\Repositories\Repository;
use App\Status;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Session;

class HomeController
{
    protected $category, $product, $color, $comment, $user, $image_feedback, $status, $order, $order_detail;

    public function __construct(Category $category, Product $product, Color $color, Comment $comment, User $user, ImageFeedback $image_feedback, Status $status, Order $order, OrderDetail $order_detail)
    {
        $this->category = new Repository($category);
        $this->product = new ProductRepository($product);
        $this->color = new Repository($color);
        $this->comment = new Repository($comment);
        $this->user = new Repository($user);
        $this->image_feedback = new Repository($image_feedback);
        $this->status = new Repository($status);
        $this->order = new Repository($order);
        $this->order_detail = new Repository($order_detail);
    }

    public function index()
    {
        $listProduct = $this->product->findThrough('sale_phone', 1);
        $newProducts = $this->product->listNewProduct('id');
        $today = Carbon::now();
        $start_promotion = DB::table('products')->select('start_promotion')->get()[0];
        $end_promotion = DB::table('products')->select('end_promotion')->get()[0];
        $start = (array)$start_promotion;
        $end = (array)$end_promotion;
        return view('client.homepage', compact('listProduct', 'newProducts', 'today', 'start', 'end'));
    }

    public function getDetail($id)
    {
        $product = $this->product->find($id);
        $images = $this->product->with(['image'])
            ->join('images', 'images.product_id', '=', 'products.id')
            ->where('images.deleted_at', null)
            ->where('products.id', '=', $id)
            ->select('images.image', 'images.deleted_at')
            ->get();
        $count = $images->count();
        $today = Carbon::now();
        $start_promotion = DB::table('products')->where('id', '=', $id)->select('start_promotion')->get()[0];
        $end_promotion = DB::table('products')->where('id', '=', $id)->select('end_promotion')->get()[0];
        $start = (array)$start_promotion;
        $end = (array)$end_promotion;
        $comments = $this->comment->findThrough('product_id', $id)->sortByDesc('id');
        foreach ($comments as $key => $comment) {
            $img_cmt[$key] = $this->image_feedback->findThrough('comment_id', $comment->id);
        }
        return view('client.details', compact('product', 'images', 'count', 'start', 'end', 'today', 'comments', 'img_cmt', 'colors'));
    }

    public function getProduct($id)
    {
        $products = $this->product->findThrough('id_cate', $id);
        return view('client.products', compact('products'));
    }

    public function sendInfor()
    {
        $value = session()->get('user_id');
        if ($value == null) {
            return view('client.forminfo');
        }
    }

    public function send(SendFormRequest $request)
    {
        $user = $this->user->create($request->all());
        $user_id = DB::table('users')->latest('id')->first();
        session()->put('user_id', $user_id->id);
        return Response::json($user);
    }

    public function sendCommentAndImageFeedback($id, Request $request)
    {
        DB::beginTransaction();
        try {
            $user = DB::table('users')->latest('id')->first();
            $comment = DB::table('comments')->insert([
                'user_id' => $user->id,
                'product_id' => $id,
                'comment_content' => $request->comment_content,
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ]);
            $comment_id = DB::table('comments')->latest('id')->first();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
        if ($request->image) {
            if ($request->hasfile('image')) {
                foreach ($request->file('image') as $image) {
                    $name = $image->getClientOriginalName();
                    $image->move(public_path() . '/images_feedbacks/', $name);
                    $data[] = $name;
                    DB::table('image_feedbacks')->insert([
                        'image' => $name,
                        'comment_id' => $comment_id->id,
                        "created_at" => date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s'),
                    ]);
                }
            }
            $array = $request->file('image');
            $img_cmt = DB::table('image_feedbacks')->orderBy('id', 'desc')->limit(sizeof($array))->get();
            return Response::json(['comment_id' => $comment_id, 'user' => $user, 'img_cmt' => $img_cmt]);
        } else {
            return Response::json(['comment_id' => $comment_id, 'user' => $user]);
        }

    }

    public function addToCart($id, Request $request)
    {
        $product = $this->getListProduct($id);
        $oldCart = Session('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product[0], $id);
        $request->session()->put('cart', $cart);
        return redirect()->route('order.item');
    }

    public function getListProduct($id)
    {
        $select = [
            'products.*',
            'c.color_name'
        ];
        return Product::leftJoin('colors as c', 'products.id', '=', 'c.product_id')
            ->where('products.id', $id)
            ->select($select)->get();
    }

    public function getDelItemCart($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
            return response()->json([
                'redirect' => route('complete-order')
            ]);
        }
        return Response::json(['cart' => $cart]);
    }

    public function orderItem()
    {
        $customer_info = session()->get('customer_info');
        return view('client.cart', compact('customer_info'));
    }

    public function sendOrder(CartRequest $request)
    {
        $status_id = $this->status->search('status_name', "Chưa duyệt")->get('id')[0]->id;
        DB::beginTransaction();
        try {
            $cart = Session::get('cart');
            $customer_info = session()->get('customer_info');
            $data = [
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'deliverer_id' => 0,
                'delivery_address' => $request->delivery_address,
                'note' => $request->note,
                'status_id' => $status_id,
                'total_price' => $request->total_price,
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ];
            $this->order->create($data);
            $order = DB::table('orders')->orderBy('id', 'desc')->limit(1)->get();
            $customer = [
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
            ];
            $request->session()->push('customer_info', $customer);
            $productList = [];
            foreach ($cart->items as $key => $value) {
                array_push($productList, $value['item']);
            }
            $records = [];
            for ($i = 0; $i < sizeof($productList); $i++) {
                $color[$i] = DB::table('colors')->where('deleted_at', null)->where('product_id', '=', $key)->where('color_name', 'like', "%" . $request->color_id[$i] . "%")->get('id')[0]->id;
                array_push($records, [$productList[$i], $color[$i], $request->sale_quantity[$i]]);
            }
            foreach ($records as $record) {
                if ($record[0]->start_promotion <= \Carbon\Carbon::now() && \Carbon\Carbon::now() <= $record[0]->end_promotion) {
                    $real_price = $record[0]->promotion_price;
                } else {
                    $real_price = $record[0]->price;
                }
                $order_detail = $this->order_detail->create(
                    [
                        'order_id' => $order[0]->id,
                        'product_id' => $record[0]->id,
                        'price' => $real_price,
                        'sale_quantity' => $record[2],
                        'color_id' => $record[1],
                        "created_at" => date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s'),
                    ]
                );
                $sale_quantity = DB::table('order_details')->where('product_id', $record[0]->id)->count();
                DB::table('sale_phones')->where('phone_id', $record[0]->id)->update(['quantity' => $sale_quantity]);
            }
            if ($customer_info) {
                DB::table('orders')->where('customer_name', $customer_info[0]['customer_name'])
                    ->where('customer_phone', $customer_info[0]['customer_phone'])
                    ->where('customer_email', $customer_info[0]['customer_email'])
                    ->update(['customer_name' => $request->customer_name, 'customer_phone' => $request->customer_phone, 'customer_email' => $request->customer_email]);
            }
            Session::forget('cart');
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
        return response()->json([
            'redirect' => route('order-success')
        ]);
    }

    public function orderSuccess()
    {
        $customer_info = session()->get('customer_info');
        $order = DB::table('orders')->orderBy('id', 'desc')->limit(1)->get();
        return view('client.order_info', compact('customer_info', 'order'));
    }
}
