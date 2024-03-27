 <script>
    $(document).ready(()=>{
        // alert
        $(" .menu-alert").hide()

        //new house
        $("#new-house-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#new-house-form").serialize()
            $.ajax({
                url:'{{route('new-house')}}',
                method:'POST',
                cache:false,
                data: form_data,

                success:(Response)=>{
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#new-house-modal .menu-alert").removeClass('alert-warning')
                        $("#new-house-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#new-house-modal .menu-alert").removeClass('alert-danger')
                        $("#new-house-modal .menu-alert").removeClass('alert-warning')

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
                                $("#new-house-modal").modal('hide')
                                $("#new-house-modal .menu-alert").removeClass('alert-danger')
                                $("#new-house-modal .menu-alert").removeClass('alert-warning')
                                $("#new-house-modal .menu-alert").html('')
                                $("#HousesDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#new-house-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                        ('<li>'+value+'</li>');
                    });
                }
            })
        })

        //show edit house modal with data
        $("#edit-house-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget);
            let house_id = str.data('id')

            let modal = $("#edit-house-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('edit-house')}}',
                method:'GET',
                cache:false,
                data: {house_id:house_id},
                success:(Response)=>{
                    modal.find("input[name=house_id]").val(house_id)
                    modal.find("input[name=house_name]").val(Response['house_name'])
                    modal.find("textarea[name=house_description]").val(Response['house_description'])
                    modal.find("select[name=branch]").val(Response['branch_id'])
                    modal.find("select[name=house_type]").val(Response['house_type'])
                    modal.find("select[name=house_is_active]").val(Response['is_active'])
                }
            })
        })

        //update house data
        $("#update-house-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#update-house-form").serialize()
            $.ajax({
                url:'{{route('update-house')}}',
                method:'POST',
                cache:false,
                data: form_data,

                success:(Response)=>{
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#edit-house-modal .menu-alert").removeClass('alert-warning')
                        $("#edit-house-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#edit-house-modal .menu-alert").removeClass('alert-danger')
                        $("#edit-house-modal .menu-alert").removeClass('alert-warning')

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
                                $("#edit-house-modal").modal('hide')
                                $("#edit-house-modal .menu-alert").removeClass('alert-danger')
                                $("#edit-house-modal .menu-alert").removeClass('alert-warning')
                                $("#edit-house-modal .menu-alert").html('')
                                $("#HousesDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#edit-house-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

        //show delete house modal with data
        $("#delete-house-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget);
            let house_id = str.data('id')

            let modal = $("#delete-house-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('edit-house')}}',
                method:'GET',
                cache:false,
                data: {house_id:house_id},
                success:(Response)=>{
                    modal.find("input[name=house_id]").val(house_id)
                    modal.find(".delete-notice").html("Are you sure of deleting "
                        + Response['house_name'] + " data?")
                }
            })
        })

        //delete house data
        $("#delete-house-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#delete-house-form")
            $.ajax({
                url:'{{route('delete-house')}}',
                method:'POST',
                cache:false,
                data: form_data.serialize(),
                success:(Response)=>{

                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#delete-house-modal .menu-alert").removeClass('alert-warning')
                        $("#delete-house-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#delete-house-modal .menu-alert").removeClass('alert-danger')
                        $("#delete-house-modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#delete-house-modal").modal('hide')
                                $("#delete-house-modal .menu-alert").removeClass('alert-danger')
                                $("#delete-house-modal .menu-alert").removeClass('alert-warning')
                                $("#delete-house-modal .menu-alert").html('')
                                $("#HousesDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#delete-house-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

    })
</script>
