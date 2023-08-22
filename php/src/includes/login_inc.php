<?php



// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (isset($_POST['uname'], $_POST['pw'])) {
    $uname = $_POST["uname"];
    $pw = $_POST["pw"];

    require_once "db_inc.php";
    require_once "functions_inc.php";

    login_user($conn, $uname, $pw);

}
if (empty($_POST['uname']) || empty($_POST['pw'])) {
    header("location: ../index.php");
    exit('Please fill both the username and password fields!');
}