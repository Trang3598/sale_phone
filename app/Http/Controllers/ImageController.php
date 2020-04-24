<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Image;
use App\Product;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ImageController extends Controller
{
    protected $image;
    protected $product;

    public function __construct(Image $image, Product $product)
    {
        parent::__construct();
        $this->image = new Repository($image);
        $this->product = new Repository($product);
        $this->middleware('permission:image-list');
        $this->middleware('permission:image-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:image-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:image-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $items = $request->items ?? 10;
        $count = $this->image->all($items)->total();
        $images = $this->image->all($items);
        return view('admin.image.list', compact('images', 'count', 'items'));
    }

    public function create()
    {
        $listProducts = Product::all();
        $products = $listProducts->pluck('name_phone', 'id')->all();
        return view('admin.image.create', compact('products'));
    }

    public function store(ImageRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $file = $request->image;
            $image = time() . $file->getClientOriginalName();
            $file->move('images', $image);
            $data['image'] = $image;
        }
        $images = $this->image->create($data);
        $product = $this->product->find($request->product_id);
        return Response::json(['images' => $images,'product' => $product]);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $listProducts = Product::all();
        $products = $listProducts->pluck('name_phone', 'id')->all();
        $image = $this->image->find($id);
        return view('admin.image.update', compact('image', 'products'));

    }

    public function update($id, ImageRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $file = $request->image;
            $image = time() . $file->getClientOriginalName();
            $file->move('images', $image);
            $data['image'] = $image;
        }
        $images = $this->image->update($id, $data);
        $product = $this->product->find($request->product_id);
        return Response::json(['images' => $images,'product' => $product]);
    }

    public function destroy($id)
    {
        $this->image->delete($id);
        return redirect()->route('image.index')->with('message', 'Delete successfully');
    }

    public function showImage($id)
    {
        $image = $this->image->find($id);
        return view('admin.image.show_image', compact('image'));
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $images = $this->image->with(['product'])
                ->join('products', 'images.product_id', '=', 'products.id')->where('images.deleted_at', null)
                ->where('products.name_phone', 'like', '%' . $request->all()['key'] . '%')
                ->select('images.*', 'products.name_phone')
                ->get();
            foreach ($images as $key => $image) {
                $buttonUpdate = '<div class="btn-edit"> <a href="javascript:void(0)" class="edit-image btn btn-success" data-id= "' . $image->id . '">Update</a></div>';
                $buttonDelete = '<a href="javascript:void(0)" id="delete-image" class="btn btn-danger delete-image" data-id="' . $image->id . '">Delete</a>';
                $fileImage = '<a href="javascript:void(0)" class="show-image"
                                       data-id="' . $image->id . '">
                                        <img id="image_' . $image->id . '" src="images/' . $image->image . '" alt=""
                                             style="height:50px;width: 50px" class="img-responsive"/>
                                    </a>';
                $output .= '<tr>' .
                    '<td>' . $image->id . '</td>' .
                    '<td>' . $image->name_phone . '</td>' .
                    '<td>' . $fileImage . '</td>' .
                    '<td>' . $image->created_at . '</td>' .
                    '<td>' . $image->updated_at . '</td>' .
                    '<td>' . $buttonUpdate . '</td>' .
                    '<td>' . $buttonDelete . '</td>' .
                    '</tr>';
            }
            return Response($output);
        }
    }
}
