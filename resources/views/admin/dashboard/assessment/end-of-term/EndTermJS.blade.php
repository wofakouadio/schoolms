 <script>
    $(document).ready(()=> {
        // alert
        $(" .menu-alert").hide()

        //get students based on select level
        $("#new-end-term-setup-modal select[name=level]").on("change", (e)=>{
            e.preventDefault()
            let level_id = $("#new-end-term-setup-modal select[name=level]").val()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('getStudentsBasedOnLevel')}}',
                method:'GET',
                cache:false,
                data: {level_id:level_id},
                success:(Response)=>{
                    $("#new-end-term-setup-modal").find("select[name=student]").html(Response)
                }
            })
        })

        //student end of term form
        $("#new-end-term-setup-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let form = $("#new-end-term-setup-form").serialize()
            $.ajax({
                url:'{{route('get-student-to-end-term')}}',
                method:'GET',
                cache: false,
                data: form,
                success:(Response)=>{
                    $("#new-end-term-setup-modal").modal('hide')
                    $("#insert-student-end-term-modal").modal('show')
                    $("#insert-student-end-term-modal").find('input[name=student_id]').val
                    (Response['StudentData']['student_id'])
                    $("#insert-student-end-term-modal").find('input[name=studentId]').val
                    (Response['StudentData']['id'])
                    $("#insert-student-end-term-modal").find('input[name=student_name]').val
                    (Response['StudentData']['student_firstname'] + ' ' +
                        Response['StudentData']['student_othername'] + ' '
                        +Response['StudentData']['student_lastname'])
                    $("#insert-student-end-term-modal").find('input[name=student_gender]').val
                    (Response['StudentData']['student_gender'])
                    $("#insert-student-end-term-modal").find('input[name=student_level]').val
                    (Response['StudentData']['level']['level_name'])
                    $("#insert-student-end-term-modal").find('input[name=level_id]').val
                    (Response['StudentData']['student_level'])
                    $("#insert-student-end-term-modal").find('input[name=student_residency]').val
                    (Response['StudentData']['student_residency_type'])
                    $("#insert-student-end-term-modal").find('input[name=term_name]').val
                    (Response['Term']['term_name'])
                    $("#insert-student-end-term-modal").find('input[name=term_id]').val
                    (Response['Term']['id'])
                    $("#insert-student-end-term-modal").find('input[name=academic_year]').val
                    (Response['Term']['academic_year']['academic_year_start']+'/'+Response['Term']['academic_year' +
                    '']['academic_year_end'])
                    $("#insert-student-end-term-modal").find('input[name=branch_id]').val
                    (Response['StudentData']['student_branch'])
                    $.each(Response['Subjects'], function (index, value){
                        $("#insert-student-end-term-modal #Subjects").append
                        ('<div class="col-md-4">' +
                            '<label  class="form-label font-w600">Subject '+(index + 1)+'</label>' +
                            '<input type="text" name="end_term['+(index + 1)+'][subject]" class="form-control solid" value="'+value['subject']['subject_name']+'" readonly>' +
                            '<input type="hidden" name="end_term['+(index + 1)+'][subject_id]" value="'+value['subject_id']+'">' +
                            '</div>' +
                            '<div class="col-md-2">' +
                            '<label  class="form-label font-w600">Class Score</label>' +
                            '<input type="text" name="end_term['+(index + 1)+'][class_score]" class="form-control ' +
                            'solid">' +
                            '<label  class="form-label font-w600">Exam Score</label>' +
                            '<input type="text" name="end_term['+(index + 1)+'][exam_score]" class="form-control ' +
                            'solid">' +
                            '</div>')
                    })
                }
            })
        })

        //save student mock data
        $("#insert-student-end-term-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('new-student-end-term-entry')}}',
                method:'POST',
                cache: false,
                data: $("#insert-student-end-term-form").serialize(),
                success:(Response)=>{
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#insert-student-end-term-modal .menu-alert").removeClass('alert-warning')
                        $("#insert-student-end-term-modal .menu-alert").show().addClass('alert-danger').html
                        (DecodedResults
                            .msg)
                    }else{
                        $("#insert-student-end-term-modal .menu-alert").removeClass('alert-danger')
                        $("#insert-student-end-term-modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#insert-student-end-term-modal").modal('hide')
                                $("#insert-student-end-term-modal .menu-alert").removeClass('alert-danger')
                                $("#insert-student-end-term-modal .menu-alert").removeClass('alert-warning')
                                $("#insert-student-end-term-modal .menu-alert").html('')
                                $("#StudentsEndTermDataTables").DataTable().draw()
                                window.location.reload()
                            }
                        })
                    }
                },
                error:(Response)=>{
                    console.log(Response)
                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#insert-student-end-term-form').find(".menu-alert").show().addClass('alert-warning').find
                        ("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

        $("#new-student-mock-with-bulk-upload-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route('export-students-mock-list-in-excel')}}',
                method:'GET',
                cache:false,
                data: $("#new-student-mock-with-bulk-upload-form").serialize(),
                success:(Response)=>{
                    // console.log(Response)
                },
                error:(Response)=>{
                    console.log(Response)
                }
            })
        })
    })
</script>
