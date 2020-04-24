<?php

namespace App\Http\Controllers;


use App\Color;
use App\Http\Requests\OrderDetailRequest;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class OrderDetailController extends Controller
{
    protected $order_detail;
    protected $product;
    protected $color;

    public function __construct(OrderDetail $orderDetail, Product $product, Color $color)
    {
        parent::__construct();
        $this->order_detail = new Repository($orderDetail);
        $this->product = new Repository($product);
        $this->color = new Repository($color);
        $this->middleware('permission:order_detail-list');
        $this->middleware('permission:order_detail-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:order_detail-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:order_detail-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $items = $request->items ?? 10;
        $count = $this->order_detail->all($items)->total();
        $order_details = $this->order_detail->all($items);
        return view('admin.order_detail.list', compact('order_details', 'count', 'items'));
    }

    public function create()
    {
        $listOrders = Order::all();
        $orders = $listOrders->pluck('id', 'id')->all();
        $listProducts = Product::all();
        $products = $listProducts->pluck('name_phone', 'id')->all();
        $listColors = Color::all();
        $colors = $listColors->pluck('color_name', 'product_id')->all();
        return view('admin.order_detail.create', compact('orders', 'products', 'colors'));
    }

    public function store(OrderDetailRequest $request)
    {
        $order_details = $this->order_detail->create($request->all());
        $product = $this->product->find($request->product_id);
        $color = $this->color->find($request->color_id);
        return Response::json(["order_details" => $order_details, 'product' => $product, 'color' => $color]);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $order_detail = $this->order_detail->find($id);
        $listOrders = Order::all();
        $orders = $listOrders->pluck('id', 'id')->all();
        $listProducts = Product::all();
        $products = $listProducts->pluck('name_phone', 'id')->all();
        $listColors = Color::all();
        $colors = $listColors->pluck('color_name', 'product_id')->all();
        return view('admin.order_detail.update', compact('order_detail', 'orders', 'products','colors'));

    }

    public function update($id, OrderDetailRequest $request)
    {
        $order_details = $this->order_detail->update($id, $request->all());
        $product = $this->product->find($request->product_id);
        $color = $this->color->find($request->color_id);
        return Response::json(["order_details" => $order_details, 'product' => $product, 'color' => $color]);
    }

    public function destroy($id)
    {
        $this->order_detail->delete($id);
        return redirect()->route('order_detail.index')->with('message', 'Delete successfully');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $order_details = $this->order_detail->with(['product'])
                ->join('products', 'order_details.product_id', '=', 'products.id')
                ->join('colors', 'order_details.color_id', '=', 'colors.id')
                ->where('products.name_phone', 'like', '%' . $request->all()['key'] . '%')
                ->select('order_details.*', 'products.name_phone')
                ->get();
            foreach ($order_details as $key => $order_detail) {
                $buttonUpdate = '<div class="btn-edit"> <a href="javascript:void(0)" class="edit-order_detail btn btn-success" data-id= "' . $order_detail->id . '">Update</a></div>';
                $buttonDelete = '<a href="javascript:void(0)" id="delete-order_detail" class="btn btn-danger delete-order_detail" data-id="' . $order_detail->id . '">Delete</a>';
                $output .= '<tr>' .
                    '<td>' . $order_detail->id . '</td>' .
                    '<td>' . $order_detail->order_id . '</td>' .
                    '<td>' . $order_detail->name_phone . '</td>' .
                    '<td>' . $order_detail->color_name . '</td>' .
                    '<td>' . $order_detail->sale_quantity . '</td>' .
                    '<td>' . $order_detail->price . '</td>' .
                    '<td>' . $order_detail->created_at . '</td>' .
                    '<td>' . $order_detail->updated_at . '</td>' .
                    '<td>' . $buttonUpdate . '</td>' .
                    '<td>' . $buttonDelete . '</td>' .
                    '</tr>';
            }
            return Response($output);
        }
    }
}
