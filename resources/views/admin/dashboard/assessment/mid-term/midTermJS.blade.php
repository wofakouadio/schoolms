 <script>
    $(document).ready(()=> {
        // alert
        $(" .menu-alert").hide()

        //get students based on select level
        $("#new-student-mid-term-modal select[name=level]").on("change", (e)=>{
            e.preventDefault()
            let level_id = $("#new-student-mid-term-modal select[name=level]").val()
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
                    $("#new-student-mid-term-modal").find("select[name=student]").html(Response)
                }
            })
        })

        //student mock form
        $("#new-student-mid-term-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let form = $("#new-student-mid-term-form").serialize()
            let modal = $("#insert-student-mid-term-modal")
            $.ajax({
                url:'{{route('get-student-to-mid-term')}}',
                method:'GET',
                cache: false,
                data: form,
                success:(Response)=>{
                    // console.log(Response['Subjects'])
                    $("#new-student-mid-term-modal").modal('hide')
                    modal.modal('show')
                    modal.find('input[name=student_id]').val(Response['StudentData']['student_id'])
                    modal.find('input[name=studentId]').val(Response['StudentData']['id'])
                    modal.find('input[name=student_name]').val(Response['StudentData']['student_firstname'] + ' ' +
                        Response['StudentData']['student_othername'] + ' '
                        +Response['StudentData']['student_lastname'])
                    modal.find('input[name=student_gender]').val(Response['StudentData']['student_gender'])
                    modal.find('input[name=student_level]').val(Response['StudentData']['level']['level_name'])
                    modal.find('input[name=level_id]').val(Response['StudentData']['student_level'])
                    modal.find('input[name=student_residency]').val(Response['StudentData']['student_residency_type'])
                    modal.find('input[name=mid_term_name]').val(Response['MidTerm'])
                    modal.find('input[name=term]').val(Response['Term']['term_name'])
                    modal.find('input[name=term_id]').val(Response['Term']['id'])
                    modal.find('input[name=academic_year]').val
                    (Response['Term']['academic_year']['academic_year_start']+'/'+Response['Term']['academic_year' +
                    '']['academic_year_end'])
                    modal.find('input[name=branch_id]').val(Response['StudentData']['student_branch'])
                    $.each(Response['Subjects'], function (index, value){
                        $("#insert-student-mid-term-modal #Subjects").append
                        ('<div class="col-md-4">' +
                            '<label  class="form-label font-w600">Subject '+(index + 1)+'</label>' +
                            '<input type="text" name="mid_term['+(index + 1)+'][subject]" class="form-control solid" ' +
                            ' ' +
                            'value="'+value['subject']['subject_name']+'" readonly>' +
                            '<input type="hidden" name="mid_term['+(index + 1)+'][subject_id]" ' +
                            'value="'+value['subject_id']+'">' +
                            '</div>' +
                            '<div class="col-md-2">' +
                            '<label  class="form-label font-w600">Score</label>' +
                            '<input type="text" name="mid_term['+(index + 1)+'][score]" class="form-control ' +
                            'solid"></div>')
                    })
                }
            })
        })

        //save student mock data
        $("#insert-student-mid-term-form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route('new-student-mid-term-entry')}}',
                method:'POST',
                cache: false,
                data: $("#insert-student-mid-term-form").serialize(),
                success:(Response)=>{
                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#insert-student-mid-term-modal .menu-alert").removeClass('alert-warning')
                        $("#insert-student-mid-term-modal .menu-alert").show().addClass('alert-danger').html
                        (DecodedResults
                            .msg)
                    }else{
                        $("#insert-student-mid-term-modal .menu-alert").removeClass('alert-danger')
                        $("#insert-student-mid-term-modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                $("#insert-student-mid-term-modal").modal('hide')
                                $("#insert-student-mid-term-modal .menu-alert").removeClass('alert-danger')
                                $("#insert-student-mid-term-modal .menu-alert").removeClass('alert-warning')
                                $("#insert-student-mid-term-modal .menu-alert").html('')
                                $("#StudentsMidTermDataTables").DataTable().draw()
                                window.location.reload()
                            }
                        })
                    }
                },
                error:(Response)=>{
                    console.log(Response)
                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#insert-student-mid-term-form').find(".menu-alert").show().addClass('alert-warning').find
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
