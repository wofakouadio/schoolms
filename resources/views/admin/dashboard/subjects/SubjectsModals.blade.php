{{--Create new subject--}}
<div class="modal fade" id="new-subject-modal">
    <form method="post" id="new-subject-form">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <div class="col-xl-12 mb-4">
                        <label  class="form-label font-w600">Subject Name<span class="text-danger scale5 ms-2">*</span></label>
                        <input type="text" class="form-control solid" placeholder="Subject Name" aria-label="name"
                               name="subject_name" value="{{old('name')}}">
                    </div>
                    <div class="col-xl-12 mb-4">
                        <label  class="form-label font-w600">Type<span class="text-danger scale5 ms-2">*</span></label>
                        <select class="form-control" name="subject_type">
                            <option value="">Choose</option>
                            <option value="Core">Core Subject</option>
                            <option value="Elective">Elective Subject</option>
                        </select>
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


{{--edit subject--}}
<div class="modal fade" id="edit_subject_modal">
    <form method="post" id="update_subject_form">
        @csrf
        @method('PUT')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <div class="col-xl-12 mb-4">
                        <label  class="form-label font-w600">Subject Name<span class="text-danger scale5 ms-2">*</span></label>
                        <input type="text" class="form-control solid" placeholder="Subject Name" aria-label="name"
                               name="subject_name" value="{{old('name')}}">
                        <input type="hidden" name="subject_id">
                    </div>
                    <div class="col-xl-12 mb-4">
                        <label  class="form-label font-w600">Type<span class="text-danger scale5 ms-2">*</span></label>
                        <select class="form-control" name="subject_type">
                            <option value="">Choose</option>
                            <option value="Core">Core Subject</option>
                            <option value="Elective">Elective Subject</option>
                        </select>
                    </div>
                    <div class="col-xl-12 mb-4">
                        <label  class="form-label font-w600">Status<span class="text-danger scale5
                        ms-2">*</span></label>
                        <select class="form-control" name="subject_status">
                            <option value="">Choose</option>
                            <option value="0">ACTIVE</option>
                            <option value="1">DISABLED</option>
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


{{--delete subject--}}
<div class="modal fade" id="delete_subject_modal">
    <form method="post" id="delete_subject_form">
        @csrf
        @method('DELETE')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <h4 class="text-danger fw-bold delete-notice"></h4>
                    <span class="text-muted">Note that this action is irreversible</span>
                    <input type="hidden" name="subject_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>
