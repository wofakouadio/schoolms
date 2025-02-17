{{-- Create ne teacher --}}
<div class="modal fade" id="new-teacher-modal">
    <form method="post" id="new-teacher-form" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Teacher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <h4 class="text-danger">Bio-Data</h4>
                    <div class="row">
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Title<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="teacher_title">
                                <option value="">Choose</option>
                                <option value="Mr">Mr</option>
                                <option value="Ms">Ms</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Doc">Doc</option>
                                <option value="Prof">Prof</option>
                            </select>
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Firstname<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_firstname"
                                value="{{ old('teacher_firstname') }}">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Other Name</label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_oname"
                                value="{{ old('teacher_oname') }}">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Lastname<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_lastname"
                                value="{{ old('teacher_lastname') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Gender<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="teacher_gender">
                                <option value="">Choose</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Date of Birth<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="date" class="form-control solid" aria-label="name" name="teacher_date_of_birth"
                                value="{{ old('teacher_date_of_birth') }}">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Place of Birth<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name"
                                name="teacher_place_of_birth" value="{{ old('teacher_place_of_birth') }}">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Nationality<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_nationality"
                                value="{{ old('teacher_nationality') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Postal Address - GPS<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" name="teacher_address" class="form-control solid"
                                value="{{ old('teacher_address') }}" aria-label>
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Email Address<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_email"
                                value="{{ old('teacher_email') }}">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Contact<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="tel" class="form-control solid" aria-label="name" name="teacher_contact"
                                value="{{ old('teacher_contact') }}">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Profile Picture</label>
                            <input class="form-control" type="file" id="formFile" name="teacher_profile">
                        </div>
                    </div>
                    <h4 class="text-danger">Academic Achievements</h4>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">College/University Attended<span class="text-danger
                            scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control" name="teacher_school_attended">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Admission Year<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control solid" name="teacher_admission_year">
                                <option value="">Choose</option>
                                @php
                                    $years = range(1960, date('Y'));
                                    foreach ($years as $year) {
                                        echo '<option value="' . $year . '">' . $year . '</option>';
                                    }
                                @endphp
                            </select>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Completion Year<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control solid" name="teacher_completion_year">
                                <option value="">Choose</option>
                                @php
                                    $years = range(1960, date('Y'));
                                    foreach ($years as $year) {
                                        echo '<option value="' . $year . '">' . $year . '</option>';
                                    }
                                @endphp
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Country</label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_country"
                                value="Ghana" readonly>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Region<span class="text-danger
                            scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_region"
                                value="{{ old('teacher_region') }}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">District<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_district"
                                value="{{ old('teacher_district') }}">
                        </div>
                    </div>
                    <h4 class="text-danger">Employment Details</h4>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">1<sup>st</sup> Appointment Date</label>
                            <input type="date" name="teacher_first_appointment"
                                value="{{ old('teacher_first_appointment') }}" class="form-control solid">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Most recent Institution taught (if any)</label>
                            <input type="text" class="form-control solid" aria-label="name"
                                name="teacher_present_school">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Academic Qualification<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="teacher_qualification">
                                <option value="">Choose</option>
                                <option value="Doctorate Degree">Doctorate Degree</option>
                                <option value="Masters DEgree">Masters DEgree</option>
                                <option value="Bachelor Degree">Bachelor Degree</option>
                                <option value="Diploma">Diploma</option>
                                <option value="Certificate">Certificate</option>
                                <option value="WASSCE">WASSCE</option>
                                <option value="SSSCE">SSSCE</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Professional Qualification</label>
                            <input type="text" class="form-control" name="teacher_professional" />
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Present Rank
                                <span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="teacher_rank">
                                <option value="">Choose</option>
                                <option value="Director General">Director General</option>
                                <option value="Deputy Director General">Deputy Director General</option>
                                <option value="Director I">Director I</option>
                                <option value="Director II">Director II</option>
                                <option value="Deputy Director">Deputy Director</option>
                                <option value="Assistant Director I">Assistant Director I</option>
                                <option value="Assistant Director II">Assistant Director II</option>
                                <option value="Principal Superintendent">Principal Superintendent</option>
                                <option value="Senior Superintendent I">Senior Superintendent I</option>
                                <option value="Senior Superintendent II">Senior Superintendent II</option>
                                <option value="Superintendent I">Superintendent I</option>
                                <option value="Superintendent II">Superintendent II</option>
                                <option value="Pupil Teacher">Pupil Teacher</option>
                                <option value="Other (Specify)">Other (Specify)</option>
                            </select>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Circuit</label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_circuit"
                                value="{{ old('teacher_circuit') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">GES Staff ID</label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_staff_id"
                                value="{{ old('teacher_staff_id') }}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Registration Number</label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_reg_num"
                                value="{{ old('teacher_reg_num') }}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">District File No.</label>
                            <input type="text" class="form-control solid" aria-label="name"
                                name="teacher_district_file_number" value="{{ old('teacher_district_file_number') }}">
                        </div>
                    </div>
                    <h4 class="text-danger">Other Relevant Information</h4>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Bank Name</label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_bank_name"
                                value="{{ old('teacher_bank_name') }}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Account Number</label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_acc_number"
                                value="{{ old('teacher_acc_number') }}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Bank Branch Name</label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_bank_branch"
                                value="{{ old('teacher_bank_branch') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">SSNIT Number</label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_ssnit"
                                value="{{ old('teacher_ssnit') }}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">NTC Number</label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_ntc"
                                value="{{ old('teacher_ntc') }}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Ghana Card No.</label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_ghana_card"
                                value="{{ old('teacher_ghana_card') }}">
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

{{-- edit teacher --}}
<div class="modal fade" id="edit-teacher-modal">
    <form method="post" id="update-teacher-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Teacher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <h4 class="text-danger">Bio-Data</h4>
                    <p>
                        <img height="200" width="200" id="image" class="img img-thumbnail">
                    </p>
                    <div class="row">
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Title<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="teacher_title">
                                <option value="">Choose</option>
                                <option value="Mr">Mr</option>
                                <option value="Ms">Ms</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Doc">Doc</option>
                                <option value="Prof">Prof</option>
                            </select>
                            <input type="hidden" name="teacher_id">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Firstname<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_firstname"
                                value="{{ old('teacher_firstname') }}">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Other Name</label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_oname"
                                value="{{ old('teacher_oname') }}">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Lastname<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_lastname"
                                value="{{ old('teacher_lastname') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Gender<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="teacher_gender">
                                <option value="">Choose</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Date of Birth<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="date" class="form-control solid" aria-label="name" name="teacher_date_of_birth"
                                value="{{ old('teacher_date_of_birth') }}">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Place of Birth<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name"
                                name="teacher_place_of_birth" value="{{ old('teacher_place_of_birth') }}">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Nationality<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_nationality"
                                value="{{ old('teacher_nationality') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Postal Address - GPS<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" name="teacher_address" class="form-control solid"
                                value="{{ old('teacher_address') }}" aria-label>
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Email Address<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_email"
                                value="{{ old('teacher_email') }}">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Contact<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="tel" class="form-control solid" aria-label="name" name="teacher_contact"
                                value="{{ old('teacher_contact') }}">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Profile Picture</label>
                            <input class="form-control" type="file" id="formFile" name="teacher_profile">
                        </div>
                    </div>
                    <h4 class="text-danger">Academic Achievements</h4>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">College/University Attended<span class="text-danger
                            scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control" name="teacher_school_attended">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Admission Year<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control solid" name="teacher_admission_year">
                                <option value="">Choose</option>
                                @php
                                    $years = range(1960, date('Y'));
                                    foreach ($years as $year) {
                                        echo '<option value="' . $year . '">' . $year . '</option>';
                                    }
                                @endphp
                            </select>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Completion Year<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control solid" name="teacher_completion_year">
                                <option value="">Choose</option>
                                @php
                                    $years = range(1960, date('Y'));
                                    foreach ($years as $year) {
                                        echo '<option value="' . $year . '">' . $year . '</option>';
                                    }
                                @endphp
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Country</label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_country"
                                value="Ghana" readonly>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Region<span class="text-danger
                            scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_region"
                                value="{{ old('teacher_region') }}">
                            {{-- <select class="form-control solid" name="teacher_region"> --}}
                                {{-- <option value="">Choose</option> --}}
                                {{-- @for ($x = 1960; $x <= date('Y'); $x++) --}} {{-- <option value="{{$x++}}">{{$x++}}
                                    </option> --}}
                                    {{-- @endfor --}}
                                    {{-- </select> --}}
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">District</label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_district"
                                value="{{ old('teacher_district') }}">
                            {{-- <select class="form-control solid" name="teacher_district"> --}}
                                {{-- <option value="">Choose</option> --}}
                                {{-- @for ($x = 1960; $x <= date('Y'); $x++) --}} {{-- <option value="{{$x++}}">{{$x++}}
                                    </option> --}}
                                    {{-- @endfor --}}
                                    {{-- </select> --}}
                        </div>
                    </div>
                    <h4 class="text-danger">Employment Details</h4>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">1<sup>st</sup> Appointment Date</label>
                            <input type="date" name="teacher_first_appointment"
                                value="{{ old('teacher_first_appointment') }}" class="form-control solid">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Most recent Institution taught (if any)</label>
                            <input type="text" class="form-control solid" aria-label="name"
                                name="teacher_present_school" value="{{ old('teacher_present_school') }}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Academic Qualification<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="teacher_qualification">
                                <option value="">Choose</option>
                                <option value="Doctorate Degree">Doctorate Degree</option>
                                <option value="Masters DEgree">Masters DEgree</option>
                                <option value="Bachelor Degree">Bachelor Degree</option>
                                <option value="Diploma">Diploma</option>
                                <option value="Certificate">Certificate</option>
                                <option value="WASSCE">WASSCE</option>
                                <option value="SSSCE">SSSCE</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Professional Qualification</label>
                            <input type="text" class="form-control" name="teacher_professional" />
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Present Rank<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="teacher_rank">
                                <option value="">Choose</option>
                                <option value="Director General">Director General</option>
                                <option value="Deputy Director General">Deputy Director General</option>
                                <option value="Director I">Director I</option>
                                <option value="Director II">Director II</option>
                                <option value="Deputy Director">Deputy Director</option>
                                <option value="Assistant Director I">Assistant Director I</option>
                                <option value="Assistant Director II">Assistant Director II</option>
                                <option value="Principal Superintendent">Principal Superintendent</option>
                                <option value="Senior Superintendent I">Senior Superintendent I</option>
                                <option value="Senior Superintendent II">Senior Superintendent II</option>
                                <option value="Superintendent I">Superintendent I</option>
                                <option value="Superintendent II">Superintendent II</option>
                                <option value="Pupil Teacher">Pupil Teacher</option>
                                <option value="Other (Specify)">Other (Specify)</option>
                            </select>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Circuit</label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_circuit"
                                value="{{ old('teacher_circuit') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">GES Staff ID</label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_staff_id"
                                value="{{ old('teacher_staff_id') }}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Registration Number</label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_reg_num"
                                value="{{ old('teacher_reg_num') }}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">District File No.</label>
                            <input type="text" class="form-control solid" aria-label="name"
                                name="teacher_district_file_number" value="{{ old('teacher_district_file_number') }}">
                        </div>
                    </div>
                    <h4 class="text-danger">Other Relevant Information</h4>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Bank Name</label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_bank_name"
                                value="{{ old('teacher_bank_name') }}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Account Number</label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_acc_number"
                                value="{{ old('teacher_acc_number') }}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Bank Branch Name</label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_bank_branch"
                                value="{{ old('teacher_bank_branch') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">SSNIT Number</label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_ssnit"
                                value="{{ old('teacher_ssnit') }}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">NTC Number</label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_ntc"
                                value="{{ old('teacher_ntc') }}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label class="form-label font-w600">Ghana Card No.</label>
                            <input type="text" class="form-control solid" aria-label="name" name="teacher_ghana_card"
                                value="{{ old('teacher_ghana_card') }}">
                        </div>
                    </div>
                    <div class="col-xl-4 mb-4">
                        <label class="form-label font-w600">Status</label>
                        <select class="form-control" name="teacher_is_active">
                            <option value="">Choose</option>
                            <option value="1">ACTIVE</option>
                            <option value="0">DISABLED</option>
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

{{-- delete teacher --}}
<div class="modal fade" id="delete-teacher-modal">
    <form method="post" id="delete-teacher-form">
        @csrf
        @method('DELETE')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Teacher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <h4 class="text-danger fw-bold delete-notice"></h4>
                    <span class="text-muted">Note that this action is irreversible</span>
                    <input type="hidden" name="teacher_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </div>
        </div>
    </form>
</div>


{{--Assign Levels/Classes to Teacher--}}
<div class="modal fade" id="new-assign-level-teacher-modal">
    <form method="post" id="new-assign-level-teacher-form" action="{{route('assign-subjects-to-teacher')}}">
        @csrf
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Levels/Classes to Teacher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Teacher<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="teacher">
                                <option value="">Choose</option>
                            </select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Level<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="level"></select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Subject<span class="text-danger scale5
                            ms-2">*</span></label>
                            <div class="row teacherSubjects"></div>
                            {{-- <select class="form-control" name="subject">--}}
                                {{-- <option value="">Choose</option>--}}
                                {{-- <option value="All">All Subjects</option>--}}
                                {{-- </select>--}}
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
