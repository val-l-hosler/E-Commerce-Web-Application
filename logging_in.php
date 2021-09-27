<?php
// This ensures that the customer session won't conflict with the admin session
session_id('admin');
session_start();

header('Location: admin_dashboard.php');
exit;
