{{--New Student Mock--}}
<div class="modal fade" id="new-end-term-setup-modal">
    <form method="post" id="new-end-term-setup-form">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New End of Term Setup</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Term</label>
                            <input class="form-control solid" name="term_name" type="text" readonly>
                            <input type="hidden" name="term_id">
                        </div>
                        <div class="col-xl-12 mb-4">
                            <label  class="form-label font-w600">Academic Year</label>
                            <input class="form-control solid" name="term_academic_year" type="text" readonly>
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


{{--insert new student mock--}}
<div class="modal fade" id="insert-student-end-term-modal">
    <form method="post" id="insert-student-end-term-form">
        @csrf
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Student End of Term Exams Entry</h5>
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
                        <h4 class="text-primary">Term Calendar</h4>
                        <div class="col-xl-6 mb-4">
                            <label  class="form-label font-w600">Term<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input class="form-control solid" name="term_name" type="text" readonly>
                            <input type="hidden" name="term_id">
                        </div>
                        <div class="col-xl-6 mb-4">
                            <label  class="form-label font-w600">Academic Year<span class="text-danger scale5
                            ms-2">*</span></label>
                            <input class="form-control solid" name="academic_year" type="text" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <h4 class="text-primary">End of Term Exams Entry</h4>
                        <div class="col-xl-12 mb-4">
                            <div class="row" id="Subjects"></div>
                        </div>
                    </div>
                    <div class="row">
                        <h4 class="text-primary">Other Information</h4>
                        <div class="col-xl-3 mb-4">
                            <label  class="form-label font-w600">Conduct<span class="text-danger scale5
                            ms-2">*</span></label>
                            <select class="form-control solid" name="conduct">
                                <option value="">Choose</option>
                                <option value="Satisfactory">Satisfactory</option>
                                <option value="Good">Good</option>
                                <option value="Very Good">Very Good</option>
                            </select>
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label  class="form-label font-w600">Attitude</label>
                            <select name="attitude" class="form-control solid">
                                <option value="">Choose</option>
                                <option value="Sociable">Sociable</option>
                                <option value="Respectful">Respectful</option>
                                <option value="Obedient">Obedient</option>
                                <option value="Dependable">Dependable</option>
                                <option value="Lazy">Lazy</option>
                                <option value="Slow">Slow</option>
                                <option value="Humble">Humble</option>
                                <option value="Calm">Calm</option>
                            </select>
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">Interest</label>
                            <select name="interest" class="form-control solid">
                                <option value="">Choose</option>
                                <option value="Reading">Reading</option>
                                <option value="Sports and Games">Sports and Games</option>
                                <option value="Music and Dance">Music and Dance</option>
                                <option value="Art work">Art work</option>
                                <option value="Entertainment">Entertainment</option>
                                <option value="I.T">I.T</option>
                            </select>
                        </div>
                        <div class="col-xl-3 mb-4">
                            <label class="form-label font-w600">General Remarks</label>
                            <select name="general_remarks" class="form-control solid">
                                <option value="">Choose</option>
                                <option value="Could do better">Could do better</option>
                                <option value="Excellent Performance">Excellent Performance</option>
                                <option value="Keep it up">Keep it up</option>
                                <option value="Has improved">Has improved</option>
                                <option value="Hardworking">Hardworking</option>
                                <option value="Not serious in class">Not serious in class</option>
                                <option value="Very promising student">Very promising student</option>
                                <option value="More room for improvement">More room for improvement</option>
                                <option value="Declined in performance">Declined in performance</option>
                                <option value="Should learn seriously to catch up">Should learn seriously to catch up</option>
                                <option value="Should Buckle up">Should Buckle up</option>
                                <option value="More room for improvement">More room for improvement</option>
                                <option value="Good in Maths">Good in Maths</option>
                                <option value="Good in Information Technology">Good in Information Technology</option>
                                <option value="Good in English Language">Good in English Language</option>
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


{{--bulk upload--}}
<div class="modal fade" id="new-student-end-term-with-bulk-upload-modal">
    <form method="post" id="new-student-end-term-with-bulk-upload-form">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Student End of Term Exams bulk Upload</h5>
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
