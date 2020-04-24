<?php

namespace App\Http\Controllers;

use App\Color;
use App\Deliverer;
use App\Http\Requests\OrderDetailRequest;
use App\Http\Requests\OrderRequest;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\Repositories\Repository;
use App\Status;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{
    protected $order;
    protected $order_detail;
    protected $deliverer;
    protected $status;
    protected $color;

    public function __construct(Order $order, OrderDetail $orderDetail, Deliverer $deliverer, Status $status,Color $color)
    {
        parent::__construct();
        $this->order = new Repository($order);
        $this->order_detail = new Repository($orderDetail);
        $this->deliverer = new Repository($deliverer);
        $this->status = new Repository($status);
        $this->color = new Repository($color);
        $this->middleware('permission:order-list');
        $this->middleware('permission:order-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:order-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:order-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $items = $request->items ?? 10;
        $count = $this->order->all($items)->total();
        $orders = $this->order->all($items);
        return view('admin.order.list', compact('orders', 'items', 'count'));
    }

    public function create()
    {
        $listStatus = Status::all();
        $status = $listStatus->pluck('status_name', 'id')->all();
        $listDeliverer = Deliverer::all();
        $deliverers = $listDeliverer->pluck('deliverer_name', 'id')->all();
        return view('admin.order.create', compact('status', 'deliverers'));
    }

    public function store(OrderRequest $request)
    {
        $orders = $this->order->create($request->all());
        $deliverer = $this->deliverer->find($request->deliverer_id);
        $status = $this->status->find($request->status_id);
        return Response::json(["orders" => $orders, "deliverer" => $deliverer, "status" => $status]);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $listStatus = Status::all();
        $status = $listStatus->pluck('status_name', 'id')->all();
        $listDeliverer = Deliverer::all();
        $deliverers = $listDeliverer->pluck('deliverer_name', 'id')->all();
        $order = $this->order->find($id);
        return view('admin.order.update', compact('order', 'status', 'deliverers'));

    }

    public function update($id, OrderRequest $request)
    {
        $orders = $this->order->update($id, $request->all());
        $deliverer = $this->deliverer->find($request->deliverer_id);
        $status = $this->status->find($request->status_id);
        return Response::json(["orders" => $orders, "deliverer" => $deliverer, "status" => $status]);
    }

    public function destroy($id)
    {
        $this->order->delete($id);
        return redirect()->route('order.index');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $fieldName = 'customer_name';
            $output = "";
            $key = $request->all()['key'];
            $orders = $this->order->search($fieldName, $key)->orWhere('customer_phone', 'like', '%' . $key . '%')->orWhere('customer_email', 'like', '%' . $key . '%')->get();
            foreach ($orders as $key => $order) {
                $buttonUpdate = '<div class="btn-edit"> <a href="javascript:void(0)" class="edit-order btn btn-success" data-id= "' . $order->id . '">Update</a></div>';
                $buttonDelete = '<a href="javascript:void(0)" id="delete-order" class="btn btn-danger delete-order" data-id="' . $order->id . '">Delete</a>';
                $output .= '<tr>' .
                    '<td>' . $order->id . '</td>' .
                    '<td>' . $order->customer_name . '</td>' .
                    '<td>' . $order->customer_phone . '</td>' .
                    '<td>' . $order->status->status_name . '</td>' .
                    '<td>' . $order->deliverer->deliverer_name . '</td>' .
                    '<td>' . $order->total_price . '</td>' .
                    '<td>' . $order->delivery_address . '</td>' .
                    '<td>' . $order->created_at->format('d/m/Y') . '</td>' .
                    '<td>' . $buttonUpdate . '</td>' .
                    '<td>' . $buttonDelete . '</td>' .
                    '</tr>';
            }
            return Response($output);
        }
    }

    public function detail($id)
    {
        $order = $this->order->find($id);
        $deliverer = $this->order->with(['deliverer'])->where('orders.id', '=', $id)
            ->join('deliverer', 'orders.deliverer_id', '=', 'deliverer.id')
            ->select('deliverer.*')
            ->get()[0];
        $status = $this->order->with(['status'])->where('orders.id', '=', $id)
            ->join('status', 'orders.status_id', '=', 'status.id')
            ->select('status.*')
            ->get()[0];
        $order_details = $this->order->with(['orderDetail'])
            ->join('order_details', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('colors', 'order_details.color_id', '=', 'colors.id')
            ->where('order_details.deleted_at', null)
            ->where('order_details.order_id', '=', $id)
            ->select('order_details.*', 'products.name_phone','colors.color_name')->get();
        $total_price = 0;
        foreach ($order_details as $order_detail) {
            $total_price = $total_price + ($order_detail->price) * ($order_detail->sale_quantity);
        }
        DB::table('orders')->where('id', '=', $id)->update(['total_price' => $total_price]);
        return view('admin.order.detail', compact('order', 'status', 'deliverer', 'order_details', 'total_price'));
    }

    public function addOrderDetail($id)
    {
        $listProducts = Product::all();
        $products = $listProducts->pluck('name_phone', 'id')->all();
        return view('admin.order.add_order_detail', compact('products', 'id'));
    }

    public function setPrice(Request $request)
    {
        $product_id = $request->product_id;
        if ($product_id == null) {
            $price = 0;
        } else {
            $today = Carbon::now();
            $start_promotion = DB::table('products')->where('id', '=', $product_id)->select('start_promotion')->get()[0];
            $end_promotion = DB::table('products')->where('id', '=', $product_id)->select('end_promotion')->get()[0];
            $start = (array)$start_promotion;
            $end = (array)$end_promotion;
            if ($today >= $start['start_promotion'] && $today <= $end['end_promotion']) {
                $price = DB::table('products')->where('id', '=', $product_id)->select('promotion_price')->get()[0];
            } else {
                $price = DB::table('products')->where('id', '=', $product_id)->select('price')->get()[0];
            }
        }
        return Response::json($price);
    }

    public function setColor(Request $request){
        $product_id = $request->product_id;
        $listColors = $this->color->findThrough('product_id',$product_id);
        return Response::json($listColors);
    }
    public function addOrderDetailAction(OrderDetailRequest $request, $id)
    {
        $order_detail = $this->order_detail->create($request->all());
        return Response::json($order_detail);
    }

    public function deleteProductFromCart($id)
    {
        $this->order_detail->delete($id);
        return redirect()->back();
    }

    public function updateViewOrderDetail($id)
    {
        $listProducts = Product::all();
        $products = $listProducts->pluck('name_phone', 'id')->all();
        $order_detail = $this->order_detail->find($id);
        $listColors = Color::all();
        $colors = $listColors->pluck('color_name', 'id')->all();
        return view('admin.order.add_order_detail', compact('products', 'id','colors','order_detail'));
    }

    public function updateOrderDetail(OrderDetailRequest $request, $id)
    {
        $order_details = DB::table('order_details')
            ->where('id', $id)
            ->update(['product_id' => $request->product_id, 'sale_quantity' => $request->sale_quantity, 'price' => $request->price]);
        return Response::json($order_details);
    }

    public function exportPDF($id)
    {
        $order = $this->order->find($id);
        $deliverer = $this->order->with(['deliverer'])->where('orders.id', '=', $id)
            ->join('deliverer', 'orders.deliverer_id', '=', 'deliverer.id')
            ->select('deliverer.*')
            ->get()[0];
        $status = $this->order->with(['status'])->where('orders.id', '=', $id)
            ->join('status', 'orders.status_id', '=', 'status.id')
            ->select('status.*')
            ->get()[0];
        $order_details = $this->order->with(['orderDetail'])
            ->join('order_details', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->where('order_details.deleted_at', null)
            ->where('order_details.order_id', '=', $id)
            ->select('order_details.*', 'products.name_phone')->get();
        $total_price = 0;
        foreach ($order_details as $order_detail) {
            $total_price = $total_price + ($order_detail->price) * ($order_detail->sale_quantity);
        }
        $pdf = PDF::loadView('admin.order.detail', compact('order', 'deliverer', 'status', 'order_details', 'total_price'));
        return $pdf->download('order.pdf');
    }
}
