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

        // sync all values from feeding fee collection imput form
        $("#btn_sync").on("click", (e)=>{
            e.preventDefault()

            let arv = (0);
            let np = 0
            let ndp = 0
            let nc = 0
            let ac = 0
            let ap = 0
            let ff = 0
            
            np = $("#feeding_fee_new_collection_form").find('input[name=number_of_presents]').val()
            ndp = $("#feeding_fee_new_collection_form").find('input[name=number_of_do_not_pay]').val()
            nc = $("#feeding_fee_new_collection_form").find('input[name=number_of_credits]').val()
            ac = $("#feeding_fee_new_collection_form").find('input[name=arrears_clearance]').val()
            ap = $("#feeding_fee_new_collection_form").find('input[name=advance_payment]').val()
            ff = $("#feeding_fee_new_collection_form").find('input[name=feeding_fee]').val()

            let a = parseFloat(np) - parseFloat(ndp) - parseFloat(nc)
            let b = parseFloat(ac) + parseFloat(ap)

            arv = (parseFloat(a) + parseFloat(b)) * parseFloat(ff)

            $("#feeding_fee_new_collection_form").find('input[name=amount_realized]').val(arv)

        })


    })

</script>
