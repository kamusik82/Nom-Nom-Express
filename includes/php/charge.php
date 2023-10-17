<!-- This code runs the payment -->

<?php
  require_once('../../config.php');

  // populate variables to be used with stripe payment
  $token  = $_POST['stripeToken'];
  $email  = $_POST['stripeEmail'];
  $totalamt_cents = $_POST['totalamt_cents'];

  // populate variables to be used with database updates in cart_to_order.php
  $totalamt = $_POST['totalamt'];
  $taxamt = $_POST['taxamt'];
  $shipamt = $_POST['shipamt'];
  $u_id = $_POST['user'];


  $customer = \Stripe\Customer::create([
      'email' => $email,
      'source'  => $token,
  ]);

  $charge = \Stripe\Charge::create([
      'customer' => $customer->id,
      'amount'   => $totalamt_cents,
      'currency' => 'cad',
  ]);

  include('./cart_to_order.php');
?>



