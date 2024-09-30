<script>
    $(document).ready(()=>{
        // alert
        $(" .menu-alert").hide()

        //new branch
        $("#new-branch-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#new-branch-form").serialize()
            $.ajax({
                url:"{{route('new-branch')}}",
                method:'POST',
                cache:false,
                data: form_data,

                success:(Response)=>{
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#new-branch-modal .menu-alert").removeClass('alert-warning')
                        $("#new-branch-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#new-branch-modal .menu-alert").removeClass('alert-danger')
                        $("#new-branch-modal .menu-alert").removeClass('alert-warning')

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
                                $("#new-branch-modal").modal('hide')
                                $("#new-branch-modal .menu-alert").removeClass('alert-danger')
                                $("#new-branch-modal .menu-alert").removeClass('alert-warning')
                                $("#new-branch-modal .menu-alert").html('')
                                $("#BranchesDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#new-branch-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                        ('<li>'+value+'</li>');
                    });
                }
            })
        })

        //show edit branch modal with data
        $("#edit-branch-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget);
            let branch_id = str.data('id')

            let modal = $("#edit-branch-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('edit-branch')}}",
                method:'GET',
                cache:false,
                data: {branch_id:branch_id},
                success:(Response)=>{
                    modal.find("input[name=branch_id]").val(branch_id)
                    modal.find("input[name=branch_name]").val(Response['branch_name'])
                    modal.find("textarea[name=branch_description]").val(Response['branch_description'])
                    modal.find("input[name=branch_address]").val(Response['branch_location'])
                    modal.find("input[name=branch_email]").val(Response['branch_email'])
                    modal.find("input[name=branch_contact]").val(Response['branch_contact'])
                    modal.find("select[name=branch_is_active]").val(Response['is_active'])
                }
            })
        })

        //update branch data
        $("#update-branch-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#update-branch-form").serialize()
            $.ajax({
                url:"{{route('update-branch')}}",
                method:'POST',
                cache:false,
                data: form_data,

                success:(Response)=>{
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#edit-branch-modal .menu-alert").removeClass('alert-warning')
                        $("#edit-branch-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#edit-branch-modal .menu-alert").removeClass('alert-danger')
                        $("#edit-branch-modal .menu-alert").removeClass('alert-warning')

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
                                $("#edit-branch-modal").modal('hide')
                                $("#edit-branch-modal .menu-alert").removeClass('alert-danger')
                                $("#edit-branch-modal .menu-alert").removeClass('alert-warning')
                                $("#edit-branch-modal .menu-alert").html('')
                                $("#BranchesDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#edit-branch-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

        //show delete branch modal with data
        $("#delete-branch-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget);
            let branch_id = str.data('id')

            let modal = $("#delete-branch-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('edit-branch')}}",
                method:'GET',
                cache:false,
                data: {branch_id:branch_id},
                success:(Response)=>{
                    modal.find("input[name=branch_id]").val(branch_id)
                    modal.find(".delete-notice").html("Are you sure of deleting "
                        + Response['branch_name'] + " data?")
                }
            })
        })

        //delete branch data
        $("#delete-branch-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#delete-branch-form")
            $.ajax({
                url:"{{route('delete-branch')}}",
                method:'POST',
                cache:false,
                data: form_data.serialize(),
                success:(Response)=>{

                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#delete-branch-modal .menu-alert").removeClass('alert-warning')
                        $("#delete-branch-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#delete-branch-modal .menu-alert").removeClass('alert-danger')
                        $("#delete-branch-modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#delete-branch-modal").modal('hide')
                                $("#delete-branch-modal .menu-alert").removeClass('alert-danger')
                                $("#delete-branch-modal .menu-alert").removeClass('alert-warning')
                                $("#delete-branch-modal .menu-alert").html('')
                                $("#BranchesDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#delete-branch-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

    })
</script>
