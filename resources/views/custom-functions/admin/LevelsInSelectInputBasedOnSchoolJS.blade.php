<script>
    $(document).ready(()=>{

        const SchoolLevels = () =>{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route("getLevelsBySchoolId") }}',
                method:'GET',
                cache:false,
                success:(Response)=>{
                    // console.log(Response)
                    $("#new-bill-form select[name=level]").html(Response)
                    $("#update-bill-form select[name=level]").html(Response)
                    $("#new-dl-form select[name=level]").html(Response)
                    $("#update-dl-form select[name=level]").html(Response)
                    $("#assign-subjects-to-mock-modal select[name=level]").html(Response)
                    $("#new-student-mock-modal").find("select[name=level]").html(Response)
                    $("#new-student-mock-with-bulk-upload-modal").find("select[name=level]").html(Response)
                    $("#new-student-mid-term-modal").find("select[name=level]").html(Response)
                    $("#new-end-term-setup-modal").find("select[name=level]").html(Response)
                    $("#mock_report_form").find("select[name=level]").html(Response)
                    $("#mid_term_report_form").find("select[name=level]").html(Response)
                    $("#end_of_term_report_form").find("select[name=level]").html(Response)
                    $("#new-assign-level-teacher-form").find("select[name=level]").html(Response)
                    $("#new-level-assessment-form").find("select[name=level]").html(Response)
                    $("#feeding_fee_new_collection_form").find("select[name=level_id]").html(Response)
                    $(".level").html(Response)
                    $("#level").html(Response)
                    // $("#assign-leveltodepartment-form").find("select[name=level_id]").html(Response)
                }
            })
        }
        SchoolLevels()

    })
</script>
