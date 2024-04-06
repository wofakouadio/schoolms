{{--Create new bill--}}
<div class="modal fade" id="new-bill-modal">
    <form method="post" id="new-bill-form">
        @csrf
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title">New Bill</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Term<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="term">

                            </select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Academic Year<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="academic_year">
                                <option value="">Choose</option>
                                @php
                                    $years = range(1960, date('Y'));
                                    foreach ($years as $year){
                                        echo '<option value="'.$year.'/'.$year + 1 .'">'.$year
                                        .'/'.$year + 1 .'</option>';
                                    }
                                @endphp
                            </select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Level / Class<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="level"></select>
                        </div>
                        <div class="row AddMoreFields">
                            <div class="col-5 mb-4">
                                <label  class="form-label font-w600">Description<span class="text-danger scale5
                            ms-2">*</span></label>
                                <input type="text" name="addMore[0][bill_description]" value="{{old
                                ('bill_description')}}"
                                       class="form-control
                            solid">
                            </div>
                            <div class="col-5 mb-4">
                                <label  class="form-label font-w600">Amount<span class="text-danger scale5
                            ms-2">*</span></label>
                                <input type="text" name="addMore[0][bill_amount]" value="{{old('bill_amount')}}"
                                       class="form-control
                            solid">
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-xs btn-primary" id="addMoreBtn">Add More</button>
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


{{--edit bill--}}
<div class="modal fade" id="edit-bill-modal">
    <form method="post" id="update-bill-form">
        @csrf
        @method('PUT')
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title">Update Bill</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Term<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="term"></select>
                            <input type="hidden" name="bill_id">
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Academic Year<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="academic_year">
                                <option value="">Choose</option>
                                @php
                                    $years = range(1960, date('Y'));
                                    foreach ($years as $year){
                                        echo '<option value="'.$year.'/'.$year + 1 .'">'.$year
                                        .'/'.$year + 1 .'</option>';
                                    }
                                @endphp
                            </select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Level / Class<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="level"></select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Amount<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" name="amount" value="{{old('bill_amount')}}"
                                   class="form-control
                            solid">
                        </div>
                        <div class="Fields">
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Status</label>
                            <select class="form-control" name="bill_is_active">
                                <option value="">Choose</option>
                                <option value="0">ACTIVE</option>
                                <option value="1">DISABLED</option>
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


{{--delete bill--}}
<div class="modal fade" id="delete-bill-modal">
    <form method="post" id="delete-bill-form">
        @csrf
        @method('DELETE')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Bill</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <h4 class="text-danger fw-bold delete-notice"></h4>
                    <span class="text-muted">Note that this action is irreversible</span>
                    <input type="hidden" name="bill_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </div>
        </div>
    </form>
</div>
