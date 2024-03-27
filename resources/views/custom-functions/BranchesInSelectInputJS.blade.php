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
                url:'{{route('getBranchesBySchoolId')}}',
                method:'GET',
                cache:false,
                data:{school_id: school_id},
                success:(Response)=>{
                    console.log(Response)
                    $("#new-level-form").find("select[name=branch]").html(Response)
                    $("#update-level-form").find("select[name=branch]").html(Response)
                    $("#new-house-form").find("select[name=branch]").html(Response)
                    $("#update-house-form").find("select[name=branch]").html(Response)
                }
            })
        }
        SchoolBranches()
    });
</script>
