<?php
session_start();
//session_destroy();

?>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="description" content="registration"/>
  <title>registration</title>
  <link type='text/css' rel="stylesheet" href="normalize.css">
  <link type='text/css' rel="stylesheet" href="registration.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
<body>

<wrapper>
  <div id='top'>
  	<h2>Registration</h2>
  </div>
  <div class='content'>
    <form action="process.php" method="post">
      <div class='box'>
        <h2>First Name 
          <?php
            //if(!empty($_SESSION['problem']['email'])) {
            //echo '**';
            //}
          ?>
        </h2>  
          <input type="text" name="first">
      </div>

      <div class='box'>
        <h2>Last Name 
        </h2>  
          <input type="text" name="last">
      </div>

      <div class='box'>
        <h2>Email 
        </h2>  
          <input type="text" name="email">
      </div>

      <div class='box'>
          <h2>Password
          </h2>
          <input type="password" name="password">
      </div>

       <div class='box'>
          <h2>Confirm
          <?php
            ?>
          </h2>
          <input type="password" name="confirm">
        </div>
      <input type="submit" name='action' value="register">
  </form>
</div><!--CLOSE CONTENT-->

<div class='content'>
  <form action="process.php" method="post"> <div id='box'>
    <div class='box'>
      <h2>Email 
      </h2>  
        <input type="text" name="email">
      </div>
  
  <div class='box'>
      <h2>Password
      </h2>
        <input type="password" name="password">
      </div>
    <input type="submit" name='action' value="login">
    </form>
  </div>
</div><!--CLOSE CONTENT-->

  <div id='messages'>
    <h2>Messages:</h1>
      <?php
      if(isset($_SESSION['errors'])) {
        echo '<p>';
        foreach($_SESSION['errors'] as $error) {
          echo $error.'<br>';
        }
        unset($_SESSION['errors']);
      }
      if(isset($_SESSION['yes'])) {
        echo '<p>';
        echo $_SESSION['yes'].'<br>';
        unset($_SESSION['yes']);
      }
      ?>
    </h2>
    </div>

  </wrapper><!--CLOSE WRAPPER-->
</body>
</html>