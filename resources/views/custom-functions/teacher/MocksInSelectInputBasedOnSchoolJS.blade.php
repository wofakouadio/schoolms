<script>
    $(document).ready(()=>{

        const SchoolMocks = () =>{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('getTeacherMocksInSelectBasedOnSchool')}}",
                method:'GET',
                cache:false,
                success:(Response)=>{
                    $("#new-student-mock-modal").find("select[name=mock]").html(Response)
                    $("#mock_report_form").find("select[name=mock]").html(Response)
                }
            })
        }
        SchoolMocks()

    })
</script>
