<script>
    $("document").ready(()=>{

        //get dates of attendance made in dropdown
        const AttendanceDates = () => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('get_attendance_dates')}}",
                method:'get',
                cache: false,
                success:(Response)=>{
                    // console.log(Response)
                    $.each(Response, function (key, value){
                        // console.log("<option value='"+value['attendance_date']+"'>"+value['attendance_date']+"</option>")
                        $("#attendance_report_form").find("select[name=attendance_date]").append("<option " +
                            "value='"+value['attendance_date']+"'>"+value['attendance_date']+"</option>")
                    })
                }
            })
        }
        AttendanceDates()

        //get levels based on selected department
        $("#attendance_report_form select[name=department]").on("change", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('get_levels_by_department')}}",
                method:'GET',
                cache: false,
                data:{department_id: $("#attendance_report_form select[name=department]").val()},
                success:(Response)=>{
                    $("#attendance_report_form").find("select[name=level]").html('')
                    $.each(Response, function(key, value){
                        $("#attendance_report_form").find("select[name=level]").append(
                            "<option value='"+value['level_id']+"'>"+value['assign_level']['level_name' +
                            '']+"</option>"
                        )
                    })
                }
            })

            //get attendance report
            $("#attendance_report_form").on("submit", (e)=>{
                e.preventDefault()
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({

                })
            })
        })

    })
</script>
