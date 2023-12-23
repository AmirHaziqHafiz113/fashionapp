@extends('layouts.main')

@section('content')

<section class="container mt-2 my-3 py-5">
    <div>
        @if(Session::has('total') && Session::get('total') != null)
            @if(Session::has('order_id') && Session::get('order_id') != null)
                <h4>Total: ${{ Session::get('total') }}</h4>

                <!-- Set up a container element for the button -->
                <div id="paypal-button-container"></div>
            @endif
        @endif
    </div>
</section>

<script src="https://www.paypal.com/sdk/js?client-id=ARYTr2MKEDiUsYbp-UE_RT7_OxSfWrAHenSu43ACIx4I5HeLUy1Uv0amvX1dbt4wPzE4lKC3LwoTd4R9&currency=MYR"></script>

<script>
    paypal.Buttons({
        createOrder: function (data, actions) {
            // This function sets up the details of the transaction, including the amount.
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '{{ Session::get('total') }}'
                    }
                }]
            });
        },
        onApprove: function (data, actions) {
            // This function captures the funds from the transaction.
            return actions.order.capture().then(function (details) {
                // This function shows a transaction success message to your buyer.
                alert('Transaction completed by ' + details.payer.name.given_name);

                window.location.href = '/verify_payment' + transaction.id;
            });
        }
    }).render('#paypal-button-container');
    // This function displays payment buttons on your web page.
</script>

@endsection
