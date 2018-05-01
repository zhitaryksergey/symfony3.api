<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Test</title>
</head>
<body>

    <div class="container">
        <form id="paymentForm" class="form-signin">
            <h2 class="form-signin-heading">Test Payment</h2>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="text" name="email" id="inputEmail" class="form-control" placeholder="Email address" autofocus="">
            <label for="inputAmount" class="sr-only">Amount</label>
            <input type="text" name="amount" id="inputAmount" class="form-control" placeholder="Amount" >
            <button class="btn btn-primary btn-block" type="submit">Send</button>
        </form>
        <hr>
        <div id="paymentResponse">

        </div>

        <div>
            <button class="getTotalTransactions btn btn-primary btn-block" data-type="" type="submit">All Totals</button>
            <button class="getTotalTransactions btn btn-primary btn-block" data-type="week" type="submit">Current Week Totals</button>
            <button class="getTotalTransactions btn btn-primary btn-block" data-type="month" type="submit">Current Month Totals</button>
        </div>
        <div id="totalResponse">

        </div>
    </div>

    <script src="jquery-1.12.4.min.js"></script>
    <script>
        $( document ).ready(function() {

            $('#paymentForm').submit(function(e) {
                e.preventDefault();

                var data = $( this ).serializeArray();
                $.ajax({
                    type: "POST",
                    url: "send.php",
                    data: data,
                    success: function(response) {
                        $('#paymentResponse').html(response);
                    }
                });
            });

            $('.getTotalTransactions').click(function(e) {
                e.preventDefault();

                var type = $( this ).data('type');
                $.ajax({
                    type: "GET",
                    url: "totals.php?type=" + type,
                    success: function(response) {
                        $('#totalResponse').html(response);
                    }
                });
            });

        });
    </script>
</body>
</html>
 
