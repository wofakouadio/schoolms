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
                url:"{{route('new-teacher')}}",
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
                                $("#new-teacher-form")[0].reset()
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
                url:"{{route('edit-teacher')}}",
                method:'GET',
                cache:false,
                data: {teacher_id:teacher_id},
                success:(Response)=>{
                    $("input[name=teacher_id]").val(teacher_id)
                    $("select[name=teacher_title]").val(Response['teacher_title'])
                    $("input[name=teacher_firstname]").val(Response['teacher_firstname'])
                    $("input[name=teacher_lastname]").val(Response['teacher_lastname'])
                    $("input[name=teacher_oname]").val(Response['teacher_othername'])
                    $("select[name=teacher_gender]").val(Response['teacher_gender'])
                    $("input[name=teacher_date_of_birth]").val(Response['teacher_dob'])
                    $("input[name=teacher_place_of_birth]").val(Response['teacher_pob'])
                    $("input[name=teacher_nationality]").val(Response['teacher_nationality'])
                    $("input[name=teacher_address]").val(Response['teacher_address'])
                    $("input[name=teacher_email]").val(Response['teacher_email'])
                    $("input[name=teacher_contact]").val(Response['teacher_contact'])
                    $("input[name=teacher_school_attended]").val(Response['teacher_school_attended'])
                    $("select[name=teacher_admission_year]").val(Response['teacher_admission_year'])
                    $("select[name=teacher_completion_year]").val(Response['teacher_completion_year'])
                    $("input[name=teacher_country]").val(Response['teacher_country'])
                    $("input[name=teacher_region]").val(Response['teacher_region'])
                    $("input[name=teacher_district]").val(Response['teacher_district'])
                    $("input[name=teacher_first_appointment]").val(Response['teacher_first_app'])
                    $("input[name=teacher_present_school]").val(Response['teacher_present_school'])
                    $("select[name=teacher_qualification]").val(Response['teacher_qualification'])
                    $("input[name=teacher_professional]").val(Response['teacher_professional'])
                    $("select[name=teacher_rank]").val(Response['teacher_rank'])
                    $("input[name=teacher_circuit]").val(Response['teacher_circuit'])
                    $("input[name=teacher_staff_id]").val(Response['teacher_staff_id'])
                    $("input[name=teacher_reg_num]").val(Response['teacher_reg_number'])
                    $("input[name=teacher_district_file_number]").val
                    (Response['teacher_district_file_number'])
                    $("input[name=teacher_bank_name]").val(Response['teacher_bank_name'])
                    $("input[name=teacher_acc_number]").val(Response['teacher_account_number'])
                    $("input[name=teacher_bank_branch]").val(Response['teacher_bank_branch'])
                    $("input[name=teacher_ssnit]").val(Response['teacher_ssnit'])
                    $("input[name=teacher_ntc]").val(Response['teacher_ntc'])
                    $("input[name=teacher_ghana_card]").val(Response['teacher_ghana_card'])
                    $("select[name=teacher_is_active]").val(Response['is_active'])

                    if(Response['media'].length > 0){
                        $('#image').show()
                        $('#image').attr("src",Response['media'][0]['original_url'])
                    }else{
                        $('#image').hide()
                    }
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
                url:"{{route('update-teacher')}}",
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
                url:"{{route('edit-teacher')}}",
                method:'GET',
                cache:false,
                data: {teacher_id:teacher_id},
                success:(Response)=>{
                    $("input[name=teacher_id]").val(teacher_id)
                    $(".delete-notice").html("Are you sure of deleting "
                        + Response['teacher_title'] + ". "+Response['teacher_firstname'] + " "
                    + Response['teacher_othername'] + " " + Response['teacher_lastname'] +" data?")
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
                url:"{{route('delete-teacher')}}",
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

        //get subjects based on level
        $("#new-assign-level-teacher-form select[name=level]").on("change", ()=>{
            let level = $("#new-assign-level-teacher-form select[name=level]").val()
            let teacher = $("#new-assign-level-teacher-form select[name=teacher]").val()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('get_subjects_by_level')}}",
                method:'GET',
                cache: false,
                data:{level:level, teacher:teacher},
                success:(Response)=>{
                    // console.log(Response)
                    $("#new-assign-level-teacher-form").find(".teacherSubjects").html(Response)
                    // $.each(Response, (key, value)=>{
                    //     $("#new-assign-level-teacher-form select[name=subject]").append(
                    //         '<option value="'+value['subject_id']+'">'+value['subject']['subject_name' +
                    //         '']+'</option>'
                    //     )
                    // })
                }
            })
        })

    })
</script>
