<?php

namespace App\Http\Controllers;

use App\Category;
use App\Exports\ProductsExport;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\Repositories\ProductRepository;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    protected $product;
    protected $category;

    public function __construct(Product $product, Category $category)
    {
        parent::__construct();
        $this->product = new ProductRepository($product);
        $this->category = new Repository($category);
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
        $category = $this->category->find($request->id_cate);
        if ($request->sale_phone == 1) {
            $sale_phone = "Best Seller";
        } else {
            $sale_phone = "Unmarketable";
        }
        return Response::json(["products" => $products, 'category' => $category, 'sale_phone' => $sale_phone]);
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
        $category = $this->category->find($request->id_cate);
        if ($request->sale_phone == 1) {
            $sale_phone = "Best Seller";
        } else {
            $sale_phone = "Unmarketable";
        }
        return Response::json(["products" => $products, 'category' => $category, 'sale_phone' => $sale_phone]);
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
                $buttonImage = '<a href="javascript:void(0)" id="image-product"
                                   data-id="' . $product->id . '"
                                   class="image-product btn btn-primary">Image</a>';
                $output .= '<tr>' .
                    '<td>' . $product->id . '</td>' .
                    '<td>' . $product->category->category_name . '</td>' .
                    '<td><img src="images/' . $product->thumbnail . '" alt="" style="height:50px;width: 50px" class="img-responsive"/></td>' .
                    '<td>' . $product->name_phone . '</td>' .
                    '<td>' . $product->quantity . '</td>' .
                    '<td>' . $product->price . '</td>' .
                    '<td>' . $check . '</td>' .
                    '<td>' . $product->created_at->format('d/m/Y') . '</td>' .
                    '<td>' . $buttonImage . '</td>' .
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
