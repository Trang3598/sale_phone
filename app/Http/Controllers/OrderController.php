<?php

namespace App\Http\Controllers;

use App\Deliverer;
use App\Http\Requests\OrderRequest;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\Repositories\Repository;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{
    protected $order;
    protected $order_detail;

    public function __construct(Order $order, OrderDetail $orderDetail)
    {
        parent::__construct();
        $this->order = new Repository($order);
        $this->order_detail = new Repository($orderDetail);
        $this->middleware('permission:order-list');
        $this->middleware('permission:order-create', ['only' => ['create','store']]);
        $this->middleware('permission:order-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:order-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $items = $request->items ?? 10;
        $count = $this->order->all($items)->total();
        $orders = $this->order->all($items);
        return view('admin.order.list', compact('orders','items','count'));
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
        return Response::json($orders);
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
        return Response::json($orders);
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
                    '<td>' . $order->customer_email . '</td>' .
                    '<td>' . $order->status->status_name . '</td>' .
                    '<td>' . $order->deliverer->deliverer_name . '</td>' .
                    '<td>' . $order->total_price . '</td>' .
                    '<td>' . $order->delivery_address . '</td>' .
                    '<td>' . $order->note . '</td>' .
                    '<td>' . $order->created_at->format('d/m/Y') . '</td>' .
                    '<td>' . $order->updated_at->format('d/m/Y') . '</td>' .
                    '<td>' . $buttonUpdate . '</td>' .
                    '<td>' . $buttonDelete . '</td>' .
                    '</tr>';
            }
            return Response($output);
        }
    }
}
