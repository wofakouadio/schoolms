 <script>
    $(document).ready(()=> {
        // alert
        $(" .menu-alert").hide()

        $("#StudentAttendanceDataTables").DataTable({
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                },
                lengthMenu: "Display _MENU_ records per page",
                zeroRecords: "Nothing found - sorry",
                info: "Showing page _PAGE_ of _PAGES_",
                infoEmpty: "No records available",
                infoFiltered: ""
            },
            ajax:{
                url:"{{route('get-attendance-sheet')}}",
                data :function (d){
                    d.department_id = $("#get-attendance-sheet-form select[name=department_id]").val();
                    d.level_id = $("#get-attendance-sheet-form select[name=level_id]").val();
                    d.subject_id = $("#get-attendance-sheet-form select[name=subject_id]").val();
                }
            },
            serverSide: true,
            processing: true,
            columns: [
                {data:'name', name:'name'},
                {data:'gender', name:'gender'},
                {data:'residency', name:'residency'},
                {data:'level', name:'level'},
                {data:'check', orderable:false, searchable:false}
            ],
            searching: true,
            paging: true,
            lengthChange: true,
            autoWidth: true,
            aoStateSave: true
            // stateSave: true
        })

        // hide check all if table is empty
        $("#StudentAttendanceDataTables").on("draw.dt", ()=>{
            if($("#StudentAttendanceDataTables tbody tr td .checkStudent").length > 0){
                $("#StudentAttendanceDataTables thead tr th .checkAll").show()
            }else{
                $("#StudentAttendanceDataTables thead tr th .checkAll").hide()
            }
        })

        // display mark attendance button when single checkbox is checked
        $("#StudentAttendanceDataTables tbody").on("change", "input[type=checkbox]", ()=>{
            if($("#StudentAttendanceDataTables tbody input[type=checkbox]:checked").length > 0){
                $("#btn-mark-attendance").show()
            }else{
                $("#btn-mark-attendance").hide()
            }
        })

        // trigger check all when checked
        $("#checkAll").on('click', ()=>{
            if(this.checked){
                $(".checkStudent input[type=checkbox]").each(function(){
                    $(this).checked = true;
                })
            }else{
                $(".checkStudent input[type=checkbox]").each(function(){
                    $(this).checked = false;
                })
            }
        })

        // show/hide mark attendance button when checkAll checkbox is checked or unchecked
        // $("#StudentAttendanceDataTables thead tr th .checkAll input[name=checkAll]").on("click", ()=>{
        //     if(this.checked){
        //         $(".checkStudent input[type=checkbox]").each(function(){
        //             $(this).checked = true;
        //         })
        //         let count = $("#StudentAttendanceDataTables tbody input[type=checkbox]:checked").length
        //         console.log(count)
        //     }
        //
        // })


        //new
        $("#get-attendance-sheet-form").on("submit", (e) => {
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#StudentAttendanceDataTables").DataTable().ajax.reload()
            let subject_id = $("#get-attendance-sheet-form select[name=subject_id]").val()
            $.ajax({
                url:'{{route("get-subject")}}',
                method:'GET',
                cache: false,
                data: {subject_id: subject_id},
                success:(Response)=>{
                    $(".subject").html(Response['subject_name'] + ' Attendance Sheet')
                    $("#mark-attendance-sheet").find('input[name=subject_id]').val($("#get-attendance-sheet-form select[name=subject_id]").val())
                    $("#mark-attendance-sheet").find('input[name=department_id]').val($("#get-attendance-sheet-form select[name=department_id]").val())
                    $("#mark-attendance-sheet").find('input[name=level_id]').val($("#get-attendance-sheet-form select[name=level_id]").val())
                }
            })
        })

        //mark student attendance sheet
        $("#mark-attendance-sheet").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            let students = [];
            $("#StudentAttendanceDataTables tbody input[type=checkbox]:checked").each(function(){
                // students.push({sutdent_id : $(this).val()})
                students.push($(this).val())
            })
            if(students.length > 0){
                let subject_id = $("#mark-attendance-sheet").find('input[name=subject_id]').val()
                let department_id = $("#mark-attendance-sheet").find('input[name=department_id]').val()
                let level_id = $("#mark-attendance-sheet").find('input[name=level_id]').val()

                $.ajax({
                    url:"{{route('mark-student-attendance')}}",
                    method:'POST',
                    cache:false,
                    data:{
                        students: students,
                        subject_id: subject_id,
                        department_id: department_id,
                        level_id: level_id
                    },
                    success:(Response)=>{
                        let StringResults = JSON.stringify(Response)
                        let DecodedResults = JSON.parse(StringResults)
                        if(DecodedResults.status === 201){
                            $("#mark-attendance-sheet .menu-alert").removeClass('alert-warning')
                            $("#mark-attendance-sheet .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                        }else{
                            $("#mark-attendance-sheet .menu-alert").removeClass('alert-danger')
                            $("#mark-attendance-sheet .menu-alert").removeClass('alert-warning')

                            Swal.fire({
                                title: 'Notification',
                                html: DecodedResults.msg,
                                type: 'success',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonText: 'Close',
                            }).then((result) => {
                                if (result) {
                                    // window.location.reload()
                                    // $("#new-branch-modal").modal('hide')
                                    // $("#new-branch-modal .menu-alert").removeClass('alert-danger')
                                    // $("#new-branch-modal .menu-alert").removeClass('alert-warning')
                                    // $("#new-branch-modal .menu-alert").html('')
                                    $("#StudentAttendanceDataTables").DataTable().ajax.draw();
                                }
                            })
                        }
                    },
                    error:(Response)=>{

                        $.each( Response.responseJSON.errors, function( key, value ) {
                            $('#mark-attendance-sheet').find(".menu-alert").show().addClass('alert-warning').find("ul")
                                .append
                                ('<li>'+value+'</li>');
                        });
                    }
                    // success:(Response)=>{
                    //     console.log(Response)
                    // },
                    // error:(Response)=>{
                    //     console.log(Response)
                    // }
                })
            }
            // console.log(student_id)
        })

    })
</script>
