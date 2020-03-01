<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="userCrudModal">Add New Category</h1>
            </div>
            <div class="modal-body">
                <form id="addForm" name="addForm" class="form-horizontal"
                      action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="deliverer_id" id="deliverer_id" value="">
                    <input type="hidden" name="_method" value="POST">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-12">Deliverer Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="deliverer_name" name="deliverer_name"
                                   placeholder="Enter deliverer's name"
                                   value="" maxlength="50" required="">
                            <input type="hidden" value="" id="cate_form" name="cate_name">
                            <span class="text-danger">
                                <strong id="deliverer_name-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Deliverer Phone</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="deliverer_phone" name="deliverer_phone"
                                   placeholder="Enter deliverer's phone number "
                                   value="" maxlength="50" required="">
                            <span class="text-danger">
                                <strong id="deliverer_phone-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Date Created</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="created_at" name="created_at">
                            <span class="text-danger">
                                <strong id="created_at-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Date Updated</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="updated_at" name="updated_at">
                            <span class="text-danger">
                                <strong id="updated_at-error"></strong>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" value="add_deliverer">Save changes
                </button>
                <button type="button" class="btn btn-default" id="btn-back" value="back">Back
                </button>
            </div>
        </div>
    </div>
</div>