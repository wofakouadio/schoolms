{{--Create new admission-fee--}}
<div class="modal fade" id="new-admission-fee-modal">
    <form method="post" id="new-admission-fee-form">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title">New Admission Fee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Academic Year<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="academic_year">
                                <option value="">Choose</option>
                                    @foreach($academicYears as $value)
                                        <option value="{{ $value->id }}">{{ $value->academic_year_start .'/'. $value->academic_year_end }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Branch<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="branch">
                                <option value="">Choose</option>
                                @foreach($branches as $value)
                                    <option value="{{ $value->id }}">{{ $value->branch_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Department<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="department">
                                <option value="">Choose</option>
                                @foreach($departments as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Amount<span class="text-danger scale5
                        ms-2">*</span></label>
                            <input type="text" name="amount" value="{{old('amount')}}" class="form-control
                        solid">
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

{{--Edit admission-fee--}}
<div class="modal fade" id="edit-admission-fee-modal">
    <form method="post" id="edit-admission-fee-form">
        @method('PUT')
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title">Update Admission Fee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Academic Year<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="academic_year">
                                <option value="">Choose</option>
                                @foreach($academicYears as $value)
                                    <option value="{{ $value->id }}">{{ $value->academic_year_start .'/'. $value->academic_year_end }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="admission_fee_id">
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Branch<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="branch">
                                <option value="">Choose</option>
                                @foreach($branches as $value)
                                    <option value="{{ $value->id }}">{{ $value->branch_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Department<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="department">
                                <option value="">Choose</option>
                                @foreach($departments as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Amount<span class="text-danger scale5
                        ms-2">*</span></label>
                            <input type="text" name="amount" value="{{old('amount')}}" class="form-control solid">
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Status<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="status">
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


{{--Delete admission-fee--}}
<div class="modal fade" id="delete-admission-fee-modal">
    <form method="post" id="delete-admission-fee-form">
        @method('DELETE')
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Admission Fee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <h4 class="text-danger fw-bold delete-notice"></h4>
                    <span class="text-muted">Note that this action is irreversible</span>
                    <input type="hidden" name="admission_fee_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </div>
        </div>
    </form>
</div>
