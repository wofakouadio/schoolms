<script>
    $(document).ready(()=>{
        // alert
        $(" .menu-alert").hide()
        //new Subject
        $("#new-subject-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#new-subject-form").serialize()
            $.ajax({
                url:'{{route('new_subject')}}',
                method:'POST',
                cache:false,
                data: form_data,
                success:(Response)=>{

                    // console.log(Response)

                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        // $("#new-subject-modal .menu-alert").removeClass('alert-success')
                        $("#new-subject-modal #new-subject-form .menu-alert").removeClass('alert-warning')
                        $("#new-subject-modal #new-subject-form .menu-alert").show().addClass('alert-danger').html
                        (DecodedResults.msg)
                    }else{
                        $("#new-subject-modal #new-subject-form .menu-alert").removeClass('alert-danger')
                        $("#new-subject-modal #new-subject-form .menu-alert").removeClass('alert-warning')

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
                                $("#new-subject-modal").modal('hide')
                                $("#new-subject-form")[0].reset()
                                $("#new-subject-modal #new-subject-form .menu-alert").removeClass('alert-danger')
                                $("#new-subject-modal #new-subject-form .menu-alert").removeClass('alert-warning')
                                $("#new-subject-modal #new-subject-form .menu-alert").html('')
                                $("#SubjectsDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#new-subject-modal #new-subject-form').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                        ('<li>'+value+'</li>');
                    });
                    // console.log(Response);
                }
            })
        })

        $("#edit_subject_modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let modal = $("#edit_subject_modal")
            let subject_id = str.data("id")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('edit_subject')}}',
                method:'GET',
                cache:false,
                data:{subject_id:subject_id},
                success:(Response)=>{
                    modal.find("input[name=subject_id]").val(subject_id)
                    modal.find("input[name=subject_name]").val(Response['subject_name'])
                    modal.find("select[name=subject_type]").val(Response['description'])
                    modal.find("select[name=subject_status]").val(Response['is_active'])
                }
            })
        })

        $("#delete_subject_modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let modal = $("#delete_subject_modal")
            let subject_id = str.data("id")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('edit_subject')}}',
                method:'GET',
                cache:false,
                data:{subject_id:subject_id},
                success:(Response)=>{
                    modal.find("input[name=subject_id]").val(subject_id)
                    modal.find(".delete-notice").html("Are you sure of deleting "+Response['subject_name']+" Subject?")
                }
            })
        })

        $("#update_subject_form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let form_data = $("#update_subject_form").serialize()
            $.ajax({
                url:'{{route('update_subject')}}',
                method:'POST',
                cache:false,
                data: form_data,
                success:(Response)=>{
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#edit_subject_modal .menu-alert").removeClass('alert-warning')
                        $("#edit_subject_modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#edit_subject_modal .menu-alert").removeClass('alert-danger')
                        $("#edit_subject_modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#edit_subject_modal").modal('hide')
                                $("#edit_subject_modal .menu-alert").removeClass('alert-danger')
                                $("#edit_subject_modal .menu-alert").removeClass('alert-warning')
                                $("#edit_subject_modal .menu-alert").html('')
                                $("#SubjectsDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{
                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#edit_subject_modal #update_subject_form').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

        $("#delete_subject_form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let form_data = $("#delete_subject_form").serialize()
            $.ajax({
                url:'{{route('delete_subject')}}',
                method:'POST',
                cache:false,
                data: form_data,
                success:(Response)=>{
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#delete_subject_modal .menu-alert").removeClass('alert-warning')
                        $("#delete_subject_modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#delete_subject_modal .menu-alert").removeClass('alert-danger')
                        $("#delete_subject_modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#delete_subject_modal").modal('hide')
                                $("#delete_subject_modal .menu-alert").removeClass('alert-danger')
                                $("#delete_subject_modal .menu-alert").removeClass('alert-warning')
                                $("#delete_subject_modal .menu-alert").html('')
                                $("#SubjectsDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{
                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#delete_subject_modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })
    })
</script>
