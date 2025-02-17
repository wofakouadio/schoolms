<script>

    $(document).ready(()=>{
        $(".menu-alert").hide()

        // create new admission fee
        $("#new-admission-fee-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('new_admission_fee')}}",
                method:'POST',
                cache:false,
                data: $("#new-admission-fee-form").serialize(),
                success:(Response)=>{
                    // console.log(Response)
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#new-admission-fee-modal .menu-alert").removeClass('alert-warning')
                        $("#new-admission-fee-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#new-admission-fee-modal .menu-alert").removeClass('alert-danger')
                        $("#new-admission-fee-modal .menu-alert").removeClass('alert-warning')

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
                                $("#new-admission-fee-modal").modal('hide')
                                $("#new-admission-fee-modal .menu-alert").removeClass('alert-danger')
                                $("#new-admission-fee-modal .menu-alert").removeClass('alert-warning')
                                $("#new-admission-fee-modal .menu-alert").html('')
                                $("#new-admission-fee-form")[0].reset()
                                window.location.reload()
                                $("#AdmissionFeesDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{
                    console.log(Response)

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#new-admission-fee-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

        // view admission fee
        $("#edit-admission-fee-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let id = str.data('id')
            let modal = $("#edit-admission-fee-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('edit_admission_fee')}}",
                method:'GET',
                cache:false,
                data: {id:id},
                success:(Response)=>{
                    modal.find("select[name=academic_year]").val(Response['academic_year_id'])
                    modal.find("input[name=admission_fee_id]").val(id)
                    modal.find("select[name=branch]").val(Response['branch_id'])
                    modal.find("select[name=department]").val(Response['department_id'])
                    modal.find("input[name=amount]").val(Response['amount'])
                    modal.find("input[name=status]").val(Response['is_active'])
                }
            })
        })

        // delete admission fee
        $("#delete-admission-fee-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let id = str.data('id')
            let modal = $("#delete-admission-fee-modal")
            modal.find("input[name=admission_fee_id]").val(id)
        })


        // update admission fee
        $("#edit-admission-fee-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('update_admission_fee')}}",
                method:'POST',
                cache:false,
                data: $("#edit-admission-fee-form").serialize(),
                success:(Response)=>{
                    // console.log(Response)
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#edit-admission-fee-modal .menu-alert").removeClass('alert-warning')
                        $("#edit-admission-fee-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#edit-admission-fee-modal .menu-alert").removeClass('alert-danger')
                        $("#edit-admission-fee-modal .menu-alert").removeClass('alert-warning')

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
                                $("#edit-admission-fee-modal").modal('hide')
                                $("#edit-admission-fee-modal .menu-alert").removeClass('alert-danger')
                                $("#edit-admission-fee-modal .menu-alert").removeClass('alert-warning')
                                $("#edit-admission-fee-modal .menu-alert").html('')
                                $("#edit-admission-fee-form")[0].reset()
                                window.location.reload()
                                $("#AdmissionFeesDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{
                    console.log(Response)

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#new-admission-fee-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })


        // delete admission fee
        $("#delete-admission-fee-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('delete_admission_fee')}}",
                method:'POST',
                cache:false,
                data: $("#delete-admission-fee-form").serialize(),
                success:(Response)=>{
                    // console.log(Response)
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#delete-admission-fee-modal .menu-alert").removeClass('alert-warning')
                        $("#delete-admission-fee-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#delete-admission-fee-modal .menu-alert").removeClass('alert-danger')
                        $("#delete-admission-fee-modal .menu-alert").removeClass('alert-warning')

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
                                $("#delete-admission-fee-modal").modal('hide')
                                $("#delete-admission-fee-modal .menu-alert").removeClass('alert-danger')
                                $("#delete-admission-fee-modal .menu-alert").removeClass('alert-warning')
                                $("#delete-admission-fee-modal .menu-alert").html('')
                                $("#delete-admission-fee-form")[0].reset()
                                window.location.reload()
                                $("#AdmissionFeesDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{
                    console.log(Response)

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#delete-admission-fee-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })
    })

</script>
