<script>
    $("document").ready(()=>{
        $("#edit-assessment-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let modal = $("#edit-assessment-modal form")
            let id = str.data('id')
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $.ajax({
                url: "{{route('edit_assessment_setup')}}",
                method: 'GET',
                cache:false,
                data:{assessment_id: id},
                success:(Response)=>{
                    modal.find('input[name=assessment_id]').val(id)
                    modal.find('input[name=academic_year_name]').val
                    (Response['school_academic_year']['academic_year_start']+"/"+Response['school_academic_year' +
                    '']['academic_year_end'])
                    modal.find('input[name=academic_year]').val(Response['academic_year'])
                    modal.find('input[name=class_percentage]').val(Response['class_percentage'])
                    modal.find('input[name=mid_term_percentage]').val(Response['mid_term_percentage'])
                    modal.find('input[name=exam_percentage]').val(Response['exam_percentage'])
                    modal.find('select[name=assessment_status]').val(Response['is_active'])
                }
            })
        })

        $("#delete-assessment-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let modal = $("#delete-assessment-modal form")
            let id = str.data('id')
            modal.find('input[name=assessment_id]').val(id)
        })

        $("#edit-grading-system-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let modal = $("#edit-grading-system-modal form")
            let id = str.data('id')
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $.ajax({
                url: "{{route('edit_grading_system')}}",
                method: 'GET',
                cache:false,
                data:{grading_system_id: id},
                success:(Response)=>{
                    modal.find('input[name=grading_system_id]').val(id)
                    modal.find('input[name=academic_year_name]').val
                    (Response['school_academic_year']['academic_year_start']+"/"+Response['school_academic_year' +
                    '']['academic_year_end'])
                    modal.find('input[name=academic_year]').val(Response['academic_year'])
                    modal.find('input[name=score_from]').val(Response['score_from'])
                    modal.find('input[name=score_to]').val(Response['score_to'])
                    modal.find('input[name=grade]').val(Response['grade'])
                    modal.find('input[name=level_of_proficiency]').val(Response['level_of_proficiency'])
                    modal.find('select[name=category_applicable_to]').val(Response['category_applicable_to'])
                    modal.find('select[name=grading_system_status]').val(Response['is_active'])
                }
            })
        })

        $("#delete-grading-system-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let modal = $("#delete-grading-system-modal form")
            let id = str.data('id')
            modal.find('input[name=grading_system_id]').val(id)
        })
    })
</script>
