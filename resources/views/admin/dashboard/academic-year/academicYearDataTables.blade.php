<script>
    $(document).ready(()=>{
        // $.noConflict();
        $("#academicYearDataTables").DataTable({
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
            searching: true,
            paging: true,
            lengthChange: true,
            autoWidth: true,
            stateSave: true
            // stateSave: true
        })
    })
</script>
