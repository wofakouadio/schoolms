<script>
    $(document).ready(()=>{
        // alert
        $(" .menu-alert").hide()

        //new student
        $("#new-student-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#new-student-form")[0]
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
                        $("#new-student-modal .menu-alert").removeClass('alert-warning')
                        $("#new-student-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#new-student-modal .menu-alert").removeClass('alert-danger')
                        $("#new-student-modal .menu-alert").removeClass('alert-warning')

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
                                $("#new-student-modal").modal('hide')
                                $("#new-student-modal .menu-alert").removeClass('alert-danger')
                                $("#new-student-modal .menu-alert").removeClass('alert-warning')
                                $("#new-student-modal .menu-alert").html('')
                                $("#TeachersDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#new-student-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                        ('<li>'+value+'</li>');
                    });
                }
            })
        })

        //show edit student modal with data
        {{--$("#edit-student-modal").on("show.bs.modal", (event)=>{--}}
        {{--    let str = $(event.relatedTarget);--}}
        {{--    let student_id = str.data('id')--}}

        {{--    let modal = $("#edit-student-modal")--}}
        {{--    $.ajaxSetup({--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--        }--}}
        {{--    });--}}
        {{--    $.ajax({--}}
        {{--        url:'{{route('edit-student')}}',--}}
        {{--        method:'GET',--}}
        {{--        cache:false,--}}
        {{--        data: {student_id:student_id},--}}
        {{--        success:(Response)=>{--}}

        {{--            modal.find("input[name=student_id]").val(student_id)--}}
        {{--            modal.find("select[name=student_title]").val(Response[0]['student_title'])--}}
        {{--            modal.find("input[name=student_firstname]").val(Response[0]['student_firstname'])--}}
        {{--            modal.find("input[name=student_lastname]").val(Response[0]['student_lastname'])--}}
        {{--            modal.find("input[name=student_oname]").val(Response[0]['student_othername'])--}}
        {{--            modal.find("select[name=student_gender]").val(Response[0]['student_gender'])--}}
        {{--            modal.find("input[name=student_date_of_birth]").val(Response[0]['student_dob'])--}}
        {{--            modal.find("input[name=student_place_of_birth]").val(Response[0]['student_pob'])--}}
        {{--            modal.find("input[name=student_nationality]").val(Response[0]['student_nationality'])--}}
        {{--            modal.find("input[name=student_address]").val(Response[0]['student_address'])--}}
        {{--            modal.find("input[name=student_email]").val(Response[0]['student_email'])--}}
        {{--            modal.find("input[name=student_contact]").val(Response[0]['student_contact'])--}}
        {{--            modal.find("input[name=student_school_attended]").val(Response[0]['student_school_attended'])--}}
        {{--            modal.find("select[name=student_admission_year]").val(Response[0]['student_admission_year'])--}}
        {{--            modal.find("select[name=student_completion_year]").val(Response[0]['student_completion_year'])--}}
        {{--            modal.find("input[name=student_country]").val(Response[0]['student_country'])--}}
        {{--            modal.find("input[name=student_region]").val(Response[0]['student_region'])--}}
        {{--            modal.find("input[name=student_district]").val(Response[0]['student_district'])--}}
        {{--            modal.find("input[name=student_first_appointment]").val(Response[0]['student_first_app'])--}}
        {{--            modal.find("input[name=student_present_school]").val(Response[0]['student_present_school'])--}}
        {{--            modal.find("select[name=student_qualification]").val(Response[0]['student_qualification'])--}}
        {{--            modal.find("select[name=student_professional]").val(Response[0]['student_professional'])--}}
        {{--            modal.find("select[name=student_rank]").val(Response[0]['student_rank'])--}}
        {{--            modal.find("input[name=student_circuit]").val(Response[0]['student_circuit'])--}}
        {{--            modal.find("input[name=student_staff_id]").val(Response[0]['student_staff_id'])--}}
        {{--            modal.find("input[name=student_reg_num]").val(Response[0]['student_reg_number'])--}}
        {{--            modal.find("input[name=student_district_file_number]").val--}}
        {{--            (Response[0]['student_district_file_number'])--}}
        {{--            modal.find("input[name=student_bank_name]").val(Response[0]['student_bank_name'])--}}
        {{--            modal.find("input[name=student_acc_number]").val(Response[0]['student_account_number'])--}}
        {{--            modal.find("input[name=student_bank_branch]").val(Response[0]['student_bank_branch'])--}}
        {{--            modal.find("input[name=student_ssnit]").val(Response[0]['student_ssnit'])--}}
        {{--            modal.find("input[name=student_ntc]").val(Response[0]['student_ntc'])--}}
        {{--            modal.find("input[name=student_ghana_card]").val(Response[0]['student_ghana_card'])--}}
        {{--            modal.find("select[name=student_is_active]").val(Response[0]['is_active'])--}}
        {{--            modal.find("input[name=student_fetched_profile]").val(Response[0]['student_profile'])--}}
        {{--        }--}}
        {{--    })--}}
        {{--})--}}

        {{--//update student data--}}
        {{--$("#update-student-form").on("submit", (e)=>{--}}
        {{--    e.preventDefault()--}}
        {{--    $.ajaxSetup({--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--        }--}}
        {{--    });--}}

        {{--    let form_data = $("#update-student-form")[0]--}}
        {{--    $.ajax({--}}
        {{--        url:'{{route('update-student')}}',--}}
        {{--        method:'POST',--}}
        {{--        cache:false,--}}
        {{--        data: new FormData(form_data),--}}
        {{--        processData: false,--}}
        {{--        contentType: false,--}}
        {{--        success:(Response)=>{--}}

        {{--            let StringResults = JSON.stringify(Response)--}}
        {{--            let DecodedResults = JSON.parse(StringResults)--}}
        {{--            if(DecodedResults.status === 201){--}}
        {{--                $("#edit-student-modal .menu-alert").removeClass('alert-warning')--}}
        {{--                $("#edit-student-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)--}}
        {{--            }else{--}}
        {{--                $("#edit-student-modal .menu-alert").removeClass('alert-danger')--}}
        {{--                $("#edit-student-modal .menu-alert").removeClass('alert-warning')--}}

        {{--                Swal.fire({--}}
        {{--                    title: 'Notification',--}}
        {{--                    html: DecodedResults.msg,--}}
        {{--                    type: 'success',--}}
        {{--                    allowOutsideClick: false,--}}
        {{--                    allowEscapeKey: false,--}}
        {{--                    confirmButtonText: 'Close',--}}
        {{--                }).then((result) => {--}}
        {{--                    if (result) {--}}
        {{--                        $("#edit-student-modal").modal('hide')--}}
        {{--                        $("#edit-student-modal .menu-alert").removeClass('alert-danger')--}}
        {{--                        $("#edit-student-modal .menu-alert").removeClass('alert-warning')--}}
        {{--                        $("#edit-student-modal .menu-alert").html('')--}}
        {{--                        $("#TeachersDataTables").DataTable().draw();--}}
        {{--                    }--}}
        {{--                })--}}
        {{--            }--}}
        {{--        },--}}
        {{--        error:(Response)=>{--}}

        {{--            $.each( Response.responseJSON.errors, function( key, value ) {--}}
        {{--                $('#edit-student-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")--}}
        {{--                    .append--}}
        {{--                    ('<li>'+value+'</li>');--}}
        {{--            });--}}
        {{--        }--}}
        {{--    })--}}
        {{--})--}}

        {{--//show delete student modal with data--}}
        {{--$("#delete-student-modal").on("show.bs.modal", (event)=>{--}}
        {{--    let str = $(event.relatedTarget);--}}
        {{--    let student_id = str.data('id')--}}

        {{--    let modal = $("#delete-student-modal")--}}
        {{--    $.ajaxSetup({--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--        }--}}
        {{--    });--}}
        {{--    $.ajax({--}}
        {{--        url:'{{route('edit-student')}}',--}}
        {{--        method:'GET',--}}
        {{--        cache:false,--}}
        {{--        data: {student_id:student_id},--}}
        {{--        success:(Response)=>{--}}
        {{--            modal.find("input[name=student_id]").val(student_id)--}}
        {{--            modal.find(".delete-notice").html("Are you sure of deleting "--}}
        {{--                + Response[0]['student_title'] + ". "+Response[0]['student_firstname'] + " "--}}
        {{--            + Response[0]['student_othername'] + " " + Response[0]['student_lastname'] +" data?")--}}
        {{--        }--}}
        {{--    })--}}
        {{--})--}}

        {{--//delete student data--}}
        {{--$("#delete-student-form").on("submit", (e)=>{--}}
        {{--    e.preventDefault()--}}
        {{--    $.ajaxSetup({--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--        }--}}
        {{--    });--}}

        {{--    let form_data = $("#delete-student-form")--}}
        {{--    $.ajax({--}}
        {{--        url:'{{route('delete-student')}}',--}}
        {{--        method:'POST',--}}
        {{--        cache:false,--}}
        {{--        data: form_data.serialize(),--}}
        {{--        success:(Response)=>{--}}

        {{--            let StringResults = JSON.stringify(Response)--}}
        {{--            let DecodedResults = JSON.parse(StringResults)--}}
        {{--            if(DecodedResults.status === 201){--}}
        {{--                $("#delete-student-modal .menu-alert").removeClass('alert-warning')--}}
        {{--                $("#delete-student-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)--}}
        {{--            }else{--}}
        {{--                $("#delete-student-modal .menu-alert").removeClass('alert-danger')--}}
        {{--                $("#delete-student-modal .menu-alert").removeClass('alert-warning')--}}

        {{--                Swal.fire({--}}
        {{--                    title: 'Notification',--}}
        {{--                    html: DecodedResults.msg,--}}
        {{--                    type: 'success',--}}
        {{--                    allowOutsideClick: false,--}}
        {{--                    allowEscapeKey: false,--}}
        {{--                    confirmButtonText: 'Close',--}}
        {{--                }).then((result) => {--}}
        {{--                    if (result) {--}}
        {{--                        $("#delete-student-modal").modal('hide')--}}
        {{--                        $("#delete-student-modal .menu-alert").removeClass('alert-danger')--}}
        {{--                        $("#delete-student-modal .menu-alert").removeClass('alert-warning')--}}
        {{--                        $("#delete-student-modal .menu-alert").html('')--}}
        {{--                        $("#TeachersDataTables").DataTable().draw();--}}
        {{--                    }--}}
        {{--                })--}}
        {{--            }--}}
        {{--        },--}}
        {{--        error:(Response)=>{--}}

        {{--            $.each( Response.responseJSON.errors, function( key, value ) {--}}
        {{--                $('#delete-student-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")--}}
        {{--                    .append--}}
        {{--                    ('<li>'+value+'</li>');--}}
        {{--            });--}}
        {{--        }--}}
        {{--    })--}}
        {{--})--}}

    })
</script>
