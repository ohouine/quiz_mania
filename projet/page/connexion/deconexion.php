<?php
session_start();
$_SESSION['userName'] = '';
$_SESSION['token'] = '';
header('location: ../../index.php');
die();