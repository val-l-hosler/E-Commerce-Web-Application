<?php
// This ensures that the customer session won't conflict with the admin session
session_id('admin');
session_start();

echo '
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Cupcakery | A Cupcake Bakery</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <link href="css/normalize.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <script src="js/script.js"></script>
</head>

<body>
';