@extends('admin.layout.index')
@section('content')
    <div class="col-lg-10">
        <div class="card card-fluid">
            <h6 class="card-header">Profile </h6>
            <div class="card-body">
                <form method="post" action="{{route('user.settingAccount',$user->id)}}" enctype="multipart/form-data"
                      id="updateForm">
                    <div class="form-group">
                        <img src="images/{{$user->avatar}}" id="output"
                             alt="example placeholder avatar" width="200px" height="200px" style="border-radius: 50%;">
                    </div>
                    <div class="form-group">
                        <input type="file" id="avatar" required="" name="avatar" onchange="readURL(this)">
                        <span class="text-danger">
                                <strong id="avatar-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="input05">Username</label>
                        <input type="text" class="form-control" id="username" value="{{$user->username}}" required=""
                               name="username" readonly>
                        <span class="text-danger">
                                <strong id="username-error"></strong>
                            </span>
                    </div>
                    <div class="form-group">
                        <label for="input03">Full Name</label>
                        <input type="text" class="form-control enable" id="full_name" value="{{$user->full_name}}"
                               required=""
                               name="full_name" readonly>
                        <span class="text-danger">
                                <strong id="full_name-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="input03">Email</label>
                        <input type="email" class="form-control" id="email" value="{{$user->email}}" required=""
                               name="email" readonly>
                        <span class="text-danger">
                                <strong id="email-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="input04">Current Password</label>
                        <input type="password" class="form-control" id="current_password" required=""
                               name="current_password" readonly>
                        <span class="text-danger">
                                <strong id="current_password-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="input04">New Password</label>
                        <input type="password" class="form-control" id="password" required=""
                               name="password" readonly>
                        <span class="text-danger">
                                <strong id="password-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="input04">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm" required=""
                               name="confirm" readonly>
                        <span class="text-danger">
                                <strong id="confirm-error"></strong>
                        </span>
                    </div>
                    <div class="form-group" id="btn_action">
                        <a href="javascript:void(0)" class="update_account btn btn-success" data-id="{{$user->id}}">Update
                            Account</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="message_warning">
        <div class="alert alert-success" id="showmess" style="display: none"></div>
        @if(session('message'))
            <div class="alert alert-success">
                {{session('message')}}
                <button style="float: right;border: none;background-color: #dff0d8">X</button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{session('error')}}
                <button style="float: right;border: none;background-color: #f2dede">X</button>
            </div>
        @endif
    </div>
@endsection
