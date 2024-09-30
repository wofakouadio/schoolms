<script>
    $(document).ready(()=>{
        // alert
        $(" .menu-alert").hide()

        //update school information
        $("#school-basic-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#school-basic-form")[0]
            $.ajax({
                url:"{{route('admin_school_update')}}",
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
                        $("#school-basic-form .menu-alert").removeClass('alert-warning')
                        $("#school-basic-form .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#school-basic-form .menu-alert").removeClass('alert-danger')
                        $("#school-basic-form .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#school-basic-form .menu-alert").removeClass('alert-danger')
                                $("#school-basic-form .menu-alert").removeClass('alert-warning')
                                $("#school-basic-form .menu-alert").html('')
                                window.location.reload()
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#school-basic-form').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                        ('<li>'+value+'</li>');
                    });
                }
            })
        })

        //create term
        // {{--$("#new-term-form").on("submit", (e)=>{--}}
        // {{--    e.preventDefault()--}}
        // {{--    $.ajaxSetup({--}}
        // {{--        headers: {--}}
        // {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        // {{--        }--}}
        // {{--    });--}}

        // {{--    let form_data = $("#new-term-form").serialize()--}}
        // {{--    $.ajax({--}}
        // {{--        url:'{{route('new-term')}}',--}}
        // {{--        method:'POST',--}}
        // {{--        cache:false,--}}
        // {{--        data: form_data,--}}
        // {{--        success:(Response)=>{--}}
        // {{--            // console.log(Response)--}}
        // {{--            let StringResults = JSON.stringify(Response)--}}
        // {{--            let DecodedResults = JSON.parse(StringResults)--}}
        // {{--            if(DecodedResults.status === 201){--}}
        // {{--                $("#new-term-form .menu-alert").removeClass('alert-warning')--}}
        // {{--                $("#new-term-form .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)--}}
        // {{--            }else{--}}
        // {{--                $("#new-term-form .menu-alert").removeClass('alert-danger')--}}
        // {{--                $("#new-term-form .menu-alert").removeClass('alert-warning')--}}

        // {{--                Swal.fire({--}}
        // {{--                    title: 'Notification',--}}
        // {{--                    html: DecodedResults.msg,--}}
        // {{--                    type: 'success',--}}
        // {{--                    allowOutsideClick: false,--}}
        // {{--                    allowEscapeKey: false,--}}
        // {{--                    confirmButtonText: 'Close',--}}
        // {{--                }).then((result) => {--}}
        // {{--                    if (result) {--}}
        // {{--                        $("#new-term-modal").modal('hide')--}}
        // {{--                        $("#new-term-form")[0].reset()--}}
        // {{--                        $("#new-term-form .menu-alert").removeClass('alert-danger')--}}
        // {{--                        $("#new-term-form .menu-alert").removeClass('alert-warning')--}}
        // {{--                        $("#new-term-form .menu-alert").html('')--}}
        // {{--                        $("#TermsDataTables").DataTable().draw()--}}
        // {{--                    }--}}
        // {{--                })--}}
        // {{--            }--}}
        // {{--        },--}}
        // {{--        error:(Response)=>{--}}

        // {{--            $.each( Response.responseJSON.errors, function( key, value ) {--}}
        // {{--                $('#new-term-form').find(".menu-alert").show().addClass('alert-warning').find("ul")--}}
        // {{--                    .append--}}
        // {{--                    ('<li>'+value+'</li>');--}}
        // {{--            });--}}
        // {{--        }--}}
        // {{--    })--}}
        // {{--})--}}

        //edit term
        $("#edit-term-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let term_id = str.data('id')
            let modal = $("#edit-term-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('edit-term')}}",
                method:'GET',
                cache:false,
                data:{term_id : term_id},
                success:(Response)=>{
                    modal.find('input[name=term_id]').val(term_id)
                    modal.find('input[name=term_name]').val(Response['term_name'])
                    modal.find('input[name=term_opening_date]').val(Response['term_opening_date'])
                    modal.find('input[name=term_closing_date]').val(Response['term_closing_date'])
                    modal.find('select[name=term_academic_year]').val(Response['term_academic_year'])
                }
            })
        })

        //edit term status
        $("#edit-term-status-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let term_id = str.data('id')
            let modal = $("#edit-term-status-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('edit-term')}}",
                method:'GET',
                cache:false,
                data:{term_id : term_id},
                success:(Response)=>{
                    modal.find('input[name=term_id]').val(term_id)
                    modal.find('input[name=term_name]').val(Response['term_name'])
                    modal.find('select[name=term_is_active]').val(Response['is_active'])
                }
            })
        })

        //update term
        // {{--$("#update-term-form").on("submit", (e)=>{--}}
        // {{--    e.preventDefault()--}}
        // {{--    $.ajaxSetup({--}}
        // {{--        headers: {--}}
        // {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        // {{--        }--}}
        // {{--    });--}}
        // {{--    let form_data = $("#update-term-form").serialize()--}}
        // {{--    $.ajax({--}}
        // {{--        url:'{{route('update-term')}}',--}}
        // {{--        method:'POST',--}}
        // {{--        cache:false,--}}
        // {{--        data: form_data,--}}
        // {{--        success:(Response)=>{--}}
        // {{--            // console.log(Response)--}}
        // {{--            let StringResults = JSON.stringify(Response)--}}
        // {{--            let DecodedResults = JSON.parse(StringResults)--}}
        // {{--            if(DecodedResults.status === 201){--}}
        // {{--                $("#update-term-form .menu-alert").removeClass('alert-warning')--}}
        // {{--                $("#update-term-form .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)--}}
        // {{--            }else{--}}
        // {{--                $("#update-term-form .menu-alert").removeClass('alert-danger')--}}
        // {{--                $("#update-term-form .menu-alert").removeClass('alert-warning')--}}

        // {{--                Swal.fire({--}}
        // {{--                    title: 'Notification',--}}
        // {{--                    html: DecodedResults.msg,--}}
        // {{--                    type: 'success',--}}
        // {{--                    allowOutsideClick: false,--}}
        // {{--                    allowEscapeKey: false,--}}
        // {{--                    confirmButtonText: 'Close',--}}
        // {{--                }).then((result) => {--}}
        // {{--                    if (result) {--}}
        // {{--                        $("#edit-term-modal").modal('hide')--}}
        // {{--                        $("#update-term-form .menu-alert").removeClass('alert-danger')--}}
        // {{--                        $("#update-term-form .menu-alert").removeClass('alert-warning')--}}
        // {{--                        $("#update-term-form .menu-alert").html('')--}}
        // {{--                        $("#TermsDataTables").DataTable().draw()--}}
        // {{--                        window.location.reload()--}}
        // {{--                    }--}}
        // {{--                })--}}
        // {{--            }--}}
        // {{--        },--}}
        // {{--        error:(Response)=>{--}}

        // {{--            $.each( Response.responseJSON.errors, function( key, value ) {--}}
        // {{--                $('#update-term-form').find(".menu-alert").show().addClass('alert-warning').find("ul")--}}
        // {{--                    .append--}}
        // {{--                    ('<li>'+value+'</li>');--}}
        // {{--            });--}}
        // {{--        }--}}
        // {{--    })--}}
        // {{--})--}}

        //update term
        // {{--$("#update-term-status-form").on("submit", (e)=>{--}}
        // {{--    e.preventDefault()--}}
        // {{--    $.ajaxSetup({--}}
        // {{--        headers: {--}}
        // {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        // {{--        }--}}
        // {{--    });--}}
        // {{--    let form_data = $("#update-term-status-form").serialize()--}}
        // {{--    $.ajax({--}}
        // {{--        url:'{{route('update-term-status')}}',--}}
        // {{--        method:'POST',--}}
        // {{--        cache:false,--}}
        // {{--        data: form_data,--}}
        // {{--        success:(Response)=>{--}}
        // {{--            // console.log(Response)--}}
        // {{--            let StringResults = JSON.stringify(Response)--}}
        // {{--            let DecodedResults = JSON.parse(StringResults)--}}
        // {{--            if(DecodedResults.status === 201){--}}
        // {{--                $("#update-term-status-form .menu-alert").removeClass('alert-warning')--}}
        // {{--                $("#update-term-status-form .menu-alert").show().addClass('alert-danger').html(DecodedResults--}}
        // {{--                    .msg)--}}
        // {{--            }else{--}}
        // {{--                $("#update-term-status-form .menu-alert").removeClass('alert-danger')--}}
        // {{--                $("#update-term-status-form .menu-alert").removeClass('alert-warning')--}}

        // {{--                Swal.fire({--}}
        // {{--                    title: 'Notification',--}}
        // {{--                    html: DecodedResults.msg,--}}
        // {{--                    type: 'success',--}}
        // {{--                    allowOutsideClick: false,--}}
        // {{--                    allowEscapeKey: false,--}}
        // {{--                    confirmButtonText: 'Close',--}}
        // {{--                }).then((result) => {--}}
        // {{--                    if (result) {--}}
        // {{--                        $("#edit-term-status-modal").modal('hide')--}}
        // {{--                        $("#update-term-status-form .menu-alert").removeClass('alert-danger')--}}
        // {{--                        $("#update-term-status-form .menu-alert").removeClass('alert-warning')--}}
        // {{--                        $("#update-term-status-form .menu-alert").html('')--}}
        // {{--                        $("#TermsDataTables").DataTable().draw()--}}
        // {{--                        window.location.reload()--}}
        // {{--                    }--}}
        // {{--                })--}}
        // {{--            }--}}
        // {{--        },--}}
        // {{--        error:(Response)=>{--}}

        // {{--            $.each( Response.responseJSON.errors, function( key, value ) {--}}
        // {{--                $('#update-term-status-form').find(".menu-alert").show().addClass('alert-warning').find("ul")--}}
        // {{--                    .append--}}
        // {{--                    ('<li>'+value+'</li>');--}}
        // {{--            });--}}
        // {{--        }--}}
        // {{--    })--}}
        // {{--})--}}

        //delete term
        $("#delete-term-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let term_id = str.data('id')
            let modal = $("#delete-term-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('edit-term')}}",
                method:'GET',
                cache:false,
                data:{term_id : term_id},
                success:(Response)=>{
                    modal.find('input[name=term_id]').val(term_id)
                    modal.find('.delete-notice').html('Are you sure of deleting ' + Response['term_name'] + ' Term?')
                }
            })
        })

        //delete term
        // {{--$("#delete-term-form").on("submit", (e)=>{--}}
        // {{--    e.preventDefault()--}}
        // {{--    $.ajaxSetup({--}}
        // {{--        headers: {--}}
        // {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        // {{--        }--}}
        // {{--    });--}}
        // {{--    let form_data = $("#delete-term-form").serialize()--}}
        // {{--    $.ajax({--}}
        // {{--        url:'{{route('delete-term')}}',--}}
        // {{--        method:'POST',--}}
        // {{--        cache:false,--}}
        // {{--        data: form_data,--}}
        // {{--        success:(Response)=>{--}}
        // {{--            // console.log(Response)--}}
        // {{--            let StringResults = JSON.stringify(Response)--}}
        // {{--            let DecodedResults = JSON.parse(StringResults)--}}
        // {{--            if(DecodedResults.status === 201){--}}
        // {{--                $("#delete-term-form .menu-alert").removeClass('alert-warning')--}}
        // {{--                $("#delete-term-form .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)--}}
        // {{--            }else{--}}
        // {{--                $("#delete-term-form .menu-alert").removeClass('alert-danger')--}}
        // {{--                $("#delete-term-form .menu-alert").removeClass('alert-warning')--}}

        // {{--                Swal.fire({--}}
        // {{--                    title: 'Notification',--}}
        // {{--                    html: DecodedResults.msg,--}}
        // {{--                    type: 'success',--}}
        // {{--                    allowOutsideClick: false,--}}
        // {{--                    allowEscapeKey: false,--}}
        // {{--                    confirmButtonText: 'Close',--}}
        // {{--                }).then((result) => {--}}
        // {{--                    if (result) {--}}
        // {{--                        $("#delete-term-modal").modal('hide')--}}
        // {{--                        $("#delete-term-form .menu-alert").removeClass('alert-danger')--}}
        // {{--                        $("#delete-term-form .menu-alert").removeClass('alert-warning')--}}
        // {{--                        $("#delete-term-form .menu-alert").html('')--}}
        // {{--                        $("#TermsDataTables").DataTable().draw()--}}
        // {{--                    }--}}
        // {{--                })--}}
        // {{--            }--}}
        // {{--        },--}}
        // {{--        error:(Response)=>{--}}

        // {{--            $.each( Response.responseJSON.errors, function( key, value ) {--}}
        // {{--                $('#delete-term-form').find(".menu-alert").show().addClass('alert-warning').find("ul")--}}
        // {{--                    .append--}}
        // {{--                    ('<li>'+value+'</li>');--}}
        // {{--            });--}}
        // {{--        }--}}
        // {{--    })--}}
        // {{--})--}}
    })
</script>
