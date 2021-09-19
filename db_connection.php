<?php

$host = 'localhost';
$user = 'valerjp1_cupcakery';
$pass = 'Cupcakery123*';
$dbname = 'valerjp1_cupcakery';

$connect = mysqli_connect($host, $user, $pass, $dbname);

if (mysqli_connect_errno()) {
    die('Database connection failed: ' .
        mysqli_connect_error() .
        ' (' . mysqli_connect_errno() . ')'
    );
}
