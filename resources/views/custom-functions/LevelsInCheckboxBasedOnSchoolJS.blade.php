<script>
    $(document).ready(()=>{

        const SchoolLevelsInCheckbox = () =>{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('getLevelsInCheckboxBySchoolId')}}',
                method:'GET',
                cache:false,
                success:(Response)=>{
                    console.log(Response)
                    $("#new-dl-form .row .levelCheckbox").html(Response)
                    // $("#new-bill-form select[name=level]").html(Response)
                    // $("#update-bill-form select[name=level]").html(Response)
                    // $("#new-dl-form select[name=level]").html(Response)
                    // $("#update-dl-form select[name=level]").html(Response)
                }
            })
        }
        SchoolLevelsInCheckbox()

    })
</script>
