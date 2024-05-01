<script>
    $(document).ready(()=>{

        const SchoolTerms = () =>{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('getTermsBySchoolId')}}',
                method:'GET',
                cache:false,
                success:(Response)=>{
                    // console.log(Response)
                    $("#new-bill-form select[name=term]").html(Response)
                    $("#update-bill-form select[name=term]").html(Response)
                    $("#end_of_term_report_form").find("select[name=term]").html(Response)
                }
            })
        }
        SchoolTerms()

    })
</script>
