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
                    console.log(Response)
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
                    console.log(Response)
                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#assign-subjects-to-mock-form').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })
    })
</script>
