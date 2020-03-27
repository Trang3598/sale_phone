<?php

namespace App\Http\Controllers;

use App\Category;
use App\Exports\ProductsExport;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    protected $product;

    public function __construct(Product $product)
    {
        parent::__construct();
        $this->product = new ProductRepository($product);
        $this->middleware('permission:product-list');
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $items = $request->items ?? 10;
        $products = $this->product->searchDetail($request->all())->paginate($items);
        $count = $this->product->searchDetail($request->all())->count();
        return view('admin.product.list', compact('products', 'items', 'count'));
    }

    public function create()
    {
        $listCategories = Category::all();
        $categories = $listCategories->pluck('category_name', 'id')->all();
        return view('admin.product.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('thumbnail')) {
            $file = $request->thumbnail;
            $thumbnail = time() . $file->getClientOriginalName();
            $file->move('images', $thumbnail);
            $data['thumbnail'] = $thumbnail;
        }
        $products = $this->product->create($data);
        return Response::json($products);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $product = $this->product->find($id);
        $listCategories = Category::all();
        $categories = $listCategories->pluck('category_name', 'id')->all();
        return view('admin.product.update', compact('product', 'categories'));

    }

    public function update($id, ProductRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('thumbnail')) {
            $file = $request->thumbnail;
            $thumbnail = time() . $file->getClientOriginalName();
            $file->move('images', $thumbnail);
            $data['thumbnail'] = $thumbnail;
        }
        $products = $this->product->update($id, $data);
        return Response::json($products);
    }

    public function destroy($id)
    {
        $this->product->delete($id);
        return redirect()->route('product.index');
    }

    public function export()
    {
        return Excel::download(new ProductsExport(), 'products.xlsx');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $fieldName = 'name_phone';
            $output = "";
            $key = $request->all()['key'];
            $products = $this->product->search($fieldName, $key)->orWhere('title', 'LIKE', '%' . $key . '%')->get();
            foreach ($products as $key => $product) {
                $check = ($product->sale_phone == 1) ? 'Best Seller' : 'Unmarketable';
                $buttonUpdate = '<div class="btn-edit"> <a href="javascript:void(0)" class="edit-product btn btn-success" data-id= "' . $product->id . '">Update</a></div>';
                $buttonDelete = '<a href="javascript:void(0)" id="delete-product" class="btn btn-danger delete-product" data-id="' . $product->id . '">Delete</a>';
                $output .= '<tr>' .
                    '<td>' . $product->id . '</td>' .
                    '<td>' . $product->category->category_name . '</td>' .
                    '<td>' . $product->name_phone . '</td>' .
                    '<td>' . $product->title . '</td>' .
                    '<td>' . $product->description . '</td>' .
                    '<td>' . $product->quantity . '</td>' .
                    '<td>' . $product->detail . '</td>' .
                    '<td>' . $product->price . '</td>' .
                    '<td>' . $product->size . '</td>' .
                    '<td>' . $product->memory . '</td>' .
                    '<td>' . $product->weight . '</td>' .
                    '<td>' . $product->cpu_speed . '</td>' .
                    '<td>' . $product->ram . '</td>' .
                    '<td>' . $product->os . '</td>' .
                    '<td>' . $product->camera_primary . '</td>' .
                    '<td>' . $product->battery . '</td>' .
                    '<td>' . $product->warranty . '</td>' .
                    '<td>' . $product->bluetooth . '</td>' .
                    '<td>' . $product->wlan . '</td>' .
                    '<td>' . $product->promotion_price . '</td>' .
                    '<td>' . $product->start_promotion->format('d/m/Y') . '</td>' .
                    '<td>' . $product->end_promotion->format('d/m/Y') . '</td>' .
                    '<td>' . $check . '</td>' .
                    '<td>' . $product->created_at->format('d/m/Y') . '</td>' .
                    '<td>' . $product->updated_at->format('d/m/Y') . '</td>' .
                    '<td>' . $buttonUpdate . '</td>' .
                    '<td>' . $buttonDelete . '</td>' .
                    '</tr>';
            }
            return Response($output);
        }
    }

    public function showImage($id)
    {
        $product = $this->product->find($id);
        $images = $this->product->with(['image'])
            ->join('images', 'images.product_id', '=', 'products.id')
            ->where('images.deleted_at', null)
            ->where('products.id', '=', $id)
            ->select('images.image', 'images.deleted_at')
            ->get();
        return view('admin.product.image', compact('images', 'product'));
    }
}
