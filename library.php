<?php
session_start();

/* connection to database */
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'chat';
$connection = mysqli_connect($host, $username, $password, $database);

if (!isset($_SESSION["userLogin"])) {
    $_SESSION["userLogin"] = false;
}
if (!isset($_SESSION["username"])) {
    $_SESSION["username"] = "Unknown";
}