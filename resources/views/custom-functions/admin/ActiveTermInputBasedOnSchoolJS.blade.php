<script>
    $(document).ready(()=>{
        const ActiveTerm = ()=>{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({

                url:'{{route("getActiveTermBySchoolID")}}',
                method:'GET',
                cache:false,
                success:(Response)=>{
                    $("#new-end-term-setup-form").find("input[name=term_id]").val(Response['term_id']);
                    $("#new-end-term-setup-form").find("input[name=term_name]").val(Response['term_name']);
                    $("#new-end-term-setup-form").find("input[name=term_academic_year]").val
                    (Response['academic_year_start']+'/'+Response['academic_year_end']);
                }
            })
        }
        ActiveTerm()
    });
</script>
