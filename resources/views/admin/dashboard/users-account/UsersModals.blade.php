{{-- Create ne teacher --}}
<div class="modal fade" id="new-user-modal">
    <form method="post" id="new-user-form" action="{{route('add-new-user')}}">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>

                    <div class="row">
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">User<span
                                    class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="user">
                                <option value="">Choose</option>
                            </select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Status<span
                                    class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="user_status">
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

