{{--Create new class assessment size--}}
<div class="modal fade" id="new-cas-modal">
    <form method="post" id="new-cas-form" action="{{route('add_new_class_assessment_size')}}">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Class Assessment Size</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label  class="form-label font-w600">Term<span class="text-danger scale5
                            ms-2">*</span></label>
                        <select class="form-control solid" name="term"></select>
                    </div>
                    <div class="form-group">
                        <label  class="form-label font-w600">Class Assessment Size<span class="text-danger scale5
                            ms-2">*</span></label>
                        <input type="number" class="form-control solid" aria-label="name" name="assessment_size"
                               value="{{old('assessment_size')}}">
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

{{--Edit Class Assessment Size--}}
<div class="modal fade" id="edit-cas-modal">
    <form method="post" id="edit-cas-form" action="{{route('update_class_assessment_size')}}">
        @csrf
        @method('PUT')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Class Assessment Size</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label  class="form-label font-w600">Term<span class="text-danger scale5
                            ms-2">*</span></label>
                        <select class="form-control solid" name="term"></select>
                        <input type="hidden" name="id">
                    </div>
                    <div class="form-group">
                        <label  class="form-label font-w600">Class Assessment Size<span class="text-danger scale5
                            ms-2">*</span></label>
                        <input type="number" class="form-control solid" aria-label="name" name="assessment_size"
                               value="{{old('assessment_size')}}">
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

{{--Status Class Assessment Size--}}
<div class="modal fade" id="edit-cas-status-modal">
    <form method="post" id="edit-cas-status-form" action="{{route('update_class_assessment_size_status')}}">
        @csrf
        @method('PUT')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Class Assessment Size Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label  class="form-label font-w600">Status<span class="text-danger scale5
                            ms-2">*</span></label>
                        <select class="form-control solid" name="is_active">
                            <option>Choose</option>
                            <option value="1">ACTIVE</option>
                            <option value="0">DISABLED</option>
                        </select>
                        <input type="hidden" name="id">
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

{{--Delete Class Assessment Size--}}
<div class="modal fade" id="delete-cas-modal">
    <form method="post" id="delete-cas-form" action="{{route('delete_class_assessment_size')}}">
        @csrf
        @method('DELETE')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Class Assessment Size</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <h4>Ae you sure of deleting this Class Assessment Size?</h4>
                        <small>Note that this action is irreversible</small>
                        <input type="hidden" name="id">
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
