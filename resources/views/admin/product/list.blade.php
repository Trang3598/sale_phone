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
            <div style="padding-bottom:25px;float: right" class="btn-add">
                @csrf
                <a href="{{ route('product.export') }}" class="btn btn-outline-success export" id="export-button">Export
                    file </a>
                @can('product-create')
                    <a href="javascript:void(0)" class="add-product btn btn-info">Add New Product</a>
                @endcan
            </div>
            <div class="col-8">
                {!! Form::open(['method' => 'GET','route' => 'product.index']) !!}
                <table class="table table-hover">
                    <tr>
                        <td>Choose a price:</td>
                        <td>{{Form::number('price_from',\Request::get('price_from'),['class' => 'form-control'])}}</td>
                        <td>TO</td>
                        <td>{{Form::number('price_to',\Request::get('price_to'),['class' => 'form-control'])}}</td>
                    </tr>
                    <tr>
                        <td>Sort</td>
                        <td colspan="3">
                            {!! Form::select('showList', ['0'=>'Choose option','1' => 'HOT', '2' => 'High to low prices','3' => 'Low to high prices'], \Request::get('showList'),['class'=>'form-control']) !!}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="float:right">
                {!! Form::select('pagination', ['0'=>'Open this select menu','50' => '50', '100' => '100','200' => '200'], \Request::get('pagination'),['class'=>'form-control','id'=>'pagination']) !!}
            </div>
            {!! Form::close() !!}
        </div>
        <div style="margin-left: 20px">
            <label>Total: {{isset($count)?$count:0}} records</label>
        </div>
        <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
                <thead>
                <tr class="text-center">
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Phone Name</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Detail</th>
                    <th>Price(VND)</th>
                    <th>Size</th>
                    <th>Memory</th>
                    <th>Weight</th>
                    <th>Speed CPU</th>
                    <th>RAM</th>
                    <th>OS</th>
                    <th>Camera Primary</th>
                    <th>Battery</th>
                    <th>Wlan</th>
                    <th>Warranty</th>
                    <th>Bluetooth</th>
                    <th>Promotion Price(VND)</th>
                    <th>Start Promotion</th>
                    <th>End Promotion</th>
                    <th>Sale Phone Status</th>
                    <th>Date Created</th>
                    <th>Date Updated</th>
                    <th colspan="3">Action</th>
                </tr>
                </thead>
                <tbody id="listItem">
                @if($products)
                    @foreach($products as $product)
                        <tr id="id_{{ $product->id }}">
                            <td id="product_id_{{$product->id}}">{{$product->id}}</td>
                            <td id="id_cate_{{$product->id}}">{{(isset($product->category->category_name)) ?$product->category->category_name:''}}</td>
                            <td id="name_phone_{{$product->id}}">{{$product->name_phone}}</td>
                            <td id="title_{{$product->id}}">{{$product->title}}</td>
                            <td id="description_{{$product->id}}">{{$product->description}}</td>
                            <td id="quantity_{{$product->id}}">{{$product->quantity}}</td>
                            <td id="detail_{{$product->id}}">{{$product->detail}}</td>
                            <td id="price_{{$product->id}}">{{$product->price}}</td>
                            <td id="size_{{$product->id}}">{{$product->size}}</td>
                            <td id="memory_{{$product->id}}">{{$product->memory}}</td>
                            <td id="weight_{{$product->id}}">{{$product->weight}}</td>
                            <td id="cpu_speed_{{$product->id}}">{{$product->cpu_speed}}</td>
                            <td id="ram_{{$product->id}}">{{$product->ram}}</td>
                            <td id="os_{{$product->id}}">{{$product->os}}</td>
                            <td id="camera_primary_{{$product->id}}">{{$product->camera_primary}}</td>
                            <td id="battery_{{$product->id}}">{{$product->battery}}</td>
                            <td id="promotion_price_{{$product->id}}">{{$product->wlan}}</td>
                            <td id="warranty_{{$product->id}}">{{$product->warranty}}
                            <td id="bluetooth_{{$product->id}}">{{$product->bluetooth}}</td>
                            <td id="name_phone_{{$product->id}}">{{$product->promotion_price}}</td>
                            <td id="start_promotion_{{$product->id}}">{{isset($product->start_promotion)?$product->start_promotion->format('d/m/Y'):''}}</td>
                            <td id="end_promotion_{{$product->id}}">{{isset($product->end_promotion)?$product->end_promotion->format('d/m/Y'):''}}</td>
                            <td id="sale_phone_{{$product->id}}">{{$product->sale_phone == 1 ? "Best Seller" : "Unmarketable"}}</td>
                            <td id="created_at_{{$product->id}}">{{isset($product->created_at)?$product->created_at->format('d/m/Y'):''}}</td>
                            <td id="updated_at_{{$product->id}}">{{isset($product->updated_at)?$product->updated_at->format('d/m/Y'):''}}</td>
                            <td>
                                <a href="javascript:void(0)" id="image-product"
                                   data-id="{{$product->id}}"
                                   class="image-product btn btn-primary">Watch</a>
                            </td>
                            @can('product-edit')
                                <td>
                                    <div class="btn-edit">
                                        <a href="javascript:void(0)" class="edit-product btn btn-success"
                                           data-id="{{$product->id}}">Update</a>
                                    </div>
                                </td>
                            @endcan
                            @can('product-delete')
                                <td>
                                    <a href="javascript:void(0)" id="delete-product"
                                       data-id="{{$product->id}}"
                                       class="btn btn-danger delete-product">Delete</a>
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <div style="padding-top: 20px">
            {!! $products->appends(compact('items'))->links()!!}
        </div>

        @endsection
        @section('form-add')
            <div id="product"></div>
            <script type="text/javascript">
                document.getElementById('pagination').onchange = function () {
                    window.location = "{{ $products->url(1) }}&items=" + this.value;
                };
            </script>
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
                    $(document).on('click', '.add-product', function () {
                        $.get('admin/product/create', function (data) {
                            $("#product").html(data);
                            $('#userCrudModal').html("Add New Product");
                            $('#btn-save').val("add-cate");
                            $('#ajax-crud-modal').modal('show');
                        })
                    });
                    $(document).on('click', '.edit-product', function () {
                        var product_id = $(this).data('id');
                        $.get('admin/product/' + product_id + '/edit', function (data) {
                            $("#product").html(data);
                            $('#userCrudModal').html("Edit Product");
                            $('#btn-save').val("edit-cate");
                            $('#ajax-crud-modal').modal('show');
                        })
                    });
                    $(document).on('click', '.image-product', function () {
                        var product_id = $(this).data('id');
                        $.get('product/image/' + product_id, function (data) {
                            $("#product").html(data);
                            $('#ajax-show-image').modal('show');
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
                                var dataItem = '<tr id="id_' + data.id + '"><td id = "product_id_">' + data.id + '</td><td id="id_cate_">' + data.id_cate + '</td><td id="name_phone_">' + data.name_phone
                                    + '</td><td id="title_">' + data.title + '</td><td id="description_">' + data.description + '</td><td id="quantity_">' + data.quantity + '</td><td id="detail_">' + data.detail
                                    + '</td><td id="price_">' + data.price + '</td><td id="size_">' + data.size + '</td><td id="ram_">' + data.ram + '</td><td id="memory_">' + data.memory
                                    + '</td><td id="weight_">' + data.weight + '</td><td id="cpu_speed_">' + data.cpu_speed + '</td><td id="os_">' + data.os + '</td><td id="camera_primary_">' + data.camera_primary
                                    + '</td><td id="battery_">' + data.battery + '</td><td id="warranty_">' + data.warranty + '</td><td id="wlan_">' + data.wlan + '</td><td id = "memory_">' + data.memory + '</td><td id ="promotion_price_">'
                                    + data.promotion_price + '</td><td id = "start_promotion_">' + data.start_promotion + '</td><td id = "end_promotion_">' + data.end_promotion + '</td><td id = "sale_phone_">' + data.sale_phone + '</td><td id = "created_at_">' + data.created_at
                                    + '</td><td id = "updated_at_">' + data.updated_at + '</td>';
                                dataItem += '<td><a href="javascript:void(0)" id="edit-product" data-id="' + data.id + '" class="btn btn-success mr-2">Update</a></td>';
                                dataItem += '<td><a href="javascript:void(0)" id="delete-product" data-id="' + data.id + '" class="btn btn-danger delete-user ml-1">Delete</a></td></tr>';
                                $('#listItem').append(dataItem);
                                $('#ajax-crud-modal').modal('hide');
                                $('#addForm').trigger("reset");
                                $('#btn-save').html('Save Changes');
                                $('#showmess').html('Add successfully').css({'display': 'block'});
                            },
                            error: function (data) {
                                if (data.responseJSON.errors) {
                                    $('#id_cate-error').html(data.responseJSON.errors.id_cate);
                                    $('#name_phone-error').html(data.responseJSON.errors.name_phone);
                                    $('#title-error').html(data.responseJSON.errors.title);
                                    $('#description-error').html(data.responseJSON.errors.description);
                                    $('#quantity-error').html(data.responseJSON.errors.quantity);
                                    $('#detail-error').html(data.responseJSON.errors.detail);
                                    $('#price-error').html(data.responseJSON.errors.price);
                                    $('#size-error').html(data.responseJSON.errors.size);
                                    $('#ram-error').html(data.responseJSON.errors.ram);
                                    $('#memory-error').html(data.responseJSON.errors.memory);
                                    $('#weight-error').html(data.responseJSON.errors.weight);
                                    $('#cpu_speed-error').html(data.responseJSON.errors.cpu_speed);
                                    $('#os-error').html(data.responseJSON.errors.os);
                                    $('#camera_primary-error').html(data.responseJSON.errors.camera_primary);
                                    $('#battery-error').html(data.responseJSON.errors.battery);
                                    $('#warranty-error').html(data.responseJSON.errors.warranty);
                                    $('#wlan-error').html(data.responseJSON.errors.wlan);
                                    $('#bluetooth-error').html(data.responseJSON.errors.memory);
                                    $('#promotion_price-error').html(data.responseJSON.errors.promotion_price);
                                    $('#start_promotion-error').html(data.responseJSON.errors.start_promotion);
                                    $('#end_promotion-error').html(data.responseJSON.errors.end_promotion);
                                    $('#sale_phone-error').html(data.responseJSON.errors.sale_phone);
                                    $('#created_at-error').html(data.responseJSON.errors.created_at);
                                    $('#updated_at-error').html(data.responseJSON.errors.updated_at);
                                    $('#btn-save').html('Save Changes');
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
                                    $("#id_cate_" + data.id).html(data.id_cate);
                                    $("#name_phone_" + data.id).html(data.name_phone);
                                    $("#title_" + data.id).html(data.title);
                                    $("#description_" + data.id).html(data.description);
                                    $("#quantity_" + data.id).html(data.quantity);
                                    $("#detail_" + data.id).html(data.detail);
                                    $("#price_" + data.id).html(data.price);
                                    $("#size_" + data.id).html(data.size);
                                    $("#memory_" + data.id).html(data.memory);
                                    $("#weight_" + data.id).html(data.weight);
                                    $("#cpu_speed_" + data.id).html(data.cpu_speed);
                                    $("#ram_" + data.id).html(data.ram);
                                    $("#os_" + data.id).html(data.os);
                                    $("#camera_primary_" + data.id).html(data.camera_primary);
                                    $("#battery_" + data.id).html(data.battery);
                                    $("#wlan_" + data.id).html(data.wlan);
                                    $("#warranty_" + data.id).html(data.warranty);
                                    $("#bluetooth_" + data.id).html(data.bluetooth);
                                    $("#promotion_price_" + data.id).html(data.promotion_price);
                                    $("#start_promotion" + data.id).html(data.start_promotion);
                                    $("#end_promotion_" + data.id).html(data.end_promotion);
                                    $("#sale_phone_" + data.id).html(data.sale_phone);
                                    $("#created_at_" + data.id).html(data.created_at);
                                    $("#updated_at_" + data.id).html(data.updated_at);
                                    $('#ajax-crud-modal').modal('hide');
                                    $('#editForm').trigger("reset");
                                    $('#btn-savechanges').html('Save Changes');
                                    $('#showmess').html('Edit successfully').css({'display': 'block'});
                                },
                                error: function (data) {
                                    if (data.responseJSON.errors.id_cate) {
                                        $('#id_cate-error').html(data.responseJSON.errors.id_cate);
                                    }
                                    if (data.responseJSON.errors.name_phone) {
                                        $('#name_phone-error').html(data.responseJSON.errors.name_phone);
                                    }
                                    if (data.responseJSON.errors.title) {
                                        $('#title-error').html(data.responseJSON.errors.title);
                                    }
                                    if (data.responseJSON.errors.description) {
                                        $('#description-error').html(data.responseJSON.errors.description);
                                    }
                                    if (data.responseJSON.errors.quantity) {
                                        $('#quantity-error').html(data.responseJSON.errors.quantity);
                                    }
                                    if (data.responseJSON.errors.detail) {
                                        $('#detail-error').html(data.responseJSON.errors.detail);
                                    }
                                    if (data.responseJSON.errors.price) {
                                        $('#price-error').html(data.responseJSON.errors.price);
                                    }
                                    if (data.responseJSON.errors.size) {
                                        $('#size-error').html(data.responseJSON.errors.size);
                                    }
                                    if (data.responseJSON.errors.memory) {
                                        $('#memory-error').html(data.responseJSON.errors.memory);
                                    }
                                    if (data.responseJSON.errors.weight) {
                                        $('#weight-error').html(data.responseJSON.errors.weight);
                                    }
                                    if (data.responseJSON.errors.cpu_speed) {
                                        $('#cpu_speed-error').html(data.responseJSON.errors.cpu_speed);
                                    }
                                    if (data.responseJSON.errors.ram) {
                                        $('#ram-error').html(data.responseJSON.errors.ram);
                                    }
                                    if (data.responseJSON.errors.os) {
                                        $('#os-error').html(data.responseJSON.errors.os);
                                    }
                                    if (data.responseJSON.errors.camera_primary) {
                                        $('#camera_primary-error').html(data.responseJSON.errors.camera_primary);
                                    }
                                    if (data.responseJSON.errors.battery) {
                                        $('#battery-error').html(data.responseJSON.errors.battery);
                                    }
                                    if (data.responseJSON.errors.warranty) {
                                        $('#warranty-error').html(data.responseJSON.errors.warranty);
                                    }
                                    if (data.responseJSON.errors.bluetooth) {
                                        $('#bluetooth-error').html(data.responseJSON.errors.bluetooth);
                                    }
                                    if (data.responseJSON.errors.wlan) {
                                        $('#wlan-error').html(data.responseJSON.errors.wlan);
                                    }
                                    if (data.responseJSON.errors.promotion_price) {
                                        $('#promotion_price-error').html(data.responseJSON.errors.promotion_price);
                                    }
                                    if (data.responseJSON.errors.start_promotion) {
                                        $('#start_promotion-error').html(data.responseJSON.errors.start_promotion);
                                    }
                                    if (data.responseJSON.errors.end_promotion) {
                                        $('#end_promotion-error').html(data.responseJSON.errors.end_promotion);
                                    }
                                    if (data.responseJSON.errors.sale_phone) {
                                        $('#sale_phone-error').html(data.responseJSON.errors.sale_phone);
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
                        );
                    }
                });
                $('body').on('click', '#delete-product', function (event) {
                    event.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var product_id = $(this).data("id");
                    if (confirm("Are you sure want to delete this field !")) {
                        $.ajax({
                            type: "GET",
                            url: "admin/product/destroy/" + product_id,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                $("#id_" + product_id).remove();
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
                        url: 'product/search',
                        data: dataString,
                        success: function (data) {
                            $('#listItem').html(data);
                        },
                    });
                });
            </script>
            <script type="text/javascript">
                function myFunction(imgs) {
                    var expandImg = document.getElementById("expandedImg");
                    var imgText = document.getElementById("imgtext");
                    expandImg.src = imgs.src;
                    imgText.innerHTML = imgs.alt;
                    expandImg.parentElement.style.display = "block";
                }
            </script>
@endsection
