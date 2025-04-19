<script>

    function filterHouse(){
        $("#HousesDataTables").DataTable().ajax.reload();
    }

    $(document).ready(()=>{
        // $.noConflict();
        $("#HousesDataTables").DataTable({
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                },
            },
            searching: false,
            paging: true,
            lengthChange: true,
            autoWidth: false,
            stateSave: true,
            scrollCollapse: true,
            processing: true,
            serverSide: true,
            ajax:{
                url:"{{route('housesTables')}}",
                dataType: 'json',
                type:'get',
                data:{
                    _token: "{{ csrf_token() }}",
                    house_name: function(){
                        return $("#house_name").val()
                    },
                    branch: function(){
                        return $("#branch").val()
                    },
                    status: function(){
                        return $("#status").val()
                    },
                    created_at: function(){
                        return $("#created_at").val()
                    }
                }
            },
            columns: [
                {data: null, render: function(data, type, row, meta){
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                {data: 'name', name: 'name'},
                {data: 'branch', name: 'branch'},
                {data: 'is_active', name: 'is_active'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            dom: "Bfrtip",
            buttons:[{
                extend: 'collection',
                text: 'Export',
                buttons: [{
                        text: 'Export Excel',
                        action: function(e, dt, node, config) {
                            // Get all current filter values
                            var filters = {
                                house_name: $('#house_name').val(),
                                branch: $('#branch').val(),
                                status: $('#status').val(),
                                created_at: $('#created_at').val()
                            };
                            // Build URL with filter parameters
                            var url =
                                "{{ route('housesTables_export') }}?" + $
                                .param(filters);
                            window.location = url;
                        }
                    },

                ]
            }]
        })
    })
</script>
