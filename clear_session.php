<?php
session_id('customer');
session_start();

if (isset($_SESSION['order_id'])) {
    $redirect_order_id = $_SESSION['order_id'];
    // This destroys the customer session, but not the admin session
    session_destroy();
    header('Location: receipt.php?order_id=' . $redirect_order_id . '');
    exit;
}
