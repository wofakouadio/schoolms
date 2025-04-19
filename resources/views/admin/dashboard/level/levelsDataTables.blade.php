<script>

    function filterLevel(){
        $("#LevelsDataTables").DataTable().ajax.reload()
    }

    $(document).ready(()=>{
        // $.noConflict();
        $("#LevelsDataTables").DataTable({
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                },
                // lengthMenu: "Display _MENU_ records per page",
                // zeroRecords: "Nothing found - sorry",
                // info: "Showing page _PAGE_ of _PAGES_",
                // infoEmpty: "No records available",
                // infoFiltered: ""
                pagingType: "full_numbers"
            },
            processing: true,
            serverSide: true,
            ajax:{
                url:"{{route('levelsTables_list')}}",
                dataType: "json",
                type: "get",
                data:{
                    _token: "{{ csrf_token() }}",
                    level_is_active: function(){
                        return $("#level_is_active").val()
                    },
                    level_name: function(){
                        return $("#level_name").val()
                    },
                    branch: function(){
                        return $("#branch").val()
                    },
                    created_at: function(){
                        return $("#created_at").val()
                    }
                }
            },
            columns: [
                {data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }},
                {data: 'name', name: 'name'},
                {data: 'branch', name: 'branch'},
                {data: 'is_active', name: 'is_active'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action'},
            ],
            searching: false,
            paging: true,
            lengthChange: true,
            autoWidth: false,
            stateSave: true,
            dom: "Bfrtip",
            buttons: [{
                extend: 'collection',
                text: 'Export',
                buttons: [{
                        text: 'Export Excel',
                        action: function(e, dt, node, config) {
                            // Get all current filter values
                            var filters = {
                                level_is_active: $("#level_is_active").val(),
                                level_name: $("#level_name").val(),
                                branch: $("#branch").val(),
                                created_at: $("#created_at").val()
                            };
                            // Build URL with filter parameters
                            var url =
                                "{{ route('export_levelsTables_list') }}?" + $
                                .param(filters);
                            window.location = url;
                        }
                    },

                ]
            }]
            // stateSave: true
        })
    })
</script>
