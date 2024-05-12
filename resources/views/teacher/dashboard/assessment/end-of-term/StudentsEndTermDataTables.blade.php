<script>
    $(document).ready(()=>{
        // $.noConflict();
        $("#StudentsEndTermDataTables").DataTable({
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
            {{--    url:"{{route('StudentsEndTermDataTables')}}",--}}
            {{--},--}}
            {{--columns: [--}}
            {{--    {data: 'term', name: 'term'},--}}
            {{--    {data: 'student_id', name: 'student_id'},--}}
            {{--    {data: 'student_name', name: 'student_name'},--}}
            {{--    {data: 'student_level', name: 'student_level'},--}}
            {{--    {data: 'total_class_score', name: 'total_class_score'},--}}
            {{--    {data: 'total_exam_score', name: 'total_exam_score'},--}}
            {{--    {data: 'total_score', name: 'total_score'},--}}
            {{--    {data: 'action', name: 'action'},--}}
            {{--],--}}
            searching: true,
            paging: true,
            lengthChange: true,
            autoWidth: true,
            // aoStateSave: true
            stateSave: true
        })
    })
</script>
