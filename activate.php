<?php
  include 'includes/config.php';
  include 'includes/function.php';
  define('title', 'Activating account');
  $message_success = $message = "";
  if(isset($_GET['token'])) {
      $TokenFromUrl = $_GET['token'];
      if(confirmAccountActivation()) {
        $message_success = "<div class='message success'>Email already activated.";
        $message_success .= "<p><small>Going automatically to login page, if not <a style = 'color: rgba(255,255,255,0.7);' href='login.php'>Click here.</a></small></p></div>";
      }else {
          $query = "UPDATE admin_panel SET active = 'On'";
          $excute = mysqli_query($con, $query);
          if ($excute) {
              $message_success = "<div class='message success'>Account activated successfully.";
              $message_success .= "<p><small>Going automatically to login page, if not <a style = 'color: rgba(255,255,255,0.7);' href='login.php'>Click here.</a></small></p></div>";
          } else {
              $message = "<div class='message'>Something went wrong Please try again letter!</div>";
          }
      }
  }
  ?>
  <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo title ?></title>
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,900&display=swap" rel="stylesheet">
</head>

<body style="background: #fff;">

  <?php 
    echo $message;
    echo $message_success;
    
  ?>
  <script>
  setTimeout(function () {
   window.location.href= 'login.php'; // the redirect goes here

},8000);
</script>
</body>
</html>