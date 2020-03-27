<?php


namespace App\Http\Controllers\Client;


use App\Category;
use App\Color;
use App\Comment;
use App\Http\Requests\SendFormRequest;
use App\ImageFeedback;
use App\Product;
use App\Repositories\ProductRepository;
use App\Repositories\Repository;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class HomeController
{
    protected $category, $product, $color, $comment, $user, $image_feedback;

    public function __construct(Category $category, Product $product, Color $color, Comment $comment, User $user, ImageFeedback $image_feedback)
    {
        $this->category = new Repository($category);
        $this->product = new ProductRepository($product);
        $this->color = new Repository($color);
        $this->comment = new Repository($comment);
        $this->user = new Repository($user);
        $this->image_feedback = new Repository($image_feedback);
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
        $colors = $this->product->with(['color'])
            ->join('colors', 'colors.product_id', '=', 'products.id')
            ->where('colors.deleted_at', null)
            ->where('products.id', '=', $id)
            ->select('colors.color_name')
            ->get();
        $comments = $this->comment->findThrough('product_id', $id)->sortByDesc('id');
        foreach ($comments as $key => $comment) {
            $img_cmt[$key] = $this->image_feedback->findThrough('comment_id', $comment->id);
        }
        return view('client.details', compact('product', 'images', 'count', 'start', 'end', 'today', 'comments', 'img_cmt'));
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
            $img_cmt = DB::table('image_feedbacks')->orderBy('id','desc')->limit(sizeof($array))->get();
            return Response::json(['comment_id' => $comment_id, 'user' => $user, 'img_cmt' => $img_cmt]);
        } else {
            return Response::json(['comment_id' => $comment_id, 'user' => $user]);
        }

    }

}
