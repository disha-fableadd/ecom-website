<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Payment</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <button id="pay-button">Pay with Stripe</button>

    <script>
        var stripe = Stripe("{{ env('STRIPE_PUBLIC_KEY') }}");
        var payButton = document.getElementById('pay-button');

        payButton.addEventListener('click', function() {
            stripe.confirmCardPayment("{{ $clientSecret }}", {
                payment_method: {
                    card: cardElement,
                }
            }).then(function(result) {
                if (result.error) {
                    console.error(result.error.message);
                    alert("Payment failed.");
                } else {
                    if (result.paymentIntent.status === 'succeeded') {
                        window.location.href = "{{ route('payment.success') }}";
                    }
                }
            });
        });
    </script>
</body>
</html>
