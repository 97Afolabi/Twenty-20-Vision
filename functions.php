<?php
//start a session to maintain user's info
session_start();

//include the help file
include "tutorial.php";

//JS script to print path to current file -- not useful now
$path = "<script type='text/javascript'>document.write(location.pathname);</script>";

//if the user is not logged in, return to the log in page
if (!isset($_SESSION['user_name'])) {
	//$target = $_SERVER["SCRIPT_NAME"];
	//$target = urlencode($target);
	header("Location: index.php");
	exit;
}

$conn = mysqli_connect("localhost", "root", "password", "twenty_20");

//SQL connect query shortcut instead of writing on every page, simply write the query,
//enclose it in a variable and insert the variable within the connect($function) :-)
function connect($sqlQuery) {
  $conn = mysqli_connect("localhost", "root", "password", "twenty_20");
  $exQuery = mysqli_query($conn, $sqlQuery) OR die(mysqli_error($conn));
  echo "<br/>"; //print a line break after an error
  return $exQuery;
}

//a function from W3Schools to sanitize user input
	//$data is reassigned values each time it is called
	//different functions are called on the input in order
function test_input($data) {
	$conn = mysqli_connect("localhost", "root", "password", "twenty_20");
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = mysqli_real_escape_string($conn, $data);
	return $data;
}

//a function to show the retrieved value of a <select> from the db
function isset_select($database, $value) {
	if ($database === $value) {
		echo "selected = 'selected'";
	}
}

//a function to show the retrieved value of a [type=checkbox], [type=radio] from the db
function isset_check($database, $value) {
	if ($database === $value) {
		echo "checked = 'checked'";
	}
}

//functions to manage access levels
//access the warehouse
function isperm_warehouse() {
	if ($_SESSION["perm_warehouse"] !== "privileged") {
		header("Location: home.php");
		exit;
	}
}

//view stock in other branches
function isperm_stock() {
	if ($_SESSION["perm_stock"] !== "global") {
		header("Location: home.php");
		exit;
	}
}

//manage staff and branches
function isperm_management() {
	if ($_SESSION["perm_management"] !== "privileged") {
		header("Location: home.php");
		exit;
	}
}

//view all patients and edit their profiles
function isperm_patients() {
	if ($_SESSION["perm_patients"] !== "global") {
		header("Location: home.php");
		exit;
	}
}

//answer appointments
function isperm_appointments() {
	if ($_SESSION["perm_appointments"] !== "privileged") {
		header("Location: home.php");
		exit;
	}
}

//manage finances
function isperm_finance() {
	if ($_SESSION["perm_finance"] !== "privileged") {
		header("Location: home.php");
		exit;
	}
}

//date function for form values
function date_is() {
	echo date("Y-m-d");
}
//time function, not really needed now
function time_is() {
	echo date("h:i:s");
}

//date and time function in MySQL format
function time_date() {
	echo date("Y-m-d h:i:s");
}

?>
<!DOCTYPE html>
<html lang='en'>
<head>
<link rel='icon' type='image/png' href='images/mercy.png'/>
<link rel='stylesheet' href='style/style.css'/>
<script type="text/javascript" src="scripts/main.js"></script>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

<div id="header">
<h1 id="title">Twenty-20 Vision</h1>
</div>

<div class="navbar">
<a href='home.php'>Home</a><a href='frames.php'>Frames</a><a href='lenses.php'>Lenses</a><a href='accessories.php'>Accessories</a><a href='patients.php'>Patients</a> <a href='account.php'>Account</a>
</div>
