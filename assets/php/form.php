<?php

require 'database.php';

function verifyInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$usernameError = $emailError = $passwordError = $newpasswordError = "";
$userName = $email = $password = $newpassword = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["username"])) {
        $usernameError = "Username is required";
    } else {
        $userName = verifyInput($_POST["username"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $userName)) {
            $usernameError = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["email"])) {
        $emailError = "Email is required";
    } else {
        $email = verifyInput($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = "Invalid email format";
        }
    }
    if (empty($_POST["password"])) {
        $passwordError = "Password is required";
    } else {
        $password = verifyInput($_POST["password"]);
    }

    if (empty($_POST["new-password"])) {
        $newpasswordError = "New Password is required";
    } else {
        $newpassword = verifyInput($_POST["new-password"]);
    }

    if (!empty($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["username"])) {
        $db = Database::connect();

        $db->query("INSERT INTO signup (username, email, mdpassword) VALUES('$userName', '$email', '$password')");
        echo "Successfull";

        Database::disconnect();
    } else {
        echo "Empty";
    }
}