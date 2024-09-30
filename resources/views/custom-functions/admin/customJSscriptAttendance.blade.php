<script>
    $(document).ready(()=>{

        $("#get-attendance-sheet-form select[name=department_id]").on('change', (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let department_id = $("#get-attendance-sheet-form select[name=department_id]").val()
            $.ajax({
                url:'{{route("getLevelsByDepartmentBranchSchoolId")}}',
                method:'GET',
                cache:false,
                data:{department_id: department_id},
                success:(Response)=>{
                    // console.log(Response)
                    $("#get-attendance-sheet-form select[name=level_id]").html(Response)
                }
            })
        })

        $("#get-attendance-sheet-form select[name=level_id]").on("change", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let level_id = $("#get-attendance-sheet-form select[name=level_id]").val()
            $.ajax({
                url:'{{route("getSubjectsByLevelDepartmentBranchSchoolId")}}',
                method:'GET',
                cache:false,
                data:{level_id: level_id},
                success:(Response)=>{
                    // console.log(Response)
                    $("#get-attendance-sheet-form select[name=subject_id]").html(Response)
                }
            })
        })
    })
</script>
