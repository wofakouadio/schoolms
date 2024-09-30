<script>
    $(document).ready(()=>{

        $(".menu-alert").hide()

        // implementing add more functionality
        let i = 0;

        $("#addMoreBtn").on('click', (e)=>{
            e.preventDefault()
            i++
            let html = '<div class="row AddMoreFields"><div class="col-5 mb-4"><label  class="form-label font-w600">Description<span class="text-danger scale5 ms-2">*</span></label><input type="text" name="addMore['+i+'][bill_description]" value="{{old('bill_description')}}" class="form-control solid"></div><div class="col-5 mb-4"><label  class="form-label font-w600">Amount<span class="text-danger scale5 ms-2">*</span></label><input type="text" name="addMore['+i+'][bill_amount]" value="{{old('bill_amount')}}" class="form-control solid"></div><div class="col-2"><button type="button" class="btn btn-xs btn-danger" id="removeBtn">Remove</button></div></div>'

            $("#new-bill-modal .modal-body").append(html)
        })

        $(document).on('click', '#removeBtn', function(){
            $(this).parents('.AddMoreFields').remove();
        });

        // create new bill
        $("#new-bill-form").on('submit', (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let form_data = $("#new-bill-form").serialize()
            $.ajax({
                url:"{{route('new-bill')}}",
                method:'POST',
                cache:false,
                data: form_data,
                success:(Response)=>{

                    // console.log(Response)

                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#new-bill-modal .menu-alert").removeClass('alert-warning')
                        $("#new-bill-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#new-bill-modal .menu-alert").removeClass('alert-danger')
                        $("#new-bill-modal .menu-alert").removeClass('alert-warning')

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
                                $("#new-bill-modal").modal('hide')
                                $("#new-bill-modal .menu-alert").removeClass('alert-danger')
                                $("#new-bill-modal .menu-alert").removeClass('alert-warning')
                                $("#new-bill-modal .menu-alert").html('')
                                $("#new-bill-form")[0].reset()
                                $("#BillsDataTables").DataTable().draw();
                            }
                        })
                    }
                },
                error:(Response)=>{
                    console.log(Response)

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#new-bill-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

        // reset modal form after modal close
        $(".modal-footer button[type=button]").on("click", (e)=>{
            e.preventDefault()
            $(".Fields").html('')
        })

        //edit bill modal
        $("#edit-bill-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let modal = $("#edit-bill-modal")
            let bill_id = str.data('id')
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('edit-bill')}}",
                method:'GET',
                cache:false,
                data: {bill_id:bill_id},
                success:(Response)=>{
                    let arrayLength = Response['billsbreakdown'].length

                    modal.find("input[name=bill_id]").val(bill_id)
                    modal.find("input[name=amount]").val(Response['bill_amount'])
                    modal.find("select[name=term]").val(Response['term_id'])
                    modal.find("select[name=level]").val(Response['level_id'])
                    modal.find("input[name=branch_id]").val(Response['branch_id'])
                    // modal.find("input[name=academic_year]").val(Response['academic_year'])
                    modal.find("select[name=bill_is_active]").val(Response['is_active'])

                    $("#edit-bill-modal .modal-body .Fields").append('<button type="button" class="btn btn-xs ' +
                        'btn-primary" id="EditaddMoreBtn">Add More Fields</button>');

                    i = Response['billsbreakdown'].length - 1

                    $("#EditaddMoreBtn").on('click', (e)=>{
                        e.preventDefault()
                        i++
                        let html = '<div class="row AddMoreFields">' +
                            '<div class="col-5 mb-4">' +
                            '<label  class="form-label ' +
                            'font-w600">Description<span class="text-danger scale5 ms-2">*</span></label>' +
                            '<input type="text" ' +
                            'name="addMore['+i+'][bill_description]" value="{{old('bill_description')}}" ' +'" ' +
                            'class="form-control " '+
                            'solid"><input type="hidden" name="addMore['+i+'][billbreakdown_id]"></div><div ' +
                            'class="col-5 ' +
                            'mb-4"><label  ' +
                            'class="form-label' +
                            ' ' +
                            'font-w600">Amount<span ' +
                            'class="text-danger scale5 ms-2">*</span></label><input type="text" ' +
                            'name="addMore['+i+'][bill_amount]" value="{{old('bill_amount')}}" class="form-control solid"></div><div class="col-2"><button type="button" class="btn "' +
                            '"btn-xs btn-danger" id="removeBtn">Remove</button></div></div>'
                        $("#edit-bill-modal .modal-body .Fields").append(html)
                    })

                    for (let i = 0; i <= Response['billsbreakdown'].length; i++ ){
                        let html ='<div class="row AddMoreFields">' +
                            '<div class="col-5 mb-4">' +
                            '<label  class="form-label ' +
                            'font-w600">Description<span class="text-danger scale5 ms-2">*</span></label>' +
                            '<input type="text" ' +
                            'name="addMore['+i+'][bill_description]" value="'+Response['billsbreakdown'][i]
                                .item+'" ' +
                            'class="form-control " '+
                            '"solid"><input type="hidden" name="addMore['+i+'][billbreakdown_id]" ' +
                            'value="'+Response['billsbreakdown'][i]
                                .id+'"></div><div class="col-5 ' +
                            'mb-4"><label  ' +
                            'class="form-label ' +
                            'font-w600">Amount<span ' +
                            'class="text-danger scale5 ms-2">*</span></label><input type="text" ' +
                            'name="addMore['+i+'][bill_amount]" value="'+Response['billsbreakdown'][i]
                                .amount+'" class="form-control ' +
                            'solid"></div><div class="col-2"><button type="button" class="btn "' +
                            '"btn-xs btn-danger" id="removeBtn">Remove</button></div></div>'
                        $("#edit-bill-modal .modal-body .Fields").append(html)
                    }

                    $(document).on('click', '#removeBtn', function(){
                        $(this).parents('.AddMoreFields').remove();
                    });

                }
            })
        })

        //update bill
        $("#update-bill-form").on('submit', (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let form_data = $("#update-bill-form").serialize()
            $.ajax({
                url:"{{route('update-bill')}}",
                method:'POST',
                cache:false,
                data: form_data,
                success:(Response)=>{

                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#edit-bill-modal .menu-alert").removeClass('alert-warning')
                        $("#edit-bill-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#edit-bill-modal .menu-alert").removeClass('alert-danger')
                        $("#edit-bill-modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                window.location.reload()
                                $("#edit-bill-modal").modal('hide')
                                $("#update-bill-form")[0].reset()
                                $("#BillsDataTables").DataTable().draw();
                                $("#edit-bill-modal .menu-alert").removeClass('alert-danger')
                                $("#edit-bill-modal .menu-alert").removeClass('alert-warning')
                                $("#edit-bill-modal .menu-alert").html('')
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#edit-bill-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })

        //delete bill modal
        $("#delete-bill-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let modal = $("#delete-bill-modal")
            let bill_id = str.data('id')
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('edit-bill')}}",
                method:'GET',
                cache:false,
                data: {bill_id:bill_id},
                success:(Response)=>{

                    modal.find("input[name=bill_id]").val(bill_id)
                    modal.find(".delete-notice").html("Are you sure of deleting this Bill?")

                }
            })
        })

        //delete bill
        $("#delete-bill-form").on('submit', (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let form_data = $("#delete-bill-form").serialize()
            $.ajax({
                url:"{{route('delete-bill')}}",
                method:'POST',
                cache:false,
                data: form_data,
                success:(Response)=>{

                    let StringResults = JSON.stringify(Response)
                    let DecodedResults = JSON.parse(StringResults)
                    if(DecodedResults.status === 201){
                        $("#delete-bill-modal .menu-alert").removeClass('alert-warning')
                        $("#delete-bill-modal .menu-alert").show().addClass('alert-danger').html(DecodedResults.msg)
                    }else{
                        $("#delete-bill-modal .menu-alert").removeClass('alert-danger')
                        $("#delete-bill-modal .menu-alert").removeClass('alert-warning')

                        Swal.fire({
                            title: 'Notification',
                            html: DecodedResults.msg,
                            type: 'success',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Close',
                        }).then((result) => {
                            if (result) {
                                window.location.reload()
                                $("#delete-bill-modal").modal('hide')
                                $("#BillsDataTables").DataTable().draw();
                                $("#delete-bill-modal .menu-alert").removeClass('alert-danger')
                                $("#delete-bill-modal .menu-alert").removeClass('alert-warning')
                                $("#delete-bill-modal .menu-alert").html('')
                            }
                        })
                    }
                },
                error:(Response)=>{

                    $.each( Response.responseJSON.errors, function( key, value ) {
                        $('#delete-bill-modal').find(".menu-alert").show().addClass('alert-warning').find("ul")
                            .append
                            ('<li>'+value+'</li>');
                    });
                }
            })
        })
    })
</script>
