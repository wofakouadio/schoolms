 <script>
    $(document).ready(()=>{
        // alert
        $(" .menu-alert").hide()

        //new category
        $("#new-category-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#new-category-form").serialize()
            $.ajax({
                url:"{{route('new-category')}}",
                method:'POST',
                cache:false,
                data: form_data,

                success:(Response)=>{
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#new-category-modal .menu-alert").removeClass('alert-warning')
                        $("#new-category-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#new-category-modal .menu-alert").removeClass('alert-danger')
                        $("#new-category-modal .menu-alert").removeClass('alert-warning')

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
                                $("#new-category-modal").modal('hide')
                                $("#new-category-modal .menu-alert").removeClass('alert-danger')
                                $("#new-category-modal .menu-alert").removeClass('alert-warning')
                                $("#new-category-modal .menu-alert").html('')
                                $("#CategoriesDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#new-category-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                        ('<li>'+value+'</li>');
                    });
                }
            })
        })

        //show edit category modal with data
        $("#edit-category-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget);
            let category_id = str.data('id')

            let modal = $("#edit-category-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('edit-category')}}",
                method:'GET',
                cache:false,
                data: {category_id:category_id},
                success:(Response)=>{
                    modal.find("input[name=category_id]").val(category_id)
                    modal.find("input[name=category_name]").val(Response['category_name'])
                    modal.find("textarea[name=category_description]").val(Response['category_description'])
                    modal.find("select[name=category_is_active]").val(Response['is_active'])
                }
            })
        })

        //update category data
        $("#update-category-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#update-category-form").serialize()
            $.ajax({
                url:"{{route('update-category')}}",
                method:'POST',
                cache:false,
                data: form_data,

                success:(Response)=>{
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#edit-category-modal .menu-alert").removeClass('alert-warning')
                        $("#edit-category-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#edit-category-modal .menu-alert").removeClass('alert-danger')
                        $("#edit-category-modal .menu-alert").removeClass('alert-warning')

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
                                $("#edit-category-modal").modal('hide')
                                $("#edit-category-modal .menu-alert").removeClass('alert-danger')
                                $("#edit-category-modal .menu-alert").removeClass('alert-warning')
                                $("#edit-category-modal .menu-alert").html('')
                                $("#CategoriesDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#edit-category-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

        //show delete category modal with data
        $("#delete-category-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget);
            let category_id = str.data('id')

            let modal = $("#delete-category-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('edit-category')}}",
                method:'GET',
                cache:false,
                data: {category_id:category_id},
                success:(Response)=>{
                    modal.find("input[name=category_id]").val(category_id)
                    modal.find(".delete-notice").html("Are you sure of deleting "
                        + Response['category_name'] + " data?")
                }
            })
        })

        //delete category data
        $("#delete-category-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#delete-category-form")
            $.ajax({
                url:"{{route('delete-category')}}",
                method:'POST',
                cache:false,
                data: form_data.serialize(),
                success:(Response)=>{

                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#delete-category-modal .menu-alert").removeClass('alert-warning')
                        $("#delete-category-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#delete-category-modal .menu-alert").removeClass('alert-danger')
                        $("#delete-category-modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#delete-category-modal").modal('hide')
                                $("#delete-category-modal .menu-alert").removeClass('alert-danger')
                                $("#delete-category-modal .menu-alert").removeClass('alert-warning')
                                $("#delete-category-modal .menu-alert").html('')
                                $("#CategoriesDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#delete-category-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

    })
</script>
