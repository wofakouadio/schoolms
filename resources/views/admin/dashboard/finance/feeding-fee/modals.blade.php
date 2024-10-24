{{--Create new feeding-fee--}}
<div class="modal fade" id="add_new_feeding_fee_setup">
    <form method="post" id="add_new_feeding_fee_setup_form" action="{{ route('admin_finance_feeding_fee_setup') }}">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title">New Feeding Fee Setup</h5>
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
                            <input type="hidden" name="academic_year_id" value="{{ $academicYear->id }}"/>
                            <input type="text" value="{{ $academicYear->academic_year_start .'/'.$academicYear->academic_year_start }}" readonly class="form-control"/>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Amount<span class="text-danger scale5
                        ms-2">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">{{ $currency->symbol }}</span>
                                <input type="text" name="amount" value="{{old('amount')}}" class="form-control solid">
                                <input type="hidden" name="currency_id" value="{{ $currency->id }}"/>
                            </div>

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

{{--Edit feeding-fee--}}
<div class="modal fade" id="edit_feeding_fee_setup">
    <form method="post" id="edit_feeding_fee_setup_form" action="{{ route('admin_finance_update_feeding_fee_data') }}">
        @method('PUT')
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title">Update Feeding Fee Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Academic Year</label>
                            <input type="text" name="academic_year" readonly class="form-control"/>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Amount<span class="text-danger scale5
                        ms-2">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" id="currency"></span>
                                <input type="text" name="amount" value="{{old('amount')}}" class="form-control solid">
                                <input type="hidden" name="feeding_fee_id"/>
                            </div>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Status</label>
                            <select class="form-control" name="is_active">
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


{{--Delete feeding-fee--}}
<div class="modal fade" id="delete_feeding_fee_setup">
    <form method="post" id="delete_feeding_fee_setup_form" action="{{ route('admin_finance_delete_feeding_fee_data') }}">
        @method('DELETE')
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Feeding Fee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <h4 class="text-danger fw-bold delete-notice">Are you sure of deleting this data?</h4>
                    <span class="text-muted">Note that this action is irreversible</span>
                    <input type="hidden" name="feeding_fee_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </div>
        </div>
    </form>
</div>
