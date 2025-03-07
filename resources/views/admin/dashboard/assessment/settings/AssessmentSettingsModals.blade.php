{{-- Create new assessment setup --}}
<div class="modal fade" id="new-assessment-modal">
    <form method="post" id="new-assessment-form" action="{{ route('new_assessment_setup') }}">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Assessment Setup</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    {{--                    <div class="alert menu-alert"> --}}
                    {{--                        <ul></ul> --}}
                    {{--                    </div> --}}
                    <div class="row">
                        <div class="col-xl-12 mb-4">
                            <div class="form-group">
                                <label class="form-label font-w600">Academic Year</label>
                                <input type="text" class="form-control solid" name="academic_year_name"
                                    value="{{ $schoolTerm['academic_year']['academic_year_start'] . '/' . $schoolTerm['academic_year']['academic_year_end'] }}"
                                    readonly>
                                <input type="hidden" name="academic_year"
                                    value="{{ $schoolTerm['term_academic_year'] }}">
                            </div>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Class Percentage<span
                                    class="text-danger scale5
                            ms-2">*</span></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control solid" name="class_percentage">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Mid-Term Percentage<span
                                    class="text-danger scale5
                            ms-2">*</span></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control solid" name="mid_term_percentage">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Exam Percentage<span
                                    class="text-danger scale5
                            ms-2">*</span></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control solid" name="exam_percentage">
                                <span class="input-group-text">%</span>
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

{{-- Edit assessment status --}}
<div class="modal fade" id="edit-assessment-modal">
    <form method="post" id="edit-assessment-form" action="{{ route('update_assessment_setup') }}">
        @csrf
        @method('PUT')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Assessment Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 mb-4">
                            <div class="form-group">
                                <label class="form-label font-w600">Academic Year</label>
                                <input type="text" class="form-control solid" name="academic_year_name" readonly>
                                <input type="hidden" name="academic_year"
                                    value="{{ $schoolTerm['term_academic_year'] }}">
                                <input type="hidden" name="assessment_id">
                            </div>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Class Percentage<span
                                    class="text-danger scale5
                            ms-2">*</span></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control solid" name="class_percentage" readonly>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Mid-Term Percentage<span
                                    class="text-danger scale5
                            ms-2">*</span></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control solid" name="mid_term_percentage">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Exam Percentage<span
                                    class="text-danger scale5
                            ms-2">*</span></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control solid" name="exam_percentage" readonly>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Status<span
                                    class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control solid" name="assessment_status">
                                <option>Choose</option>
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

{{-- delete assessment --}}
<div class="modal fade" id="delete-assessment-modal">
    <form method="post" id="delete-assessment-form" action="{{ route('delete_assessment_setup') }}">
        @csrf
        @method('DELETE')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Assessment Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="assessment_id">
                    <h4 class="text-danger fw-bold delete-notice">Are you sure of deleting this Assessment Setup?</h4>
                    <span class="text-muted">Note that this action is irreversible</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Create new grading system --}}
<div class="modal fade" id="new-grading-system-modal">
    <form method="post" id="new-grading-system-form" action="{{ route('new_grading_system') }}">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Grading System Setup</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 mb-4">
                            <div class="form-group">
                                <label class="form-label font-w600">Academic Year</label>
                                <input type="text" class="form-control solid" name="academic_year_name"
                                    value="{{ $schoolTerm['academic_year']['academic_year_start'] . '/' . $schoolTerm['academic_year']['academic_year_end'] }}"
                                    readonly>
                                <input type="hidden" name="academic_year"
                                    value="{{ $schoolTerm['term_academic_year'] }}">
                            </div>
                        </div>
                        <div class="col-xl-6 mb-4">
                            <label class="form-label font-w600">Score From<span
                                    class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" name="score_from">
                        </div>
                        <div class="col-xl-6 mb-4">
                            <label class="form-label font-w600">Score To<span
                                    class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" name="score_to">
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Grade<span
                                    class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" name="grade">
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Level of Proficiency<span
                                    class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" name="level_of_proficiency">
                        </div>
                        <div class="col-xl-12 mb-4">
                        {{-- {{$SchoolCategories}} --}}
                            <label class="form-label font-w600">Applicable to Department<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control solid" name="department_applicable_to">
                                <option>Select Department</option>
                                @foreach($SchoolDepartments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name}}</option>
                                @endforeach
                            </select>
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

{{-- edit grading system --}}
<div class="modal fade" id="edit-grading-system-modal">
    <form method="post" id="edit-grading-system-form" action="{{ route('update_grading_system') }}">
        @csrf
        @method('PUT')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Grading System</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 mb-4">
                            <div class="form-group">
                                <label class="form-label font-w600">Academic Year</label>
                                <input type="text" class="form-control solid" name="academic_year_name" readonly>
                                <input type="hidden" name="academic_year"
                                    value="{{ $schoolTerm['term_academic_year'] }}">
                                <input type="hidden" name="grading_system_id">
                            </div>
                        </div>
                        <div class="col-xl-6 mb-4">
                            <label class="form-label font-w600">Score From<span
                                    class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" name="score_from">
                        </div>
                        <div class="col-xl-6 mb-4">
                            <label class="form-label font-w600">Score To<span
                                    class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" name="score_to">
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Grade<span
                                    class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" name="grade">
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Level of Proficiency<span
                                    class="text-danger scale5
                            ms-2">*</span></label>
                            <input type="text" class="form-control solid" name="level_of_proficiency">
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Applicable to Department<span class="text-danger scale5
                                ms-2">*</span></label>
                            <select class="form-control solid" name="department_applicable_to">
                                <option>Select Department</option>
                                @foreach($SchoolDepartments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label class="form-label font-w600">Status<span
                                    class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control solid" name="grading_system_status">
                                <option>Choose</option>
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

{{-- delete assessment --}}
<div class="modal fade" id="delete-grading-system-modal">
    <form method="post" id="delete-grading-system-form" action="{{ route('delete_grading_system') }}">
        @csrf
        @method('DELETE')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Grading System</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="grading_system_id">
                    <h4 class="text-danger fw-bold delete-notice">Are you sure of deleting this Grading System?</h4>
                    <span class="text-muted">Note that this action is irreversible</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </div>
        </div>
    </form>
</div>
