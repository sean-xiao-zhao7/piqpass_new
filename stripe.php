<?php

require('stripe/init.php');

// Set your secret key: remember to change this to your live secret key in production
// See your keys here https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey("sk_test_BQokikJOvBiI2HlWgH4olfQ2");

if (!empty($_POST)) {
  // Get the credit card details submitted by the form
  $token = $_POST['stripeToken'];
  //echo "We got the token $token";

  // Create the charge on Stripe's servers - this will charge the user's card
  try {
    $charge = \Stripe\Charge::create(array(
      "amount" => 1000, // amount in cents, again
      "currency" => "cad",
      "source" => $token,
      "description" => "Example charge"
      ));
  } catch(\Stripe\Error\Card $e) {
    // The card has been declined
  }
  
}

?>

<script src="https://code.jquery.com/jquery-2.2.3.min.js"   integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo="   crossorigin="anonymous"></script>

<script src="https://checkout.stripe.com/checkout.js"></script>

<button id="customButton">Purchase</button>

<script>
  var handler = StripeCheckout.configure({
    key: 'pk_test_6pRNASCoBOKtIshFeQd4XMUh',
    image: '/img/documentation/checkout/marketplace.png',
    locale: 'auto',
    name: 'Stripe.com',
    description: '2 widgets',
    amount: 2000, 
    currency: "CAD", 
    token: function(token) {
      //console.log("token is " + token.id);
      alert('about to post!');
      $.post('stripe.php', {'stripeToken': token.id}, function(data) {
        //$( ".result" ).html( data );
        alert(data);
      });
    }
  });

  $('#customButton').on('click', function(e) {
    // Open Checkout with further options:
    handler.open({

    });
    e.preventDefault();
  });

  // Close Checkout on page navigation:
  // $(window).on('popstate', function() {
  //   handler.close();
  // });
</script>


