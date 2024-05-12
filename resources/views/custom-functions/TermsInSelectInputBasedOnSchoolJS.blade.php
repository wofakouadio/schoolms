<script>
    $(document).ready(()=>{

        const SchoolTerms = () =>{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                @if(Auth::guard('admin')->check())
                    url:'{{route('getTermsBySchoolId')}}',
                @elseif(Auth::guard('teacher')->check())
                    url:'{{route('getTeacherTermsBySchoolId')}}',
                @endif
                method:'GET',
                cache:false,
                success:(Response)=>{
                    // console.log(Response)
                    @if(Auth::guard('admin')->check())
                        $("#new-bill-form select[name=term]").html(Response)
                        $("#update-bill-form select[name=term]").html(Response)
                        $("#end_of_term_report_form").find("select[name=term]").html(Response)
                    @elseif(Auth::guard('teacher')->check())
                        $("#end_of_term_report_form").find("select[name=term]").html(Response)
                    @endif
                }
            })
        }
        SchoolTerms()

    })
</script>
