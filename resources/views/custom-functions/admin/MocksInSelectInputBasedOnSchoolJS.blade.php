<script>
    $(document).ready(()=>{

        const SchoolMocks = () =>{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                // @if(Auth::guard('admin')->check())
                    url:'{{route('getMocksInSelectBasedOnSchool')}}',
                // @elseif(Auth::guard('teacher')->check())
                //     url:'{{route('getTeacherMocksInSelectBasedOnSchool')}}',
                // @endif
                method:'GET',
                cache:false,
                success:(Response)=>{
                    // @if(Auth::guard('admin')->check())
                        $("#assign-subjects-to-mock-modal").find("select[name=mock]").html(Response)
                        $("#new-student-mock-modal").find("select[name=mock]").html(Response)
                        $("#new-student-mock-with-bulk-upload-modal").find("select[name=mock]").html(Response)
                        $("#mock_report_form").find("select[name=mock]").html(Response)
                    // @elseif(Auth::guard('teacher')->check())
                    //     $("#new-student-mock-modal").find("select[name=mock]").html(Response)
                    //     $("#mock_report_form").find("select[name=mock]").html(Response)
                    // @endif
                }
            })
        }
        SchoolMocks()

    })
</script>
