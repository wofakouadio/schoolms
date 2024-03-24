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

                    // console.log(Response)

                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        // $("#new-department-modal .menu-alert").removeClass('alert-success')
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
                                // window.location.reload()
                                $("#new-department-modal").modal('hide')
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
                    // console.log(Response);
                }
            })
        })
    })
</script>
