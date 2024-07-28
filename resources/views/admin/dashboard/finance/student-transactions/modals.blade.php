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

                            </select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Branch<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="branch">
                                <option value="">Choose</option>

                            </select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Department<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="department">
                                <option value="">Choose</option>

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
                            <select class="form-control" name="academic_year"></select>
                            <input type="hidden" name="admission_fee_id">
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Branch<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="branch"></select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Department<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="department"></select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Amount<span class="text-danger scale5
                        ms-2">*</span></label>
                            <input type="text" name="amount" value="{{old('amount')}}" class="form-control solid">
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Status<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="status"></select>
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

{{-- Edit Transaction data --}}
<div class="modal fade" id="edit-transaction-data-modal">
    <form id="edit-transaction-data-form" action="{{ route('admin_update_student_transaction') }}" method="POST">
        @method('PUT')
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title">Update Transaction Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Invoice Number<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" readonly class="form-control solid" name="invoice_id">
                            <input type="hidden" name="transaction_id">
                            <input type="hidden" name="student_uuid">
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Item<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" readonly class="form-control solid" name="item">
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Amount Due<span class="text-danger scale5
                            ms-2">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">{{ $schoolCurrency->getData()->default_currency_symbol }}</span>
                                <input type="text" name="amount_due" class="form-control solid">
                            </div>
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

{{-- Delete Transaction data --}}
<div class="modal fade" id="delete-transaction-data-modal">
    <form method="post" id="delete-transaction-data-form" action="{{ route('admin_delete_student_transaction') }}">
        @method('DELETE')
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Transaction Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <h4 class="text-danger fw-bold delete-notice"></h4>
                    <span class="text-muted">Note that this action is irreversible</span>
                    <input type="hidden" name="transaction_id">
                    <input type="hidden" name="student_uuid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </div>
        </div>
    </form>
</div>
