{{--Create new Academic Year--}}
<div class="modal fade" id="new-academic-year-modal">
    <form method="post" id="new-academic-year-form" action="{{route('new_admin_academic_year')}}">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Academic Year</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label  class="form-label font-w600">Academic Year Beginning<span class="text-danger scale5
                            ms-2">*</span></label>
                        <select class="form-control" name="academic_year_start">
                            <option value="">Choose</option>
                            @php
                                $years = range(1960, date('Y'));
                                foreach ($years as $year){
                                    echo '<option value="'.$year.'">'.$year.'</option>';
                                }
                            @endphp
                        </select>
                    </div>
                    <div class="form-group">
                        <label  class="form-label font-w600">Academic Year Ending<span class="text-danger scale5
                            ms-2">*</span></label>
                        <select class="form-control" name="academic_year_end">
                            <option value="">Choose</option>
                            @php
                                $years = range(1960, date('Y'));
                                foreach ($years as $year){
                                    echo '<option value="'.$year + 1 .'">'.$year + 1 .'</option>';
                                }
                            @endphp
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

{{--Update Academic Year--}}
<div class="modal fade" id="edit-academic-year-modal">
    <form method="post" id="edit-academic-year-form" action="{{route('update_admin_academic_year')}}">
        @csrf
        @method('PUT')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Academic Year</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label  class="form-label font-w600">Academic Year Beginning<span class="text-danger scale5
                            ms-2">*</span></label>
                        <select class="form-control" name="academic_year_start">
                            <option value="">Choose</option>
                            @php
                                $years = range(1960, date('Y'));
                                foreach ($years as $year){
                                    echo '<option value="'.$year.'">'.$year.'</option>';
                                }
                            @endphp
                        </select>
                        <input type="hidden" name="academic_year_id">
                    </div>
                    <div class="form-group">
                        <label  class="form-label font-w600">Academic Year Ending<span class="text-danger scale5
                            ms-2">*</span></label>
                        <select class="form-control" name="academic_year_end">
                            <option value="">Choose</option>
                            @php
                                $years = range(1960, date('Y'));
                                foreach ($years as $year){
                                    echo '<option value="'.$year + 1 .'">'.$year + 1 .'</option>';
                                }
                            @endphp
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

{{--Update Academic Year Status--}}
<div class="modal fade" id="edit-academic-year-status-modal">
    <form method="post" id="edit-academic-year-status-form" action="{{route('update_admin_academic_year_status')}}">
        @csrf
        @method('PUT')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Academic Year Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label  class="form-label font-w600">Status<span class="text-danger scale5
                            ms-2">*</span></label>
                        <select class="form-control" name="academic_status">
                            <option value="">Choose</option>
                            <option value="1">ACTIVE</option>
                            <option value="0">DISABLED</option>
                        </select>
                        <input type="hidden" name="academic_year_id">
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

{{--Delete Academic Year--}}
<div class="modal fade" id="delete-academic-year-modal">
    <form method="post" id="delete-academic-year-status-form" action="{{route('delete_admin_academic_year')}}">
        @csrf
        @method('DELETE')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Academic Year</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <h4 class="text-danger fw-bold delete-notice">Are you sure of deleting this Academic Year?</h4>
                        <span class="text-muted">Note that this action is irreversible</span>
                        <input type="hidden" name="academic_year_id">
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
