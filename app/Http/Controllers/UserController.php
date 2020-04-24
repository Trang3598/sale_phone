<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountSettingRequest;
use App\Http\Requests\UserRequest;
use App\Repositories\Repository;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = new Repository($user);
        $this->middleware('permission:user-list');
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->middleware('permission:user-account', ['only' => ['account', 'settingAccount']]);
    }

    public function index()
    {
        $items = $request->items ?? 10;
        $count = $this->user->all($items)->total();
        $users = $this->user->all($items);
        return view('admin.user.list', compact('users', 'count', 'items'));
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('admin.user.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('avatar')) {
            $file = $request->avatar;
            $avatar = time() . $file->getClientOriginalName();
            $file->move('images', $avatar);
            $data['avatar'] = $avatar;
        }
        $users = $this->user->create($data);
        $users->assignRole($request->input('roles'));
        $role_data = [];
        foreach ($users->roles as $item) {
            array_push($role_data, $item);
        }
        return Response::json(['users' => $users,'role_data' => $role_data]);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $user = $this->user->find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('admin.user.update', compact('user', 'roles', 'userRole'));

    }

    public function update($id, UserRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('avatar')) {
            $file = $request->avatar;
            $avatar = time() . $file->getClientOriginalName();
            $file->move('images', $avatar);
            $data['avatar'] = $avatar;
        }
        $users = $this->user->update($id, $data);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $users->assignRole($request->input('roles'));
        $role_data = [];
        foreach ($users->roles as $item) {
            array_push($role_data, $item->name);
        }
        return Response::json(['users' => $users,'role_data' => $role_data]);
    }

    public function destroy($id)
    {
        $this->user->delete($id);
        return redirect()->route('user.index')->with('message', 'Delete successfully');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $fieldName = 'email';
            $output = "";
            $users = $this->user->search($fieldName, $request->all()['key'])->orWhere('username', 'like', '%' . $request->all()['key'] . '%')->get();
            foreach ($users as $key => $user) {
                $buttonUpdate = '<div class="btn-edit"> <a href="javascript:void(0)" class="edit-user btn btn-success" data-id= "' . $user->id . '">Update</a></div>';
                $buttonDelete = '<a href="javascript:void(0)" id="delete-user" class="btn btn-danger delete-user" data-id="' . $user->id . '">Delete</a>';
                $output .= '<tr>' .
                    '<td>' . $user->id . '</td>' .
                    '<td>' . $user->username . '</td>' .
                    '<td>' . $user->full_name . '</td>' .
                    '<td>' . $user->email . '</td>' .
                    '<td>' . $user->created_at->format('d/m/Y') . '</td>' .
                    '<td>' . $user->updated_at->format('d/m/Y') . '</td>' .
                    '<td>' . $buttonUpdate . '</td>' .
                    '<td>' . $buttonDelete . '</td>' .
                    '</tr>';
            }
            return Response($output);
        }
    }

    public function account()
    {
        $id = Auth::user()->id;
        $user = $this->user->find($id);
        return view('admin.user.account', compact('user'));
    }

    public function settingAccount(AccountSettingRequest $request, $id)
    {
        $data = $request->all();
        if ($request->hasFile('avatar')) {
            $file = $request->avatar;
            $avatar = time() . $file->getClientOriginalName();
            $file->move('images', $avatar);
            $data['avatar'] = $avatar;
        }
        $user = User::find(auth()->user()->id);
        if (Hash::check($data['current_password'], $user->password)) {
            $users = $this->user->update($id, $data);
        } else {
            return response()->json(['message' => ['The current password does not match our records.']], 400);
        }
        return Response::json($users);
    }
}
