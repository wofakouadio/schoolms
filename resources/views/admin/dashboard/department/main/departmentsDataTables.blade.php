<script>
    $(document).ready(()=>{
        // $.noConflict();
        $("#DepartmentsDataTables").DataTable({
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                },
            },
            searching: false,
            paging: true,
            lengthChange: true,
            autoWidth: false
            // processing: true,
            // serverSide: true,
            // ajax:{
            //     url:"{{route('departmentsTables')}}",
            // },
            columns: [
                {data: null, render: function(data, type, row, meta){
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                {data: 'name', name: 'name'},
                {data: 'branch', name: 'branch'},
                {data: 'is_active', name: 'is_active'},
                {data: 'action', name: 'action'},
            ],
        })
    })
</script>
