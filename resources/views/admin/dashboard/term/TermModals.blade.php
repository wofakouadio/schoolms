{{--Create new Term--}}
<div class="modal fade" id="new-term-modal">
    <form method="post" id="new-term-form" action="{{route('new-term')}}">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Term</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <div class="form-group">
                        <label  class="form-label font-w600">Term<span class="text-danger scale5
                            ms-2">*</span></label>
                        <input type="text" class="form-control solid" aria-label="name" name="term_name"
                               value="{{old('term_name')}}">
                    </div>
                    <div class="form-group">
                        <label  class="form-label font-w600">Opening Date<span class="text-danger scale5
                            ms-2">*</span></label>
                        <input type="date" class="form-control solid" aria-label="name" name="term_opening_date"
                               value="{{old('term_opening_date')}}">
                    </div>
                    <div class="form-group">
                        <label  class="form-label font-w600">Closing Date<span class="text-danger scale5
                            ms-2">*</span></label>
                        <input type="date" class="form-control solid" aria-label="name" name="term_closing_date"
                               value="{{old('term_closing_date')}}">
                    </div>
                    <div class="form-group">
                        <label  class="form-label font-w600">Academic Year<span class="text-danger scale5
                            ms-2">*</span></label>
                        <select class="form-control" name="term_academic_year">
{{--                            <option value="">Choose</option>--}}
{{--                            @php--}}
{{--                                $years = range(1960, date('Y'));--}}
{{--                                foreach ($years as $year){--}}
{{--                                    echo '<option value="'.$year.'/'.$year + 1 .'">'.$year--}}
{{--                                    .'/'.$year + 1 .'</option>';--}}
{{--                                }--}}
{{--                            @endphp--}}
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


{{--Edit Term--}}
<div class="modal fade" id="edit-term-modal">
    <form method="post" id="update-term-form" action="{{route('update-term')}}">
        @csrf
        @method('PUT')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Term</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <div class="form-group">
                        <label  class="form-label font-w600">Term<span class="text-danger scale5
                            ms-2">*</span></label>
                        <input type="text" class="form-control solid" aria-label="name" name="term_name"
                               value="{{old('term_name')}}">
                        <input type="hidden" name="term_id">
                    </div>
                    <div class="form-group">
                        <label  class="form-label font-w600">Opening Date<span class="text-danger scale5
                            ms-2">*</span></label>
                        <input type="date" class="form-control solid" aria-label="name" name="term_opening_date"
                               value="{{old('term_opening_date')}}">
                    </div>
                    <div class="form-group">
                        <label  class="form-label font-w600">Closing Date<span class="text-danger scale5
                            ms-2">*</span></label>
                        <input type="date" class="form-control solid" aria-label="name" name="term_closing_date"
                               value="{{old('term_closing_date')}}">
                    </div>
                    <div class="form-group">
                        <label  class="form-label font-w600">Academic Year<span class="text-danger scale5
                            ms-2">*</span></label>
                        <select class="form-control" name="term_academic_year">
{{--                            <option value="">Choose</option>--}}
{{--                            @php--}}
{{--                                $years = range(1960, date('Y'));--}}
{{--                                foreach ($years as $year){--}}
{{--                                    echo '<option value="'.$year.'/'.$year + 1 .'">'.$year--}}
{{--                                    .'/'.$year + 1 .'</option>';--}}
{{--                                }--}}
{{--                            @endphp--}}
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

{{--Edit Term Status--}}
<div class="modal fade" id="edit-term-status-modal">
    <form method="post" id="update-term-status-form" action="{{route('update-term-status')}}">
        @csrf
        @method('PUT')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Term Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <div class="form-group">
                        <label  class="form-label font-w600">Term<span class="text-danger scale5
                            ms-2">*</span></label>
                        <input type="text" class="form-control solid" aria-label="name" name="term_name"
                               value="{{old('term_name')}}" readonly>
                        <input type="hidden" name="term_id">
                    </div>
                    <div class="form-group">
                        <label  class="form-label font-w600">Status</label>
                        <select class="form-control" name="term_is_active">
                            <option value="">Choose</option>
                            <option value="0">DISABLED</option>
                            <option value="1">ACTIVE</option>
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


{{--delete term--}}
<div class="modal fade" id="delete-term-modal">
    <form method="post" id="delete-term-form" action="{{route('delete-term')}}">
        @csrf
        @method('DELETE')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Term</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <h4 class="text-danger fw-bold delete-notice"></h4>
                    <span class="text-muted">Note that this action is irreversible</span>
                    <input type="hidden" name="term_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </div>
        </div>
    </form>
</div>
