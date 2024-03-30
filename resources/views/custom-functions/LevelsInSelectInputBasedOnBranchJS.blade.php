<script>
    $(document).ready(()=>{
        $("#new-student-form select[name=student_branch]").on('change', (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let branch_id = $("#new-student-form select[name=student_branch]").val()
            $.ajax({
                url:'{{route('getLevelsByBranchId')}}',
                method:'GET',
                cache:false,
                data:{branch_id: branch_id},
                success:(Response)=>{
                    // console.log(Response)
                    $("#new-student-form select[name=student_level]").html(Response)
                }
            })
        })
    })
</script>
