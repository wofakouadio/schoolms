<script>
    $("document").ready(()=>{

        //get students based on select level
        $("#mid_term_report_form select[name=level]").on("change", (e)=>{
            e.preventDefault()
            let level_id = $("#mid_term_report_form select[name=level]").val()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('getStudentsBasedOnLevel')}}',
                method:'GET',
                cache:false,
                data: {level_id:level_id},
                success:(Response)=>{
                    $("#mid_term_report_form").find("select[name=student]").html(Response)
                }
            })
        })

        $("#mid_term_report_form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('get_mid_term_report')}}',
                method:'GET',
                cache: false,
                data: $("#mid_term_report_form").serialize(),
                success:(Response)=>{
                    console.log(Response)
                    $("#mid_term_report_display").html(Response)
                }
            })
        })
    })
</script>
