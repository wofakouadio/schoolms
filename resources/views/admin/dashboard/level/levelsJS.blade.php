 <script>
    $(document).ready(()=>{
        // alert
        $(" .menu-alert").hide()

        //new level
        $("#new-level-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#new-level-form").serialize()
            $.ajax({
                url:"{{route('new-level')}}",
                method:'POST',
                cache:false,
                data: form_data,

                success:(Response)=>{
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#new-level-modal .menu-alert").removeClass('alert-warning')
                        $("#new-level-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#new-level-modal .menu-alert").removeClass('alert-danger')
                        $("#new-level-modal .menu-alert").removeClass('alert-warning')

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
                                $("#new-level-modal").modal('hide')
                                $("#new-level-form")[0].reset()
                                $("#new-level-modal .menu-alert").removeClass('alert-danger')
                                $("#new-level-modal .menu-alert").removeClass('alert-warning')
                                $("#new-level-modal .menu-alert").html('')
                                $("#LevelsDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#new-level-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                        ('<li>'+value+'</li>');
                    });
                }
            })
        })

        //show edit level modal with data
        $("#edit-level-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget);
            let level_id = str.data('id')

            let modal = $("#edit-level-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('edit-level')}}",
                method:'GET',
                cache:false,
                data: {level_id:level_id},
                success:(Response)=>{
                    modal.find("input[name=level_id]").val(level_id)
                    modal.find("input[name=level_name]").val(Response['level_name'])
                    modal.find("textarea[name=level_description]").val(Response['level_description'])
                    modal.find("select[name=branch]").val(Response['branch_id'])
                    modal.find("select[name=level_is_active]").val(Response['is_active'])
                }
            })
        })

        //update level data
        $("#update-level-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#update-level-form").serialize()
            $.ajax({
                url:"{{route('update-level')}}",
                method:'POST',
                cache:false,
                data: form_data,

                success:(Response)=>{
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#edit-level-modal .menu-alert").removeClass('alert-warning')
                        $("#edit-level-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#edit-level-modal .menu-alert").removeClass('alert-danger')
                        $("#edit-level-modal .menu-alert").removeClass('alert-warning')

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
                                $("#edit-level-modal").modal('hide')
                                $("#edit-level-modal .menu-alert").removeClass('alert-danger')
                                $("#edit-level-modal .menu-alert").removeClass('alert-warning')
                                $("#edit-level-modal .menu-alert").html('')
                                $("#LevelsDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#edit-level-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

        //show delete level modal with data
        $("#delete-level-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget);
            let level_id = str.data('id')

            let modal = $("#delete-level-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('edit-level')}}",
                method:'GET',
                cache:false,
                data: {level_id:level_id},
                success:(Response)=>{
                    modal.find("input[name=level_id]").val(level_id)
                    modal.find(".delete-notice").html("Are you sure of deleting "
                        + Response['level_name'] + " data?")
                }
            })
        })

        //delete level data
        $("#delete-level-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#delete-level-form")
            $.ajax({
                url:"{{route('delete-level')}}",
                method:'POST',
                cache:false,
                data: form_data.serialize(),
                success:(Response)=>{

                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#delete-level-modal .menu-alert").removeClass('alert-warning')
                        $("#delete-level-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#delete-level-modal .menu-alert").removeClass('alert-danger')
                        $("#delete-level-modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#delete-level-modal").modal('hide')
                                $("#delete-level-modal .menu-alert").removeClass('alert-danger')
                                $("#delete-level-modal .menu-alert").removeClass('alert-warning')
                                $("#delete-level-modal .menu-alert").html('')
                                $("#LevelsDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#delete-level-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

        //assign subjects to level modal
        $("#assign-subjects-to-level-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let level_id = str.data('id')
            let modal = $("#assign-subjects-to-level-modal")
            let level_name = str.data('name')
            modal.find("input[name=level_id]").val(level_id)
            modal.find("input[name=level_name]").val(level_name)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('get_subjects_in_checkboxes')}}",
                method:'GET',
                cache:false,
                data:{level_id: level_id},
                success:(Response)=>{
                    modal.find('.subjectCheckbox').html(Response)
                }
            })
        })

        //assign subjects to level form
        $("#assign-subjects-to-level-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#assign-subjects-to-level-form").serialize()
            $.ajax({
                url:"{{route('assign_subjects_to_level')}}",
                method:'POST',
                cache:false,
                data: form_data,
                success:(Response)=>{
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#assign-subjects-to-level-modal .menu-alert").removeClass('alert-warning')
                        $("#assign-subjects-to-level-modal .menu-alert").show().addClass('alert-danger').html
                        (DecodedResults
                            .msg)
                    }else{
                        $("#assign-subjects-to-level-modal .menu-alert").removeClass('alert-danger')
                        $("#assign-subjects-to-level-modal .menu-alert").removeClass('alert-warning')

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
                                $("#assign-subjects-to-level-modal").modal('hide')
                                $("#assign-subjects-to-level-modal .menu-alert").removeClass('alert-danger')
                                $("#assign-subjects-to-level-modal .menu-alert").removeClass('alert-warning')
                                $("#assign-subjects-to-level-modal .menu-alert").html('')
                                $("#LevelsDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#assign-subjects-to-level-modal').find(".menu-alert").show().addClass('alert-warning').find
                        ("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

    })
</script>
