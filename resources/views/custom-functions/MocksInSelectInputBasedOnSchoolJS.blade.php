<script>
    $(document).ready(()=>{

        const SchoolMocks = () =>{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('getMocksInSelectBasedOnSchool')}}',
                method:'GET',
                cache:false,
                success:(Response)=>{
                    // console.log(Response)
                    $("#assign-subjects-to-mock-modal").find("select[name=mock]").html(Response)
                    $("#new-student-mock-modal").find("select[name=mock]").html(Response)
                }
            })
        }
        SchoolMocks()

    })
</script>
