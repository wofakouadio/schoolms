<script>
    $(document).ready(()=>{

        const SchoolSubjectInCheckbox = () =>{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('getSubjectInCheckboxBySchoolId')}}',
                method:'GET',
                cache:false,
                success:(Response)=>{
                    // console.log(Response)
                    $("#assign-subjects-to-mock-modal .row #subject_checkbox").html(Response)
                }
            })
        }
        SchoolSubjectInCheckbox()

    })
</script>
