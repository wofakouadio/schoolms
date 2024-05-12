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
                url:'{{route('getTeacherStudentsBasedOnLevel')}}',
                method:'GET',
                cache:false,
                data: {level_id:level_id},
                success:(Response)=>{
                    $("#end_of_term_report_form").find("select[name=student]").html(Response)
                }
            })
        })

        {{--$("#end_of_term_report_form").on("submit", (e)=>{--}}
        {{--    e.preventDefault()--}}
        {{--    $.ajaxSetup({--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--        }--}}
        {{--    });--}}
        {{--    $.ajax({--}}
        {{--        --}}{{--url:'{{route('get_end_of_term_report')}}',--}}
        {{--        method:'GET',--}}
        {{--        cache: false,--}}
        {{--        data: $("#end_of_term_report_form").serialize(),--}}
        {{--        success:(Response)=>{--}}
        {{--            console.log(Response)--}}
        {{--            $("#end_of_term_report_display").html(Response)--}}
        {{--        }--}}
        {{--    })--}}
        {{--})--}}
    })
</script>
