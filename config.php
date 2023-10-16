<?php
require_once('vendor/autoload.php');

$stripe = [
  "secret_key"      => "sk_test_51O08vnBimfXJrliw9kAbxwWNsxfzofPqChDwGbuawvXJOYvqC6e3uf3m3SNoQqkBANRPX7PdiRlOE0laB6ajv5yc000FEyMYVl",
  "publishable_key" => "pk_test_51O08vnBimfXJrliwGGso7E6JprvvbSOZf3bDXtgLbzuvShdNzQjFCZ6KlmbfQWPO9QCsI1pJydArFsOam9cGXb9g00uIwa1pTV",
];

\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>