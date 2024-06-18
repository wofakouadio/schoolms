{{--Create new student--}}
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
                    <h4 class="text-danger">Bio-Data</h4>
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Firstname<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name" name="student_firstname"
                                   value="{{old('student_firstname')}}">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Other Name</label>
                            <input type="text" class="form-control solid" aria-label="name" name="student_oname"
                                   value="{{old('student_oname')}}">
                        </div>
                        <div class="col-xl-4 mb-4">
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
                            <label  class="form-label font-w600">House</label>
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
                                <option value="Employed">Employed</option>
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

{{--create new admission using bulk upload in excel/csv--}}
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
                    <label  class="form-label font-w600">Upload Excel/CVS file<span class="text-danger scale5
                            ms-2">*</span></label>
                    <input type="file" class="form-control solid" aria-label="name" name="admission_bulk">
                    <input type="hidden" name="school_id" value="{{Auth::guard('admin')->user()->school_id}}">

                    <a class="text-success mt-4 mb-4" href="{{asset('sample.xlsx')}}">Download Sample format</a>
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
                    <h4 class="text-danger">Bio-Data</h4>
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
                            <label  class="form-label font-w600">Firstname<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" aria-label="name" name="student_firstname"
                                   value="{{old('student_firstname')}}">
                            <input type="hidden" name="admission_id">
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
{{--                        <div class="col-xl-4 mb-4">--}}
{{--                            <label  class="form-label font-w600">Student Status<span class="text-danger scale5--}}
{{--                            ms-2">*</span></label>--}}
{{--                            <select class="form-control solid" name="student_status">--}}
{{--                                <option value="">Choose</option>--}}
{{--                                <option value="1">In</option>--}}
{{--                                <option value="2">Out</option>--}}
{{--                                <option value="3">Stop</option>--}}
{{--                                <option value="4">Sick</option>--}}
{{--                                <option value="5">Restore</option>--}}
{{--                                <option value="6">Dismiss</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
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
                                <option value="Employed">Employed</option>
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
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </form>
</div>

{{--set admissions status--}}
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
                        <label  class="form-label font-w600">Admission Status<span class="text-danger scale5
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

{{--delete student--}}
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
