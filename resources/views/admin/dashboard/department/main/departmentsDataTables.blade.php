<script>
    $(document).ready(()=>{
        // $.noConflict();
        $("#DepartmentsDataTables").DataTable({
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                },
                lengthMenu: "Display _MENU_ records per page",
                zeroRecords: "Nothing found - sorry",
                info: "Showing page _PAGE_ of _PAGES_",
                infoEmpty: "No records available",
                infoFiltered: ""
            },
            processing: true,
            serverSide: true,
            ajax:{
                url:"{{route('departmentsTables')}}",
            },
            columns: [
                {data: 'name', name: 'name'},
                {data: 'branch', name: 'branch'},
                {data: 'is_active', name: 'is_active'},
                {data: 'action', name: 'action'},
            ],
            searching: true,
            paging: true,
            lengthChange: true,
            autoWidth: true
        })
    })
</script>
