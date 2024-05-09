<script>
    $("document").ready(()=>{

        //get students based on select level
        $("#mock_report_form select[name=level]").on("change", (e)=>{
            e.preventDefault()
            let level_id = $("#mock_report_form select[name=level]").val()
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
                    $("#mock_report_form").find("select[name=student]").html(Response)
                }
            })
        })

        $("#mock_report_form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('get_mock_report')}}',
                method:'GET',
                cache: false,
                data: $("#mock_report_form").serialize(),
                success:(Response)=>{
                    console.log(Response)
                    $("#mock_report_display").html(Response)
                },
                // error:(Response)=>{
                //
                // }
            })
        })

        {{--$("#DownloadMockReport").on("click", ()=>{--}}
        {{--    // e.preventDefault()--}}
        {{--    $.ajaxSetup({--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--        }--}}
        {{--    });--}}
        {{--    $.ajax({--}}
        {{--        --}}{{--url:'{{route('download_mock_report')}}',--}}
        {{--        method:'GET',--}}
        {{--        cache: false,--}}
        {{--        data: {--}}
        {{--            mock_id: $("#mock_report_form select[name=mock]").val(),--}}
        {{--            level_id: $("#mock_report_form select[name=level]").val(),--}}
        {{--            student_id: $("#mock_report_form select[name=student]").val(),--}}
        {{--        },--}}
        {{--        success:(Response)=>{--}}
        {{--            console.log(Response)--}}
        {{--            // $("#mock_report_display").html(Response)--}}
        {{--        }--}}
        {{--    })--}}
        {{--})--}}

    })
</script>
