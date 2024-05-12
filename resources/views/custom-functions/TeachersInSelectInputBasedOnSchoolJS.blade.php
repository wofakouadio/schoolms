<script>
    $("document").ready(()=>{
        const SchoolTeachers = () => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('getTeachersBySchool')}}',
                method:'GET',
                cache:false,
                success:(Response)=>{
                    $.each(Response, (key, value)=>{
                        $("#new-assign-level-teacher-form").find("select[name=teacher]").append(
                            '<option value="'+value['id']+'">'+value['teacher_firstname']+' ' +
                            ''+value['teacher_lastname']+'</option>')
                        $("#new-user-form").find("select[name=user]").append(
                            '<option value="'+value['id']+'">'+value['teacher_firstname']+' ' +
                            ''+value['teacher_lastname']+'</option>')
                    })
                }
            })
        }
        SchoolTeachers()
    })
</script>
