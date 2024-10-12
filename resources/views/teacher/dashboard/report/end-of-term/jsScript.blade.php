<script>
    $("document").ready(()=>{

        //get students based on select level
        $("#end_of_term_report_form select[name=level]").on("change", (e)=>{
            e.preventDefault()
            let level_id = $("#end_of_term_report_form select[name=level]").val()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('getTeacherStudentsBasedOnLevel')}}",
                method:'GET',
                cache:false,
                data: {level_id:level_id},
                success:(Response)=>{
                    $("#end_of_term_report_form").find("select[name=student]").html(Response)
                }
            })
        })
    })
</script>
