<?php 
  require_once 'includes/session.php';
  require_once 'includes/config.php';
  require_once 'includes/function.php';
  define('title', 'Create New Password');
  // Adding default value for variable
   $password = $confirmPassword = $message = $message_success = "";

  // check the submit
  if (isset($_GET['token'])) {
      $TokenFromUrl = $_GET['token'];

      if (isset($_POST['reset'])) {
          // sanitize the data
          $password = clean($_POST['password']);
          $confirmPassword = clean($_POST['password-c']);

          // Validating the data
          if (empty($password) || empty($confirmPassword)) {
              $message = "<div class='message'>All fields must be filled out!</div>";
          //  Redirect_to('user_registration.php');
          } elseif ($confirmPassword !== $password) {
              $message = "<div class='message'>Both Password Value should be same!</div>";
          } elseif (strlen($password) < 4) {
              $message = "<div class='message'>Your password should have at least 4 values!</div>";
          } else {
              $hash_password = Password_Encription($password);
              $query = "UPDATE admin_panel SET password = '$hash_password' WHERE token= '$TokenFromUrl'";
              $excute = mysqli_query($con, $query);
              if ($excute) {
                  $_SESSION['message'] = "<div class='message success'>Password reset successfully.</div>";
                  Redirect_to('login.php');
              } else {
                $_SESSION['message'] = "<div class='message'>Something went wrong Please try again letter!</div>";
                Redirect_to('login.php');
              }
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

<body>

  <?php 
    echo $message;
  ?>

    <div class="form-container">
    <h2>Register</h2>
        <form action="reset_password.php?token=<?php echo $TokenFromUrl; ?>" method="post">
        
            <label for="pass">New Password:</label>
            <input type="password" name="password" placeholder="" id="pass"/>
            <label for="pass2">Confirm Password:</label>
            <input type="password" name="password-c" placeholder="" id="pass2"/>

            <button type="submit" name="reset">Reset</button>

        </form>
    </div>
</body>

</html>
