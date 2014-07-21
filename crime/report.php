<?php
session_start();
require('new-connection.php');
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
<body id='report'>
<?php
  $incid = $_SESSION['increportid'];
  $reportquery = "SELECT * FROM incidents WHERE id = {$incid}";
  $report = fetch_record($reportquery);
  $seenquery = "SELECT * FROM incidents_has_users WHERE incidents_id = {$incid}";
  $viewers = fetch_all($seenquery);
  ?>
<div id='wrapper'>
  <div id='incident_box'>
    <h1><?php echo $_SESSION['yesmessage'];?></h1>
    <h1>INCIDENT NAME</h1>
    <p><?php echo $report['name'];?></p>
    <h1>INCIDENT DATE</h1>
    <p><?php echo $report['thedate'];?></p>
    <h1>SEEN BY <?php
    if ($viewers == 0)
      echo 0;
    else {
      echo count($viewers);
    }
    ?></h1>
    <?php
      foreach ($viewers as $viewer) {
        echo "<p>";
        $lookup = "SELECT first, last FROM users WHERE id = {$viewer['users_id']}";
        $userlookup = fetch_record($lookup);
        echo $userlookup['first']." ".$userlookup['last']."</p>";
      } ?>
  <form action="process.php" method="post">
  <input type="submit" name='action' value="Back To Main">
  </form>
  <?php
  if ($_SESSION['user_id'] == $report['users_id']) {
    echo "<form action='process.php' method='post'>
    <input type='hidden' name='incid' value={$incid}>
    <input type='submit' name='action' value='Delete Incident'>
    </form>";
  }
  unset($_SESSION['yesmessage']);
?>
  </div>
</div><!--CLOSE WRAPPER-->
</body>
</html>