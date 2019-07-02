<?php include "functions.php";

echo "<div id='main'>\n";

//Update the recorded user info
//make sure a _valid_ user is selected
//find a smart way to redirect the user to patients.php if an alphabet or such-like character is passed as the value of p
//select details of the user with that id (lazy)
if (isset($_REQUEST["p"])) {
	//the value of the query string is assigned to variable 'pId' here
	//this value is then passed as the value of the hidden form element 'patientid'
	$pId = test_input($_REQUEST["p"]);
	$patient_info = "SELECT patientid, p_title, p_name, p_sex, p_num1, p_num2, p_num3, p_num4, p_mail, p_occupation, p_address, p_debt, comment FROM patients WHERE patientid = $pId;";
	$patientinfo = connect($patient_info);

echo "<a href='prescription.php?p=$pId'><button type='submit'><< Go Back</button></a>\n";

//update info
//was the 'submit' button clicked?
//assign the value of the input field to variables
if (isset($_POST["submit"])) {
	$ptitle = test_input($_POST["p_title"]);
	$pname = test_input($_POST["p_name"]);
	$psex = test_input($_POST["p_sex"]);
	$pnum1 = test_input($_POST["p_number1"]);
	$pnum2 = test_input($_POST["p_number2"]);
	$pnum3 = test_input($_POST["p_number3"]);
	$pnum4 = test_input($_POST["p_number4"]);
	$pmail = test_input($_POST["p_mail"]);
	$poccupation = test_input($_POST["p_occupation"]);
	$paddress = test_input($_POST["p_address"]);
	$pcomment = test_input($_POST["p_comment"]);
	$powing = test_input($_POST["p_owing"]);
	$patId = test_input($_POST["patientid"]); //pId as been redefined as patId here to prevent confusion in SQL query
	$staffid = $_SESSION["staffid"];

	$update_info = "UPDATE patients SET p_title = '$ptitle', p_name = '$pname', p_sex = '$psex', p_num1 = '$pnum1', p_num2 = '$pnum2', p_num3 = '$pnum3', p_num4 = '$pnum4', p_mail = '$pmail', p_occupation = '$poccupation', p_address = '$paddress', comment = '$pcomment', p_debt = '$powing', reg_by = '$staffid' WHERE patientid = $patId;";
	$updateInfo = connect($update_info);
	if ($updateInfo) {
		header("Location: edit-patient.php?p=$patId");
		exit;
	} else {
		echo "<div class='text'>Unable to perform the update at the moment, contact site admin.</div>\n";
	}
}

	if (mysqli_num_rows($patientinfo) > 0) {
		while ($pi = mysqli_fetch_assoc($patientinfo)) {
			echo "<title>Edit ".$pi["p_title"]."&nbsp;".$pi["p_name"]."</title>\n";

		echo '<form action="edit-patient.php?p='.$pId.'" method="POST">';
		echo "Title:<br/>\n";
		echo '<select name="p_title">';
		echo '<option value="Miss"';
		isset_select($pi["p_title"], "Miss");
		echo '>Miss</option>';
		echo '<option value="Mr"';
		isset_select($pi["p_title"], "Mr");
		echo '>Mr</option>';
		echo '<option value="Mrs"';
		isset_select($pi["p_title"], "Mrs");
		echo '>Mrs</option>';
		echo '</select><br/>';
		echo 'Name:<br/>';
		echo '<input type="text" name="p_name" placeholder="Patient\'s name" value="'.$pi["p_name"].'" required="required"><br/>';
		echo 'Sex:<br/>';
		echo '<select name="p_sex">';
		echo '<option value="Female"';
		isset_select($pi["p_sex"], "Female");
		echo '>Female</option>';
		echo '<option value="Male"';
		isset_select($pi["p_sex"], "Male");
		echo '>Male</option>';
		echo '<option value="Other"';
		isset_select($pi["p_sex"], "Other");
		echo '>Other</option>';
		echo '</select><br/>';
    	echo 'Occupation:<br/>';
		echo '<input type="text" name="p_occupation" placeholder="Patient\'s occupation" value="'.$pi["p_occupation"].'"><br/>';
		echo 'Phone number 1: <br/>';
		echo '<input type="number" name="p_number1" placeholder="Patient\'s number" value="'.$pi["p_num1"].'" required="required"><br/>';
		echo 'Phone number 2: <br/>';
		echo '<input type="number" name="p_number2" placeholder="Patient\'s number" value="'.$pi["p_num2"].'"><br/>';
		echo 'Phone number 3: <br/>';
		echo '<input type="number" name="p_number3" placeholder="Patient\'s number" value="'.$pi["p_num3"].'"><br/>';
		echo 'Phone number 4: <br/>';
		echo '<input type="number" name="p_number4" placeholder="Patient\'s number" value="'.$pi["p_num4"].'"><br/>';
		echo 'e-mail: <br/>';
		echo '<input type="e-mail" name="p_mail" placeholder="Patient\'s e-mail address" value="'.$pi["p_mail"].'"><br/>';
		echo "Debt:<br/>\n";
		echo 'N<input type="number" name="p_owing" placeholder="Debt" value="'.$pi["p_debt"].'"><br/>';
		echo 'Address: <br/>';
		echo '<textarea name="p_address" placeholder="Patient\'s address">'.$pi["p_address"].'</textarea><br/>';
		echo 'Note: <br/>';
		echo '<textarea name="p_comment" placeholder="Your comment">'.$pi["comment"].'</textarea><br/>';
		echo '<input type="hidden" name="patientid" value="'.$pId.'">';
		echo '<input type="submit" name="submit" value="Update '.$pi["p_name"].'\'s info">';
		echo '</form>';

		}

	} else {
		//if no user exist with that id, return to patients.php
		//may work in cases when the query string has been tampered with
		header("Location: patients.php");
		exit;
	}

} else {
	//if no query string value is attached, go to patients.php
		header("Location: patients.php");
		exit;
	}
echo "<div class='title'>Help</div>\n";
help_edit_patient();
echo "</div>";

include "footer.php";
?>
