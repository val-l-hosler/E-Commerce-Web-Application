<?php
// This ensures that the customer session won't conflict with the admin session
session_id('customer');
session_start();

// This controls the cart button UI
if (isset($_SESSION['cart_item_num'])) {
    $items = $_SESSION['cart_item_num'];
} else {
    $items = 0;
}

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
  <script src="https://addevent.com/libs/atc/1.6.1/atc.min.js" async defer></script>
  <script src="js/script.js"></script>
</head>

<body>

  <header>
    <div class="logo-container" id="logo-container">
      <img src="images/cupcake.png" alt="cupcake logo" />
      <h1>Cupcakery</h1>
    </div>
    <div class="shopping-cart-container">
      <a href="cart.php"><img src="images/shopping-cart.png" alt="shopping cart" />
        <h2 id="cart-items">{' . $items . '}</h2>
      </a>
    </div>
  </header>

  <nav>
    <ul>
      <li>
        <a href="menu.php">Menu</a>
      </li>
      <li>
        <a href="index.php">Order Cupcakes</a>
      </li>
    </ul>
  </nav>
';