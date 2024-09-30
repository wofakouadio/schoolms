<script>
    $(document).ready(()=>{

        //edit
        $("#edit-academic-year-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let academic_year_id = str.data('id')
            let modal = $("#edit-academic-year-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route("edit_admin_academic_year")}}',
                method:'GET',
                cache:false,
                data:{academic_year_id : academic_year_id},
                success:(Response)=>{
                    modal.find('input[name=academic_year_id]').val(academic_year_id)
                    modal.find('select[name=academic_year_start]').val(Response['academic_year_start'])
                    modal.find('select[name=academic_year_end]').val(Response['academic_year_end'])
                }
            })
        })

        //edit status
        $("#edit-academic-year-status-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let academic_year_id = str.data('id')
            let modal = $("#edit-academic-year-status-modal")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{route("edit_admin_academic_year")}}',
                method:'GET',
                cache:false,
                data:{academic_year_id : academic_year_id},
                success:(Response)=>{
                    modal.find('input[name=academic_year_id]').val(academic_year_id)
                    modal.find('select[name=academic_status]').val(Response['is_active'])
                }
            })
        })

        //delete
        $("#delete-academic-year-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let academic_year_id = str.data('id')
            $("#delete-academic-year-modal").find('input[name=academic_year_id]').val(academic_year_id)
        })
    })
</script>
