<script>
    $(document).ready(()=>{

        const SchoolLevels = () =>{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('getLevelsBySchoolId')}}',
                method:'GET',
                cache:false,
                success:(Response)=>{
                    // console.log(Response)
                    $("#new-bill-form select[name=level]").html(Response)
                    $("#update-bill-form select[name=level]").html(Response)
                }
            })
        }
        SchoolLevels()

    })
</script>