<?php
require_once 'includes/session.php';
require_once 'includes/config.php';
// For redirecting page to new location
function Redirect_to($newLocation) {
     header("location: $newLocation");
     exit;
}
// For password encryption
function Password_Encription($password) {
    $Blowfish_hash_formate = "$2y$10$";
    $Salt_length = 22;
    $Salt = Generate_salt($Salt_length);
    $Formating_Blowfish_With_Salt = $Blowfish_hash_formate . $Salt;
    $Hash = crypt($password, $Formating_Blowfish_With_Salt);
    return $Hash;
}

// function for generating random salt

function Generate_salt($length) {
    $Unique_Random_String = md5(uniqid(mt_rand(), true));
    $Base64_String = base64_encode($Unique_Random_String);
    $Modify64_String = str_replace('+','.', $Base64_String);
    $Salt = substr($Modify64_String,0,$length);
    return $Salt;
}

// Password check

function Password_Check($Password, $Existing_pass) {
    $Hash = crypt($Password, $Existing_pass);
    if($Hash === $Existing_pass) {
        return true;
    }else {
        return false;
    }
}

// sanetize and prevent it from sql injection

function clean($data) {
    $data = trim(stripslashes(htmlspecialchars($data)));
    return $data;
}
 
// Check if email already exist
function checkEmail_exist($email) {
    global $con;
    $query = "SELECT * FROM admin_panel WHERE email = '$email'";
    $result = mysqli_query($con, $query);
    if(mysqli_num_rows($result) > 0) {
        return true;
    }else {
        return false;
    }
}
// For login attempt
function Login_attempt($email, $password) {
    global $con;
    $query = "SELECT * FROM admin_panel WHERE email = '$email'";
    $result = mysqli_query($con, $query);
    if(mysqli_num_rows($result) > 0) {
        $rows = mysqli_fetch_assoc($result);
        if(Password_Check($password, $rows['password'])) {
            return $rows;
        }else {
            return null;
        }
    }
}
// Defining a function for activated account
function confirmAccountActivation() {
    global $con;
    $query = "SELECT * FROM admin_panel WHERE active = 'On'";
    $result = mysqli_query($con, $query);
    if(mysqli_num_rows($result) > 0) {
        return true;
    }else {
        return false;
    }
}

// function for login 
function login() {
    if(isset($_SESSION['user_id'])) {
        return true;
    }
}
function confirmLogin() {
    if(!login()) {
    $_SESSION['message'] = "<div class='message'>You have to login.</div>";
    Redirect_to('login.php');
    }
}
