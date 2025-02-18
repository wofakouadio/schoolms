<script>

    $(document).ready(()=>{
        // load level
        $("select[name=department_id]").on("change", ()=>{
            let department_id = $("select[name=department_id]").val()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"{{ route('get_department_levels') }}",
                method:"GET",
                cache: false,
                data:{department_id:department_id},
                success:(Response)=>{
                    console.log(Response)
                }
            })
        })

    })

</script>
