<?php

if (isset($_POST["uname"], $_POST["pw"])) {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $uname = $_POST["uname"];
    $pw = $_POST["pw"];

    require_once "db_inc.php";
    require_once "functions_inc.php";
    create_user($conn, $fname, $lname, $email, $uname, $pw);

} else {
    header("location: ../signup.php");
    exit();
}