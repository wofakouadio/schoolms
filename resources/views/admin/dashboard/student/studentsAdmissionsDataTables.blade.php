<script>
    function filterStudent(){
        $("#StudentsAdmissionsDatatables").DataTable().ajax.reload()
    }
    $(document).ready(()=>{
        // $.noConflict();
        $("#StudentsAdmissionsDatatables").DataTable({
            searching: false,
            paging: true,
            lengthChange: true,
            autoWidth: false,
            stateSave: true,
            ordering: true,
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
                url:"{{route('studentsAdmissionsTables')}}",
                dataType: 'json',
                type:'get',
                data:{
                    _token: "{{ csrf_token() }}",
                    level: function(){
                        return $("#level").val()
                    },
                    branch: function(){
                        return $("#branch").val()
                    },
                    category: function(){
                        return $("#category").val()
                    },
                    house: function(){
                        return $("#house").val()
                    },
                    residency_status: function(){
                        return $("#residency_status").val()
                    },
                    admission_status: function(){
                        return $("#admission_status").val()
                    },
                    student_name: function() {
                        return $("#student_name").val()
                    },
                    gender: function(){
                        return $("#gender").val()
                    },
                    date_of_birth: function() {
                        return $("#date_of_birth").val()
                    },
                    registration_date: function() {
                        return $("#registration_date").val()
                    }
                }
            },
            columns: [
                {data: null, render: function(data, type, row, meta){
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                {data: 'profile', name: 'profile',  orderable: false, searchable: false},
                {data: 'name', name: 'name',  orderable: true, searchable: true},
                {data: 'dob', name: 'dob',  orderable: true, searchable: true},
                {data: 'gender', name: 'gender',  orderable: true, searchable: true},
                {data: 'level', name: 'level',  orderable: true, searchable: true},
                {data: 'residency', name: 'residency',  orderable: true, searchable: true},
                {data: 'admission_status', name: 'admission_status', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            // scrollY: 700,
            scrollCollapse: true,
            dom: "Bfrtip",
            buttons:[{
                extend: 'collection',
                text: 'Export',
                buttons: [{
                        text: 'Export Excel',
                        action: function(e, dt, node, config) {
                            // Get all current filter values
                            var filters = {
                                level: $('#level').val(),
                                branch: $('#branch').val(),
                                category: $('#category').val(),
                                house: $('#house').val(),
                                residency_status: $('#residency_status').val(),
                                admission_status: $('#admission_status').val(),
                                student_name: $('#student_name').val(),
                                gender: $('#gender').val(),
                                date_of_birth: $('#date_of_birth').val(),
                                registration_date: $('#registration_date').val()
                            };
                            // Build URL with filter parameters
                            var url =
                                "{{ route('export_studentsAdmissionsTables') }}?" + $
                                .param(filters);
                            window.location = url;
                        }
                    },

                ]
            }]
        })
    })
</script>
