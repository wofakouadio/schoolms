<script>
    $(document).ready(()=>{
        // $.noConflict();
        $("#feeding_fee_table").DataTable({
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                },
                lengthMenu: "Display _MENU_",
                zeroRecords: "Nothing found - sorry",
                info: "Showing page _PAGE_ of _PAGES_",
                infoEmpty: "No records available",
                infoFiltered: ""
            },
            // processing: true,
            // serverSide: true,
            // ajax:{
            //     url:"{{route('billsTables')}}",
            // },
            // columns: [
            //     {data: 'academic_year', name: 'academic_year'},
            //     {data: 'term', name: 'term'},
            //     {data: 'level', name:'level'},
            //     {data: 'amount', name: 'amount'},
            //     {data: 'last_updated', name:'last_updated'},
            //     {data: 'is_active', name: 'is_active'},
            //     {data: 'action', name: 'action'},
            // ],
            searching: true,
            paging: true,
            lengthChange: true,
            autoWidth: true,
            aoStateSave: true
            // stateSave: true
        })

        $("#feeding_fee_collection_table").DataTable({
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                },
                lengthMenu: "Display _MENU_",
                zeroRecords: "Nothing found - sorry",
                info: "Showing page _PAGE_ of _PAGES_",
                infoEmpty: "No records available",
                infoFiltered: ""
            },
            // processing: true,
            // serverSide: true,
            // ajax:{
            //     url:"{{route('billsTables')}}",
            // },
            // columns: [
            //     {data: 'academic_year', name: 'academic_year'},
            //     {data: 'term', name: 'term'},
            //     {data: 'level', name:'level'},
            //     {data: 'amount', name: 'amount'},
            //     {data: 'last_updated', name:'last_updated'},
            //     {data: 'is_active', name: 'is_active'},
            //     {data: 'action', name: 'action'},
            // ],
            searching: true,
            paging: true,
            lengthChange: true,
            autoWidth: true,
            aoStateSave: true
            // stateSave: true
        })
    })
</script>
