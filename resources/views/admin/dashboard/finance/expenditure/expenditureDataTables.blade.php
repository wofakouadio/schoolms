<script>
    $(document).ready(()=>{
        // $.noConflict();
        $("#ExpenditureDatatables").DataTable({
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
            {{--processing: true,--}}
            {{--serverSide: true,--}}
            {{--ajax:{--}}
            {{--    url:"{{route('studentsAdmissionsTables')}}",--}}
            {{--},--}}
            {{--columns: [--}}
            {{--    {data: 'profile', name: 'profile', },--}}
            {{--    {data: 'name', name: 'name'},--}}
            {{--    {data: 'dob', name: 'dob'},--}}
            {{--    {data: 'gender', name: 'gender'},--}}
            {{--    {data: 'level', name: 'level'},--}}
            {{--    {data: 'residency', name: 'residency'},--}}
            {{--    {data: 'admission_status', name: 'admission_status'},--}}
            {{--    {data: 'action', name: 'action'},--}}
            {{--],--}}
            searching: true,
            paging: true,
            lengthChange: true,
            autoWidth: true,
            aoStateSave: true
            // stateSave: true
        })
    })
</script>
