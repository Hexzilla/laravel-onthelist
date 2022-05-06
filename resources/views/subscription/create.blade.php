@extends('layouts.vendor')

@section('styles')
<link href="{{ asset('css/vendor.css') }}" rel="stylesheet">
<style>
    label {
        color: black;
    }
</style>
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-md-12">
            <input id="card-holder-name" type="text">
        
                <!-- Stripe Elements Placeholder -->
                <div id="card-element"></div>

                <button id="card-button">
                    Process Payment
                </button>
                
                <form method="POST" action="{{ route('subscription.purchase') }}" id="purchase-form">
                    @csrf
                    <input type="text" id="paymentMethodId" name="paymentMethodId" value="">
                    <button type="submit">
                        Stripe
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script>
    window.ParsleyConfig = {
        errorsWrapper: '<div></div>',
        errorTemplate: '<div class="alert alert-danger parsley" role="alert"></div>',
        errorClass: 'has-error',
        successClass: 'has-success'
    };
</script>
<script src="http://parsleyjs.org/dist/parsley.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
<script>

    $(document).ready(function() {
        const stripe = Stripe("<?php echo env('STRIPE_PUBLISHABLE_SECRET') ?>");
        console.log('stripe', stripe)

        const elements = stripe.elements();
        const cardElement = elements.create('card');

        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');

        /*$('#purchase-form').submit(async (e) => {
            const { paymentMethod, error } = await stripe.createPaymentMethod(
                'card', cardElement, {
                    billing_details: { name: cardHolderName.value }
                }
            );
            
            console.log('paymentMethod', paymentMethod);
            if (error) {
                // Display "error.message" to the user...
                return false;
            }
            $("#paymentMethodId").val(paymentMethod.id);
            return true;
        });*/
        
        cardButton.addEventListener('click', async (e) => {
            const { paymentMethod, error } = await stripe.createPaymentMethod(
                'card', cardElement, {
                    billing_details: { name: cardHolderName.value }
                }
            );
            
            console.log('paymentMethod', error, paymentMethod);
            if (error) {
                // Display "error.message" to the user...
                return;
            }

            $("#paymentMethodId").val(paymentMethod.id);
        });
    });

    // Stripe.setPublishableKey("<?php echo env('STRIPE_PUBLISHABLE_SECRET') ?>");
    // jQuery(function($) {
    //     $('#payment-form').submit(function(event) {
    //         var $form = $(this);
    //         /*$form.parsley().subscribe('parsley:form:validate', function(formInstance) {
    //             formInstance.submitEvent.preventDefault();
    //             return false;
    //         });*/
    //         $form.find('#submitBtn').prop('disabled', true);
    //         Stripe.card.createToken($form, stripeResponseHandler);
    //         return false;
    //     });
    // });

    // function stripeResponseHandler(status, response) {
    //     console.log('response', response)
    //     alert(response.id)
    //     var $form = $('#payment-form');
    //     if (response.error) {
    //         $form.find('.payment-errors').text(response.error.message);
    //         $form.find('.payment-errors').addClass('alert alert-danger');
    //         $form.find('#submitBtn').prop('disabled', false);
    //         $('#submitBtn').button('reset');
    //     } else {
    //         var token = response.id;
    //         $("#stripeToken").val(token);
    //         $form.get(0).submit();
    //     }
    // };
</script>
@endsection