<script>
    $(document).ready(()=>{

        $(".menu-alert").hide()

        // create new bill
        $("#student_bill_form").on('submit', (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let form_data = $("#student_bill_form").serialize()
            $.ajax({
                url:'{{route('new-student-bill')}}',
                method:'POST',
                cache:false,
                data: form_data,
                success:(Response)=>{

                    // console.log(Response)

                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#student_bill_form .menu-alert").removeClass('alert-warning')
                        $("#student_bill_form .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#student_bill_form .menu-alert").removeClass('alert-danger')
                        $("#student_bill_form .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                window.location.href = '{{ route("admin_student_bill") }}'
                                // $("#student_bill_form").form('hide')
                                $("#student_bill_form .menu-alert").removeClass('alert-danger')
                                $("#student_bill_form .menu-alert").removeClass('alert-warning')
                                $("#student_bill_form .menu-alert").html('')
                                // $("#new-bill-form")[0].reset()
                                // $("#BillsDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{
                    console.log(Response)

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#student_bill_form').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })
    })
</script>
