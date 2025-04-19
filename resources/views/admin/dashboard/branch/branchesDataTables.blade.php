<script>
    function filterBranch() {
        $("#BranchesDataTables").DataTable().ajax.reload()
    }

    $(document).ready(() => {
        // $.noConflict();
        $("#BranchesDataTables").DataTable({
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
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('branches_datatables_list') }}",
                dataType: "json",
                type: "get",
                data: {
                    _token: "{{ csrf_token() }}",
                    branch_is_active: function() {
                        return $("#branch_is_active").val()
                    },
                    branch_name: function() {
                        return $("#branch_name").val()
                    },
                    branch_contact: function() {
                        return $("#branch_contact").val()
                    },
                    branch_location: function() {
                        return $("#branch_location").val()
                    },
                    branch_email: function() {
                        return $("#branch_email").val()
                    },
                    created_at: function() {
                        return $("#created_at").val()
                    }
                }
            },
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'contact',
                    name: 'contact'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'location',
                    name: 'location'
                },
                {
                    data: 'is_active',
                    name: 'is_active'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            searching: false,
            paging: true,
            lengthChange: true,
            autoWidth: false,
            stateSave: true,
            scrollCollapse: true,
            dom: "Bfrtip",
            buttons: [{
                extend: 'collection',
                text: 'Export',
                buttons: [{
                        text: 'Export Excel',
                        action: function(e, dt, node, config) {
                            // Get all current filter values
                            var filters = {
                                branch_is_active: $("#branch_is_active").val(),
                                branch_name: $("#branch_name").val(),
                                branch_contact: $("#branch_contact").val(),
                                branch_location: $("#branch_location").val(),
                                branch_email: $("#branch_email").val(),
                                created_at: $("#created_at").val()
                            };
                            // Build URL with filter parameters
                            var url =
                                "{{ route('export_branches_datatables_list') }}?" + $
                                .param(filters);
                            window.location = url;
                        }
                    },

                ]
            }]
        })
    })
</script>
