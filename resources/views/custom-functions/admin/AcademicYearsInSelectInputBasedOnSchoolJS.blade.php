<script>
    $(document).ready(()=>{
        const SchoolAcademicYears = ()=>{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route("getAcademicYearsBySchoolId")}}',
                method:'GET',
                cache:false,
                success:(Response)=>{
                    // console.log(Response)
                    $.each(Response, (key, value)=>{
                        $("#new-term-modal").find("select[name=term_academic_year]").append(
                            '<option value='+value['id']+'>'+value['academic_year_start']+'/'+value
                                ['academic_year_end' +
                        '']+'</option>'
                        )
                        $("#edit-term-modal").find("select[name=term_academic_year]").append(
                            '<option value='+value['id']+'>'+value['academic_year_start']+'/'+value
                                ['academic_year_end' +
                            '']+'</option>'
                        )
                        $(".academic_year").append(
                            '<option value='+value['id']+'>'+value['academic_year_start']+'/'+value
                                ['academic_year_end' +
                            '']+'</option>')

                        $("#academic_year").append(
                            '<option value='+value['id']+'>'+value['academic_year_start']+'/'+value
                                ['academic_year_end' +
                            '']+'</option>')
                    })

                }
            })
        }
        SchoolAcademicYears()
    });
</script>
