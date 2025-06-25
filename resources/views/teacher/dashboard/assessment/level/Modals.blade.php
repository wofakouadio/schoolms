{{--New Level Assessment--}}
<div class="modal fade" id="new-level-assessment-modal">
    <form method="post" id="new-level-assessment-form">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Level Assessment</h5>
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
                            <input type="text" value="{{$schoolTerm->term_name . ' - ' .
                            $schoolTerm->academic_year->academic_year_start.'/'.$schoolTerm->academic_year
                            ->academic_year_end}}" class="form-control solid" readonly>
                            <input type="hidden" name="teacher_term" value="{{$schoolTerm->id}}">
                        </div>
                        {{-- {{ dd($TeacherAssignedLevels) }} --}}
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Level<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control solid" name="teacher_level">
                                {{-- <option>Choose</option>
                                @foreach($TeacherAssignedLevels as $key => $level)
                                    <option value={{ $level->level_id }}>{{ $level->level->level_name }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Student<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select name="teacher_student" class="form-control solid"></select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Subject<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select name="teacher_subject" class="form-control solid"></select>
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


{{--insert new student level assessment--}}
<div class="modal fade" id="insert-level-assessment-modal">
    <form method="post" id="insert-level-assessment-form" action="{{route('new_student_class_assessment_entry')}}">
        @csrf
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Student Level Assessment Entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="alert menu-alert">
                            <ul></ul>
                        </div>
                        <h4 class="text-primary">Student Data</h4>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Student ID<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" name="teacher_student_id" readonly>
                            <input type="hidden" name="teacher_studentId">
                            <input type="hidden" name="teacher_branch_id">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Name<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" name="teacher_student_name" readonly>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Gender<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" name="teacher_student_gender" readonly>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Level<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" name="teacher_student_level" readonly>
                            <input type="hidden" name="teacher_level_id">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Residency<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input class="form-control solid" name="teacher_student_residency" type="text" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <h4 class="text-primary">Calendar</h4>
                        <div class="col-xl-6 mb-4">
                            <label  class="form-label font-w600">Term<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input class="form-control solid" name="teacher_term" type="text" readonly>
                            <input type="hidden" name="teacher_term_id">
                        </div>
                        <div class="col-xl-6 mb-4">
                            <label  class="form-label font-w600">Academic Year<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input class="form-control solid" name="teacher_academic_year" type="text" readonly>
                            <input type="hidden" name="teacher_academic_year_id">
                        </div>
                    </div>
                    <div class="row">
                        <h4 class="text-primary">Class Score Assessment</h4>
                        <div class="col-xl-6 mb-4">
                            <label  class="form-label font-w600">Subject<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input class="form-control solid" name="teacher_subject" type="text" readonly>
                            <input type="hidden" name="teacher_subject_id">
                        </div>
                        <div class="col-xl-6 mb-4">
                            <label  class="form-label font-w600">Score<span class="text-danger scale5
                            ms-2">*</span></label>
                            <div class="input-group">
                                <input class="form-control solid" name="teacher_score" type="text">
                                <span class="input-group-text">/10</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-save-close">Save & Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-save-add-more">Save & Add More</button>
                </div>
            </div>
        </div>
    </form>
</div>

{{--Edit level assessment--}}
<div class="modal fade" id="edit-level-assessment-modal">
    <form method="post" id="edit-level-assessment-form" action="{{route('update_student_class_assessment_entry')}}">
        @csrf
        @method('PUT')
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Student Level Assessment Entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="alert menu-alert">
                            <ul></ul>
                        </div>
                        <h4 class="text-primary">Student Data</h4>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Student ID<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" name="teacher_student_id" readonly>
                            <input type="hidden" name="teacher_studentId">
                            <input type="hidden" name="teacher_branch_id">
                            <input type="hidden" name="teacher_level_assessment_id">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Name<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" name="teacher_student_name" readonly>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Gender<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" name="teacher_student_gender" readonly>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Level<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" name="teacher_student_level" readonly>
                            <input type="hidden" name="teacher_level_id">
                        </div>
                        <div class="col-xl-4 mb-4">
                            <label  class="form-label font-w600">Residency<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input class="form-control solid" name="teacher_student_residency" type="text" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <h4 class="text-primary">Calendar</h4>
                        <div class="col-xl-6 mb-4">
                            <label  class="form-label font-w600">Term<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input class="form-control solid" name="teacher_term" type="text" readonly>
                            <input type="hidden" name="teacher_term_id">
                        </div>
                        <div class="col-xl-6 mb-4">
                            <label  class="form-label font-w600">Academic Year<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input class="form-control solid" name="teacher_academic_year" type="text" readonly>
                            <input type="hidden" name="teacher_academic_year_id">
                        </div>
                    </div>
                    <div class="row">
                        <h4 class="text-primary">Class Score Assessment</h4>
                        <div class="col-xl-6 mb-4">
                            <label  class="form-label font-w600">Subject<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input class="form-control solid" name="teacher_subject" type="text" readonly>
                            <input type="hidden" name="teacher_subject_id">
                        </div>
                        <div class="col-xl-6 mb-4">
                            <label  class="form-label font-w600">Score<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input class="form-control solid" name="teacher_score" type="text">
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

{{--Delete level assessment--}}
<div class="modal fade" id="delete-level-assessment-modal">
    <form method="post" id="delete-level-assessment-form" action="{{route('delete_student_class_assessment_entry')}}">
        @csrf
        @method('DELETE')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Student Level Assessment Entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <h4 class="text-primary">Are you sure of deleting this class assessment record?</h4>
                    <small>Note that this action is irreversible</small>
                    <input type="hidden" name="teacher_level_assessment_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </div>
        </div>
    </form>
</div>


{{--bulk upload--}}
<div class="modal fade" id="new-level-assessment-with-bulk-upload-modal">
    <form method="post" id="new-level-assessment-with-bulk-upload-form">
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
