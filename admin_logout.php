<?php

session_id('admin');
session_start();
// This destroys the admin session, but not the customer session
session_destroy();
header('Location: admin_login.php');
exit;

