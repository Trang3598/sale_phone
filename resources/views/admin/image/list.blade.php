@extends('admin.layout.index')
@section('content')
    <div class="card">
        <div class="card-body">
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
            @can('image-create')
                <div style="padding-bottom:25px;float: right" class="btn-add">
                    <a href="javascript:void(0)" class="add-image btn btn-info">Add New Image</a>
                </div>
            @endcan
            <div style="padding-top: 25px">
                <label>Total: {{isset($count)?$count:0}} records</label>
            </div>
            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Product</th>
                        <th>Image</th>
                        <th>Date Created</th>
                        <th>Date Updated</th>
                        @can('image-edit','image-delete')
                            <th colspan="2">Action</th>
                        @endcan
                    </tr>
                    </thead>
                    <tbody id="listItem">
                    @if($images)
                        @foreach($images as $image)
                            <tr id="id_{{$image->id }}">
                                <td id="image_id_{{$image->id}}">{{$image->id}}</td>
                                <td id="product_id_{{$image->id}}">{{(isset($image->product->name_phone)) ?$image->product->name_phone:''}}</td>
                                <td><a href="javascript:void(0)" class="show-image"
                                       data-id="{{ $image->id }}">
                                        <img id="image_{{$image->id}}" src="images/{{$image->image}}" alt=""
                                             style="height:50px;width: 50px" class="img-responsive"/>
                                    </a></td>
                                <td id="created_at_{{$image->id}}">{{isset($image->created_at)?$image->created_at->format('d/m/Y'):''}}</td>
                                <td id="updated_at_{{$image->id}}">{{isset($image->updated_at)?$image->updated_at->format('d/m/Y'):''}}</td>
                                @can('image-edit')
                                    <td>
                                        <div class="btn-edit">
                                            <a href="javascript:void(0)" class="edit-image btn btn-success"
                                               data-id="{{$image->id}}">Update</a>
                                        </div>
                                    </td>
                                @endcan
                                @can('image-delete')
                                    <td>
                                        <a href="javascript:void(0)" id="delete-image"
                                           data-id="{{$image->id}}"
                                           class="btn btn-danger delete-image">Delete</a>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div style="padding-top: 20px">
                {!! $images->appends(compact('items'))->links()!!}
            </div>
            @endsection
            @section('form-add')
                <div id="image"></div>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('div.message_warning').on('click', function () {
                            $('div.message_warning').remove();
                        });
                    });
                </script>
                <script>
                    $(document).ready(function () {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $(document).on('click', '#btn-back', function () {
                            $('#ajax-crud-modal').hide();
                        });
                        $(document).on('click', '.add-image', function () {
                            $.get('admin/image/create', function (data) {
                                $("#image").html(data);
                                $('#userCrudModal').html("Add New Image");
                                $('#btn-save').val("add-image");
                                $('#ajax-crud-modal').modal('show');
                            })
                        });
                        $(document).on('click', '.edit-image', function () {
                            var image_id = $(this).data('id');
                            $.get('admin/image/' + image_id + '/edit', function (data) {
                                $("#image").html(data);
                                $('#userCrudModal').html("Edit Image Information");
                                $('#btn-save').val("edit-image");
                                $('#ajax-crud-modal').modal('show');
                            })
                        });
                    });
                    $(document).on('click', '#btn-save', function (event) {
                        event.preventDefault();
                        var form_data = new FormData($('#addForm')[0]);
                        form_data.append('_method', 'post');
                        if ($("#addForm").length > 0) {
                            var actionType = $('#btn-save').val();
                            $('#btn-save').html('Sending..');
                            $.ajax({
                                data: form_data,
                                url: $('#addForm').attr('action'),
                                type: "POST",
                                contentType: false,
                                processData: false,
                                success: function (data) {
                                    var dataItem = '<tr id="id_' + data.id + '"><td>' + data.id + '</td><td>' + data.product_id + '</td><td><a href="javascript:void(0)" class="show-image" data-id ="' + data.id + '"><img id="image_' + data.id + '"  src = "images/' + data.image + '" alt ="" style="height:50px;width: 50px" class="img-responsive" />' + '</td><td>' + data.created_at + '</td><td>' + data.updated_at + '</td>';
                                    dataItem += '<td><a href="javascript:void(0)" id="edit-image" data-id="' + data.id + '" class="btn btn-success mr-2">Update</a></td>';
                                    dataItem += '<td><a href="javascript:void(0)" id="delete-image" data-id="' + data.id + '" class="btn btn-danger delete-user ml-1">Delete</a></td></tr>';
                                    $('#listItem').append(dataItem);
                                    $('#ajax-crud-modal').modal('hide');
                                    $('#addForm').trigger("reset");
                                    $('#btn-save').html('Save Changes');
                                    $('#showmess').html('Add successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    if (data.responseJSON.errors) {
                                        $('#product_id-error').html(data.responseJSON.errors.product_id);
                                        $('#image-error').html(data.responseJSON.errors.image);
                                        $('#created_at-error').html(data.responseJSON.errors.created_at);
                                        $('#updated_at-error').html(data.responseJSON.errors.updated_at);
                                        $('#btn-save').html('Save Changes');
                                        $('#image').val('');
                                    }
                                }
                            });
                        }
                    });
                    $(document).on('click', '#btn-savechanges', function (event) {
                        event.preventDefault();
                        var form_data = new FormData($('#editForm')[0]);
                        form_data.append('_method', 'patch');
                        if ($("#editForm").length > 0) {
                            var actionType = $('#btn-savechanges').val();
                            $('#btn-savechanges').html('Sending..');
                            $.ajax({
                                data: form_data,
                                url: $('#editForm').attr('action'),
                                type: "POST",
                                contentType: false,
                                processData: false,
                                success: function (data) {
                                    $("#product_id" + data.id).html(data.product_id);
                                    $("#image_" + data.id).attr('src', 'images/' + data.image);
                                    $("#created_at_" + data.id).html(data.created_at);
                                    $("#updated_at_" + data.id).html(data.updated_at);
                                    $('#ajax-crud-modal').modal('hide');
                                    $('#editForm').trigger("reset");
                                    $('#btn-savechanges').html('Save Changes');
                                    $('#showmess').html('Edit successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    if (data.responseJSON.errors) {
                                        if (data.responseJSON.errors.product_id) {
                                            $('#product_id-error').html(data.responseJSON.errors.product_id);
                                        }
                                        if (data.responseJSON.errors.image) {
                                            $('#image-error').html(data.responseJSON.errors.image);
                                        }
                                        if (data.responseJSON.errors.created_at) {
                                            $('#created_at-error').html(data.responseJSON.errors.created_at);
                                        }
                                        if (data.responseJSON.errors.updated_at) {
                                            $('#updated_at-error').html(data.responseJSON.errors.updated_at);
                                        }
                                        $('#btn-save').html('Save Changes');
                                        $('#image').val('');
                                    }
                                }
                            });
                        }
                    });
                    $('body').on('click', '#delete-image', function (event) {
                        event.preventDefault();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var image_id = $(this).data("id");
                        if (confirm("Are you sure want to delete this field !")) {
                            $.ajax({
                                type: "GET",
                                url: "admin/image/destroy/" + image_id,
                                contentType: false,
                                processData: false,
                                success: function (data) {
                                    $("#id_" + image_id).remove();
                                    $('#showmess').html('Delete successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    console.log('Error:', data);
                                }
                            });
                        }
                    });
                </script>
                <script type="text/javascript">
                    $('#search').keyup(function () {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var value = $(this).val();
                        var dataString = 'key=' + value;
                        $.ajax({
                            type: 'GET',
                            url: 'image/search',
                            data: dataString,
                            success: function (data) {
                                $('#listItem').html(data);
                            },
                        });
                    });
                </script>
            @endsection
            @section('show-image')
                <div id="image">
                </div>
                <script>
                    $('body').on('click', '.show-image', function () {
                        var image_id = $(this).data('id');
                        $.get('admin/image/' + image_id + '/showImage', function (data) {
                            $("#image").html(data);
                            $('#ajax-show-image').modal('show');
                        });
                    });
                </script>
@endsection
