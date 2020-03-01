<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalePhoneRequest;
use App\Product;
use App\Repositories\Repository;
use App\SalePhone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class SalePhoneController extends Controller
{
    protected $sale_phone;

    public function __construct(SalePhone $sale_phone)
    {
        parent::__construct();
        $this->sale_phone = new Repository($sale_phone);
        $this->middleware('permission:sale_phone-list');
        $this->middleware('permission:sale_phone-create', ['only' => ['create','store']]);
        $this->middleware('permission:sale_phone-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:sale_phone-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $items = $request->items ?? 10;
        $count = $this->sale_phone->all($items)->total();
        $sale_phones = $this->sale_phone->all($items);
        return view('admin.sale_phone.list', compact('sale_phones','count'));
    }

    public function create()
    {
        $listPhones = Product::all();
        $phones = $listPhones->pluck('name_phone', 'id')->all();
        return view('admin.sale_phone.create', compact('phones'));
    }

    public function store(SalePhoneRequest $request)
    {
        $sale_phones = $this->sale_phone->create($request->all());
        return Response::json($sale_phones);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $listPhones = Product::all();
        $phones = $listPhones->pluck('name_phone', 'id')->all();
        $sale_phone = $this->sale_phone->find($id);
        return view('admin.sale_phone.update', compact('sale_phone', 'phones'));

    }

    public function update($id, SalePhoneRequest $request)
    {
        $sale_phones = $this->sale_phone->update($id, $request->all());
        return Response::json($sale_phones);
    }

    public function destroy($id)
    {
        $this->sale_phone->delete($id);
        return redirect()->route('sale_phone.index');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $sale_phones = $this->sale_phone->with(['product'])
                ->join('products', 'sale_phones.phone_id', '=', 'products.id')
                ->where('products.name_phone', 'like', '%' . $request->all()['key'] . '%')
                ->select('sale_phones.*', 'products.name_phone')->get();
            foreach ($sale_phones as $key => $sale_phone) {
                $buttonUpdate = '<div class="btn-edit"> <a href="javascript:void(0)" class="edit-sale_phone btn btn-success" data-id= "' . $sale_phone->id . '">Update</a></div>';
                $buttonDelete = '<a href="javascript:void(0)" id="delete-sale_phone" class="btn btn-danger delete-sale_phone" data-id="' . $sale_phone->id . '">Delete</a>';
                $output .= '<tr>' .
                    '<td>' . $sale_phone->id . '</td>' .
                    '<td>' . $sale_phone->name_phone . '</td>' .
                    '<td>' . $sale_phone->quantity . '</td>' .
                    '<td>' . $sale_phone->created_at . '</td>' .
                    '<td>' . $sale_phone->updated_at . '</td>' .
                    '<td>' . $buttonUpdate . '</td>' .
                    '<td>' . $buttonDelete . '</td>' .
                    '</tr>';
            }
            return Response($output);
        }
    }

}
