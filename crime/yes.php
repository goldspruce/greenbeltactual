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
<body id='yes'>

<div id='wrapper'>
<form action="process.php" method="post">
	<div id='small_box'>
		<h2>
      <?php
		    echo "<p>{$_SESSION['first']} -- Welcome To The Crime Report"
		  ?>
  </h2>
     <input type="submit" name='action' value="LOG OFF">
	</div>
</form>

<div id='message_box'>
  <h1>PAST INCIDENTS</h1>
  <table>
    <thead><tr>
      <th>Incident</th>
      <th>Date</th>
      <th>Reported By</th>
      <th>Did You See It?</th>
      <th>Go to Report</th>
    </tr></thead>
    <?php
      $querylist = "SELECT * FROM incidents";
      $list = fetch_all($querylist);
      if (count($list) > 0) {
        foreach ($list as $incident) {
          echo 
          "<tr>
            <td>{$incident['name']}</td>
            <td>{$incident['thedate']}</td>
            <td>";
            $creator = "SELECT first, last FROM users WHERE id = {$incident['users_id']}";
            $creatorlookup = fetch_record($creator);
            echo $creatorlookup['first']." ".$creatorlookup['last']."</td>
            <td>";
            if ($_SESSION['user_id'] == $incident['users_id'])
              echo "Reported By You";
            else {
              echo "<form action='process.php' method='post'>
              <input type='hidden' name='incid' value={$incident['id']}>
              <input type='submit' name='action' value='YES'></td></form>";
            }
            echo "<td>
              <form action='process.php' method='post'>
              <input type='hidden' name='incid' value={$incident['id']}>
              <input type='submit' name='action' value='GO'></td></form>
              </tr>";
        }
      }
      else {
        echo 
        "<tr>
            <td>None</td>
            <td>None</td>
            <td>None</td>
            <td>Peaceful</td>
            <td>Quiet</td>
        </tr>";
        }
     ?>
  </table>
</div>   		

<div id='messages'>
      <form id='comment' action='process.php' method='post'>
      <h2>Report a New Incident</h2>
      <span>Incident Name:</span>
              <input type='text' name='incidentname'>
      <span>Incident Date:</span>
              <input type='text' name='incidentdate'>
              <input type='submit' name='action' value='REPORT'>
      </form>
    </div>

</div><!--CLOSE WRAPPER-->
</body>
</html>