<?php include "functions.php";

//can user access the Warehouse?
isperm_management();

echo "<title>Reset staff's password</title>\n";
echo "<div id='main'>\n";
echo "<div class='title'>Reset staff's password</div>\n";

if (isset($_REQUEST['SId'])) {
//if the form as been submitted then...
$staff_id = $_REQUEST['SId'];

	echo "<form action='reset-password-admin.php?SId=$staff_id' method='POST'>\n";
	echo "<input type='hidden' name='staff' value='$staff_id'>\n";
	echo "<button type='submit' name='submit'>Reset staff's password</button>\n";
	echo "</form>\n";

if (isset($_POST['submit'])) {
	$staff = $_POST["staff"];
	$reset_password = "UPDATE staff SET passU = 'Kowope123' WHERE staffid = $staff;";
	$resetPassword = connect($reset_password);

	if ($resetPassword) {
		echo "<div class='text'>Staff's password has being reset.<br/>\n";
		echo "The new password is: <b>Kowope123</b><br/>\n";
		echo "<input type='text' value='Kowope123'>\n";
		echo "</div>\n";
	} else {
		echo "<div class='text'>Unable to reset staff's password at the moment. Contact site admin</div>\n";
	}
}
} else {
	header("Location: staff.php");
	exit;
}

echo "</div>";

include "footer.php";
