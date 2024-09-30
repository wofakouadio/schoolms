 <script>
    $(document).ready(()=> {

        $(".menu-alert").hide()

        //get students based on select level
        $("#new-level-assessment-form select[name=level]").on("change", (e)=>{
            e.preventDefault()
            let level_id = $("#new-level-assessment-form select[name=level]").val()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('getStudentsBasedOnLevel')}}",
                method:'GET',
                cache:false,
                data: {level_id:level_id},
                success:(Response)=>{
                    $("#new-level-assessment-modal").find("select[name=student]").html(Response)
                }
            })
        })

        // get subjects based on levels
        $("#new-level-assessment-form select[name=level]").on("change", (e)=>{
            e.preventDefault()
            let level_id = $("#new-level-assessment-form select[name=level]").val()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('getSubjectsBasedOnLevel')}}",
                method:'GET',
                cache:false,
                data: {level_id:level_id},
                success:(Response)=>{
                    $("#new-level-assessment-modal").find("select[name=subject]").append('<option>Choose</option>')
                    $.each(Response, (key, value)=>{
                        $("#new-level-assessment-modal").find("select[name=subject]").append
                        ('<option value='+value['subject_id']+'>'+value['subject']['subject_name']+'</option>')
                    })

                }
            })
        })

        //student mock form
        $("#new-level-assessment-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let form = $("#new-level-assessment-form").serialize()
            $.ajax({
                url:"{{route('get_student_to_level_assessment')}}",
                method:'GET',
                cache: false,
                data: form,
                success:(Response)=>{
                    // console.log(Response)
                    $("#new-level-assessment-modal").modal('hide')
                    $("#insert-level-assessment-modal").modal('show')
                    $("#insert-level-assessment-modal").find('input[name=student_id]').val
                    (Response['student']['student_id'])
                    $("#insert-level-assessment-modal").find('input[name=studentId]').val
                    (Response['student']['id'])
                    $("#insert-level-assessment-modal").find('input[name=student_name]').val
                    (Response['student']['student_firstname'] + ' ' +
                        Response['student']['student_othername'] + ' '
                        +Response['student']['student_lastname'])
                    $("#insert-level-assessment-modal").find('input[name=student_gender]').val
                    (Response['student']['student_gender'])
                    $("#insert-level-assessment-modal").find('input[name=student_level]').val
                    (Response['student']['level']['level_name'])
                    $("#insert-level-assessment-modal").find('input[name=level_id]').val
                    (Response['student']['student_level'])
                    $("#insert-level-assessment-modal").find('input[name=student_residency]').val
                    (Response['student']['student_residency_type'])
                    $("#insert-level-assessment-modal").find('input[name=term]').val
                    (Response['term']['term_name'])
                    $("#insert-level-assessment-modal").find('input[name=term_id]').val
                    (Response['term']['id'])
                    $("#insert-level-assessment-modal").find('input[name=academic_year]').val
                    (Response['term']['academic_year']['academic_year_start']+'/'+Response['term']['academic_year' +
                    '']['academic_year_end'])
                    $("#insert-level-assessment-modal").find('input[name=academic_year_id]').val
                    (Response['term']['term_academic_year'])
                    $("#insert-level-assessment-modal").find('input[name=branch_id]').val
                    (Response['student']['student_branch'])
                    $("#insert-level-assessment-modal").find('input[name=subject]').val
                    (Response['subject']['subject_name'])
                    $("#insert-level-assessment-modal").find('input[name=subject_id]').val
                    (Response['subject']['id'])
                }
            })
        })

        //save and close
        $("#btn-save-close").on("click", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let form = $("#insert-level-assessment-form").serialize()
            $.ajax({
                url:"{{route('new_student_class_assessment_entry')}}",
                method:'POST',
                cache: false,
                data: form,
                success:(Response)=>{
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#insert-level-assessment-modal .menu-alert").removeClass('alert-warning')
                        $("#insert-level-assessment-modal .menu-alert").show().addClass('alert-danger').html
                        (DecodedResults
                            .msg)
                    }else{
                        $("#insert-level-assessment-modal .menu-alert").removeClass('alert-danger')
                        $("#insert-level-assessment-modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#insert-level-assessment-modal").modal('hide')
                                $("#insert-level-assessment-modal .menu-alert").removeClass('alert-danger')
                                $("#insert-level-assessment-modal .menu-alert").removeClass('alert-warning')
                                $("#insert-level-assessment-modal .menu-alert").html('')
                                window.location.reload()
                            }
                        })
                    }
                },
                error:(Response)=>{
                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#insert-level-assessment-form').find(".menu-alert").show().addClass('alert-warning').find
                        ("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

        //save and add more
        $("#btn-save-add-more").on("click", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let form = $("#insert-level-assessment-form").serialize()
            $.ajax({
                url:"{{route('new_student_class_assessment_entry')}}",
                method:'POST',
                cache: false,
                data: form,
                success:(Response)=>{
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#insert-level-assessment-modal form .menu-alert").removeClass('alert-warning')
                        $("#insert-level-assessment-modal form .menu-alert").show().addClass('alert-danger').html
                        (DecodedResults
                            .msg)
                    }else{
                        $("#insert-level-assessment-modal form .menu-alert").removeClass('alert-danger')
                        $("#insert-level-assessment-modal form .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#insert-level-assessment-modal").find('input[name=score]').val('')
                                $("#insert-level-assessment-modal form .menu-alert").removeClass('alert-danger')
                                $("#insert-level-assessment-modal form .menu-alert").removeClass('alert-warning')
                                $("#insert-level-assessment-modal form .menu-alert").html('')

                            }
                        })
                    }
                },
                error:(Response)=>{
                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#insert-level-assessment-modal').find(".menu-alert").show().addClass('alert-warning').find
                        ("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

        //edit class assessment record
        $("#edit-level-assessment-modal").on('show.bs.modal', (event)=>{
            let str = $(event.relatedTarget)
            let modal = $("#edit-level-assessment-modal")
            let id = str.data('id')
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('edit_student_class_assessment_entry')}}",
                method:'GET',
                cache: false,
                data:{id:id},
                success:(Response)=>{
                    modal.find('input[name=level_assessment_id]').val(id)
                    modal.find('input[name=student_id]').val(Response['student']['student_id'])
                    modal.find('input[name=studentId]').val(Response['student_id'])
                    modal.find('input[name=branch_id]').val(Response['branch_id'])
                    modal.find('input[name=student_name]').val(Response['student']['student_firstname'])
                    modal.find('input[name=student_gender]').val(Response['student']['student_gender'])
                    modal.find('input[name=student_level]').val(Response['level']['level_name'])
                    modal.find('input[name=level_id]').val(Response['student']['student_level'])
                    modal.find('input[name=student_residency]').val(Response['student']['student_residency_type'])
                    modal.find('input[name=term]').val(Response['term']['term_name'])
                    modal.find('input[name=term_id]').val(Response['term_id'])
                    modal.find('input[name=academic_year]').val
                    (Response['academic_year']['academic_year_start']+'/'+Response['academic_year' +
                    '']['academic_year_end'])
                    modal.find('input[name=academic_year_id]').val(Response['academic_year_id'])
                    modal.find('input[name=subject]').val(Response['subject']['subject_name'])
                    modal.find('input[name=subject_id]').val(Response['subject_id'])
                    modal.find('input[name=score]').val(Response['score'])
                }
            })
        })

        $("#delete-level-assessment-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let modal = $("#delete-level-assessment-modal")
            let id = str.data('id')
            modal.find('input[name=level_assessment_id]').val(id)
        })
    })
</script>
