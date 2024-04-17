<script>
    $(document).ready(()=>{
        // alert
        $(" .menu-alert").hide()

        //new department
        $("#new-department-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#new-department-form").serialize()
            $.ajax({
                url:'{{route('new-department')}}',
                method:'POST',
                cache:false,
                data: form_data,
                success:(Response)=>{

                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#new-department-modal .menu-alert").removeClass('alert-warning')
                        $("#new-department-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#new-department-modal .menu-alert").removeClass('alert-danger')
                        $("#new-department-modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#new-department-modal").modal('hide')
                                $("#new-department-form")[0].reset()
                                $("#new-department-modal .menu-alert").removeClass('alert-danger')
                                $("#new-department-modal .menu-alert").removeClass('alert-warning')
                                $("#new-department-modal .menu-alert").html('')
                                $("#DepartmentsDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#new-department-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                        ('<li>'+value+'</li>');
                    });
                }
            })
        })

        //edit department
        $("#edit-department-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let modal = $("#edit-department-modal")
            let department_id = str.data('id')
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('edit-department')}}',
                method:'GET',
                cache:false,
                data: {department_id: department_id},
                success:(Response)=>{
                    console.log(Response)
                    modal.find('input[name=department_id]').val(department_id)
                    modal.find('input[name=name]').val(Response['name'])
                    modal.find('textarea[name=description]').val(Response['description'])
                    modal.find('select[name=branch]').val(Response['branch_id'])
                    modal.find('select[name=department_status]').val(Response['is_active'])
                }
            })
        })

        //update department
        $("#update-department-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#update-department-form").serialize()
            $.ajax({
                url:'{{route('update-department')}}',
                method:'POST',
                cache:false,
                data: form_data,
                success:(Response)=>{

                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#edit-department-modal .menu-alert").removeClass('alert-warning')
                        $("#edit-department-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#edit-department-modal .menu-alert").removeClass('alert-danger')
                        $("#edit-department-modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#edit-department-modal").modal('hide')
                                $("#edit-department-modal .menu-alert").removeClass('alert-danger')
                                $("#edit-department-modal .menu-alert").removeClass('alert-warning')
                                $("#edit-department-modal .menu-alert").html('')
                                $("#DepartmentsDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#edit-department-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

        // assign levels to department modal
        $("#assign-leveltodepartment-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget);
            let modal = $("#assign-leveltodepartment-modal");
            let department_id = str.data('id');
            let branch_id = str.data('branch_id');
            let department_name = str.data('department_name');
            let branch_name = str.data('branch_name');
            modal.find('input[name=department_id]').val(department_id)
            modal.find('input[name=department_name]').val(department_name)
            modal.find('input[name=branch_id]').val(branch_id)
            modal.find('input[name=branch_name]').val(branch_name)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('getLevelsBasedOnDepartmentAndBranch')}}',
                method:'GET',
                cache:false,
                data: {department_id: department_id, branch_id: branch_id},
                success:(Response)=>{
                    modal.find('.levelCheckboxOne').html(Response)
                }
            })
        })

        // assign levels to department form
        $("#assign-leveltodepartment-form").on("submit", (e)=>{
            e.preventDefault()

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let form = $("#assign-leveltodepartment-form").serialize()
            $.ajax({
                url:'{{route('new-assign-department-to-level')}}',
                method:'POST',
                cache:false,
                data: form,
                success:(Response)=>{
                    console.log(Response)
                    // let StringResults = JSON.stringify(Response)
                    // let DecodedResults = JSON.parse(StringResults)
                    // if(DecodedResults.status === 201){
                    //     $("#assign-leveltodepartment-modal .menu-alert").removeClass('alert-warning')
                    //     $("#assign-leveltodepartment-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults
                    //         .msg)
                    // }else{
                    //     $("#assign-leveltodepartment-modal .menu-alert").removeClass('alert-danger')
                    //     $("#assign-leveltodepartment-modal .menu-alert").removeClass('alert-warning')
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
                    //             $("#assign-leveltodepartment-modal").modal('hide')
                    //             $("#assign-leveltodepartment-modal .menu-alert").removeClass('alert-danger')
                    //             $("#assign-leveltodepartment-modal .menu-alert").removeClass('alert-warning')
                    //             $("#assign-leveltodepartment-modal .menu-alert").html('')
                    //             // $("#DepartmentsDataTables").DataTable().draw();
                    //         }
                    //     })
                    // }
                },
                error:(Response)=>{
                    console.log(Response)
                    // $.each( Response.responseJSON.errors, function( key, value ) {
                    //     $('#assign-leveltodepartment-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                    //         .append
                    //         ('<li>'+value+'</li>');
                    // });
                }
            })
        })

        //delete department modal
        $("#delete-department-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let modal = $("#delete-department-modal")
            let department_id = str.data('id')
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('edit-department')}}',
                method:'GET',
                cache:false,
                data: {department_id: department_id},
                success:(Response)=>{
                    // console.log(Response)
                    modal.find('input[name=department_id]').val(department_id)
                    modal.find('.delete-notice').html("Are you sure of deleting "
                        + Response['name'] + " department?")
                }
            })
        })

        //delete department
        $("#delete-department-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#delete-department-form").serialize()
            $.ajax({
                url:'{{route('delete-department')}}',
                method:'POST',
                cache:false,
                data: form_data,
                success:(Response)=>{

                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#delete-department-modal .menu-alert").removeClass('alert-warning')
                        $("#delete-department-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults
                            .msg)
                    }else{
                        $("#delete-department-modal .menu-alert").removeClass('alert-danger')
                        $("#delete-department-modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#delete-department-modal").modal('hide')
                                $("#delete-department-modal .menu-alert").removeClass('alert-danger')
                                $("#delete-department-modal .menu-alert").removeClass('alert-warning')
                                $("#delete-department-modal .menu-alert").html('')
                                $("#DepartmentsDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#delete-department-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })
    })
</script>
