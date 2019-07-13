<?php 
  require_once 'includes/session.php';
  require_once 'includes/config.php';
  require_once 'includes/function.php';
  define('title', 'Reset Password');
 // If already login then forwarding user to welcome page
 if(login()) {
  Redirect_to('welcome.php');
}
  // Adding default value for variable
  $username = $email = $message = $message_success = "";

  // check the submit

  if(isset($_POST['reset'])) {
    // sanitize the data  
    $email = clean($_POST['email']);

    // Validating the data 
     if (empty($email)) {
         $message = "<div class='message'>Email required!</div>";
        //  Redirect_to('user_registration.php');
     }elseif (!checkEmail_exist($email)) {
      $message = "<div class='message'>Email not exist!</div>";
     } else {
        $query = "SELECT * FROM admin_panel WHERE email = '$email'";
        $result = mysqli_query($con, $query);
       if($row = mysqli_fetch_assoc($result)) {
         $username = $row['username'];
         $Token = $row['token'];

        $subject = "Password reset";
        $from = "santoshjha0954@gmail.com";
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        
        // Create email headers
        $headers .= 'From: '.$from."\r\n".
        'Reply-To: '.$from."\r\n" .
        'X-Mailer: PHP/' . phpversion();
        // Creating style email content
        $message = '<html><body>';
        $message .= '<h1 style="color:#f40;">Musix</h1>';
        $message .= '<p style="color:#080;font-size:18px;">Hii!'. ' ' .$username .' '. 'Click below this link for reseting your password..</p>';
        $message .= '<p style="color:#008;font-size:18px;">http://localhost/rental/reset_password.php?token='.$Token.'</p>';
        $message .= '</body></html>';
        if(mail($email, $subject, $message, $headers)) {
          $_SESSION['message'] = "<div class='message'>Check Email for reset password..</div>";
          Redirect_to('login.php');
        }else {
          $_SESSION['message'] = "<div class='message'>Something went wrong please try again!</div>";
          Redirect_to('login.php');
        }
       }else{
        $_SESSION['message'] = "<div class='message'>Something went wrong please try again!</div>";
        Redirect_to('login.php');
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
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="" id="email"/>
           
            <button type="submit" name="reset">Reset</button>

        </form>
    </div>
</body>

</html>
