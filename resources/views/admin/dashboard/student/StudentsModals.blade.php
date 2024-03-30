{{--Create new student--}}
<div class="modal fade" id="new-student-modal">
    <form method="post" id="new-student-form" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Student Admission</h5>
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
                            <label  class="form-label font-w600">Student ID<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" name="student_id" readonly>
                            <input type="hidden" name="school_id" value="{{Auth::guard('admin')->user()->school_id}}">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label  class="form-label font-w600">Firstname<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name" name="student_firstname"
                                   value="{{old('student_firstname')}}">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label  class="form-label font-w600">Other Name</label>
                            <input type="text" class="form-control solid" aria-label="name" name="student_oname"
                                   value="{{old('student_oname')}}">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label  class="form-label font-w600">Lastname<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name" name="student_lastname"
                                   value="{{old('student_lastname')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 mb-4">
                            <label  class="form-label font-w600">Gender<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="student_gender">
                                <option value="">Choose</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label  class="form-label font-w600">Date of Birth<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="date" class="form-control solid" aria-label="name" name="student_date_of_birth"
                                   value="{{old('student_date_of_birth')}}">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label  class="form-label font-w600">Place of Birth<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name"
                                   name="student_place_of_birth"
                                   value="{{old('student_place_of_birth')}}">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label  class="form-label font-w600">Profile Picture</label>
                            <input class="form-control" type="file" id="formFile" name="student_profile">
                        </div>
                    </div>
                    <h4 class="text-danger">Academic Information</h4>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Branch<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control solid" name="student_branch"></select>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Level/Class<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control solid" name="student_level"></select>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">House<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control solid" name="student_house"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Category</label>
                            <select class="form-control solid" name="student_category"></select>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Residency Type<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control solid" name="student_residency_type">
                                <option value="">Choose</option>
                                <option value="Day">Day</option>
                                <option value="Boarding">Boarding</option>
                            </select>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Student Status<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control solid" name="student_status">
                                <option value="">Choose</option>
                                <option value="0">In</option>
                                <option value="1">Out</option>
                                <option value="2">Stop</option>
                                <option value="3">Sick</option>
                                <option value="4">Restore</option>
                                <option value="5">Dismiss</option>
                            </select>
                        </div>
                    </div>
                    <h4 class="text-danger">Guardian Details</h4>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Name<span class="text-danger
                            scale5 ms-2">*</span></label>
                            <input type="text" name="student_guardian_name" value="{{old
                            ('student_guardian_name')}}"
                                   class="form-control solid">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Contact<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name"
                                   name="student_guardian_contact"
                                   value="{{old('student_guardian_contact')}}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Address<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name"
                                   name="student_guardian_address"
                                   value="{{old('student_guardian_address')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Email</label>
                            <input type="text" class="form-control solid" aria-label="name"
                                   name="student_guardian_email"
                                   value="{{old('student_guardian_email')}}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Occupation<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="student_guardian_occupation">
                                <option value="">Choose</option>
                                <option value="Unemployed">Unemployed</option>
                                <option value="employed">employed</option>
                            </select>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">ID Card Picture</label>
                            <input class="form-control" type="file" id="formFile" name="student_guardian_id_card">
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

{{--edit student--}}
<div class="modal fade" id="edit-student-modal">
    <form method="post" id="update-student-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Student</h5>
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
                            <label  class="form-label font-w600">Title<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="student_title">
                                <option value="">Choose</option>
                                <option value="Mr">Mr</option>
                                <option value="Ms">Ms</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Doc">Doc</option>
                                <option value="Prof">Prof</option>
                            </select>
                            <input type="hidden" name="student_id">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label  class="form-label font-w600">Firstname<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name" name="student_firstname"
                                   value="{{old('student_firstname')}}">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label  class="form-label font-w600">Other Name</label>
                            <input type="text" class="form-control solid" aria-label="name" name="student_oname"
                                   value="{{old('student_oname')}}">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label  class="form-label font-w600">Lastname<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name" name="student_lastname"
                                   value="{{old('student_lastname')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 mb-4">
                            <label  class="form-label font-w600">Gender<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="student_gender">
                                <option value="">Choose</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label  class="form-label font-w600">Date of Birth<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="date" class="form-control solid" aria-label="name" name="student_date_of_birth"
                                   value="{{old('student_date_of_birth')}}">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label  class="form-label font-w600">Place of Birth<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name"
                                   name="student_place_of_birth"
                                   value="{{old('student_place_of_birth')}}">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label  class="form-label font-w600">Nationality<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name" name="student_nationality"
                                   value="{{old('student_nationality')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 mb-4">
                            <label  class="form-label font-w600">Postal Address - GPD<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" name="student_address" class="form-control solid" value="{{old
                            ('student_address')}}" aria-label>
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label  class="form-label font-w600">Email Address<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name" name="student_email"
                                   value="{{old('student_email')}}">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label  class="form-label font-w600">Contact<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="tel" class="form-control solid" aria-label="name" name="student_contact"
                                   value="{{old('student_contact')}}">
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label  class="form-label font-w600">Profile Picture</label>
                            <input class="form-control" type="file" id="formFile" name="student_profile">
                            <input type="hidden" name="student_fetched_profile">
                        </div>
                    </div>
                    <h4 class="text-danger">Academic Achievements</h4>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">College/University Attended<span class="text-danger
                            scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control" name="student_school_attended">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Admission Year<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control solid" name="student_admission_year">
                                <option value="">Choose</option>
                                @php
                                    $years = range(1960, date('Y'));
                                    foreach ($years as $year){
                                        echo '<option value="'.$year.'">'.$year.'</option>';
                                    }
                                @endphp
                            </select>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Completion Year<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control solid" name="student_completion_year">
                                <option value="">Choose</option>
                                @php
                                    $years = range(1960, date('Y'));
                                    foreach ($years as $year){
                                        echo '<option value="'.$year.'">'.$year.'</option>';
                                    }
                                @endphp
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Country</label>
                            <input type="text" class="form-control solid" aria-label="name" name="student_country"
                                   value="Ghana" readonly>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Region<span class="text-danger
                            scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name" name="student_region"
                                   value="{{old('student_region')}}">
                            {{--                            <select class="form-control solid"
                            name="student_region">--}}
                            {{--                                <option value="">Choose</option>--}}
                            {{--                                @for($x=1960; $x <= date('Y'); $x++)--}}
                            {{--                                    <option value="{{$x++}}">{{$x++}}</option>--}}
                            {{--                                @endfor--}}
                            {{--                            </select>--}}
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">District</label>
                            <input type="text" class="form-control solid" aria-label="name" name="student_district"
                                   value="{{old('student_district')}}">
                            {{--                            <select class="form-control solid"
                            name="student_district">--}}
                            {{--                                <option value="">Choose</option>--}}
                            {{--                                @for($x=1960; $x <= date('Y'); $x++)--}}
                            {{--                                    <option value="{{$x++}}">{{$x++}}</option>--}}
                            {{--                                @endfor--}}
                            {{--                            </select>--}}
                        </div>
                    </div>
                    <h4 class="text-danger">Employment Details</h4>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">1<sup>st</sup> Appointment Date<span class="text-danger
                            scale5 ms-2">*</span></label>
                            <input type="date" name="student_first_appointment" value="{{old
                            ('student_first_appointment')}}"
                                   class="form-control solid">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Name of Present School<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name"
                                   name="student_present_school"
                                   value="{{old('student_present_school')}}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Academic Qualification<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="student_qualification">
                                <option value="">Choose</option>
                                <option value="3-Year POSEC">3-Year POSEC</option>
                                <option value="GCE O'Level">GCE O'Level</option>
                                <option value="WASSCE">WASSCE</option>
                                <option value="SSSCE">SSSCE</option>
                                <option value="MSLC">MSLC</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Professional Qualification<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="student_professional">
                                <option value="">Choose</option>
                                <option value="3-Year P/S">3-Year P/S</option>
                                <option value="Pupil Student">Pupil Student</option>
                                <option value="HND">HND</option>
                                <option value="DBE">DBE</option>
                                <option value="B.Ed">B.Ed</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Present Rank<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control" name="student_rank">
                                <option value="">Choose</option>
                                <option value="SNR SUPT. I">SNR SUPT. I</option>
                                <option value="SNR SUPT. II">SNR SUPT. II</option>
                                <option value="P/S">P/S</option>
                                <option value="AD I">AD I</option>
                                <option value="AD II">AD II</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Circuit</label>
                            <input type="text" class="form-control solid" aria-label="name" name="student_circuit"
                                   value="{{old('student_circuit')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Staff ID</label>
                            <input type="text" class="form-control solid" aria-label="name" name="student_staff_id"
                                   value="{{old('student_staff_id')}}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Registration Number</label>
                            <input type="text" class="form-control solid" aria-label="name" name="student_reg_num"
                                   value="{{old('student_reg_num')}}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">District File No.</label>
                            <input type="text" class="form-control solid" aria-label="name"
                                   name="student_district_file_number"
                                   value="{{old('student_district_file_number')}}">
                        </div>
                    </div>
                    <h4 class="text-danger">Other Relevant Information</h4>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Bank Name</label>
                            <input type="text" class="form-control solid" aria-label="name" name="student_bank_name"
                                   value="{{old('student_bank_name')}}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Account Number</label>
                            <input type="text" class="form-control solid" aria-label="name" name="student_acc_number"
                                   value="{{old('student_acc_number')}}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Branch</label>
                            <input type="text" class="form-control solid" aria-label="name"
                                   name="student_bank_branch"
                                   value="{{old('student_bank_branch')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">SSNIT Number</label>
                            <input type="text" class="form-control solid" aria-label="name" name="student_ssnit"
                                   value="{{old('student_ssnit')}}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">NTC Number</label>
                            <input type="text" class="form-control solid" aria-label="name" name="student_ntc"
                                   value="{{old('student_ntc')}}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Ghana Card No.</label>
                            <input type="text" class="form-control solid" aria-label="name"
                                   name="student_ghana_card"
                                   value="{{old('student_ghana_card')}}">
                        </div>
                    </div>
                    <div class="col-xl-4 mb-4">
                        <label  class="form-label font-w600">Status</label>
                        <select class="form-control" name="student_is_active">
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

{{--delete student--}}
<div class="modal fade" id="delete-student-modal">
    <form method="post" id="delete-student-form">
        @csrf
        @method('DELETE')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <h4 class="text-danger fw-bold delete-notice"></h4>
                    <span class="text-muted">Note that this action is irreversible</span>
                    <input type="hidden" name="student_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </div>
        </div>
    </form>
</div>
