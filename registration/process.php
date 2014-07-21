<?php
session_start();
require("new-connection.php");
$post=$_POST;

if (isset($post['action']) && $_POST['action'] == 'register') {
	register_user($_POST);
}
elseif (isset($post['action']) && $_POST['action'] == 'login') {
  	//var_dump($_POST);
	login_user($_POST);
}
//logoff clause
else {
	session_destroy();
	header('location: index.php');
	die();
}

function register_user($post) {
//begin validation
	$_SESSION['errors'] = array();

	if(empty($post['first'])) {
		$_SESSION['errors'][] = "First name can't be blank";

	}

	if(empty($post['last'])) {
		$_SESSION['errors'][] = "Last name can't be blank";
	
	}

	if(!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
		$_SESSION['errors'][] = "Email invalid";
	
	}
	
	if(empty($post['password'])) {
		$_SESSION['errors'][] = "Password can't be blank";
	
	}

	if($_POST['password'] != $post['confirm']) {
		$_SESSION['errors'][] = "Passwords don't match";
	
	}

	if (count($_SESSION['errors']) > 0) {
	header('location: index.php');
	die();
	
	}

//end of validation


//insert into database
	insert_new_user($_POST['first'], $_POST['last'], $_POST['password'], $_POST['email']);
	$_SESSION['yes'] = 'User successfully created';	
	header('location: index.php');
	die();

}

function login_user($post) {
	$esc_email = escape_this_string($post['email']);
	//var_dump($post);
	$md5_password = md5($post['password']);
	$query = "SELECT * FROM users WHERE users.password = '{$md5_password}'
	AND users.email = '{$esc_email}'";
	$user = fetch_all($query);

	if (count($user) > 0) {
		//var_dump($user);
		$_SESSION['user_id'] = $user[0]['id'];
		$_SESSION['first_name'] = escape_this_string($user[0]['first_name']);
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

function insert_new_user($first, $last, $password, $email)
 {
     $esc_first = escape_this_string($first);
     $esc_last = escape_this_string($last);
     $md5_password = md5($password);
     $esc_email = escape_this_string($email);
     $query = "INSERT INTO users (first_name, last_name, password, email, created_at, updated_at)
     	VALUES ('{$esc_first}', '{$esc_last}', '{$md5_password}', '{$esc_email}', NOW(), NOW())";
     run_mysql_query($query);
 }

/* $entry=$_POST['email'];
$_SESSION['email']=$entry;

$query1="INSERT INTO emails (email) VALUES ('{$entry}')";

run_mysql_query($query1);
$query2= "SELECT email FROM emails";
 
$_SESSION['record']=fetch_all($query2);
//echo var_dump(fetch_record($query2));*/

//header('location: yes.php');

/*
if (isset($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) {
	$_SESSION['problem']['email'] = "Invalid email, please re-enter";
	header('location: index.php');
	die();
}

	$_SESSION['email']=$_POST['email'];
	header('location: success.php');*/
?>