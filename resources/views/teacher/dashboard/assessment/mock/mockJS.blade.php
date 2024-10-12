<script>
    $(document).ready(()=> {
        // alert
        $(" .menu-alert").hide()

        //get students based on select level
        $("#new-student-mock-modal select[name=level]").on("change", (e)=>{
            e.preventDefault()
            let level_id = $("#new-student-mock-modal select[name=level]").val()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('getTeacherStudentsBasedOnLevel')}}',
                method:'GET',
                cache:false,
                data: {level_id:level_id},
                success:(Response)=>{
                    $("#new-student-mock-modal").find("select[name=student]").html(Response)
                }
            })
        })

        //student mock form
        $("#new-student-mock-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let form = $("#new-student-mock-form").serialize()
            $.ajax({
                url:'{{route('get-teacher-student-to-mock')}}',
                method:'GET',
                cache: false,
                data: form,
                success:(Response)=>{
                    $("#new-student-mock-modal").modal('hide')
                    $("#insert-student-mock-modal").modal('show')
                    $("#insert-student-mock-modal").find('input[name=student_id]').val
                    (Response['StudentData']['student_id'])
                    $("#insert-student-mock-modal").find('input[name=studentId]').val
                    (Response['StudentData']['id'])
                    $("#insert-student-mock-modal").find('input[name=student_name]').val
                    (Response['StudentData']['student_firstname'] + ' ' +
                        Response['StudentData']['student_othername'] + ' '
                        +Response['StudentData']['student_lastname'])
                    $("#insert-student-mock-modal").find('input[name=student_gender]').val
                    (Response['StudentData']['student_gender'])
                    $("#insert-student-mock-modal").find('input[name=student_level]').val
                    (Response['StudentData']['level']['level_name'])
                    $("#insert-student-mock-modal").find('input[name=level_id]').val
                    (Response['StudentData']['student_level'])
                    $("#insert-student-mock-modal").find('input[name=student_residency]').val
                    (Response['StudentData']['student_residency_type'])
                    $("#insert-student-mock-modal").find('input[name=mock]').val
                    (Response['MockData']['mock_type'])
                    $("#insert-student-mock-modal").find('input[name=mock_id]').val
                    (Response['MockData']['id'])
                    $("#insert-student-mock-modal").find('input[name=term]').val
                    (Response['Term']['term_name'])
                    $("#insert-student-mock-modal").find('input[name=term_id]').val
                    (Response['Term']['id'])
                    $("#insert-student-mock-modal").find('input[name=academic_year]').val
                    (Response['Term']['academic_year']['academic_year_start']+'/'+Response['Term']['academic_year' +
                    '']['academic_year_end'])
                    $("#insert-student-mock-modal").find('input[name=branch_id]').val
                    (Response['StudentData']['student_branch'])
                    $.each(Response['Subjects'], function (index, value){
                        $("#insert-student-mock-modal #MockSubjects").append
                        ('<div class="col-md-4">' +
                            '<label  class="form-label font-w600">Subject '+(index + 1)+'</label>' +
                            '<input type="text" name="mock['+(index + 1)+'][subject]" class="form-control solid"  ' +
                            'value="'+value['assign_subject']['subject_name']+'" readonly>' +
                            '<input type="hidden" name="mock['+(index + 1)+'][subject_id]" value="'+value['subject_id']+'">' +
                            '</div>' +
                            '<div class="col-md-2">' +
                            '<label  class="form-label font-w600">Score</label>' +
                            '<input type="text" name="mock['+(index + 1)+'][score]" class="form-control solid"></div>')
                    })
                },
                error:(Response) => {
                    console.log(Response)
                }
            })
        })

        //save student mock data
        // $("#insert-student-mock-form").on("submit", (e)=>{
        //     e.preventDefault()
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     $.ajax({
        //         url:'{{route('new-teacher-student-mock-entry')}}',
        //         method:'POST',
        //         cache: false,
        //         data: $("#insert-student-mock-form").serialize(),
        //         success:(Response)=>{
        //             let StringResults = JSON.stringify(Response)
        //             let DecodedResults = JSON.parse(StringResults)
        //             if(DecodedResults.status === 201){
        //                 $("#insert-student-mock-modal .menu-alert").removeClass('alert-warning')
        //                 $("#insert-student-mock-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults
        //                     .msg)
        //             }else{
        //                 $("#insert-student-mock-modal .menu-alert").removeClass('alert-danger')
        //                 $("#insert-student-mock-modal .menu-alert").removeClass('alert-warning')

        //                 Swal.fire({
        //                     title: 'Notification',
        //                     html: DecodedResults.msg,
        //                     type: 'success',
        //                     allowOutsideClick: false,
        //                     allowEscapeKey: false,
        //                     confirmButtonText: 'Close',
        //                 }).then((result) => {
        //                     if (result) {
        //                         $("#insert-student-mock-modal").modal('hide')
        //                         $("#insert-student-mock-modal .menu-alert").removeClass('alert-danger')
        //                         $("#insert-student-mock-modal .menu-alert").removeClass('alert-warning')
        //                         $("#insert-student-mock-modal .menu-alert").html('')
        //                         $("#StudentMockDataTables").DataTable().draw()
        //                         window.location.reload()
        //                     }
        //                 })
        //             }
        //         },
        //         error:(Response)=>{
        //             console.log(Response)
        //             $.each( Response.responseJSON.errors, function( key, value ) {
        //                 $('#insert-student-mock-form').find(".menu-alert").show().addClass('alert-warning').find("ul")
        //                     .append
        //                     ('<li>'+value+'</li>');
        //             });
        //         }
        //     })
        // })

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
