<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="userCrudModal">Update Deliverer</h1>
            </div>
            <div class="modal-body">
                <form id="editForm" name="editForm" class="form-horizontal"
                      action="{{route('deliverer.update',$deliverer->id)}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="deliverer_id" id="deliverer_id" value="{{$deliverer->id}}">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-12">Deliverer Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="deliverer_name" name="deliverer_name"
                                   placeholder="Enter Deliverer Name"
                                   value="{{$deliverer->deliverer_name}}" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="delivery_name-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Deliverer Phone</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="deliverer_phone" name="deliverer_phone"
                                   placeholder="Enter Deliverer Phone"
                                   value="{{$deliverer->deliverer_phone}}" maxlength="10" required="">
                            <span class="text-danger">
                                <strong id="delivery_phone-error"></strong>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-savechanges" value="edit_deliverer">Save changes
                </button>
                <button type="button" class="btn btn-default" id="btn-back" value="back">Back
                </button>
            </div>
        </div>
    </div>
</div>
