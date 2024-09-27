<script>
    $(document).ready(()=>{
        const SchoolStudentID = () =>{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let school_id = '{{Auth::guard('admin')->user()->school_id}}'
            $.ajax({
                url:'{{route('getStudentIdBySchoolId')}}',
                method:'GET',
                cache:false,
                data:{school_id: school_id},
                success:(Response)=>{
                    // console.log(Response)
                    $("#new-student-modal").find("input[name=student_id]").val(Response)
                }
            })
        }
        SchoolStudentID()
    })
</script>
