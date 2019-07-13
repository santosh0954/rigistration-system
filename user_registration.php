<?php 
  require_once 'includes/session.php';
  require_once 'includes/config.php';
  require_once 'includes/function.php';
  define('title', 'User Registration');
 // If already login then forwarding user to welcome page
 if(login()) {
  Redirect_to('welcome.php');
}
  // Adding default value for variable
  $username = $email = $password = $confirmPassword = $message = $message_success = "";

  // check the submit

  if(isset($_POST['register'])) {
    // sanitize the data  
    $username = clean($_POST['username']);
    $email = clean($_POST['email']);
    $password = clean($_POST['password']);
    $confirmPassword = clean($_POST['password-c']);
    $Token = bin2hex(openssl_random_pseudo_bytes(40));

    // Validating the data 
     if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
         $message = "<div class='message'>All fields must be filled out!</div>";
        //  Redirect_to('user_registration.php');
     }elseif ($confirmPassword !== $password) {
        $message = "<div class='message'>Both Password Value should be same!</div>";
     }elseif (strlen($password) < 4) {
      $message = "<div class='message'>Your password should have at least 4 values!</div>";

     }elseif (checkEmail_exist($email)) {
      $message = "<div class='message'>Email already exist!</div>";
     } else {
       $hash_password = Password_Encription($password);
       $query = "INSERT INTO admin_panel (username, email, password, token, active) VALUES ('$username', '$email', '$hash_password', '$Token', 'OFF')";
       if(mysqli_query($con, $query)) {
        $subject = "Confirm account";
        $from = "santoshjha0954@gmail.com";
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        
        // Create email headers
        $headers .= 'From: '.$from."\r\n".
        'Reply-To: '.$from."\r\n" .
        'X-Mailer: PHP/' . phpversion();
        
        $message = '<html><body>';
        $message .= '<h1 style="color:#f40;">Musix</h1>';
        $message .= '<p style="color:#080;font-size:18px;">Hii!'. ' ' .$username .' '. 'Click below this link for activating your account..</p>';
        $message .= '<p style="color:#008;font-size:18px;">http://localhost/rental/activate.php?token='.$Token.'</p>';
        $message .= '</body></html>';
        if(mail($email, $subject, $message, $headers)) {
          $message = "<div class='message'>Check Email for activation..</div>";
        }else {
          $message = "<div class='message'>Something went wrong please try again!</div>";
        }
       }else{
        $message = "<div class='message'>Something went wrong please try again!</div>";

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
    echo $message_success;
  ?>

    <div class="form-container">
    <h2>Register</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
            <label for="username">User Name:</label>
            <input type="text" name="username" placeholder="" id="username" value="<?php if(!empty($message)) echo $username; ?>"/>
            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="" id="email" value="<?php if(!empty($message)) echo $email ?>"/>
            <label for="pass">Password:</label>
            <input type="password" name="password" placeholder="" id="pass"/>
            <label for="pass2">Confirm Password:</label>
            <input type="password" name="password-c" placeholder="" id="pass2"/>

            <button type="submit" name="register">Register</button>

        </form>
        <p class="goto-link">Click here for <a href="login.php">login</a></p>
    </div>
</body>

</html>
