{{--Create ne department--}}
<div class="modal fade" id="new-department-modal">
    <form method="post" id="new-department-form">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <div class="col-xl-12 mb-4">
                        <label  class="form-label font-w600">Name<span class="text-danger scale5 ms-2">*</span></label>
                        <input type="text" class="form-control solid" placeholder="Name" aria-label="name" name="name" value="{{old('name')}}">
                    </div>
                    <div class="col-xl-12 mb-4">
                        <label  class="form-label font-w600">Description</label>
                        <textarea class="form-control solid" rows="5" aria-label="With textarea" name="description">{{old('description')}}</textarea>
                    </div>
                    <div class="col-xl-12 mb-4">
                        <label  class="form-label font-w600">Branch<span class="text-danger scale5 ms-2">*</span></label>
                        <select class="form-control" name="branch"></select>
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

{{--Edit department--}}
<div class="modal fade" id="edit-department-modal">
    <form method="post" id="update-department-form">
        @csrf
        @method('PUT')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <div class="col-xl-12 mb-4">
                        <label  class="form-label font-w600">Name<span class="text-danger scale5 ms-2">*</span></label>
                        <input type="text" class="form-control solid" placeholder="Name" aria-label="name" name="name" value="{{old('name')}}">
                        <input type="hidden" name="department_id">
                    </div>
                    <div class="col-xl-12 mb-4">
                        <label  class="form-label font-w600">Description</label>
                        <textarea class="form-control solid" rows="5" aria-label="With textarea" name="description">{{old('description')}}</textarea>
                    </div>
                    <div class="col-xl-12 mb-4">
                        <label  class="form-label font-w600">Branch<span class="text-danger scale5 ms-2">*</span></label>
                        <select class="form-control" name="branch"></select>
                    </div>
                    <div class="col-xl-12 mb-4">
                        <label  class="form-label font-w600">Status</label>
                        <select class="form-control" name="department_status">
                            <option value="">Choose</option>
                            <option value="1">ACTIVE</option>
                            <option value="0">DISABLED</option>
                        </select>
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

{{--assign levels to department--}}
<div class="modal fade" id="assign-leveltodepartment-modal" aria-hidden="true">
    <form method="post" id="assign-leveltodepartment-form">
        @csrf
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Assignment of Department to Level</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Department</label>
                            <input type="hidden" name="department_id">
                            <input class="form-control" name="department_name" type="text" readonly>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Branch</label>
                            <input type="hidden" name="branch_id">
                            <input class="form-control" name="branch_name" type="text" readonly>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Level</label>
                            {{-- <select class="multi-select select2-hidden-accessible form-control solid" name="level_id[]" id="single-select" multiple>
                                <option>Choose</option>
                            </select> --}}
                            <div class="row levelCheckboxOne"></div>
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


{{--Delete department--}}
<div class="modal fade" id="delete-department-modal">
    <form method="post" id="delete-department-form">
        @csrf
        @method('DELETE')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <h4 class="text-danger fw-bold delete-notice"></h4>
                    <span class="text-muted">Note that this action is irreversible</span>
                    <input type="hidden" name="department_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </div>
        </div>
    </form>
</div>
