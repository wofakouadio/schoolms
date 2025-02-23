<script>

    $(document).ready(()=>{
        // method to get levels by department id
        const LevelsByDepartmentId = (department_id) =>{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route("get_department_levels") }}',
                method:'GET',
                cache:false,
                data:{department_id:department_id},
                success:(Response)=>{
                    let options = '<option value="">Select Level</option>';
                    if(Array.isArray(Response)) {
                        Response.forEach(level => {
                            options += `<option value="${level.id}">${level.level_name}</option>`;
                        });
                    } else {
                        Object.values(Response).forEach(level => {
                            options += `<option value="${level.id}">${level.level_name}</option>`;
                        });
                    }
                    $("select[name=level_id]").html(options);
                    $(".level_id").html(options)
                }
            })
        }

        // method to get students by level id
        const StudentsByLevelId = (level_id) =>{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route("getStudentsByLevelId") }}',
                method:'GET',
                cache:false,
                data:{level_id:level_id},
                success:(Response)=>{
                    // console.log(Response)
                    let options = '<option value="">Select Student</option>';
                    Response.forEach(student => {
                        options += `<option value="${student.id}">${student.student_id} ${student.student_firstname} ${student.student_othername} ${student.student_lastname}</option>`;
                    });
                    $("select[name=student_id]").html(options);
                    $("select[name=student_uuid]").html(options);
                    $(".student_uuid").html(options)
                }
            })
        }
        // get levels assigned to department id
        $("select[name=department_id]").on("change", ()=>{
            let department_id = $("select[name=department_id]").val() ?? $(".department_id").val()
            // console.log(department_id)
            LevelsByDepartmentId(department_id);
        })

        // $("select[name=department_id]").on("change", ()=>{
        //     let department_id = $("select[name=department_id]").val()
        //     // console.log(department_id)
        //     LevelsByDepartmentId(department_id);
        // })

        // get students list based on level id
        $("select[name=level_id]").on("change", ()=>{
            let level_id = $("select[name=level_id]").val()
            StudentsByLevelId(level_id);
        })

    })

</script>
