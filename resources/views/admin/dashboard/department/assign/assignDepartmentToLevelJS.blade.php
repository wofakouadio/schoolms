 <script>
    $(document).ready(()=>{
        // alert
        $(" .menu-alert").hide()

        //new dl
        $("#new-dl-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#new-dl-form").serialize()
            $.ajax({
                url:"{{route('new-assign-department-to-level')}}",
                method:'POST',
                cache:false,
                data: form_data,

                success:(Response)=>{
                    console.log(Response)
                    // let StringResults = JSON.stringify(Response)
                    // let DecodedResults = JSON.parse(StringResults)
                    // if(DecodedResults.status === 201){
                    //     $("#new-dl-modal .menu-alert").removeClass('alert-warning')
                    //     $("#new-dl-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    // }else{
                    //     $("#new-dl-modal .menu-alert").removeClass('alert-danger')
                    //     $("#new-dl-modal .menu-alert").removeClass('alert-warning')
                    //
                    //     Swal.fire({
                    //         title: 'Notification',
                    //         html: DecodedResults.msg,
                    //         type: 'success',
                    //         allowOutsideClick: false,
                    //         allowEscapeKey: false,
                    //         confirmButtonText: 'Close',
                    //     }).then((result) => {
                    //         if (result) {
                    //             // window.location.reload()
                    //             $("#new-dl-modal").modal('hide')
                    //             $("#new-dl-form")[0].reset()
                    //             $("#new-dl-modal .menu-alert").removeClass('alert-danger')
                    //             $("#new-dl-modal .menu-alert").removeClass('alert-warning')
                    //             $("#new-dl-modal .menu-alert").html('')
                    //             $("#AssignDepartmentLevelDataTables").DataTable().draw();
                    //         }
                    //     })
                    // }
                },
                error:(Response)=>{
                    console.log(Response)
                    // $.each( Response.responseJSON.errors, function( key, value ) {
                    //     $('#new-dl-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                    //         .append
                    //     ('<li>'+value+'</li>');
                    // });
                }
            })
        })

        //show edit dl modal with data
        $("#edit-dl-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget);
            let dl_id = str.data('id')

            let modal = $("#edit-dl-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('edit-assign-department-to-level')}}",
                method:'GET',
                cache:false,
                data: {dl_id:dl_id},
                success:(Response)=>{
                    modal.find("input[name=dl_id]").val(dl_id)
                    modal.find("input[name=dl_name]").val(Response['dl_name'])
                    modal.find("textarea[name=dl_description]").val(Response['dl_description'])
                    modal.find("select[name=department]").val(Response['department_id'])
                    modal.find("select[name=dl_is_active]").val(Response['is_active'])
                }
            })
        })

        //update dl data
        $("#update-dl-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#update-dl-form").serialize()
            $.ajax({
                url:"{{route('update-assign-department-to-level')}}",
                method:'POST',
                cache:false,
                data: form_data,

                success:(Response)=>{
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#edit-dl-modal .menu-alert").removeClass('alert-warning')
                        $("#edit-dl-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#edit-dl-modal .menu-alert").removeClass('alert-danger')
                        $("#edit-dl-modal .menu-alert").removeClass('alert-warning')

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
                                $("#edit-dl-modal").modal('hide')
                                $("#edit-dl-modal .menu-alert").removeClass('alert-danger')
                                $("#edit-dl-modal .menu-alert").removeClass('alert-warning')
                                $("#edit-dl-modal .menu-alert").html('')
                                $("#AssignDepartmentLevelDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#edit-dl-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

        //show delete dl modal with data
        $("#delete-dl-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget);
            let dl_id = str.data('id')

            let modal = $("#delete-dl-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('edit-assign-department-to-level')}}",
                method:'GET',
                cache:false,
                data: {dl_id:dl_id},
                success:(Response)=>{
                    modal.find("input[name=dl_id]").val(dl_id)
                    modal.find(".delete-notice").html("Are you sure of deleting "
                        + Response['dl_name'] + " data?")
                }
            })
        })

        //delete dl data
        $("#delete-dl-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#delete-dl-form")
            $.ajax({
                url:"{{route('delete-assign-department-to-level')}}",
                method:'POST',
                cache:false,
                data: form_data.serialize(),
                success:(Response)=>{

                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#delete-dl-modal .menu-alert").removeClass('alert-warning')
                        $("#delete-dl-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#delete-dl-modal .menu-alert").removeClass('alert-danger')
                        $("#delete-dl-modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#delete-dl-modal").modal('hide')
                                $("#delete-dl-modal .menu-alert").removeClass('alert-danger')
                                $("#delete-dl-modal .menu-alert").removeClass('alert-warning')
                                $("#delete-dl-modal .menu-alert").html('')
                                $("#AssignDepartmentLevelDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#delete-dl-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

    })
</script>
