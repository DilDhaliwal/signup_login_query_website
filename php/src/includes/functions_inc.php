<?php

function create_user($conn, $fname, $lname, $email, $pw, $uname)
{
    $sql = "INSERT INTO users (userFN, userLN, userE, userU, userP) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssss", $fname, $lname, $email, $pw, $uname);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../index.php?error=none");
    exit();
}


function uid_exists($conn, $uname)
{
    $sql = "SELECT * FROM users WHERE userU = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location; ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $uname);
    mysqli_stmt_execute($stmt);
    $resultd = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    if ($row = mysqli_fetch_assoc($resultd)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
}

function login_user($conn, $uname, $pw)
{
    $uname_exists = uid_exists($conn, $uname);
    if ($uname_exists == false) {
        header("location: ../index.php?error=usernameincorrect");
        exit();
    }
    $pw_match = $uname_exists["userP"];

    if ($pw != $pw_match) {
        header("location: ../index.php?error=passwordincorrect");
        exit();
    } else if ($pw == $pw_match) {
        session_start();
        $_SESSION["uid"] = $uname_exists["id"];
        $_SESSION["uname"] = $uname_exists["userU"];
        header("location: ../dashboard.php");
        exit();
    }
}

function updateinv($conn, $pid, $sid, $inv)
{
    $sql = "UPDATE products SET quantity = ? WHERE product_id = ? AND supplier_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location; ../dashboard.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "iss", $inv, $pid, $sid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location; ../update.php");
}

function getSuppliersData($conn)
{
    $query = "SELECT * FROM suppliers";
    $result = $conn->query($query);
    return $result;
}

function getProductsData($conn)
{
    $query = "SELECT * FROM products";
    $result = $conn->query($query);
    return $result;
}

function clean_input($dta)
{
    $dta = trim($dta);
    $dta = stripslashes($dta);
    $dta = htmlspecialchars($dta);
    return $dta;
}