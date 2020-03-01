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
            @can('category-create')
                <div style="padding-bottom:25px;float: right" class="btn-add">
                    <a href="javascript:void(0)" class="add-cate btn btn-info">Add New Category</a>
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
                        <th>Name</th>
                        <th>Date Created</th>
                        <th>Date Updated</th>
                        @can('category-edit','category-delete')
                            <th colspan="2">Action</th>
                        @endcan
                    </tr>
                    </thead>
                    <tbody id="listItem">
                    @if($categories)
                        @foreach($categories as $category)
                            <tr id="id_{{ $category->id }}">
                                <td id="category_id_{{$category->id}}">{{$category->id}}</td>
                                <td id="category_name_{{$category->id}}">{{$category->category_name}}</td>
                                <td id="created_at_{{$category->id}}">{{$category->created_at->format('d/m/Y')}}</td>
                                <td id="updated_at_{{$category->id}}">{{$category->updated_at->format('d/m/Y')}}</td>
                                @can('category-edit')
                                    <td>
                                        <div class="btn-edit">
                                            <a href="javascript:void(0)" class="edit-cate btn btn-success"
                                               data-id="{{$category->id}}">Update</a>
                                        </div>
                                    </td>
                                @endcan
                                @can('category-delete')
                                    <td>
                                        <a href="javascript:void(0)" id="delete-category"
                                           data-id="{{$category->id}}"
                                           class="btn btn-danger delete-category">Delete</a>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div style="padding-top: 20px">
                {!! $categories->appends(compact('items'))->links()!!}
            </div>
            @endsection
            @section('form-add')
                <div id="category"></div>
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
                        $(document).on('click', '.add-cate', function () {
                            $.get('admin/category/create', function (data) {
                                $("#category").html(data);
                                $('#userCrudModal').html("Add New Category");
                                $('#btn-save').val("add-cate");
                                $('#ajax-crud-modal').modal('show');
                            })
                        });
                        $(document).on('click', '.edit-cate', function () {
                            var category_id = $(this).data('id');
                            $.get('admin/category/' + category_id + '/edit', function (data) {
                                $("#category").html(data);
                                $('#userCrudModal').html("Edit Category");
                                $('#btn-save').val("edit-cate");
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
                                    var dataItem = '<tr id="id_' + data.id + '"><td>' + data.id + '</td><td>' + data.category_name + '</td><td>' + data.created_at + '</td><td>' + data.updated_at + '</td>';
                                    dataItem += '<td><a href="javascript:void(0)" id="edit-cate" data-id="' + data.id + '" class="btn btn-success mr-2">Update</a></td>';
                                    dataItem += '<td><a href="javascript:void(0)" id="delete-category" data-id="' + data.id + '" class="btn btn-danger delete-user ml-1">Delete</a></td></tr>';
                                    $('#listItem').append(dataItem);
                                    $('#ajax-crud-modal').modal('hide');
                                    $('#addForm').trigger("reset");
                                    $('#btn-save').html('Save Changes');
                                    $('#showmess').html('Add successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    if (data.responseJSON.errors) {
                                        $('#category_name-error').html(data.responseJSON.errors.category_name);
                                        $('#created_at-error').html(data.responseJSON.errors.created_at);
                                        $('#updated_at-error').html(data.responseJSON.errors.updated_at);
                                    }
                                    $('#btn-save').html('Save Changes');
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
                                    $("#category_name_" + data.id).html(data.category_name);
                                    $("#created_at_" + data.id).html(data.created_at);
                                    $("#updated_at_" + data.id).html(data.updated_at);
                                    $('#ajax-crud-modal').modal('hide');
                                    $('#editForm').trigger("reset");
                                    $('#btn-savechanges').html('Save Changes');
                                    $('#showmess').html('Edit successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    if (data.responseJSON.errors) {
                                        if (data.responseJSON.errors.category_name) {
                                            $('#category_name-error').html(data.responseJSON.errors.category_name);
                                        }
                                        if (data.responseJSON.errors.created_at) {
                                            $('#created_at-error').html(data.responseJSON.errors.created_at);
                                        }
                                        if (data.responseJSON.errors.updated_at) {
                                            $('#updated_at-error').html(data.responseJSON.errors.updated_at);
                                        }
                                        $('#btn-save').html('Save Changes');
                                    }
                                }
                            });
                        }
                    });
                    $('body').on('click', '#delete-category', function (event) {
                        event.preventDefault();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var category_id = $(this).data("id");
                        if (confirm("Are you sure want to delete this field !")) {
                            $.ajax({
                                type: "GET",
                                url: "admin/category/destroy/" + category_id,
                                contentType: false,
                                processData: false,
                                success: function (data) {
                                    $("#id_" + category_id).remove();
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
                            url: 'category/search',
                            data: dataString,
                            success: function (data) {
                                $('#listItem').html(data);
                            },
                        });
                    });
                </script>
@endsection
