{{-- Create new student --}}
<div class="modal fade" id="new-student-admission-modal">
    <form method="post" id="new-student-admission-form" enctype="multipart/form-data">
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
                    <div class="default-tab">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#bio_data" aria-selected="true"
                                    role="tab">Bio Data</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#academic_info" aria-selected="true"
                                    role="tab">Academic Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#health_info" aria-selected="true"
                                    role="tab">Health Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#guardian_info" aria-selected="true"
                                    role="tab">Guardian Info</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="bio_data" role="tabpanel" style="">
                                <div class="row">
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Firstname<span class="text-danger scale5 ms-2">*</span></label>
                                        <input type="text" class="form-control solid" aria-label="name"
                                            name="student_firstname" value="{{ old('student_firstname') }}">
                                    </div>
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Other Name</label>
                                        <input type="text" class="form-control solid" aria-label="name" name="student_oname"
                                            value="{{ old('student_oname') }}">
                                    </div>
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Lastname<span class="text-danger scale5 ms-2">*</span></label>
                                        <input type="text" class="form-control solid" aria-label="name"
                                            name="student_lastname" value="{{ old('student_lastname') }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-3 mb-4">
                                        <label class="form-label font-w600">Gender<span class="text-danger scale5 ms-2">*</span></label>
                                        <select class="form-control" name="student_gender">
                                            <option value="">Choose</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-3 mb-4">
                                        <label class="form-label font-w600">Date of Birth<span class="text-danger scale5 ms-2">*</span></label>
                                        <input type="date" class="form-control solid" aria-label="name"
                                            name="student_date_of_birth" value="{{ old('student_date_of_birth') }}">
                                    </div>
                                    <div class="col-xl-3 mb-4">
                                        <label class="form-label font-w600">Place of Birth<span class="text-danger scale5 ms-2">*</span></label>
                                        <input type="text" class="form-control solid" aria-label="name"
                                            name="student_place_of_birth" value="{{ old('student_place_of_birth') }}">
                                    </div>
                                    <div class="col-xl-3 mb-4">
                                        <label class="form-label font-w600">Profile Picture</label>
                                        <input class="form-control" type="file" id="formFile" name="student_profile">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="academic_info" role="tabpanel" style="">
                                <div class="row">
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Branch<span class="text-danger scale5
                                        ms-2">*</span></label>
                                        <select class="form-control solid" name="student_branch"></select>
                                    </div>
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Level/Class<span class="text-danger scale5
                                        ms-2">*</span></label>
                                        <select class="form-control solid" name="student_level"></select>
                                    </div>
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">House</label>
                                        <select class="form-control solid" name="student_house"></select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Category</label>
                                        <select class="form-control solid" name="student_category"></select>
                                    </div>
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Residency Type<span class="text-danger scale5
                                        ms-2">*</span></label>
                                        <select class="form-control solid" name="student_residency_type">
                                            <option value="">Choose</option>
                                            <option value="Day">Day</option>
                                            <option value="Boarding">Boarding</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="health_info" role="tabpanel" style="">
                                <div class="row">
                                    <div class="col-xl-6 mb-4">
                                        <label class="form-label font-w600">Birth Type<span class="text-danger scale5 ms-2">*</span></label>
                                        <select class="form-control" name="student_birth_type">
                                            <option value="">Choose</option>
                                            <option value="Normal">Normal</option>
                                            <option value="CS">CS</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <small>If Other, specify below</small>
                                        <input type="text" class="form-control solid" aria-label="name" name="student_birth_type_other">
                                    </div>
                                    <div class="col-xl-6 mb-4">
                                        <label class="form-label font-w600">Weight</label>
                                        <input type="text" class="form-control solid" aria-label="name" name="student_weight"
                                            value="{{ old('student_weight') }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 mb-4">
                                        <label class="form-label font-w600">Any chronic disease?<span class="text-danger scale5 ms-2">*</span></label>
                                        <select class="form-control" name="student_having_chronic_disease">
                                            <option value="">Choose</option>
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>
                                        <small>If Yes, specify below</small>
                                        <input type="text" class="form-control solid" aria-label="name" name="student_has_chronic_disease">
                                    </div>
                                    <div class="col-xl-6 mb-4">
                                        <label class="form-label font-w600">Any generic disease?<span class="text-danger scale5 ms-2">*</span></label>
                                        <select class="form-control" name="student_having_generic_disease">
                                            <option value="">Choose</option>
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>
                                        <small>If Yes, specify below</small>
                                        <input type="text" class="form-control solid" aria-label="name" name="student_has_generic_disease">
                                    </div>
                                    <div class="col-xl-6 mb-4">
                                        <label class="form-label font-w600">Any allergies?<span class="text-danger scale5 ms-2">*</span></label>
                                        <select class="form-control" name="student_having_allergies">
                                            <option value="">Choose</option>
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>
                                        <small>If Yes, specify below</small>
                                        <input type="text" class="form-control solid" aria-label="name" name="student_has_allergies">
                                    </div>
                                    <div class="col-xl-6 mb-4">
                                        <label class="form-label font-w600">Does student have any stitch on the body?<span class="text-danger scale5 ms-2">*</span></label>
                                        <select class="form-control" name="student_having_stitches">
                                            <option value="">Choose</option>
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>
                                        <small>If Yes, specify where</small>
                                        <input type="text" class="form-control solid" aria-label="name" name="student_has_stitches">
                                        <small>If Yes, what was the cause?</small>
                                        <input type="text" class="form-control solid" aria-label="name" name="causes_for_student_has_stitches">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="form-label font-w600">Any other information about the student's health you would like to share</label>
                                    <textarea class="form-control solid" name="student_other_health_info"></textarea>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="guardian_info" role="tabpanel" style="">
                                <div class="row">
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Name<span class="text-danger
                                        scale5 ms-2">*</span></label>
                                        <input type="text" name="student_guardian_name" value="{{ old('student_guardian_name') }}"
                                            class="form-control solid">
                                    </div>
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Contact<span class="text-danger scale5
                                        ms-2">*</span></label>
                                        <input type="text" class="form-control solid" aria-label="name"
                                            name="student_guardian_contact" value="{{ old('student_guardian_contact') }}">
                                    </div>
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Address<span class="text-danger scale5
                                        ms-2">*</span></label>
                                        <input type="text" class="form-control solid" aria-label="name"
                                            name="student_guardian_address" value="{{ old('student_guardian_address') }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Email</label>
                                        <input type="text" class="form-control solid" aria-label="name"
                                            name="student_guardian_email" value="{{ old('student_guardian_email') }}">
                                    </div>
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Occupation<span class="text-danger scale5
                                        ms-2">*</span></label>
                                        <select class="form-control" name="student_guardian_occupation">
                                            <option value="">Choose</option>
                                            <option value="Unemployed">Unemployed</option>
                                            <option value="Employed">Employed</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">ID Card Picture</label>
                                        <input class="form-control" type="file" id="formFile" name="student_guardian_id_card">
                                    </div>
                                </div>
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

{{-- create new admission using bulk upload in excel/csv --}}
<div class="modal fade" id="new-student-admission-using-excel-modal">
    <form method="post" id="new-student-admission-using-excel-form" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Student Admission using Bulk Upload</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <label class="form-label font-w600">Upload Excel/CVS file<span class="text-danger scale5
                            ms-2">*</span></label>
                    <input type="file" class="form-control solid" aria-label="name" name="admission_bulk">
                    <input type="hidden" name="school_id" value="{{ Auth::guard('admin')->user()->school_id }}">

                    <a class="text-success mt-4 mb-4" href="{{ asset('sample.xlsx') }}">Download Sample format</a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- edit student --}}
<div class="modal fade" id="edit-student-admission-modal">
    <form method="post" id="update-student-admission-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Student Admission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <div class="default-tab">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#bio_data_edit" aria-selected="true"
                                    role="tab">Bio Data</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#academic_info_edit" aria-selected="true"
                                    role="tab">Academic Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#health_info_edit" aria-selected="true"
                                    role="tab">Health Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#guardian_info_edit" aria-selected="true"
                                    role="tab">Guardian Info</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active show mt-2" id="bio_data_edit" role="tabpanel" style="">
                                <div class="row justify-content-center">
                                    <div class="col mb-4">
                                        <p>
                                            <img height="200" width="200" id="student-profile" class="img img-thumbnail">
                                        </p>
                                    </div>
                                    <div class="col mb-4">
                                        <p>
                                            <img height="200" width="200" id="student-guardian-id" class="img img-thumbnail">
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-3 mb-4">
                                        <label class="form-label font-w600">Firstname<span class="text-danger scale5
                                        ms-2">*</span></label>
                                        <input type="text" class="form-control solid" aria-label="name" name="student_firstname"
                                            value="{{ old('student_firstname') }}">
                                        <input type="hidden" name="admission_id">
                                    </div>
                                    <div class="col-xl-3 mb-4">
                                        <label class="form-label font-w600">Other Name</label>
                                        <input type="text" class="form-control solid" aria-label="name" name="student_oname"
                                            value="{{ old('student_oname') }}">
                                    </div>
                                    <div class="col-xl-3 mb-4">
                                        <label class="form-label font-w600">Lastname<span class="text-danger scale5
                                        ms-2">*</span></label>
                                        <input type="text" class="form-control solid" aria-label="name" name="student_lastname"
                                            value="{{ old('student_lastname') }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-3 mb-4">
                                        <label class="form-label font-w600">Gender<span class="text-danger scale5
                                        ms-2">*</span></label>
                                        <select class="form-control" name="student_gender">
                                            <option value="">Choose</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-3 mb-4">
                                        <label class="form-label font-w600">Date of Birth<span class="text-danger scale5
                                        ms-2">*</span></label>
                                        <input type="date" class="form-control solid" aria-label="name" name="student_date_of_birth"
                                            value="{{ old('student_date_of_birth') }}">
                                    </div>
                                    <div class="col-xl-3 mb-4">
                                        <label class="form-label font-w600">Place of Birth<span class="text-danger scale5
                                        ms-2">*</span></label>
                                        <input type="text" class="form-control solid" aria-label="name"
                                            name="student_place_of_birth" value="{{ old('student_place_of_birth') }}">
                                    </div>
                                    <div class="col-xl-3 mb-4">
                                        <label class="form-label font-w600">Profile Picture</label>
                                        <input class="form-control" type="file" id="formFile" name="student_profile">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade mt-2" id="academic_info_edit" role="tabpanel" style="">
                                <div class="row">
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Branch<span class="text-danger scale5
                                        ms-2">*</span></label>
                                        <select class="form-control solid" name="student_branch"></select>
                                    </div>
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Level/Class<span class="text-danger scale5
                                        ms-2">*</span></label>
                                        <select class="form-control solid level" name="student_level"></select>
                                    </div>
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">House<span class="text-danger scale5
                                        ms-2">*</span></label>
                                        <select class="form-control solid" name="student_house"></select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Category</label>
                                        <select class="form-control solid" name="student_category"></select>
                                    </div>
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Residency Type<span class="text-danger scale5
                                        ms-2">*</span></label>
                                        <select class="form-control solid" name="student_residency_type">
                                            <option value="">Choose</option>
                                            <option value="Day">Day</option>
                                            <option value="Boarding">Boarding</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade mt-2" id="health_info_edit" role="tabpanel" style="">
                                <div class="row">
                                    <div class="col-xl-6 mb-4">
                                        <label class="form-label font-w600">Birth Type<span class="text-danger scale5 ms-2">*</span></label>
                                        <select class="form-control" name="student_birth_type">
                                            <option value="">Choose</option>
                                            <option value="Normal">Normal</option>
                                            <option value="CS">CS</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <small>If Other, specify below</small>
                                        <input type="text" class="form-control solid" aria-label="name" name="student_birth_type_other">
                                        <input type="hidden" name="student_health_id"/>
                                    </div>
                                    <div class="col-xl-6 mb-4">
                                        <label class="form-label font-w600">Weight<span class="text-danger scale5
                                        ms-2">*</span></label>
                                        <input type="text" class="form-control solid" aria-label="name" name="student_weight"
                                            value="{{ old('student_weight') }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 mb-4">
                                        <label class="form-label font-w600">Any chronic disease?<span class="text-danger scale5 ms-2">*</span></label>
                                        <select class="form-control" name="student_having_chronic_disease">
                                            <option value="">Choose</option>
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>
                                        <small>If Yes, specify below</small>
                                        <input type="text" class="form-control solid" aria-label="name" name="student_has_chronic_disease">
                                    </div>
                                    <div class="col-xl-6 mb-4">
                                        <label class="form-label font-w600">Any generic disease?<span class="text-danger scale5 ms-2">*</span></label>
                                        <select class="form-control" name="student_having_generic_disease">
                                            <option value="">Choose</option>
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>
                                        <small>If Yes, specify below</small>
                                        <input type="text" class="form-control solid" aria-label="name" name="student_has_generic_disease">
                                    </div>
                                    <div class="col-xl-6 mb-4">
                                        <label class="form-label font-w600">Any allergies?<span class="text-danger scale5 ms-2">*</span></label>
                                        <select class="form-control" name="student_having_allergies">
                                            <option value="">Choose</option>
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>
                                        <small>If Yes, specify below</small>
                                        <input type="text" class="form-control solid" aria-label="name" name="student_has_allergies">
                                    </div>
                                    <div class="col-xl-6 mb-4">
                                        <label class="form-label font-w600">Does student have any stitch on the body?<span class="text-danger scale5 ms-2">*</span></label>
                                        <select class="form-control" name="student_having_stitches">
                                            <option value="">Choose</option>
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>
                                        <small>If Yes, specify where</small>
                                        <input type="text" class="form-control solid" aria-label="name" name="student_has_stitches">
                                        <small>If Yes, what was the cause?</small>
                                        <input type="text" class="form-control solid" aria-label="name" name="causes_for_student_has_stitches">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="form-label font-w600">Any other information about the student's health you would like to share</label>
                                    <textarea class="form-control solid" name="student_other_health_info"></textarea>
                                </div>
                            </div>
                            <div class="tab-pane fade mt-2" id="guardian_info_edit" role="tabpanel" style="">
                                <div class="row">
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Name<span class="text-danger
                                        scale5 ms-2">*</span></label>
                                        <input type="text" name="student_guardian_name" value="{{ old('student_guardian_name') }}"
                                            class="form-control solid">
                                    </div>
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Contact<span class="text-danger scale5
                                        ms-2">*</span></label>
                                        <input type="text" class="form-control solid" aria-label="name"
                                            name="student_guardian_contact" value="{{ old('student_guardian_contact') }}">
                                    </div>
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Address<span class="text-danger scale5
                                        ms-2">*</span></label>
                                        <input type="text" class="form-control solid" aria-label="name"
                                            name="student_guardian_address" value="{{ old('student_guardian_address') }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Email</label>
                                        <input type="text" class="form-control solid" aria-label="name"
                                            name="student_guardian_email" value="{{ old('student_guardian_email') }}">
                                    </div>
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Occupation<span class="text-danger scale5
                                        ms-2">*</span></label>
                                        <select class="form-control" name="student_guardian_occupation">
                                            <option value="">Choose</option>
                                            <option value="Unemployed">Unemployed</option>
                                            <option value="Employed">Employed</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">ID Card Picture</label>
                                        <input class="form-control" type="file" id="formFile" name="student_guardian_id_card">
                                    </div>
                                </div>
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

{{-- set admissions status --}}
<div class="modal fade" id="edit-student-admission-status-modal">
    <form method="post" id="edit-student-admission-status-form">
        @csrf
        @method('PUT')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Admission Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <h4 class="text-danger fw-bold admission-notice"></h4>
                    <div class="form-group mb-4">
                        <label class="form-label font-w600">Admission Status<span class="text-danger scale5
                            ms-2">*</span></label>
                        <select class="form-control" name="admission_status">
                            <option value="">Choose</option>
                            <option value="0">Pending</option>
                            <option value="1">Admitted</option>
                            <option value="2">Declined</option>
                        </select>
                    </div>
                    <input type="hidden" name="admission_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- delete student --}}
<div class="modal fade" id="delete-student-admission-modal">
    <form method="post" id="delete-student-admission-form">
        @csrf
        @method('DELETE')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Student Admission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <h4 class="text-danger fw-bold delete-notice"></h4>
                    <span class="text-muted">Note that this action is irreversible</span>
                    <input type="hidden" name="admission_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </div>
        </div>
    </form>
</div>
