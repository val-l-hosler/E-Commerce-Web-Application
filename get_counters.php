<?php

$berry_counter = 0;
$carrot_counter = 0;
$cinnamon_counter = 0;
$mint_counter = 0;
$rainbow_counter = 0;
$red_velvet_counter = 0;

// A sum of the appropriate key's value array indexes is added onto the counters
$berry_counter += array_sum($_SESSION['cart_items']['berry']);
$carrot_counter += array_sum($_SESSION['cart_items']['carrot']);
$cinnamon_counter += array_sum($_SESSION['cart_items']['cinnamon']);
$mint_counter += array_sum($_SESSION['cart_items']['mint']);
$rainbow_counter += array_sum($_SESSION['cart_items']['rainbow']);
$red_velvet_counter += array_sum($_SESSION['cart_items']['red_velvet']);
