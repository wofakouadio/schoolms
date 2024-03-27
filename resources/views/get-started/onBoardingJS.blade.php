<script>
    $(document).ready(()=>{
        $("form").on("submit", (e)=>{
            e.preventDefault()
            let form_data = $("form input[name=school_id]").val()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('school-package-selection')}}',
                method:'POST',
                cache:false,
                data: {school_id:form_data},
                success:(Response)=>{

                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $(".auth-form .alert").removeClass('alert-success')
                        $(".auth-form .alert .media .alert-left-icon-big").removeClass('mdi-check-circle-outline')
                        $(".auth-form .alert .media .alert-left-icon-big").addClass('mdi-times-circle-outline')
                        $(".auth-form .alert .media .media-body h5").html('Red Notice')
                        $(".auth-form .alert .media .media-body p").html(DecodedResults.msg)
                    }else{
                        $(".auth-form .alert").removeClass('alert-warning')
                        $(".auth-form .alert").hide().addClass('alert-success').html('')
                        $(".auth-form .alert .media .alert-left-icon-big").removeClass('mdi-times-circle-outline')
                        $(".auth-form .alert .media .alert-left-icon-big").addClass('mdi-check-circle-outline')
                        $(".auth-form .alert .media .media-body h5").html('Congratulations!')
                        $(".auth-form .alert .media .media-body p").html(DecodedResults.msg)

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $(".auth-form .alert").removeClass('alert-warning')
                                $(".auth-form .alert").hide().addClass('alert-success').html('')
                                $(".auth-form .alert .media .alert-left-icon-big").removeClass('mdi-times-circle-outline')
                                $(".auth-form .alert .media .alert-left-icon-big").addClass('mdi-check-circle-outline')
                                $(".auth-form .alert .media .media-body h5").html('Congratulations!')
                                $(".auth-form .alert .media .media-body p").html(DecodedResults.msg)
                                window.location.href = '{{route('platform')}}'
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $(".auth-form .alert").removeClass('alert-success')
                        $(".auth-form .alert .media .alert-left-icon-big").removeClass('mdi-check-circle-outline')
                        $(".auth-form .alert .media .alert-left-icon-big").addClass('mdi-times-circle-outline')
                        $(".auth-form .alert .media .media-body h5").html('Red Notice')
                        $(".auth-form .alert .media .media-body p").html('<ul></ul>').find("ul").append('<li>'+value+'</li>');
                    });
                }
            })
        })
    })
</script>
