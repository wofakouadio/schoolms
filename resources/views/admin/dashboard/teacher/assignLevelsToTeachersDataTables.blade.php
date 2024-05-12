<script>
    $(document).ready(()=>{
        // $.noConflict();
        $("#AssignLevelsToTeachersDataTables").DataTable({
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
            {{--    url:"{{route('teachersTables')}}",--}}
            {{--},--}}
            // columns: [
            //     {data: 'profile', name: 'profile', },
            //     {data: 'name', name: 'name'},
            //     {data: 'gender', name: 'gender'},
            //     {data: 'contact', name: 'contact'},
            //     {data: 'email', name: 'email'},
            //     {data: 'staff_id', name: 'staff_id'},
            //     {data: 'rank', name: 'rank'},
            //     {data: 'is_active', name: 'is_active'},
            //     {data: 'action', name: 'action'},
            // ],
            searching: true,
            paging: true,
            lengthChange: true,
            autoWidth: true,
            stateSave: true
        })
    })
</script>
