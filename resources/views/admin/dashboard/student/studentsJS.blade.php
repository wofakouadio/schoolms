<script>
    $(document).ready(()=>{
        // alert
        $(" .menu-alert").hide()

        //new student admission
        $("#new-student-admission-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#new-student-admission-form")[0]
            $.ajax({
                url:"{{route('new-student-admission')}}",
                method:'POST',
                cache:false,
                data: new FormData(form_data),
                processData: false,
                contentType: false,
                success:(Response)=>{

                    // console.log(Response)

                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        // $("#new-student-modal .menu-alert").removeClass('alert-success')
                        $("#new-student-admission-modal .menu-alert").removeClass('alert-warning')
                        $("#new-student-admission-modal .menu-alert").show().addClass('alert-danger').html
                        (DecodedResults
                            .msg)
                    }else{
                        $("#new-student-admission-modal .menu-alert").removeClass('alert-danger')
                        $("#new-student-admission-modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                window.location.reload()
                                $("#new-student-admission-modal").modal('hide')
                                $("#new-student-admission-modal .menu-alert").removeClass('alert-danger')
                                $("#new-student-admission-modal .menu-alert").removeClass('alert-warning')
                                $("#new-student-admission-modal .menu-alert").html('')
                                $("#StudentsAdmissionsDatatables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#new-student-admission-modal').find(".menu-alert").show().addClass('alert-warning').find
                        ("ul")
                            .append
                        ('<li>'+value+'</li>');
                    });
                }
            })
        })

        // bulk upload of students admissions
        $("#new-student-admission-using-excel-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#new-student-admission-using-excel-form")[0]
            $.ajax({
                url:"{{route('new-student-admission-bulk')}}",
                method:'POST',
                cache:false,
                data: new FormData(form_data),
                processData: false,
                contentType: false,
                success:(Response)=>{

                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        // $("#new-student-modal .menu-alert").removeClass('alert-success')
                        $("#new-student-admission-using-excel-modal .menu-alert").removeClass('alert-warning')
                        $("#new-student-admission-using-excel-modal .menu-alert").show().addClass('alert-danger').html
                        (DecodedResults
                            .msg)
                    }else{
                        $("#new-student-admission-using-excel-modal .menu-alert").removeClass('alert-danger')
                        $("#new-student-admission-using-excel-modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                // window.location.reload()
                                $("#new-student-admission-using-excel-modal").modal('hide')
                                $("#new-student-admission-using-excel-modal .menu-alert").removeClass('alert-danger')
                                $("#new-student-admission-using-excel-modal .menu-alert").removeClass('alert-warning')
                                $("#new-student-admission-using-excel-modal .menu-alert").html('')
                                $("#StudentsAdmissionsDatatables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#new-student-admission-using-excel-form').find(".menu-alert").show().addClass('alert-warning').find
                        ("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

        //show edit student modal with data
        $("#edit-student-admission-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget);
            let admission_id = str.data('id')

            let modal = $("#edit-student-admission-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('edit-student-admission')}}",
                method:'GET',
                cache:false,
                data: {admission_id:admission_id},
                success:(Response)=>{
                    // console.log(Response)
                    modal.find("input[name=admission_id]").val(admission_id)
                    modal.find("input[name=student_firstname]").val(Response['studentData']['student_firstname'])
                    modal.find("input[name=student_lastname]").val(Response['studentData']['student_lastname'])
                    modal.find("input[name=student_oname]").val(Response['studentData']['student_othername'])
                    modal.find("select[name=student_gender]").val(Response['studentData']['student_gender'])
                    modal.find("input[name=student_date_of_birth]").val(Response['studentData']['student_dob'])
                    modal.find("input[name=student_place_of_birth]").val(Response['studentData']['student_pob'])
                    modal.find("select[name=student_branch]").val(Response['studentData']['student_branch'])
                    modal.find("select[name=student_level]").val(Response['studentData']['student_level'])
                    modal.find("select[name=student_house]").val(Response['studentData']['student_house'])
                    modal.find("select[name=student_category]").val(Response['studentData']['student_category'])
                    modal.find("select[name=student_residency_type]").val(Response['studentData']['student_residency_type'])
                    modal.find("input[name=student_guardian_name]").val(Response['studentData']['student_guardian_name'])
                    modal.find("input[name=student_guardian_contact]").val(Response['studentData']['student_guardian_contact'])
                    modal.find("input[name=student_guardian_address]").val(Response['studentData']['student_guardian_address'])
                    modal.find("input[name=student_guardian_email]").val(Response['studentData']['student_guardian_email'])
                    modal.find("select[name=student_guardian_occupation]").val
                    (Response['studentData']['student_guardian_occupation'])

                    if(Response['studentData']['media'].length > 0){

                        if(Response['studentData']['media'][0]){
                            modal.find('#student-profile').show()
                            modal.find('#student-profile').attr("src",Response['studentData']['media'][0]['original_url'])
                        }else{
                            modal.find('#student-profile').hide()
                        }

                        if(Response['studentData']['media'][1]){
                            modal.find('#student-guardian-id').show()
                            modal.find('#student-guardian-id').attr("src",Response['studentData']['media'][1]['original_url'])
                        }else{
                            modal.find('#student-guardian-id').hide()
                        }

                    }else{
                        modal.find('#student-profile').hide()
                        modal.find('#student-guardian-id').hide()
                    }
                    modal.find("input[name=student_health_id]").val(Response['healthData']['id'])
                    modal.find("select[name=student_birth_type]").val(Response['healthData']['student_birth_type'])
                    modal.find("input[name=student_birth_type_other]").val(Response['healthData']['student_birth_type'])
                    modal.find("input[name=student_weight]").val(Response['healthData']['student_weight'])
                    modal.find("select[name=student_having_chronic_disease]").val(Response['healthData']['student_having_chronic_disease'])
                    modal.find("input[name=student_has_chronic_disease]").val(Response['healthData']['student_has_chronic_disease'])
                    modal.find("select[name=student_having_generic_disease]").val(Response['healthData']['student_having_generic_disease'])
                    modal.find("input[name=student_has_generic_disease]").val(Response['healthData']['student_has_generic_disease'])
                    modal.find("select[name=student_having_allergies]").val(Response['healthData']['student_having_allergies'])
                    modal.find("input[name=student_has_allergies]").val(Response['healthData']['student_has_allergies'])
                    modal.find("select[name=student_having_stitches]").val(Response['healthData']['student_having_stitches'])
                    modal.find("input[name=student_has_stitches]").val(Response['healthData']['student_has_stitches'])
                    modal.find("input[name=causes_for_student_has_stitches]").val(Response['healthData']['causes_for_student_has_stitches'])
                    modal.find("textarea[name=student_other_health_info]").val(Response['healthData']['student_other_health_info'])
                }
            })
        })

        // {{--update student admission data--}}
        $("#update-student-admission-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#update-student-admission-form")[0]
            $.ajax({
                url:"{{route('update-student-admission')}}",
                method:'POST',
                cache:false,
                data: new FormData(form_data),
                processData: false,
                contentType: false,
                success:(Response)=>{

                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#edit-student-admission-modal .menu-alert").removeClass('alert-warning')
                        $("#edit-student-admission-modal .menu-alert").show().addClass('alert-danger').html
                        (DecodedResults
                            .msg)
                    }else{
                        $("#edit-student-admission-modal .menu-alert").removeClass('alert-danger')
                        $("#edit-student-admission-modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#edit-student-admission-modal").modal('hide')
                                $("#edit-student-admission-modal .menu-alert").removeClass('alert-danger')
                                $("#edit-student-admission-modal .menu-alert").removeClass('alert-warning')
                                $("#edit-student-admission-modal .menu-alert").html('')
                                $("#StudentsAdmissionsDatatables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#edit-student-admission-modal').find(".menu-alert").show().addClass('alert-warning').find
                        ("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

        // student admission status
        $("#edit-student-admission-status-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget);
            let admission_id = str.data('id')

            let modal = $("#edit-student-admission-status-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('edit-student-admission')}}",
                method:'GET',
                cache:false,
                data: {admission_id:admission_id},
                success:(Response)=>{
                    // console.log(Response)
                    let othername = Response['studentData']['student_othername'] ? Response['studentData']['student_othername'] : ' ';
                    modal.find("input[name=admission_id]").val(admission_id)
                    modal.find(".admission-notice").html(Response['studentData']['student_firstname'] + ' ' +
                        ''+othername +' ' +Response['studentData']['student_lastname'])
                    modal.find("select[name=admission_status]").val(Response['studentData']['admission_status'])
                }
            })
        })

        // update student admission status
        $("#edit-student-admission-status-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#edit-student-admission-status-form").serialize()
            $.ajax({
                url:"{{route('update-student-admission-status')}}",
                method:'POST',
                cache:false,
                data: form_data,
                success:(Response)=>{

                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#edit-student-admission-status-form .menu-alert").removeClass('alert-warning')
                        $("#edit-student-admission-status-form .menu-alert").show().addClass('alert-danger').html
                        (DecodedResults
                            .msg)
                    }else{
                        $("#edit-student-admission-status-form .menu-alert").removeClass('alert-danger')
                        $("#edit-student-admission-status-form .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#edit-student-admission-status-modal").modal('hide')
                                $("#edit-student-admission-status-form .menu-alert").removeClass('alert-danger')
                                $("#edit-student-admission-status-form .menu-alert").removeClass('alert-warning')
                                $("#edit-student-admission-status-form .menu-alert").html('')
                                $("#StudentsAdmissionsDatatables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#edit-student-admission-status-form').find(".menu-alert").show().addClass('alert-warning').find
                        ("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

        //show delete student modal with data
        $("#delete-student-admission-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget);
            let admission_id = str.data('id')

            let modal = $("#delete-student-admission-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('edit-student-admission')}}",
                method:'GET',
                cache:false,
                data: {admission_id:admission_id},
                success:(Response)=>{
                    let othername =  Response['studentData']['student_othername'] ? Response['studentData']['student_othername'] : ' '
                    modal.find("input[name=admission_id]").val(admission_id)
                    modal.find(".delete-notice").html('Are you sure of deleting '+Response['studentData']['student_firstname'] +
                        ' ' +
                        ''+ othername +' ' +Response['studentData']['student_lastname']+' admission?')
                }
            })
        })

        //delete student data
        $("#delete-student-admission-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#delete-student-admission-form")
            $.ajax({
                url:"{{route('delete-student-admission')}}",
                method:'POST',
                cache:false,
                data: form_data.serialize(),
                success:(Response)=>{

                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#delete-student-admission-modal .menu-alert").removeClass('alert-warning')
                        $("#delete-student-admission-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#delete-student-admission-modal .menu-alert").removeClass('alert-danger')
                        $("#delete-student-admission-modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#delete-student-admission-modal").modal('hide')
                                $("#delete-student-admission-modal .menu-alert").removeClass('alert-danger')
                                $("#delete-student-admission-modal .menu-alert").removeClass('alert-warning')
                                $("#delete-student-admission-modal .menu-alert").html('')
                                $("#StudentsAdmissionsDatatables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#delete-student-admission-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

    })
</script>
