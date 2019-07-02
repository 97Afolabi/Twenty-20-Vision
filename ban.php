<?php include "functions.php";

//can user access the Warehouse?
isperm_management();

echo "<title>Set account status</title>\n";
echo "<div id='main'>";
echo "<div class='title'>Set account status</div>\n";

//make sure a staff was selected
//display the full name and user name to avoid mistakes
//display a form to update the staff's profile
if (isset($_REQUEST['SId'])) {
	$staff_id = $_REQUEST['SId'];
	$staff = "SELECT nameU, fullName, status FROM staff WHERE staffid=$staff_id;";
	$vstaff = connect($staff);

	while ($sdet = mysqli_fetch_assoc($vstaff)) {
		echo "Set <b>" .$sdet["fullName"]. " (" .$sdet["nameU"]. "'s)</b> account status.\n";
		echo "<form action='ban.php' method='POST'>\n";
		echo "<input type='radio' name='status' value='Active'";
		isset_check($sdet["status"], "Active");
		echo "><b>Active</b><br/>\n";
		echo "<input type='radio' name='status' value='De-activated'";
		isset_check($sdet["status"], "De-activated");
		echo "><b>De-activated</b><br/>\n";
		echo "<input type='hidden' name='SId' value='" . $staff_id . "'>\n";
		echo "<button type='submit' name='confirm'>Set account status</button>\n";
		echo "</form><br/>\n";
	}

//when the form is submitted,
if (isset($_POST["confirm"])) {
$uid = $_POST['SId'];

//if the user selected the radio button to de-activate, de-activate
if (isset($_POST['status']) && isset($_POST['SId']) && $_POST["status"] === "De-activated") {
	while ($del = mysqli_fetch_assoc($vstaff)) {
		echo "Are you sure you want to de-activate <b>" . $del['fullName'] . "'s</b> (<b>" .$del['nameU']. "</b>) account?<br/>";
	}

	//make it impossible to de-activate Admin account
	if ($uid === "1") {
		$active_staff = "UPDATE staff SET status = 'Active' WHERE staffid = 1;";
		$activeStaff = connect($active_staff);
	} else {
		$delU = "UPDATE staff SET status = 'De-activated' WHERE staffid=$uid;";
		$delUser = connect($delU);
		if ($delU) {
			header("Location: staff.php");
			exit;
		} else {
			echo "<div class='text'>Unable to update user's status. Contact site admin.\n";
		}
	}
//if the user selected the radio button to activate, activate
} else if (isset($_POST['status']) && isset($_POST['SId']) && $_POST["status"] === "Active") {
	$active_staff = "UPDATE staff SET status = 'Active' WHERE staffid = $uid;";
	$activeStaff = connect($active_staff);

	if ($activeStaff) {
		echo "<div class='text'>Staff profile activated!</div>\n";
	} else {
		echo "<div class='text'>Unable to update user's status. Contact site admin.\n";
	}
}
}

//if no user was selected, go to staff list
} else {
	header("Location: staff.php");
	exit;
}

echo "</div>\n";

include "footer.php";
?>
