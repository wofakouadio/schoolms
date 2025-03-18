<script>
    $(document).ready(()=>{
        const SchoolLevels = () =>{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('getTeacherLevelsBySchoolId') }}",
                method:'GET',
                cache:false,
                success:(Response)=>{
                    // console.log(Response)
                    // let html = []
                    // let html[] = "<option value=''>Choose</option>";
                    // $.each(Response, (index, value)=>{
                    //     // let html[] = "<option value='"+value.level_id+"'>"+value.level.level_name+"</option>"
                    //     $("#new-student-mock-modal").find("select[name=level]").html("<option value='"+value.level_id+"'>"+value.level.level_name+"</option>")
                    //     // console.log(value.level.level_name)
                    // })
                    // console.log(html)
                    $("#new-student-mock-modal").find("select[name=level]").html(Response)
                    $("#new-level-assessment-form").find("select[name=teacher_level]").html(Response)
                    $("#new-student-mid-term-modal").find("select[name=level]").html(Response)
                    $("#new-end-term-setup-modal").find("select[name=level]").html(Response)
                    $("#mock_report_form").find("select[name=level]").html(Response)
                    $("#mid_term_report_form").find("select[name=level]").html(Response)
                    $("#end_of_term_report_form").find("select[name=level]").html(Response)
                }
            })
        }
        SchoolLevels()

    })
</script>
