<script>
    $(document).ready(()=>{
        // alert
        $(" .menu-alert").hide()
        //new Subject
        $("#new-subject-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#new-subject-form").serialize()
            $.ajax({
                url:'{{route('new-subject')}}',
                method:'POST',
                cache:false,
                data: form_data,
                success:(Response)=>{

                    // console.log(Response)

                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        // $("#new-subject-modal .menu-alert").removeClass('alert-success')
                        $("#new-subject-modal .menu-alert").removeClass('alert-warning')
                        $("#new-subject-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#new-subject-modal .menu-alert").removeClass('alert-danger')
                        $("#new-subject-modal .menu-alert").removeClass('alert-warning')

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
                                $("#new-subject-modal").modal('hide')
                                $("#new-subject-form")[0].reset()
                                $("#new-subject-modal .menu-alert").removeClass('alert-danger')
                                $("#new-subject-modal .menu-alert").removeClass('alert-warning')
                                $("#new-subject-modal .menu-alert").html('')
                                $("#SubjectsDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#new-subject-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                        ('<li>'+value+'</li>');
                    });
                    // console.log(Response);
                }
            })
        })
    })
</script>
