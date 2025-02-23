<script>

    $(document).ready(()=>{
        $(".menu-alert").hide()
        $(".student-fee-collection-holder").hide()

        $("#search_student_form").on("submit", (e)=>{
            e.preventDefault()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let form_data = $("#search_student_form").serialize()
            $.ajax({
                url:"{{ route('admin_get_student_transactions') }}",
                method:'POST',
                cache:false,
                data: form_data,
                success:(Response)=>{
                    $(".student-fee-collection-holder").show()
                    // console.log(Response.studentData.student_id)
                    $(".student-fee-collection-holder").find("#transaction_form input[name=studentId]").val(Response.studentData.student_id)
                    $(".student-fee-collection-holder").find("#transaction_form input[name=student_name]").val(Response.studentData.student_firstname + " " + Response.studentData.student_othername + " " + Response.studentData.student_lastname)
                    $(".student-fee-collection-holder").find("#transaction_form input[name=student_gender]").val(Response.studentData.student_gender)
                    $(".student-fee-collection-holder").find("#transaction_form input[name=level]").val(Response.studentData.level.level_name)
                    $(".student-fee-collection-holder").find("#transaction_form input[name=house]").val(Response.studentData.house.house_name)
                    $(".student-fee-collection-holder").find("#transaction_form input[name=residency_type]").val(Response.studentData.student_residency_type)

                    if($.isEmptyObject(Response.transactions)){
                        $(".student-fee-collection-holder").find("#items").hide()
                    }else{
                        $(".student-fee-collection-holder").find("#items").html('').show()
                        $.each(Response.transactions, (key, index) => {
                            let html = '<div class="row">'
                                                    +'<div class="col-3">'
                                                        +'<label>Invoice Number</label>'
                                                        +'<input type="text" name="transaction_allocations" value="'+index.invoice_id+'" readonly class="form-control solid mb-4">'
                                                    +'</div>'
                                                    +'<div class="col-3">'
                                                        +'<label>Item</label>'
                                                        +'<input type="text" name="transaction_allocations" value="'+index.description+'" readonly class="form-control solid mb-4">'
                                                    +'</div>'
                                                    +'<div class="col-3">'
                                                        +'<label>Amount Due</label>'
                                                        +'<div class="input-group">'
                                                            +'<span class="input-group-text">'+Response.currency_symbol+'</span>'
                                                            +'<input type="text" name="transaction_allocations" value="'+index.amount_due+'" readonly class="form-control solid">'
                                                        +'</div>'
                                                    +'</div>'
                                                    +'<div class="col-3">'
                                                        +'<label class="text-center">Action</label><br/>'
                                                        +'<a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit-transaction-data-modal" data-transaction_id="'+index.id+'" data-invoice_number="'+index.invoice_id+'" data-item_name="'+index.description+'" data-amount_due="'+index.amount_due+'" data-student_uuid="'+Response.studentData.id+'" data-currency_symbol="'+Response.currency_symbol+'">Edit</a> '
                                                        +'<a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#delete-transaction-data-modal" data-transaction_id="'+index.id+'" data-invoice_number="'+index.invoice_id+'" data-item_name="'+index.description+'" data-amount_due="'+index.amount_due+'" data-student_uuid="'+Response.studentData.id+'" data-currency_symbol="'+Response.currency_symbol+'">Delete</a>'
                                                    +'</div>'
                                                +'</div>'
                            $("#items").append(html)
                        })
                    }
                },
                error:(Response)=>{
                // console.log(Response)

                $.each( Response.responseJSON.errors, function( key, value ) {
                    $(".menu-alert").show().addClass('alert-warning').find("ul")
                        .append
                        ('<li>'+value+'</li>');
                });
                }

            })
        })


        // edit transaction data
        $("#edit-transaction-data-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let modal = $("#edit-transaction-data-modal")
            let transaction_id = str.data("transaction_id")
            let student_uuid = str.data("student_uuid")
            let invoice_id = str.data("invoice_number")
            let item = str.data("item_name")
            let amount_due = str.data("amount_due")
            let currency_symbol = str.data("currency_symbol")

            modal.find("input[name=invoice_id]").val(invoice_id)
            modal.find("input[name=transaction_id]").val(transaction_id)
            modal.find("input[name=student_uuid]").val(student_uuid)
            modal.find("input[name=item]").val(item)
            modal.find("input[name=amount_due]").val(amount_due)
            // modal.find("span.input-group-text").html(currency_symbol)
        })

        // delete transaction data
        $("#delete-transaction-data-modal").on("show.bs.modal", (event)=>{
            let str = $(event.relatedTarget)
            let modal = $("#delete-transaction-data-modal")
            let transaction_id = str.data("transaction_id")
            let student_uuid = str.data("student_uuid")
            let invoice_id = str.data("invoice_number")
            let item = str.data("item_name")
            let amount_due = str.data("amount_due")
            let currency_symbol = str.data("currency_symbol")

            modal.find("input[name=transaction_id]").val(transaction_id)
            modal.find("input[name=student_uuid]").val(student_uuid)
            modal.find(".delete-notice").html("Are you sure of deleting this transaction with Invoice Number " + invoice_id + ", " + item + " Item, Amount Due of " +currency_symbol+ " "+amount_due+ " ?")
        })



    })

</script>
