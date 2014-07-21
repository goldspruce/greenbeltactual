<?php
session_start();
require("new-connection.php");
$post = $_POST;

if (isset($_POST['action']) && $_POST['action'] == 'LOG OFF') {
	session_destroy();
	header('location: index.php');
	die();
}

if (isset($_POST['action']) && $_POST['action'] == 'GO') {
	listreport($_POST);
}

if (isset($_POST['action']) && $_POST['action'] == 'YES') {
	yes($_POST);
}

if (isset($_POST['action']) && $_POST['action'] == 'Back To Main') {
	header('location: yes.php');
    die();
}

if (isset($_POST['action']) && $_POST['action'] == 'Delete Incident') {
	delete($_POST);
}

if (isset($_POST['action']) && $_POST['action'] == 'register') {
	register_user($_POST);
}

if (isset($_POST['action']) && $_POST['action'] == 'login') {
	login_user($_POST);
}

if (isset($_POST['action']) && $_POST['action'] == 'REPORT') {
	report($_POST);
}


function yes($post) {
	$party = $_SESSION['user_id'];
	$incident = $post['incid'];
	$yesquery = "SELECT * FROM incidents_has_users WHERE users_id = {$party} AND incidents_id = {$incident} ";
	$yescheck = fetch_record($yesquery);
	if ($yescheck)
		$_SESSION['yesmessage'] = 'You already told us you saw this incident, thank you';
	else {
		$_SESSION['yesmessage'] = 'We added you, please see below';	
     	$queryyes = "INSERT INTO incidents_has_users (incidents_id, users_id, created, updated)
     	VALUES ('{$post['incid']}', '{$party}', NOW(), NOW())";
     	run_mysql_query($queryyes);
     }
     $listcall['incid'] = $post['incid'];
     //var_dump($listcall);
     listreport($listcall);
}

function listreport($post) {
	$_SESSION['increportid'] = $post['incid'];
	header('location: report.php');
 	die();
}


function report($post) {
	$incidentname = escape_this_string($post['incidentname']);
	$incidentdate = escape_this_string($post['incidentdate']);
    $query = "INSERT INTO incidents (name, thedate, created, updated, users_id)
     	VALUES ('{$post['incidentname']}', '{$post['incidentdate']}', NOW(), NOW(), {$_SESSION['user_id']})";
	run_mysql_query($query);
 	//var_dump($query);
	header('location: yes.php');
 	die();
}

function delete($post) {
	$querydelete = "DELETE FROM incidents WHERE id = {$post['incid']}";
	$todelete = run_mysql_query($querydelete);
 	header('location: yes.php');
 	die();
}

function register_user($post) {
//begin validation
	$errors = array();
	$exists = "SELECT * FROM users WHERE users.email = '{$post['email']}'";
	$userexists = fetch_all($exists);
	
	if (count($userexists) > 0) {
		$errors = "A user with that email already exists, please use another";
		$_SESSION['errors'][]= $errors;
		header('location: index.php');
		die();
	}

	if(empty($post['first'])) {
		$errors[] = "First name can't be blank";

	}

	if(empty($post['last'])) {
		$errors[] = "Last name can't be blank";
	
	}

	if(!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
		$errors[] = "Email invalid";
	
	}
	
	if(empty($post['password'])) {
		$errors[] = "Password can't be blank";
	
	}

	if($post['password'] != $post['confirm']) {
		$errors[] = "Passwords don't match";
	
	}

	if (count($errors) > 0) {
	$_SESSION['errors'] = $errors;
	header('location: index.php');
	die();

	}
	//end of validation

	//insert into database
	insert_new_user($_POST['first'], $_POST['last'], $_POST['email'], $_POST['password']);
	$_SESSION['yes'] = 'User successfully created, please login';	
	header('location: index.php');
	die();

}

function login_user($post) {
	$esc_email = escape_this_string($post['email']);
	//var_dump($post);
	//$md5_password = md5($post['password']);
	$query = "SELECT * FROM users WHERE users.email = '{$esc_email}'";
	$user = fetch_record($query);
	$salt_password = $user['password'];
	if ($salt_password == crypt($post['password'], $salt_password))

	//non-salt code, select all instead of 1
	//$query = "SELECT * FROM users WHERE users.password = '{crypt($post['password'], $salt_password)}';
	//AND users.email = '{$esc_email}'";
	//$user = fetch_all($query);

	{
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['first'] = escape_this_string($user['first']);
		$_SESSION['logged_in'] = TRUE;
		header('location: yes.php');
		die();
	}
	else {
		//var_dump($user);
		$_SESSION['errors'][] = "User, Email, and/or Password are wrong";
		header('location: index.php');
		die();
	}
}

function insert_new_user($first, $last, $email, $password)
 {
     $esc_first = escape_this_string($first);
     $esc_last = escape_this_string($last);
     $esc_email = escape_this_string($email);
     //$md5_password = md5($password);
     $salt = bin2hex(openssl_random_pseudo_bytes(22));
     //$password1 = escape_this_string($password);
     $salt_password = crypt($password, $salt);
     $query = "INSERT INTO users (first, last, email, password, created, updated)
     	VALUES ('{$esc_first}', '{$esc_last}', '{$esc_email}', '{$salt_password}', NOW(), NOW())";
     run_mysql_query($query);
 }
 
?>