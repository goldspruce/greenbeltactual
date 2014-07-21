<?php
session_start();
require('new-connection.php');
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

<?php
echo "Welcome {$_SESSION['first_name']}!
      <br><br>";
echo "<p><a href='process.php'>LOG OFF HERE</a></p>";
?>
</body>
</html>