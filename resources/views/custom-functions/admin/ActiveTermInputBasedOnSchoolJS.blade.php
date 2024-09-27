<script>
    $(document).ready(()=>{
        const ActiveTerm = ()=>{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                // @if(Auth::guard('admin')->check())
                    url:'{{route('getActiveTermBySchoolID')}}',
                // @elseif(Auth::guard('teacher')->check())
                //     url:'{{route('getTeacherActiveTermBySchoolID')}}',
                // @endif
                method:'GET',
                cache:false,
                success:(Response)=>{
                    // console.log(Response)
                    // @if(Auth::guard('admin')->check())
                        $("#new-end-term-setup-form").find("input[name=term_id]").val(Response['term_id']);
                        $("#new-end-term-setup-form").find("input[name=term_name]").val(Response['term_name']);
                        $("#new-end-term-setup-form").find("input[name=term_academic_year]").val
                        (Response['academic_year_start']+'/'+Response['academic_year_end']);
                    // @elseif(Auth::guard('teacher')->check())
                    //     $("#new-end-term-setup-form").find("input[name=term_id]").val(Response['term_id']);
                    //     $("#new-end-term-setup-form").find("input[name=term_name]").val(Response['term_name']);
                    //     $("#new-end-term-setup-form").find("input[name=term_academic_year]").val(Response['academic_year_start']+'/'+Response['academic_year_end']);
                    // @endif
                }
            })
        }
        ActiveTerm()
    });
</script>
