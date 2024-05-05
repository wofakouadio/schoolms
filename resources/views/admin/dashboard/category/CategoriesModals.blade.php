{{--Create new category--}}
<div class="modal fade" id="new-category-modal">
    <form method="post" id="new-category-form">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Category</h5>
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
                            <input type="text" name="category_name" value="{{old('category_name')}}" class="form-control
                            solid">
                            <input type="hidden" name="school_id" value="{{Auth::guard('admin')->user()->school_id}}">
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Description</label>
                            <textarea class="form-control solid" aria-label="name" name="category_description"
                                      cols="10" rows="5">{{old
                            ('category_description')}}</textarea>
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


{{--Edit/Update category data--}}
<div class="modal fade" id="edit-category-modal">
    <form method="post" id="update-category-form">
        @csrf
        @method('PUT')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Category</h5>
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
                            <input type="text" name="category_name" value="{{old('category_name')}}" class="form-control
                            solid">
                            <input type="hidden" name="category_id">
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Description</label>
                            <textarea class="form-control solid" aria-label="name" name="category_description" cols="10"
                                      rows="5">{{old
                            ('category_description')}}</textarea>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Status</label>
                            <select class="form-control" name="category_is_active">
                                <option value="">Choose</option>
                                <option value="1">ACTIVE</option>
                                <option value="0">DISABLED</option>
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

{{--delete category data--}}
<div class="modal fade" id="delete-category-modal">
    <form method="post" id="delete-category-form">
        @csrf
        @method('DELETE')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <h4 class="text-danger fw-bold delete-notice"></h4>
                    <span class="text-muted">Note that this action is irreversible</span>
                    <input type="hidden" name="category_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </div>
        </div>
    </form>
</div>

