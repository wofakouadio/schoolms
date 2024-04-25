{{--New Student Mock--}}
<div class="modal fade" id="new-student-mid-term-modal">
    <form method="post" id="new-student-mid-term-form">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Student Mid-Term Exams</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Mid-Term<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control solid" name="mid_term">
                                <option value="">Choose</option>
                                <option value="First">First</option>
                                <option value="Second">Second</option>
                            </select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Level<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control solid" name="level"></select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Student<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select name="student" class="form-control solid"></select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Fetch</button>
                </div>
            </div>
        </div>
    </form>
</div>


{{--insert new student mid term--}}
<div class="modal fade" id="insert-student-mid-term-modal">
    <form method="post" id="insert-student-mid-term-form">
        @csrf
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Student Mid-Term Exams Entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <div class="row">
                        <h4 class="text-primary">Student Data</h4>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Student ID<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" name="student_id" readonly>
                            <input type="hidden" name="studentId">
                            <input type="hidden" name="branch_id">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Name<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" name="student_name" readonly>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Gender<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" name="student_gender" readonly>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Level<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" name="student_level" readonly>
                            <input type="hidden" name="level_id">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Residency<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input class="form-control solid" name="student_residency" type="text" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <h4 class="text-primary">Mid-Term Calendar</h4>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Mid-Term<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input class="form-control solid" name="mid_term_name" type="text" readonly>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Term<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input class="form-control solid" name="term" type="text" readonly>
                            <input type="hidden" name="term_id">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Academic Year<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input class="form-control solid" name="academic_year" type="text" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <h4 class="text-primary">Mid-Term Entry</h4>
                        <div class="col-xl-12 mb-4">
                            <div class="row" id="Subjects"></div>
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


{{--bulk upload--}}
<div class="modal fade" id="new-student-mock-with-bulk-upload-modal">
    <form method="post" id="new-student-mock-with-bulk-upload-form">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Student Mock Exams bulk Upload</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Mock<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control solid" name="mock"></select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Level<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control solid" name="level"></select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Get Student Mock List</button>
                </div>
            </div>
        </div>
    </form>
</div>
