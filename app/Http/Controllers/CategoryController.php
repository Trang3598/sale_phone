<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(Category $category)
    {
        parent::__construct();
        $this->category = new Repository($category);
        $this->middleware('permission:category-list');
        $this->middleware('permission:category-create', ['only' => ['create','store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $items = $request->items ?? 10;
        $count = $this->category->all($items)->total();
        $categories = $this->category->all($items);
        return view('admin.category.list', compact('categories', 'items', 'count'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(CategoryRequest $request)
    {
        $categories = $this->category->create($request->all());
        return Response::json($categories);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $category = $this->category->find($id);
        return view('admin.category.update', compact('category'));

    }

    public function update($id, CategoryRequest $request)
    {
        $categories = $this->category->update($id, $request->all());
        return Response::json($categories);
    }

    public function destroy($id)
    {
        $this->category->delete($id);
        return redirect()->route('category.index');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $fieldName = 'category_name';
            $output = "";
            $categories = $this->category->search($fieldName, $request->all()['key'])->get();
            foreach ($categories as $key => $category) {
                $buttonUpdate = '<div class="btn-edit"> <a href="javascript:void(0)" class="edit-cate btn btn-success" data-id= "' . $category->id . '">Update</a></div>';
                $buttonDelete = '<a href="javascript:void(0)" id="delete-category" class="btn btn-danger delete-category" data-id="' . $category->id . '">Delete</a>';
                $output .= '<tr>' .
                    '<td>' . $category->id . '</td>' .
                    '<td>' . $category->category_name . '</td>' .
                    '<td>' . $category->created_at->format('d/m/Y') . '</td>' .
                    '<td>' . $category->updated_at->format('d/m/Y') . '</td>' .
                    '<td>' . $buttonUpdate . '</td>' .
                    '<td>' . $buttonDelete . '</td>' .
                    '</tr>';
            }
            return Response($output);
        }
    }

}
