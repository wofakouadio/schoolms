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
                url:"{{route('new-student-admission-bulk')}}",
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
                    console.log(Response)
                    modal.find("input[name=admission_id]").val(admission_id)
                    modal.find("input[name=student_firstname]").val(Response[0]['student_firstname'])
                    modal.find("input[name=student_lastname]").val(Response[0]['student_lastname'])
                    modal.find("input[name=student_oname]").val(Response[0]['student_othername'])
                    modal.find("select[name=student_gender]").val(Response[0]['student_gender'])
                    modal.find("input[name=student_date_of_birth]").val(Response[0]['student_dob'])
                    modal.find("input[name=student_place_of_birth]").val(Response[0]['student_pob'])
                    modal.find("select[name=student_branch]").val(Response[0]['student_branch'])
                    modal.find("select[name=student_category]").val(Response[0]['student_category'])
                    modal.find("select[name=student_residency_type]").val(Response[0]['student_residency_type'])
                    modal.find("input[name=student_guardian_name]").val(Response[0]['student_guardian_name'])
                    modal.find("input[name=student_guardian_contact]").val(Response[0]['student_guardian_contact'])
                    modal.find("input[name=student_guardian_address]").val(Response[0]['student_guardian_address'])
                    modal.find("input[name=student_guardian_email]").val(Response[0]['student_guardian_email'])
                    modal.find("select[name=student_guardian_occupation]").val
                    (Response[0]['student_guardian_occupation'])

                    if(Response[0]['student_branch']){
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        let branch_id = Response[0]['student_branch']
                        $.ajax({
                            url:'{{route('getLevelsByBranchId')}}',
                            method:'GET',
                            cache:false,
                            data:{branch_id: branch_id},
                            success:(Response)=>{
                                // console.log(Response)
                                modal.find("select[name=student_level]").html(Response)
                                if(Response){
                                    modal.find("select[name=student_level]").val(Response[0]['student_level'])
                                }

                            }
                        })
                        $.ajax({
                            url:'{{route('getHousesByBranchId')}}',
                            method:'GET',
                            cache:false,
                            data:{branch_id: branch_id},
                            success:(Response)=>{
                                // console.log(Response)
                                modal.find("select[name=student_house]").html(Response)
                                if(Response){
                                    modal.find("select[name=student_house]").val(Response[0]['student_house'])
                                }
                            }
                        })
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

    })
</script>
