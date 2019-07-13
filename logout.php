<?php
  require_once 'includes/session.php';
  require_once 'includes/function.php';
   // If login going to logout
 if(login()) {

  // Removing the Cookie
  setcookie('cookie_id', '', time()-86400 );
          setcookie('cookie_name', '', time()-86400 );
          setcookie('cookie_email', '', time()-86400);
  // unseting the session
  session_unset();
  session_destroy();
  Redirect_to('login.php');
 }else {
  Redirect_to('login.php');
 }