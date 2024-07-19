<script>

    $(document).ready(()=>{
        $(".menu-alert").hide()

        // check if amount paid is equal to the sum of all items in the transactions list of the student
        // Function to calculate the sum
        function calculateSum() {
            let sum = 0;
            $('.amount_to_pay').each(function() {
                let value = $(this).val();
                if (!isNaN(value) && value.length != 0) {
                    sum += parseFloat(value);
                }
            });
            return sum;
        }

        $("#btn_process_transaction").on("click", () => {
            // e.preventDefault()
            $(".menu-alert").hide()
            let amount_paid = parseFloat($("input[name='amount_paid']").val());
            if(amount_paid === calculateSum()){
                $(".menu-alert").hide()
                $("#transaction_form").find("#btn_process_transaction").removeAttr("type", "button")
                $("#transaction_form").find("#btn_process_transaction").attr("type", "submit")
            }else{
                $("#transaction_form").find("#btn_process_transaction").removeAttr("type", "submit")
                $("#transaction_form").find("#btn_process_transaction").attr("type", "button")
                $(".menu-alert").show().addClass("alert-warning").html("Total Sum of amount to allocate has to be equal to amount paid")
            }
        })


    })

</script>
