<html>
<body>
<button id="pay-button">Pay!</button>
<pre><div id="result-json">JSON result will appear here after payment:<br></div></pre>

<!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        // SnapToken acquired from previous step
        snap.pay('{{ $transaction }}', {
            // Optional
            onSuccess: function(result){
                /* You may add your own js here, this is just example */
                window.location.replace("http://laravelplayground.test/payment-success/" + JSON.stringify(result.order_id).trim());
            },
            // Optional
            onPending: function(result){
                /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            },
            // Optional
            onError: function(result){
                /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            }
        });
    };
</script>
</body>
</html>
