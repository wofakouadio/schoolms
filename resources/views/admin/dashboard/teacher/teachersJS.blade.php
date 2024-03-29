<script>
    $(document).ready(()=>{
        // alert
        $(" .menu-alert").hide()

        //new teacher
        $("#new-teacher-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#new-teacher-form")[0]
            $.ajax({
                url:'{{route('new-teacher')}}',
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
                        // $("#new-teacher-modal .menu-alert").removeClass('alert-success')
                        $("#new-teacher-modal .menu-alert").removeClass('alert-warning')
                        $("#new-teacher-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#new-teacher-modal .menu-alert").removeClass('alert-danger')
                        $("#new-teacher-modal .menu-alert").removeClass('alert-warning')

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
                                $("#new-teacher-modal").modal('hide')
                                $("#new-teacher-modal .menu-alert").removeClass('alert-danger')
                                $("#new-teacher-modal .menu-alert").removeClass('alert-warning')
                                $("#new-teacher-modal .menu-alert").html('')
                                $("#TeachersDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#new-teacher-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                        ('<li>'+value+'</li>');
                    });
                }
            })
        })

        //show edit teacher modal with data
        $("#edit-teacher-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget);
            let teacher_id = str.data('id')

            let modal = $("#edit-teacher-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('edit-teacher')}}',
                method:'GET',
                cache:false,
                data: {teacher_id:teacher_id},
                success:(Response)=>{

                    modal.find("input[name=teacher_id]").val(teacher_id)
                    modal.find("select[name=teacher_title]").val(Response[0]['teacher_title'])
                    modal.find("input[name=teacher_firstname]").val(Response[0]['teacher_firstname'])
                    modal.find("input[name=teacher_lastname]").val(Response[0]['teacher_lastname'])
                    modal.find("input[name=teacher_oname]").val(Response[0]['teacher_othername'])
                    modal.find("select[name=teacher_gender]").val(Response[0]['teacher_gender'])
                    modal.find("input[name=teacher_date_of_birth]").val(Response[0]['teacher_dob'])
                    modal.find("input[name=teacher_place_of_birth]").val(Response[0]['teacher_pob'])
                    modal.find("input[name=teacher_nationality]").val(Response[0]['teacher_nationality'])
                    modal.find("input[name=teacher_address]").val(Response[0]['teacher_address'])
                    modal.find("input[name=teacher_email]").val(Response[0]['teacher_email'])
                    modal.find("input[name=teacher_contact]").val(Response[0]['teacher_contact'])
                    modal.find("input[name=teacher_school_attended]").val(Response[0]['teacher_school_attended'])
                    modal.find("select[name=teacher_admission_year]").val(Response[0]['teacher_admission_year'])
                    modal.find("select[name=teacher_completion_year]").val(Response[0]['teacher_completion_year'])
                    modal.find("input[name=teacher_country]").val(Response[0]['teacher_country'])
                    modal.find("input[name=teacher_region]").val(Response[0]['teacher_region'])
                    modal.find("input[name=teacher_district]").val(Response[0]['teacher_district'])
                    modal.find("input[name=teacher_first_appointment]").val(Response[0]['teacher_first_app'])
                    modal.find("input[name=teacher_present_school]").val(Response[0]['teacher_present_school'])
                    modal.find("select[name=teacher_qualification]").val(Response[0]['teacher_qualification'])
                    modal.find("select[name=teacher_professional]").val(Response[0]['teacher_professional'])
                    modal.find("select[name=teacher_rank]").val(Response[0]['teacher_rank'])
                    modal.find("input[name=teacher_circuit]").val(Response[0]['teacher_circuit'])
                    modal.find("input[name=teacher_staff_id]").val(Response[0]['teacher_staff_id'])
                    modal.find("input[name=teacher_reg_num]").val(Response[0]['teacher_reg_number'])
                    modal.find("input[name=teacher_district_file_number]").val
                    (Response[0]['teacher_district_file_number'])
                    modal.find("input[name=teacher_bank_name]").val(Response[0]['teacher_bank_name'])
                    modal.find("input[name=teacher_acc_number]").val(Response[0]['teacher_account_number'])
                    modal.find("input[name=teacher_bank_branch]").val(Response[0]['teacher_bank_branch'])
                    modal.find("input[name=teacher_ssnit]").val(Response[0]['teacher_ssnit'])
                    modal.find("input[name=teacher_ntc]").val(Response[0]['teacher_ntc'])
                    modal.find("input[name=teacher_ghana_card]").val(Response[0]['teacher_ghana_card'])
                    modal.find("select[name=teacher_is_active]").val(Response[0]['is_active'])
                    modal.find("input[name=teacher_fetched_profile]").val(Response[0]['teacher_profile'])
                }
            })
        })

        //update teacher data
        $("#update-teacher-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#update-teacher-form")[0]
            $.ajax({
                url:'{{route('update-teacher')}}',
                method:'POST',
                cache:false,
                data: new FormData(form_data),
                processData: false,
                contentType: false,
                success:(Response)=>{

                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#edit-teacher-modal .menu-alert").removeClass('alert-warning')
                        $("#edit-teacher-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#edit-teacher-modal .menu-alert").removeClass('alert-danger')
                        $("#edit-teacher-modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#edit-teacher-modal").modal('hide')
                                $("#edit-teacher-modal .menu-alert").removeClass('alert-danger')
                                $("#edit-teacher-modal .menu-alert").removeClass('alert-warning')
                                $("#edit-teacher-modal .menu-alert").html('')
                                $("#TeachersDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#edit-teacher-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

        //show delete teacher modal with data
        $("#delete-teacher-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget);
            let teacher_id = str.data('id')

            let modal = $("#delete-teacher-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('edit-teacher')}}',
                method:'GET',
                cache:false,
                data: {teacher_id:teacher_id},
                success:(Response)=>{
                    modal.find("input[name=teacher_id]").val(teacher_id)
                    modal.find(".delete-notice").html("Are you sure of deleting "
                        + Response[0]['teacher_title'] + ". "+Response[0]['teacher_firstname'] + " "
                    + Response[0]['teacher_othername'] + " " + Response[0]['teacher_lastname'] +" data?")
                }
            })
        })

        //delete teacher data
        $("#delete-teacher-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#delete-teacher-form")
            $.ajax({
                url:'{{route('delete-teacher')}}',
                method:'POST',
                cache:false,
                data: form_data.serialize(),
                success:(Response)=>{

                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#delete-teacher-modal .menu-alert").removeClass('alert-warning')
                        $("#delete-teacher-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#delete-teacher-modal .menu-alert").removeClass('alert-danger')
                        $("#delete-teacher-modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#delete-teacher-modal").modal('hide')
                                $("#delete-teacher-modal .menu-alert").removeClass('alert-danger')
                                $("#delete-teacher-modal .menu-alert").removeClass('alert-warning')
                                $("#delete-teacher-modal .menu-alert").html('')
                                $("#TeachersDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#delete-teacher-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

    })
</script>
