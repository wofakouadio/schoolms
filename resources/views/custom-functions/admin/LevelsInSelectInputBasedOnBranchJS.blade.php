<script>
    $(document).ready(()=>{
        const SchoolBranchesLevels = () =>{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('getLevelsByBranchId')}}',
                method:'GET',
                cache:false,
                success:(Response)=>{
                    // console.log(Response)
                    $("#new-student-admission-form select[name=student_level]").html(Response)
                    $("#update-student-admission-form select[name=student_level]").html(Response)
                    $("#new-subject-form select[name=level]").html(Response)
                }
            })
        }
        SchoolBranchesLevels()
        {{--$("#new-student-admission-form select[name=student_branch]").on('change', (e)=>{--}}
        {{--    e.preventDefault()--}}
        {{--    $.ajaxSetup({--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--        }--}}
        {{--    });--}}
        {{--    let branch_id = $("#new-student-admission-form select[name=student_branch]").val()--}}
        {{--    $.ajax({--}}
        {{--        url:'{{route('getLevelsByBranchId')}}',--}}
        {{--        method:'GET',--}}
        {{--        cache:false,--}}
        {{--        data:{branch_id: branch_id},--}}
        {{--        success:(Response)=>{--}}
        {{--            // console.log(Response)--}}
        {{--            $("#new-student-admission-form select[name=student_level]").html(Response)--}}
        {{--        }--}}
        {{--    })--}}
        {{--})--}}

        {{--$("#update-student-admission-form select[name=student_branch]").on('change', (e)=>{--}}
        {{--    e.preventDefault()--}}
        {{--    $.ajaxSetup({--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--        }--}}
        {{--    });--}}
        {{--    let branch_id = $("#update-student-admission-form select[name=student_branch]").val()--}}
        {{--    $.ajax({--}}
        {{--        url:'{{route('getLevelsByBranchId')}}',--}}
        {{--        method:'GET',--}}
        {{--        cache:false,--}}
        {{--        data:{branch_id: branch_id},--}}
        {{--        success:(Response)=>{--}}
        {{--            // console.log(Response)--}}
        {{--            $("#update-student-admission-form select[name=student_level]").html(Response)--}}
        {{--        }--}}
        {{--    })--}}
        {{--})--}}
    })
</script>
