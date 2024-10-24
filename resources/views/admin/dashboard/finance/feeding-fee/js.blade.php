<script>

    $(document).ready(()=>{
        $(".menu-alert").hide()

        $("#edit_feeding_fee_setup").on('show.bs.modal', (event)=>{
            let str = $(event.relatedTarget)
            let id = str.data('id')
            let modal = $("#edit_feeding_fee_setup")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{ route('admin_finance_feeding_fee_data') }}",
                method:'GET',
                cache: false,
                data:{id:id},
                success: (Response)=>{
                    modal.find('input[name=academic_year]').val(Response['school_academic_year']['academic_year_start']+'/'+Response['school_academic_year']['academic_year_end'])
                    modal.find('#currency').text(Response['school_currency']['symbol'])
                    modal.find('input[name=amount]').val(Response['fee'])
                    modal.find('input[name=feeding_fee_id]').val(Response['id'])
                    modal.find('select[name=is_active]').val(Response['is_active'])
                }
            })
        })


        $("#delete_feeding_fee_setup").on('show.bs.modal', (event)=>{
            let str = $(event.relatedTarget)
            let id = str.data('id')
            let modal = $("#delete_feeding_fee_setup")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{ route('admin_finance_feeding_fee_data') }}",
                method:'GET',
                cache: false,
                data:{id:id},
                success: (Response)=>{
                    modal.find('input[name=feeding_fee_id]').val(Response['id'])
                }
            })
        })


    })

</script>
