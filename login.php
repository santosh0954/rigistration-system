<?php 
  require_once 'includes/session.php';
  require_once 'includes/config.php';
  require_once 'includes/function.php';
  define('title', 'User Login');
 // If already login then forwarding user to welcome page
 if(login()) {
   Redirect_to('welcome.php');
 }
  // Adding default value for variable
  $email = $password =  $message =  "";

  // check the submit

  if(isset($_POST['login'])) {
    // sanitize the data  
    $email = clean($_POST['email']);
    $password = clean($_POST['password']);

    // Validating the data 
     if (empty($email) || empty($password)) {
         $message = "<div class='message'>All fields must be filled out!</div>";
        //  Redirect_to('user_registration.php');
     } else {
       if(confirmAccountActivation()) {
      $found_account = Login_attempt($email, $password);
      if(is_array($found_account)) {
        $_SESSION['user_id'] = $found_account['id'];
        $_SESSION['user_name'] = $found_account['username'];
        $_SESSION['user_email'] = $found_account['email'];
        // Create cookie for remember me 
        if(isset($_POST['remember_me'])) {
          setcookie('cookie_id', $_SESSION['user_id'], time()+86400 );
          setcookie('cookie_name', $_SESSION['user_name'], time()+86400 );
          setcookie('cookie_email', $_SESSION['user_email'], time()+86400);
        }
        Redirect_to('welcome.php');
      }else {
        $message = "<div class='message'>Invalid Email / Password!</div>";
      }
     }else {
      $message = "<div class='message'>Account confrmation is required!</div>";
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
    echo message();
  ?>

    <div class="form-container">
      <h2>Log In</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">

            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="" id="email" value="<?php if(!empty($message)) echo $email ?>"/>
            <label for="pass">Password:</label>
            <input type="password" name="password" placeholder="" id="pass"/>
            <p id="rem"><input type="checkbox" name="remember_me" id="remember_me"/> <label for="remember_me">Remember me</label></p>
            <p class="goto-link"> <a href="recover_account.php">Forgot password</a></p>

            <button type="submit" name="login">Login</button>

        </form>
        <p class="goto-link">Click here for <a href="user_registration.php">registration</a></p>
    </div>
</body>

</html>
