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
                    $("#new-dl-form select[name=department]").html(Response)
                }
            })
        }
        SchoolDepartments()

    })
</script>
