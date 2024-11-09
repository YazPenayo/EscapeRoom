<?php
session_start();
$funciona = $_SESSION['user_name'];
include('../models/dbConnection.php');
include('../querys/querys.php');
var_dump($funciona);
exit;
