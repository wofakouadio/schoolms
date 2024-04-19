<script>
    $(document).ready(()=>{

        const SchoolDepartments = () =>{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('getDepartmentsBySchoolId')}}',
                method:'GET',
                cache:false,
                success:(Response)=>{
                    // console.log(Response)
                    $("#new-level-form select[name=department]").html(Response)
                    $("#update-level-form select[name=department]").html(Response)
                    $("#get-attendance-sheet-form select[name=department_id]").html(Response)
                }
            })
        }
        SchoolDepartments()

    })
</script>
