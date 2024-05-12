<script>
    $(document).ready(()=>{
        // $.noConflict();
        $("#StudentsAdmissionsDatatables").DataTable({
            searching: true,
            paging: true,
            lengthChange: true,
            autoWidth: true,
            stateSave: true,
            ordering: true,
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
                url:"{{route('studentsAdmissionsTables')}}",
            },
            columns: [
                {data: 'profile', name: 'profile',  orderable: false, searchable: false},
                {data: 'name', name: 'name',  orderable: true, searchable: true},
                {data: 'dob', name: 'dob',  orderable: true, searchable: true},
                {data: 'gender', name: 'gender',  orderable: true, searchable: true},
                {data: 'level', name: 'level',  orderable: true, searchable: true},
                {data: 'residency', name: 'residency',  orderable: true, searchable: true},
                {data: 'admission_status', name: 'admission_status', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
            // stateSave: true
        })
    })
</script>
