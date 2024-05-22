<script>
    $(document).ready(()=>{

        $("#edit-cas-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let modal = $("#edit-cas-modal")
            let id = str.data('id')
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route('edit_class_assessment_size')}}',
                method: 'GET',
                cache:false,
                data:{id:id},
                success:(Response)=>{
                    modal.find('input[name=id]').val(id)
                    modal.find('select[name=term]').val(Response['term_id'])
                    modal.find('input[name=assessment_size]').val(Response['class_assessment_size'])
                    if(Response['add_mid_term'] == 'on'){
                        modal.find('input[name=add_mid_term]').prop('checked', true)
                    }else{
                        modal.find('input[name=add_mid_term]').prop('checked', false)
                    }
                }
            })
        })
        $("#edit-cas-status-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let modal = $("#edit-cas-status-modal")
            let id = str.data('id')
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route('edit_class_assessment_size')}}',
                method: 'GET',
                cache:false,
                data:{id:id},
                success:(Response)=>{
                    modal.find('input[name=id]').val(id)
                    modal.find('select[name=is_active]').val(Response['is_active'])
                }
            })
        })
        $("#delete-cas-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let modal = $("#delete-cas-modal")
            let id = str.data('id')
            modal.find('input[name=id]').val(id)
        })

    })
</script>
