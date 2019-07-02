<?php include "functions.php";

echo "<title>New prescription</title>\n";

echo "<div id='main'>";
if (isset($_REQUEST["p"])) {
	$patientID = $_REQUEST["p"];

// placing the SQL code above ensures that output messages will be diplayed at the top instead of the bottom of the page
if (isset($_POST["new_prescription"])) {
	$paID = $_POST["patId"];
	$age = test_input($_POST["age"]);
	$prescOD = test_input($_POST["presc_OD"]);
	$prescOS = test_input($_POST["presc_OS"]);
	$tinting = test_input($_POST["tinting"]);
	$complaints = test_input($_POST["complaints"]);
	$drugs = test_input($_POST["drugs"]);
	$comment = test_input($_POST["comment"]);
	$duedate = test_input($_POST["due_date"]);
	$fee = test_input($_POST["to_pay"]);
	$today = test_input($_POST["today"]);
	$next_appt = test_input($_POST["next_appointment"]);
	$BranchId = $_SESSION["branchid"];

	$new_prescription = "INSERT INTO prescriptions (patientid, pat_age, presc_date, pres_od, pres_os, tinting, complaints, drugs, comment, to_pay, next_appointment, branchid) VALUES ($paID, $age, '$today', '$prescOD', '$prescOS', '$tinting', '$complaints', '$drugs', '$comment', $fee, '$next_appt', $BranchId);";
	$newPrescription = connect($new_prescription);
	if ($newPrescription) {
		header("Location: prescription.php?p=$paID");
		exit;
	} else {
		echo "Unable to register new prescription at the moment. Please, contact the site admin\n";
	}
}

echo "<a href='prescription.php?p=$patientID'><button type='submit'><< Go Back</button></a>\n";

//getting this page and other pages like it to work wasn't easy because it seems all methods of persisting the id needed fails
//however, when I include the needed id in the form action, I got the desired result
// it may not be the best practice, but it's the one I know which works so I'll stick with it till there's a better one
	//the form is presented in the form of a table and it conserves lenght
$patient_info = "SELECT p_name, p_title, p_occupation FROM patients WHERE patientid = $patientID;";
$patientInfo = connect($patient_info);
$si = mysqli_fetch_assoc($patientInfo);

echo "<form action='new-prescription.php?p=".$patientID."' method='POST'>\n";
echo "<div class='title'>New Prescription for ".$si["p_title"]. " ". $si["p_name"]." (".$si["p_occupation"].")</div>\n";
echo "Date:<br/>\n";
echo "<input type='text' name='today' value='";
echo time_date();
echo "'><br/>\n";
echo "Age:<br/>\n";
echo "<input type='number' name='age' value='' required='required'><br/>\n";
echo "OD:<br/>\n";
echo "<input type='text' name='presc_OD' value=''><br/>\n";
echo "OS:<br/>\n";
echo "<input type='text' name='presc_OS' value=''><br/>\n";
echo "Tinting:<br/>\n";
echo "<input type='text' name='tinting' value=''><br/>\n";
echo "Complaints:<br/>\n";
echo "<textarea name='complaints'></textarea><br/>\n";
echo "Drugs:<br/>\n";
echo "<textarea name='drugs'></textarea><br/>\n";
echo "Comment:<br/>\n";
echo "<textarea name='comment'></textarea><br/>\n";
echo "Due date:<br/>\n";
echo "<input type='text' name='due_date' placeholder='YYYY-MM-DD'><br/>\n";
echo "Fee:<br/>\n";
echo "<input type='number' name='to_pay' value='' required='required'><br/>\n";
echo "Date of next appointment:<br/>\n";
echo "<input type='text' name='next_appointment' value='' required='required'><br/>\n";
echo "<input type='hidden' name='patId' value='" . $patientID . "'>\n";
echo "<button type='submit' name='new_prescription'>Submit new prescription</button>\n";
echo "</form>\n";

} else {
	header("Location: patients.php");
	exit;
}
echo "<div class='title'>Help</div>\n";
help_new_prescription();
echo "</div>";

include "footer.php";
