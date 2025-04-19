    {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> --}}
    <script>
        function filterTransactionTable() {
            $('#transaction_report_table').DataTable().ajax.reload()
        }


        $(document).ready(function() {

            // alert({!! json_encode(url('/')) !!})
            // $.noConflict();

            // $("#btn_search_filter").on("click", (e)=>{

            // })

            let table = $('#transaction_report_table').DataTable({
                ajax: {
                    url: "{{ route('admin_finance_general_report') }}",
                    dataType: 'json',
                    type: 'get',
                    data: {
                        _token: "{{ csrf_token() }}",
                        invoice_id: function() {
                            return $("#invoice_id").val()
                        },
                        level: function() {
                            return $("#level").val()
                        },
                        term: function() {
                            return $("#term").val()
                        },
                        academic_year: function() {
                            return $("#academic_year").val()
                        },
                        transaction_type: function() {
                            return $("#transaction_type").val()
                        },
                        payment_status: function() {
                            return $("#payment_status").val()
                        },
                        reference: function() {
                            return $("#reference").val()
                        },
                        description: function() {
                            return $("#description").val()
                        },
                        student_id: function() {
                            return $("#student_id").val()
                        },
                        student_name: function() {
                            return $("#student_name").val()
                        },
                        paid_at_from: function() {
                            return $("#paid_at_from").val()
                        },
                        paid_at_to: function() {
                            return $("#paid_at_to").val()
                        },
                        created_at_from: function() {
                            return $("#created_at_from").val()
                        },
                        created_at_to: function() {
                            return $("#created_at_to").val()
                        }
                    },
                },
                serverSide: true,
                processing: true,
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            // Add row numbering
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'invoice_id',
                        name: 'invoice_id'
                    },
                    {
                        data: 'student_id',
                        name: 'student_id'
                    },
                    {
                        data: 'student_name',
                        name: 'student_name'
                    },
                    {
                        data: 'level',
                        name: 'level'
                    },
                    {
                        data: 'term',
                        name: 'term'
                    },
                    {
                        data: 'academic_year',
                        name: 'academic_year'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'amount_due',
                        name: 'amount_due'
                    },
                    {
                        data: 'amount_paid',
                        name: 'amount_paid'
                    },
                    {
                        data: 'balance',
                        name: 'balance'
                    },
                    {
                        data: 'transaction_type',
                        name: 'transaction_type'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'paid_at',
                        name: 'paid_at'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'reference',
                        name: 'reference'
                    }
                ],
                scrollY: 700,
                scrollCollapse: true,
                stateSave: true,
                language: {
                    paginate: {
                        next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                        previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                    },
                    // lengthMenu: "Display _MENU_ records per page",
                    // zeroRecords: "Nothing found - sorry",
                    // info: "Showing page _PAGE_ of _PAGES_",
                    // infoEmpty: "No records available",
                    // infoFiltered: "",
                    pagingType: "full_numbers"
                },
                // dom: "lBfrtip",
                dom: "Bfrtip",
                buttons: [{
                    extend: 'collection',
                    text: 'Export',
                    buttons: [{
                            text: 'Export Excel',
                            action: function(e, dt, node, config) {
                                // Get all current filter values
                                var filters = {
                                    invoice_id: $('#invoice_id').val(),
                                    level: $('#level').val(),
                                    term: $('#term').val(),
                                    academic_year: $('#academic_year').val(),
                                    transaction_type: $('#transaction_type').val(),
                                    payment_status: $('#payment_status').val(),
                                    reference: $('#reference').val(),
                                    description: $('#description').val(),
                                    student_id: $('#student_id').val(),
                                    student_name: $('#student_name').val(),
                                    paid_at_from: $('#paid_at_from').val(),
                                    paid_at_to: $('#paid_at_to').val(),
                                    created_at_from: $('#created_at_from').val(),
                                    created_at_to: $('#created_at_to').val()
                                };

                                // Build URL with filter parameters
                                var url =
                                    "{{ route('admin_finance_export_transactions') }}?" + $
                                    .param(filters);
                                window.location = url;
                            }
                        },

                    ]
                }]

            });

            // $('.general-report tbody').on('click', 'td.details-control', function() {
            //     var tr = $(this).closest('tr');
            //     var row = table.row(tr);

            //     if (row.child.isShown()) {
            //         // This row is already open - close it
            //         row.child.hide();
            //         tr.removeClass('shown');
            //     } else {
            //         // Open this row
            //         row.child(format(row.data())).show();
            //         tr.addClass('shown');
            //     }
            // });

            // $('#filters-form').on('submit', function(e) {
            //     e.preventDefault();
            //     table.draw();
            //     // $('#example').DataTable().ajax.reload();
            // });

        })
    </script>
