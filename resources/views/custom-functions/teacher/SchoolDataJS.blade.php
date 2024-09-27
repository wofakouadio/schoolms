<script>
    $(document).ready(()=>{
        const SchoolData = () =>{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
            @if(Auth::guard('admin')->check())
                url: '{{route('school_data')}}',
            @elseif(Auth::guard('teacher')->check())
                url: '{{route('teacher_school_data')}}',
            @endif
                method: 'GET',
                cache: false,
                success: (Response)=>{
                    // console.log(Response['school_data']['media'].length)
                    if(Response['school_data']['media'].length > 0){
                        $(".nav-header .brand-logo").find('#school_logo').attr("src",
                            Response['school_data']['media'][0]['original_url'])
                    }else{
                        $(".nav-header .brand-logo").find('#school_logo').attr("src",
                            '{{asset('storage/school/logo/profile.png')}}')
                    }
                    $("#new-teacher-form").find("input[name=teacher_present_school]").val(Response['school_data']['school_name']);
                    $(".nav-header .brand-title").html("<h6 " +
                        "class='fw-bolder text-primary'>"+Response['school_data']['school_name']+"</h6>")
                }
            })
        }
        SchoolData()
    })
</script>
