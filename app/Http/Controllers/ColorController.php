<?php

namespace App\Http\Controllers;


use App\Color;
use App\Http\Requests\ColorRequest;
use App\Product;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ColorController extends Controller
{
    protected $color;

    public function __construct(Color $color, Product $product)
    {
        parent::__construct();
        $this->color = new Repository($color);
        $this->middleware('permission:color-list');
        $this->middleware('permission:color-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:color-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:color-delete', ['only' => ['destroy']]);

    }

    public function index()
    {
        $items = $request->items ?? 10;
        $count = $this->color->all($items)->total();
        $colors = $this->color->all($items);
        return view('admin.color.list', compact('colors', 'count', 'items'));
    }

    public function create()
    {
        $listProducts = Product::all();
        $products = $listProducts->pluck('name_phone', 'id')->all();
        return view('admin.color.create', compact('products'));
    }

    public function store(ColorRequest $request)
    {
        $colors = $this->color->create($request->all());
        return Response::json($colors);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $listProducts = Product::all();
        $products = $listProducts->pluck('name_phone', 'id')->all();
        $color = $this->color->find($id);
        return view('admin.color.update', compact('color', 'products'));

    }

    public function update($id, ColorRequest $request)
    {
        $colors = $this->color->update($id, $request->all());
        return Response::json($colors);
    }

    public function destroy($id)
    {
        $this->color->delete($id);
        return redirect()->route('color.index')->with('message', 'Delete successfully');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $colors = $this->color->with(['product'])
                ->join('products', 'colors.product_id', '=', 'products.id')
                ->where('colors.color_name', 'like', '%' . $request->all()['key'] . '%')
                ->orWhere('products.name_phone', 'like', '%' . $request->all()['key'] . '%')
                ->select('colors.*', 'products.name_phone')
                ->get();
            foreach ($colors as $key => $color) {
                $buttonUpdate = '<div class="btn-edit"> <a href="javascript:void(0)" class="edit-color btn btn-success" data-id= "' . $color->id . '">Update</a></div>';
                $buttonDelete = '<a href="javascript:void(0)" id="delete-color" class="btn btn-danger delete-color" data-id="' . $color->id . '">Delete</a>';
                $output .= '<tr>' .
                    '<td>' . $color->id . '</td>' .
                    '<td>' . $color->name_phone . '</td>' .
                    '<td>' . $color->color_name . '</td>' .
                    '<td>' . $color->created_at->format('d/m/Y') . '</td>' .
                    '<td>' . $color->updated_at->format('d/m/Y') . '</td>' .
                    '<td>' . $buttonUpdate . '</td>' .
                    '<td>' . $buttonDelete . '</td>' .
                    '</tr>';
            }
            return Response($output);
        }
    }

}
