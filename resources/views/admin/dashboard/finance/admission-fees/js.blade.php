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
        })
    })

</script>
