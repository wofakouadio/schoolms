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
                    // console.log(Response);
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    let errorsCount = DecodedResults.responseJSON.errors
                    $(".menu-alert").removeClass('alert-success')
                    $(".menu-alert").removeClass('alert-danger')

                    if('message' in errorsCount){
                        $("#new-department-modal .menu-alert").show().addClass('alert-warning').html(errorsCount.message)
                    }else{
                        $("#new-department-modal .menu-alert").show().addClass('alert-warning').html('Check in the forms for errors')
                    }
                },
                error:(Response)=>{
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    let errorsCount = DecodedResults.responseJSON.errors
                    $(".menu-alert").removeClass('alert-success')
                    $(".menu-alert").removeClass('alert-danger')

                    if('message' in errorsCount){
                        $("#new-department-modal .menu-alert").show().addClass('alert-warning').html(errorsCount.message)
                    }else{
                        $("#new-department-modal .menu-alert").show().addClass('alert-warning').html('Check in the forms for errors')
                    }
                    // console.log(Response);
                }
            })
        })
    })
</script>
