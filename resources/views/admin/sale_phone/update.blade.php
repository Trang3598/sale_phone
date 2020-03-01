<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="userCrudModal">Update Sale Phone</h1>
            </div>
            <div class="modal-body">
                <form id="editForm" name="editForm" class="form-horizontal"
                      action="{{route('sale_phone.update',$sale_phone->id)}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="phone_id_id" id="phone_id_id" value="{{$sale_phone->id}}">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-12">Product</label>
                        <div class="col-sm-12">
                            {!! Form::select('phone_id', ['' => 'Enter the phone name...'] + $phones,$sale_phone->phone_id,['class'=> 'form-control']) !!}
                            <span class="text-danger">
                                <strong id="phone_id-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Quantity</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="quantity" name="quantity" value="{{$sale_phone->quantity}}">
                            <span class="text-danger">
                                <strong id="quantity-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Date Created</label>
                        <div class="col-sm-12">
                            {!! Form::date('created_at',$sale_phone->created_at,['class'=>'form-control','id'=>'created_at']) !!}
                            <span class="text-danger">
                                <strong id="created_at-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Date Updated</label>
                        <div class="col-sm-12">
                            {!! Form::date('updated_at',$sale_phone->created_at,['class'=>'form-control','id'=>'updated_at']) !!}
                            <span class="text-danger">
                                <strong id="updated_at-error"></strong>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-savechanges" value="edit_sale_phone">Save changes
                </button>
                <button type="button" class="btn btn-default" id="btn-back" value="back">Back
                </button>
            </div>
        </div>
    </div>
</div>
