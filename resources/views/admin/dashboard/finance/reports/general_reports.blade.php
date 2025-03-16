    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $(document).ready(function() {
            // alert({!! json_encode(url('/')) !!})
            $.noConflict();
            var table = $('.general-report').DataTable({
                ajax: {
                    url: "{{ route('admin_finance_general_report') }}",
                    data: function(d) {
                        d.diet = $('#diet').val();
                        d.student_id = $('#student_id').val();
                        // d.category = $('#category').val();
                        d.level = $('#level').val();
                    }
                },
                serverSide: true,
                processing: true,
                columns: [{
                        "className": 'details-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": ''
                    },
                    {
                        data: 'student_id',
                        name: 'student_id'
                    },
                    {
                        data: 'invoice_id',
                        name: 'invoice_id'
                    },
                    {
                        data: 'first_name',
                        name: 'first_name'
                    },
                    {
                        data: 'surname',
                        name: 'surname'
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
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                scrollY: 460,
                scrollCollapse: true,
                stateSave: true,
                "pagingType": "full_numbers"
            });

            $('.general-report tbody').on('click', 'td.details-control', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });

                $('#filters-form').on('submit', function(e) {
                e.preventDefault();
                table.draw();
                // $('#example').DataTable().ajax.reload();
            });

        })


    </script>
