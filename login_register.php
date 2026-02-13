<?php

require('connection.php');
session_start();

// For login
if (isset($_POST['login'])) {
    $email_username = mysqli_real_escape_string($con, $_POST['email_username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM `registered_users` WHERE `username` = '$email_username' OR `email` = '$email_username'";
    $result = mysqli_query($con, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $result_fetch = mysqli_fetch_assoc($result);
            if (password_verify($password, $result_fetch['password'])) {
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $result_fetch['username'];
                header("location: index.php");
                exit();
            } else {
                echo "<script>alert('Incorrect Password'); window.location.href='index.php';</script>";
            }
        } else {
            echo "<script>alert('Email or Username not registered'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Server error'); window.location.href='index.php';</script>";
    }
}

// For registration
if (isset($_POST['register'])) {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password_raw = $_POST['password'];
    $v_code = bin2hex(random_bytes(16));
    $password_hashed = password_hash($password_raw, PASSWORD_BCRYPT);

    // Optional: Password confirmation check
    /*
    if ($_POST['password'] !== $_POST['password1']) {
        echo "<script>alert('Passwords do not match'); window.location.href='index.php';</script>";
        exit();
    }
    */

    $user_exist_query = "SELECT * FROM `registered_users` WHERE `username` = '$username' OR `email` = '$email'";
    $result = mysqli_query($con, $user_exist_query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $result_fetch = mysqli_fetch_assoc($result);
            if ($result_fetch['username'] == $username) {
                echo "<script>alert('$username - Username already taken'); window.location.href='index.php';</script>";
            } else {
                echo "<script>alert('$email - Email already taken'); window.location.href='index.php';</script>";
            }
        } else {
            $query = "INSERT INTO `registered_users`(`full_name`, `username`, `email`, `password`, `verification_code`, `is_verified`)
                      VALUES ('$fullname', '$username', '$email', '$password_hashed', '$v_code', 0)";
            if (mysqli_query($con, $query)) {
                echo "<script>alert('Registration Successful'); window.location.href='index.php';</script>";
            } else {
                die("Registration Failed: " . mysqli_error($con));
            }
        }
    } else {
        die("Query Error: " . mysqli_error($con));
    }
}

?>
