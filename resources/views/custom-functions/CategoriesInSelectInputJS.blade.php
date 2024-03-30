<script>
    $(document).ready(()=>{
        const SchoolBranches = ()=>{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let school_id = '{{Auth::guard('admin')->user()->school_id}}'
            $.ajax({
                url:'{{route('getCategoriesBySchoolId')}}',
                method:'GET',
                cache:false,
                data:{school_id: school_id},
                success:(Response)=>{
                    // console.log(Response)
                    $("#new-student-form").find("select[name=student_category]").html(Response)
                }
            })
        }
        SchoolBranches()
    });
</script>
