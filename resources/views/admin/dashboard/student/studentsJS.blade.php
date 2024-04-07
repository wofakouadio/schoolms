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
                url:'{{route('new-student-admission')}}',
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
                                // window.location.reload()
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
                url:'{{route('new-student-admission-bulk')}}',
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
                url:'{{route('edit-student-admission')}}',
                method:'GET',
                cache:false,
                data: {admission_id:admission_id},
                success:(Response)=>{
                    // console.log(Response)
                    modal.find("input[name=admission_id]").val(admission_id)
                    modal.find("input[name=student_firstname]").val(Response['student_firstname'])
                    modal.find("input[name=student_lastname]").val(Response['student_lastname'])
                    modal.find("input[name=student_oname]").val(Response['student_othername'])
                    modal.find("select[name=student_gender]").val(Response['student_gender'])
                    modal.find("input[name=student_date_of_birth]").val(Response['student_dob'])
                    modal.find("input[name=student_place_of_birth]").val(Response['student_pob'])
                    modal.find("select[name=student_branch]").val(Response['student_branch'])
                    modal.find("select[name=student_level]").val(Response['student_level'])
                    modal.find("select[name=student_house]").val(Response['student_house'])
                    modal.find("select[name=student_category]").val(Response['student_category'])
                    modal.find("select[name=student_residency_type]").val(Response['student_residency_type'])
                    modal.find("input[name=student_guardian_name]").val(Response['student_guardian_name'])
                    modal.find("input[name=student_guardian_contact]").val(Response['student_guardian_contact'])
                    modal.find("input[name=student_guardian_address]").val(Response['student_guardian_address'])
                    modal.find("input[name=student_guardian_email]").val(Response['student_guardian_email'])
                    modal.find("select[name=student_guardian_occupation]").val
                    (Response['student_guardian_occupation'])

                    if(Response['media'].length > 0){

                        if(Response['media'][0]){
                            modal.find('#student-profile').show()
                            modal.find('#student-profile').attr("src",Response['media'][0]['original_url'])
                        }else{
                            modal.find('#student-profile').hide()
                        }

                        if(Response['media'][1]){
                            modal.find('#student-guardian-id').show()
                            modal.find('#student-guardian-id').attr("src",Response['media'][1]['original_url'])
                        }else{
                            modal.find('#student-guardian-id').hide()
                        }

                    }else{
                        modal.find('#student-profile').hide()
                        modal.find('#student-guardian-id').hide()
                    }
                }
            })
        })

        {{--update student admission data--}}
        $("#update-student-admission-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#update-student-admission-form")[0]
            $.ajax({
                url:'{{route('update-student-admission')}}',
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
                url:'{{route('edit-student-admission')}}',
                method:'GET',
                cache:false,
                data: {admission_id:admission_id},
                success:(Response)=>{
                    modal.find("input[name=admission_id]").val(admission_id)
                    modal.find(".admission-notice").html(Response['student_firstname'] + ' ' +
                        ''+Response['student_othername'] +' ' +Response['student_lastname'])
                    modal.find("select[name=admission_status]").val(Response['admission_status'])
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
                url:'{{route('update-student-admission-status')}}',
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

        {{--//show delete student modal with data--}}
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
                url:'{{route('edit-student-admission')}}',
                method:'GET',
                cache:false,
                data: {admission_id:admission_id},
                success:(Response)=>{
                    modal.find("input[name=admission_id]").val(admission_id)
                    modal.find(".delete-notice").html('Are you sure of deleting '+Response['student_firstname'] +
                        ' ' +
                        ''+Response['student_othername'] +' ' +Response['student_lastname']+' admission?')
                }
            })
        })

        {{--//delete student data--}}
        $("#delete-student-admission-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#delete-student-admission-form")
            $.ajax({
                url:'{{route('delete-student-admission')}}',
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
