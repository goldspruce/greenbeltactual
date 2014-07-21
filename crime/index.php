<?php
session_start();
//session_destroy();
require("new-connection.php");
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="description" content="registration"/>
  <title>Crime</title>
  <link type='text/css' rel="stylesheet" href="normalize.css">
  <link type='text/css' rel="stylesheet" href="registration.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>

<body id='index'>
<div id='wrapper'>
  <div id='top'>
  	<h2>Crime Watch</h2>
  </div>
  <div class='content'>
    <form action="process.php" method="post">
      <div class='box'>
        <h2>First Name</h2>
          <?php
            //if(!empty($_SESSION['problem']['email'])) {
            //echo '**';
            //}
          ?>
          <input type="text" name="first">
      </div>

      <div class='box'>
        <h2>Last Name</h2>  
          <input type="text" name="last">
      </div>

      <div class='box'>
        <h2>Email</h2>  
          <input type="text" name="email">
      </div>

      <div class='box'>
        <h2>Password</h2>
        <input type="password" name="password">
      </div>

       <div class='box'>
          <h2>Confirm</h2>
          <input type="password" name="confirm">
        </div>
      <input type="submit" name='action' value="register">
    </form>

    <form action="process.php" method="post">
      <div class='box'>
        <h2>Email</h2>  
        <input type="text" name="email">
      </div>
  
      <div class='box'>
        <h2>Password</h2>
        <input type="password" name="password">
      </div>
      <input type="submit" name='action' value="login">
     </form>
  
  <div id='msg'>
    <?php
      if(isset($_SESSION['errors'])) {
        echo '<p>';
        foreach($_SESSION['errors'] as $error) {
          echo $error;
          echo "</p>";
        }
          unset($_SESSION['errors']);
      }
      if(isset($_SESSION['yes'])) {
        echo '<p>';
        echo $_SESSION['yes'];
        unset($_SESSION['yes']);
        echo "</p>";
      }
    ?>
   </div>
  </div><!--CLOSE CONTENT-->
</div><!--CLOSE WRAPPER-->
</body>
</html>