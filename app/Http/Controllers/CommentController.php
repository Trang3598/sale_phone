<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentRequest;
use App\Product;
use App\Repositories\Repository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class CommentController extends Controller
{
    protected $comment;
    protected $product;
    protected $user;

    public function __construct(Comment $comment, User $user, Product $product)
    {
        parent::__construct();
        $this->middleware('permission:comment-list');
        $this->middleware('permission:comment-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:comment-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:comment-delete', ['only' => ['destroy']]);
        $this->comment = new Repository($comment);
        $this->user = new Repository($user);
        $this->product = new Repository($product);
    }

    public function index()
    {
        $items = $request->items ?? 10;
        $count = $this->comment->all($items)->total();
        $comments = $this->comment->all($items);
        return view('admin.comment.list', compact('comments', 'count', 'items'));
    }

    public function create()
    {
        $listUsers = User::all();
        $users = $listUsers->pluck('username', 'id')->all();
        $listProducts = Product::all();
        $products = $listProducts->pluck('name_phone', 'id')->all();
        return view('admin.comment.create', compact('users', 'products'));
    }

    public function store(CommentRequest $request)
    {
        $comments = $this->comment->create($request->all());
        $product = $this->product->find($request->product_id);
        $user = $this->user->find($request->user_id);
        return Response::json(['comments' => $comments, 'product' => $product, 'user' => $user]);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $comment = $this->comment->find($id);
        $listUsers = User::all();
        $users = $listUsers->pluck('username', 'id')->all();
        $listProducts = Product::all();
        $products = $listProducts->pluck('name_phone', 'id')->all();
        return view('admin.comment.update', compact('comment', 'users', 'products'));

    }

    public function update($id, CommentRequest $request)
    {
        $comments = $this->comment->update($id, $request->all());
        $product = $this->product->find($request->product_id);
        $user = $this->user->find($request->user_id);
        return Response::json(['comments' => $comments, 'product' => $product, 'user' => $user]);
    }

    public function destroy($id)
    {
        $this->comment->delete($id);
        return redirect()->route('comment.index')->with('message', 'Delete successfully');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $key = $request->all()['key'];
            $comments = $this->comment->with(['product', 'user'])
                ->join('products', 'comments.product_id', '=', 'products.id')
                ->join('users', 'comments.user_id', '=', 'users.id')
                ->where('products.name_phone', 'like', '%' . $key . '%')->orWhere('phone_number', 'like', '%' . $key . '%')->orWhere('username', 'like', '%' . $key . '%')
                ->select('comments.*', 'products.name_phone', 'users.username')
                ->get();
            foreach ($comments as $key => $comment) {
                $buttonUpdate = '<div class="btn-edit"> <a href="javascript:void(0)" class="edit-comment btn btn-success" data-id= "' . $comment->id . '">Update</a></div>';
                $buttonDelete = '<a href="javascript:void(0)" id="delete-comment" class="btn btn-danger delete-comment" data-id="' . $comment->id . '">Delete</a>';
                $username = isset($comment->username) ? $comment->username : 'VISITOR';
                $output .= '<tr>' .
                    '<td>' . $comment->id . '</td>' .
                    '<td>' . $username . '</td>' .
                    '<td>' . $comment->name_phone . '</td>' .
                    '<td>' . $comment->comment_time . '</td>' .
                    '<td>' . $comment->comment_content . '</td>' .
                    '<td>' . $comment->phone_number . '</td>' .
                    '<td>' . $comment->created_at . '</td>' .
                    '<td>' . $comment->updated_at . '</td>' .
                    '<td>' . $buttonUpdate . '</td>' .
                    '<td>' . $buttonDelete . '</td>' .
                    '</tr>';
            }
            return Response($output);
        }
    }

}
