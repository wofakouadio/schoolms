<script>
    $(document).ready(()=>{
        // alert
        $(" .menu-alert").hide()

        //show edit teacher modal with data
        $("#edit-teacher-user-permission-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget);
            let teacher_id = str.data('id')

            let modal = $("#edit-teacher-user-permission-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('edit-teacher-user')}}",
                method:'GET',
                cache:false,
                data: {teacher_user_id:teacher_id},
                success:(Response)=>{
                    // console.log(Response)
                    modal.find("input[name=teacher_user_permission_id]").val(teacher_id)
                    modal.find("select[name=teacher_user]").val(Response['user_id'])
                    modal.find("select[name=teacher_user_status]").val(Response['status'])


                }
            })
        })

        //show delete teacher modal with data
        $("#delete-teacher-user-permission-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget);
            let teacher_id = str.data('id')

            let modal = $("#delete-teacher-user-permission-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{route('edit-teacher-user')}}",
                method:'GET',
                cache:false,
                data: {teacher_user_id:teacher_id},
                success:(Response)=>{
                    // console.log(Response)
                    modal.find("input[name=teacher_user_permission_id]").val(teacher_id)
                    modal.find(".delete-notice").html("Are you sure of deleting "+Response['teacher']['teacher_firstname']+" "+Response['teacher']['teacher_lastname']+" account permission ?")
                }
            })
        })


    })
</script>
