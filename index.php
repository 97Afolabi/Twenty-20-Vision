<?php
session_start();

$conn = mysqli_connect("localhost", "root", "password", "twenty_20");
function connect($sqlQuery) {
	$conn = mysqli_connect("localhost", "root", "password", "twenty_20");
	$exQuery = mysqli_query($conn, $sqlQuery) OR die(mysqli_error($conn));
	echo "<br/>";
	return $exQuery;
}
function test_input($data) {
	$conn = mysqli_connect("localhost", "root", "password", "twenty_20");
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = mysqli_real_escape_string($conn, $data);
	return $data;
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Twenty-20 Vision</title>
		<meta name="viewport" content="width=device-width,initial-scale=1"/>
		<link rel="stylesheet" type="text/css" href="style/style.css">
	</head>
<body>

<div id='header'>
<h1 id="title">Twenty-20 Vision</h1>
</div>

<div id='main'>
<form action="index.php" method="POST" style="margin: 10% auto;">
	<?php

if (isset($_POST['submit'])) {
$uid = test_input($_POST['uname']);
//I didn't sanitize the password field because the user might enter a character that will be
// stripped away. It must be fixed
$pwd = test_input($_POST['upass']);

$sql = "SELECT nameU, staffid, branchid, status, perm_stock, perm_warehouse, perm_management, perm_patients, perm_appointments, perm_finance FROM staff WHERE (nameU='$uid' OR mailE='$uid') AND passU='$pwd'";
$result = connect($sql);

//if the input is wrong
if (!$row = mysqli_fetch_assoc($result)) {
	echo "<div class='text'>Incorrect login credentials!</div>";
} else {
	//if it is not, check if that user's account is active
	if ($row['status'] === "Active") {
	//then set the rows as session variables
	$_SESSION['user_name'] = $row['nameU'];
	$_SESSION['staffid'] = $row['staffid'];
	$_SESSION['branchid'] = $row['branchid'];
	$_SESSION['perm_stock'] = $row['perm_stock'];
	$_SESSION['perm_warehouse'] = $row['perm_warehouse'];
	$_SESSION['perm_management'] = $row['perm_management'];
	$_SESSION['perm_patients'] = $row['perm_patients'];
	$_SESSION['perm_appointments'] = $row['perm_appointments'];
	$_SESSION['perm_finance'] = $row['perm_finance'];

	if (isset($_SERVER["QUERY_STRING"])) {
	//if the user was redirected after clicking the link to another page,
	//the page address is preserved in the browser link and in the form
	//fetch the address, filter it and redirect the user to that page instead of home
	//$target = urldecode($_SERVER["QUERY_STRING"]);
	//header("Location: localhost/$target");
	//exit;
	echo $target;
	}

	header("Location: home.php");
	exit;
	} else {
	//if user's account has been de-activated, tell the truth
	echo "<div class='text'>Your account has been de-activated</div>";
	}

}
}
	?>
	<b>Username or e-mail:</b><br/>
	<input type="text" name="uname" placeholder="Username or e-mail"><br/>
	<b>Password:</b><br/>
	<input type="password" name="upass" placeholder="Password"><br/>
	<input type="submit" name="submit" value="Login">
</form>

</div>
<?php
//since $conn is my global variable for MySQLi connections, I
//can simply close it here
mysqli_close($conn);
?>
<div id='footer'><span>Kowope: designed and maintained at: <a href="https://iamlearn.i.ng" title="IAmLearn.i.ing">I am learning</a></span></div>
</body>
</html>
