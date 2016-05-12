<?php

	print_r($_POST);		

?>
<form action="/stripe_pay.php" method="POST">
  <script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="pk_test_5Ir0zjoUeZUgOHIWP4WRYVid"
    data-amount="2000"
    data-name="trypiq.com"
    data-description="2 widgets"
    data-image="/img/documentation/checkout/marketplace.png"
    data-locale="auto">
  </script>
</form>
