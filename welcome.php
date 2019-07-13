<?php
require_once 'includes/session.php';
require_once 'includes/config.php';
require_once 'includes/function.php';
define('title', 'Welcome to musix');
?>
<?php 
confirmLogin();
if(!login()) {
    $_SESSION['message'] = "<div class='message'>You have to login!</div>";
    Redirect_to('login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo title ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <?php 
   if (isset($_SESSION['user_id'])) {
       echo $_SESSION['user_id'].'and'. $_SESSION['user_name'], $_SESSION['user_email'];
   }else
   if(isset($_COOKIE['cookie_id'])) {
    echo $_COOKIE['cookie_id'].'and'. $_COOKIE['cookie_name'], $_COOKIE['cookie_email'];
   }
   ?>
    <h1>Welcome</h1>
    <a href= "logout.php">Logout</a>
</body>
</html>