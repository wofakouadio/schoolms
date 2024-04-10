{{--Create new level--}}
<div class="modal fade" id="new-level-modal">
    <form method="post" id="new-level-form">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Level</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Name<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" name="level_name" value="{{old('level_name')}}" class="form-control
                            solid">
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Description</label>
                            <textarea class="form-control solid" aria-label="name" name="level_description"
                                      cols="10" rows="5">{{old
                            ('level_description')}}</textarea>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Branch</label>
                            <select class="form-control" name="branch"></select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>


{{--Edit/Update level data--}}
<div class="modal fade" id="edit-level-modal">
    <form method="post" id="update-level-form">
        @csrf
        @method('PUT')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Level</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Name<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" name="level_name" value="{{old('level_name')}}" class="form-control
                            solid">
                            <input type="hidden" name="level_id">
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Description</label>
                            <textarea class="form-control solid" aria-label="name" name="level_description" cols="10" rows="5">{{old
                            ('level_description')}}</textarea>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Branch</label>
                            <select class="form-control" name="branch"></select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Status</label>
                            <select class="form-control" name="level_is_active">
                                <option value="">Choose</option>
                                <option value="0">ACTIVE</option>
                                <option value="1">DISABLED</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </form>
</div>

{{--delete level data--}}
<div class="modal fade" id="delete-level-modal">
    <form method="post" id="delete-level-form">
        @csrf
        @method('DELETE')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Level</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <h4 class="text-danger fw-bold delete-notice"></h4>
                    <span class="text-muted">Note that this action is irreversible</span>
                    <input type="hidden" name="level_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </div>
        </div>
    </form>
</div>

