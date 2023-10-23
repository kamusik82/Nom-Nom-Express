<?php
require_once('vendor/autoload.php');

$stripe = [
  "secret_key"      => "sk_test_51O4TGjJ71upYtmhO6aojcUnu2wSoil9DjquBMUN83mjPw65lNbWCmFHIgvhG4mueeJ4aK9YdHTMnlUl6mIHqTyOv002kdcbYIx",
  "publishable_key" => "pk_test_51O4TGjJ71upYtmhOJlKV2eh5supzuM6RVRf6xzUryjS7FKMF0J4Ms2mpSqrklPK4IpDRXqFs4ggjzFqVcxuFr49600VklJTBAx",
];

\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>