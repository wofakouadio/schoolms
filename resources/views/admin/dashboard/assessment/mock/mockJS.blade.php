 <script>
    $(document).ready(()=> {
        // alert
        $(" .menu-alert").hide()

        //new mock setup
        $("#new-mock-setup-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $.ajax({
                url:'{{route('new-mock-setup')}}',
                method:'POST',
                cache:false,
                data:$("#new-mock-setup-form").serialize(),
                success:(Response)=>{
                    // console.log(Response)
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#new-mock-setup-modal .menu-alert").removeClass('alert-warning')
                        $("#new-mock-setup-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#new-mock-setup-modal .menu-alert").removeClass('alert-danger')
                        $("#new-mock-setup-modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#new-mock-setup-modal").modal('hide')
                                $("#new-mock-setup-form")[0].reset()
                                $("#new-mock-setup-modal .menu-alert").removeClass('alert-danger')
                                $("#new-mock-setup-modal .menu-alert").removeClass('alert-warning')
                                $("#new-mock-setup-modal .menu-alert").html('')
                                $("#MockSetupDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{
                    console.log(Response)
                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#new-mock-setup-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

        //edit mock setup
        $("#edit-mock-setup-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget);
            let mock_id = str.data('id')
            let modal = $("#edit-mock-setup-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $.ajax({
                url:'{{route('edit-mock-setup')}}',
                method:'GET',
                cache:false,
                data:{mock_id: mock_id},
                success:(Response)=>{
                    modal.find('input[name=mock_id]').val(mock_id)
                    modal.find('input[name=mock_type]').val(Response['mock_type'])
                    modal.find('select[name=mock_is_active]').val(Response['is_active'])
                }
            })
        })

        //update mock setup
        $("#update-mock-setup-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $.ajax({
                url:'{{route('update-mock-setup')}}',
                method:'POST',
                cache:false,
                data:$("#update-mock-setup-form").serialize(),
                success:(Response)=>{
                    // console.log(Response)
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#edit-mock-setup-modal .menu-alert").removeClass('alert-warning')
                        $("#edit-mock-setup-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#edit-mock-setup-modal .menu-alert").removeClass('alert-danger')
                        $("#edit-mock-setup-modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#edit-mock-setup-modal").modal('hide')
                                $("#edit-mock-setup-modal .menu-alert").removeClass('alert-danger')
                                $("#edit-mock-setup-modal .menu-alert").removeClass('alert-warning')
                                $("#edit-mock-setup-modal .menu-alert").html('')
                                $("#MockSetupDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{
                    // console.log(Response)
                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#edit-mock-setup-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

        //delete mock setup   modal
        $("#delete-mock-setup-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget);
            let mock_id = str.data('id')
            let modal = $("#delete-mock-setup-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $.ajax({
                url:'{{route('edit-mock-setup')}}',
                method:'GET',
                cache:false,
                data:{mock_id: mock_id},
                success:(Response)=>{
                    modal.find('input[name=mock_id]').val(mock_id)
                    modal.find('.delete-notice').html('Are you sure of deleting ' + Response['mock_type'] + ' Mock?')
                }
            })
        })

        // delete mock setup
        $("#delete-mock-setup-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $.ajax({
                url:'{{route('delete-mock-setup')}}',
                method:'POST',
                cache:false,
                data:$("#delete-mock-setup-form").serialize(),
                success:(Response)=>{
                    // console.log(Response)
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#delete-mock-setup-modal .menu-alert").removeClass('alert-warning')
                        $("#delete-mock-setup-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults
                            .msg)
                    }else{
                        $("#delete-mock-setup-modal .menu-alert").removeClass('alert-danger')
                        $("#delete-mock-setup-modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#delete-mock-setup-modal").modal('hide')
                                $("#delete-mock-setup-modal .menu-alert").removeClass('alert-danger')
                                $("#delete-mock-setup-modal .menu-alert").removeClass('alert-warning')
                                $("#delete-mock-setup-modal .menu-alert").html('')
                                $("#MockSetupDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{
                    // console.log(Response)
                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#delete-mock-setup-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

        // fetch selected subjects for selected mock
        $("#assign-subjects-to-mock-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let mock_id = str.data('id')
            let mock_type = str.data('name')
            let modal = $("#assign-subjects-to-mock-modal")
            modal.find('input[name=mock_type]').val(mock_type)
            modal.find('input[name=mock_id]').val(mock_id)
            {{--$.ajaxSetup({--}}
            {{--    headers: {--}}
            {{--        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
            {{--    }--}}
            {{--});--}}
            {{--$.ajax({--}}
            {{--    url:'{{route('getSubjectsBasedOnMock')}}',--}}
            {{--    method:'GET',--}}
            {{--    cache:false,--}}
            {{--    data: {mock_id: mock_id},--}}
            {{--    success:(Response)=>{--}}
            {{--        modal.find("#subject_checkbox").html(Response)--}}
            {{--    }--}}
            {{--})--}}
        })

        $("#assign-subjects-to-mock-form select[name=level]").on("change", (e)=>{
            e.preventDefault()
            let mock_id = $("#assign-subjects-to-mock-form input[name=mock_id]").val()
            let level_id = $("#assign-subjects-to-mock-form select[name=level]").val()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('getSubjectsBasedOnMock')}}',
                method:'GET',
                cache:false,
                data: {mock_id: mock_id, level_id:level_id},
                success:(Response)=>{
                    $("#assign-subjects-to-mock-form").find("#subject_checkbox").html(Response)
                }
            })
        })

        //assign subjects to mock
        $("#assign-subjects-to-mock-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let form = $("#assign-subjects-to-mock-form").serialize()
            $.ajax({
                url:'{{route('assign-subject-to-mock')}}',
                method:'POST',
                cache:false,
                data: form,
                success:(Response)=>{
                    // console.log(Response)
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#assign-subjects-to-mock-form .menu-alert").removeClass('alert-warning')
                        $("#assign-subjects-to-mock-form .menu-alert").show().addClass('alert-danger').html(DecodedResults
                            .msg)
                    }else{
                        $("#assign-subjects-to-mock-form .menu-alert").removeClass('alert-danger')
                        $("#assign-subjects-to-mock-form .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#assign-subjects-to-mock-form").modal('hide')
                                $("#assign-subjects-to-mock-form .menu-alert").removeClass('alert-danger')
                                $("#assign-subjects-to-mock-form .menu-alert").removeClass('alert-warning')
                                $("#assign-subjects-to-mock-form .menu-alert").html('')
                                // $("#DepartmentsDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{
                    // console.log(Response)
                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#assign-subjects-to-mock-form').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

        //get students based on select level
        $("#new-student-mock-modal select[name=level]").on("change", (e)=>{
            e.preventDefault()
            let level_id = $("#new-student-mock-modal select[name=level]").val()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('getStudentsBasedOnLevel')}}',
                method:'GET',
                cache:false,
                data: {level_id:level_id},
                success:(Response)=>{
                    $("#new-student-mock-modal").find("select[name=student]").html(Response)
                }
            })
        })

        //student mock form
        $("#new-student-mock-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let form = $("#new-student-mock-form").serialize()
            $.ajax({
                url:'{{route('get-student-to-mock')}}',
                method:'GET',
                cache: false,
                data: form,
                success:(Response)=>{
                    $("#new-student-mock-modal").modal('hide')
                    $("#insert-student-mock-modal").modal('show')
                    $("#insert-student-mock-modal").find('input[name=student_id]').val
                    (Response['StudentData']['student_id'])
                    $("#insert-student-mock-modal").find('input[name=studentId]').val
                    (Response['StudentData']['id'])
                    $("#insert-student-mock-modal").find('input[name=student_name]').val
                    (Response['StudentData']['student_firstname'] + ' ' +
                        Response['StudentData']['student_othername'] + ' '
                        +Response['StudentData']['student_lastname'])
                    $("#insert-student-mock-modal").find('input[name=student_gender]').val
                    (Response['StudentData']['student_gender'])
                    $("#insert-student-mock-modal").find('input[name=student_level]').val
                    (Response['StudentData']['level']['level_name'])
                    $("#insert-student-mock-modal").find('input[name=level_id]').val
                    (Response['StudentData']['student_level'])
                    $("#insert-student-mock-modal").find('input[name=student_residency]').val
                    (Response['StudentData']['student_residency_type'])
                    $("#insert-student-mock-modal").find('input[name=mock]').val
                    (Response['MockData']['mock_type'])
                    $("#insert-student-mock-modal").find('input[name=mock_id]').val
                    (Response['MockData']['id'])
                    $("#insert-student-mock-modal").find('input[name=term]').val
                    (Response['Term']['term_name'])
                    $("#insert-student-mock-modal").find('input[name=term_id]').val
                    (Response['Term']['id'])
                    $("#insert-student-mock-modal").find('input[name=academic_year]').val
                    (Response['Term']['academic_year']['academic_year_start']+'/'+Response['Term']['academic_year' +
                    '']['academic_year_end'])
                    $("#insert-student-mock-modal").find('input[name=branch_id]').val
                    (Response['StudentData']['student_branch'])
                    $.each(Response['Subjects'], function (index, value){
                        $("#insert-student-mock-modal #MockSubjects").append
                        ('<div class="col-md-4">' +
                            '<label  class="form-label font-w600">Subject '+(index + 1)+'</label>' +
                            '<input type="text" name="mock['+(index + 1)+'][subject]" class="form-control solid"  ' +
                            'value="'+value['assign_subject']['subject_name']+'" readonly>' +
                            '<input type="hidden" name="mock['+(index + 1)+'][subject_id]" value="'+value['subject_id']+'">' +
                            '</div>' +
                            '<div class="col-md-2">' +
                            '<label  class="form-label font-w600">Score</label>' +
                            '<input type="text" name="mock['+(index + 1)+'][score]" class="form-control solid"></div>')
                    })
                }
            })
        })

        //save student mock data
        $("#insert-student-mock-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('new-student-mock-entry')}}',
                method:'POST',
                cache: false,
                data: $("#insert-student-mock-form").serialize(),
                success:(Response)=>{
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#insert-student-mock-modal .menu-alert").removeClass('alert-warning')
                        $("#insert-student-mock-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults
                            .msg)
                    }else{
                        $("#insert-student-mock-modal .menu-alert").removeClass('alert-danger')
                        $("#insert-student-mock-modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#insert-student-mock-modal").modal('hide')
                                $("#insert-student-mock-modal .menu-alert").removeClass('alert-danger')
                                $("#insert-student-mock-modal .menu-alert").removeClass('alert-warning')
                                $("#insert-student-mock-modal .menu-alert").html('')
                                $("#StudentMockDataTables").DataTable().draw()
                                window.location.reload()
                            }
                        })
                    }
                },
                error:(Response)=>{
                    console.log(Response)
                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#insert-student-mock-form').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

        $("#new-student-mock-with-bulk-upload-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route('export-students-mock-list-in-excel')}}',
                method:'GET',
                cache:false,
                data: $("#new-student-mock-with-bulk-upload-form").serialize(),
                success:(Response)=>{
                    // console.log(Response)
                },
                error:(Response)=>{
                    console.log(Response)
                }
            })
        })
    })
</script>
