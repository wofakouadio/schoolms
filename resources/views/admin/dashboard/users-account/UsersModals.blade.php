{{-- Create user teacher --}}
<div class="modal fade" id="new-teacher-user-permission-modal">
    <form method="post" id="new-teacher-user-permission-form" action="{{route('add-new-teacher-user')}}">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Teacher User Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>

                    <div class="row">
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Teacher User<span
                                    class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="teacher_user">
                                <option value="">Choose</option>
                            </select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Status<span
                                    class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="teacher_user_status">
                                <option value="">Choose</option>
                                <option value="1">Can login</option>
                                <option value="2">Lock Account</option>
                                <option value="3">Disabled Account</option>
                            </select>
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

{{-- Edit user teacher --}}
<div class="modal fade" id="edit-teacher-user-permission-modal">
    <form method="post" id="edit-teacher-user-permission-form" action="{{route('update-teacher-user')}}">
        @csrf
        @method('PUT')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Teacher User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>

                    <div class="row">
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Teacher User<span
                                    class="text-danger scale5 ms-2">*</span></label>
                            <select class="form-control" name="teacher_user" disabled>
                                <option value="">Choose</option>
                            </select>
                            <input type="hidden" name="teacher_user_permission_id">
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Status<span
                                    class="text-danger scale5 ms-2">*</span></label>
                            <select class="form-control" name="teacher_user_status">
                                <option value="">Choose</option>
                                <option value="1">Can login</option>
                                <option value="2">Locked Account</option>
                                <option value="3">Disabled Account</option>
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

{{-- Delete User teacher --}}
<div class="modal fade" id="delete-teacher-user-permission-modal">
    <form method="post" id="delete-teacher-user-permission-form" action="{{route('delete-teacher-user')}}">
        @csrf
        @method('DELETE')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Teacher User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>

                    <div class="row">
                        <div class="col-xl-12 mb-4">
                            <h4 class="text-danger fw-bold delete-notice"></h4>
                            <span class="text-muted">Note that this action is irreversible</span>
                            <input type="hidden" name="teacher_user_permission_id">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </div>
        </div>
    </form>
</div>

