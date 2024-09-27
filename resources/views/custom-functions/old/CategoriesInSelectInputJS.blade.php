<script>
    $(document).ready(()=>{
        const SchoolCategories = ()=>{
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
                    $("#new-student-admission-form").find("select[name=student_category]").html(Response)
                    $("#update-student-admission-form").find("select[name=student_category]").html(Response)
                }
            })
        }
        SchoolCategories()
    });
</script>
