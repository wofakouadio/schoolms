<script>
    $(document).ready(()=>{
        // alert
        $(" .menu-alert").hide()

        //new teacher
        $("#school-basic-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form_data = $("#school-basic-form")[0]
            $.ajax({
                url:'{{route('admin_school_update')}}',
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
    })
</script>
