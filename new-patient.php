<?php include "functions.php";

echo "<title>New patient</title>";
echo "<div id='main'>";
echo "<div class='title'>Register new patient</div>";

//a function for the registration form there are like three instances of the registration form
//on this page alone, two of which are similar so this function will display the form with empty values
function new_patient() {
echo '<form action="new-patient.php" method="POST">';
echo 'Title: <br/>';
echo '<select name="p_title">';
echo '<option value="Miss">Miss</option>';
echo '<option value="Mr">Mr</option>';
echo '<option value="Mrs">Mrs</option>';
echo '</select><br/>';
echo 'Name:<br/>';
echo '<input type="text" name="p_name" placeholder="Patient\'s name" value="" required="required"><br/>';
echo 'Sex:<br/>';
echo '<select name="p_sex" required="required">';
echo '<option value="Female">Female</option>';
echo '<option value="Male">Male</option>';
echo '<option value="Other">Other</option>';
echo '</select><br/>';
echo 'Occupation:<br/>';
echo '<input type="text" name="p_occupation" placeholder="Patient\'s occupation" value=""><br/>';
echo 'Address: <br/>';
echo 'Phone number 1: <br/>';
echo '<input type="number" name="p_number1" placeholder="Patient\'s number" value="" required="required"><br/>';
echo 'Phone number 2: <br/>';
echo '<input type="number" name="p_number2" placeholder="Patient\'s number" value=""><br/>';
echo 'Phone number 3: <br/>';
echo '<input type="number" name="p_number3" placeholder="Patient\'s number" value=""><br/>';
echo 'Phone number 4: <br/>';
echo '<input type="number" name="p_number4" placeholder="Patient\'s number" value=""><br/>';
echo 'e-mail: <br/>';
echo '<input type="text" name="p_mail" placeholder="Patient\'s e-mail address" value=""><br/>';
echo '<textarea name="p_address"></textarea><br/>';
echo 'Comment: <br/>';
echo '<textarea name="p_comment"></textarea><br/>';
echo '<input type="hidden" name="today" value="';
echo time_date();
echo '"><br/>';
echo '<input type="submit" name="submit" value="Register new patient">';
echo '</form>';
}

//session variables for RegisteredAt and RegisteredBy
$StaffId = $_SESSION["staffid"];
$BranchId = $_SESSION["branchid"];

//if the default form 'submit' or the filled form 'create_new' was submitted
//this is to prevent my having to assign form values to variables twice
if (isset($_POST["submit"]) || isset($_POST["create_new"])){
$pTitle = test_input($_POST["p_title"]);
$pName = test_input($_POST["p_name"]);
$pSex = test_input($_POST["p_sex"]);
$pNum1 = test_input($_POST["p_number1"]);
$pNum2 = test_input($_POST["p_number2"]);
$pNum3 = test_input($_POST["p_number3"]);
$pNum4 = test_input($_POST["p_number4"]);
$pMail = test_input($_POST["p_mail"]);
$pAddress = test_input($_POST["p_address"]);
$pOccupation = test_input($_POST["p_occupation"]);
$pComment = test_input($_POST["p_comment"]);
$today = test_input($_POST["today"]);

//search in the Patients table for the same title (works for sex), name and the first phone number
//the combination of these should give a unique value i.e. only one patient should have all of these
//information. This is to prevent a situation in which many profiles will be created for the same
// patient
$search_patients = "SELECT patientid, p_title, p_name, p_num1 FROM patients WHERE p_title = '$pTitle' AND p_name = '$pName' AND p_num1 = '$pNum1';";
$searchPatients = connect($search_patients);

if (mysqli_num_rows($searchPatients) > 0) {
//if a match is found
	//I figured (I saw the tip somewhere) that if I'm not spilling values continuously from the table
	//I don't need a while loop to retrieve the query, I can assign it to one variable
	$sp = mysqli_fetch_assoc($searchPatients);
	$pname = $sp["p_name"];
	echo "<div class='text'>There is a match in the Patients record with the infomation you provided. Do you want to:<br/>\n";
	//use the search box of the patients.php page to search for all patients with the same name
	echo "<a href='patients.php?s=$pname'><button type='submit'>Show all matches</button></a><br/>\n";

//display another form with name 'create_new' to have the value the user provided for the patient on
// the previous page. If the form is submitted (Register new patient anyway) a new patient record
// is now created
echo '<form action="new-patient.php" method="POST">';
//the div .text opened above is closed here and the form can also be submitted at the top
echo '<button type="submit" name="create_new">Register new patient anyway</button></div>';

$pTitle = test_input($_POST["p_title"]);
$pName = test_input($_POST["p_name"]);
$pSex = test_input($_POST["p_sex"]);
$pNum1 = test_input($_POST["p_number1"]);
$pNum2 = test_input($_POST["p_number2"]);
$pNum3 = test_input($_POST["p_number3"]);
$pNum4 = test_input($_POST["p_number4"]);
$pMail = test_input($_POST["p_mail"]);
$pAddress = test_input($_POST["p_address"]);
$pOccupation = test_input($_POST["p_occupation"]);
$pComment = test_input($_POST["p_comment"]);
$today = test_input($_POST["today"]);
$BranchId = $_SESSION["branchid"];

echo 'Title: <br/>';
echo '<select name="p_title">';
//isset_select($foo, $bar) is a user-defined function in function.php
echo '<option value="Mr"'. isset_select($pTitle, "Mr").'>Mr.</option>';
echo '<option value="Mrs"'. isset_select($pTitle, "Mrs").'>Mrs.</option>';
echo '<option value="Miss"'. isset_select($pTitle, "Miss").'>Miss</option>';
echo '</select><br/>';
echo 'Name:<br/>';
echo '<input type="text" name="p_name" placeholder="Patient\'s name" value="'.$pName.'" required="required"><br/>';
echo 'Sex:<br/>';
echo '<select name="p_sex">';
echo '<option value="Female"'. isset_select($pSex, "Female").'>Female</option>';
echo '<option value="Male"'. isset_select($pSex, "Male").'>Male</option>';
echo '<option value="Other"'. isset_select($pSex, "Other").'>Other</option>';
echo '</select><br/>';
echo 'Phone number 1: <br/>';
echo '<input type="number" name="p_number1" placeholder="Patient\'s number" value="'.$pNum1.'" required="required"><br/>';
echo 'Phone number 2: <br/>';
echo '<input type="number" name="p_number2" placeholder="Patient\'s number" value="'.$pNum2.'"><br/>';
echo 'Phone number 3: <br/>';
echo '<input type="number" name="p_number3" placeholder="Patient\'s number" value="'.$pNum3.'"><br/>';
echo 'Phone number 4: <br/>';
echo '<input type="number" name="p_number4" placeholder="Patient\'s number" value="'.$pNum4.'"><br/>';
echo 'e-mail: <br/>';
echo '<input type="e-mail" name="p_mail" placeholder="Patient\'s e-mail address" value="'.$pMail.'"><br/>';
echo 'Occupation:<br/>';
echo '<input type="text" name="p_occupation" placeholder="Patient\'s occupation" value="'.$pOccupation.'"><br/>';
echo 'Address: <br/>';
echo '<textarea name="p_address" placeholder="Patient\'s address">'.$pAddress.'</textarea><br/>';
echo 'Comment: <br/>';
echo '<textarea name="p_comment" placeholder="Your comment">'.$pComment.'</textarea><br/>';
echo '<input type="hidden" name="today" value="';
echo time_date();
echo '"><br/>';
echo '<button type="submit" name="create_new">Register new patient anyway</button>';
echo '</form>';

//if the filled (create_new) form is submitted, insert the record
	if(isset($_POST["create_new"])) {
		$make_patients = "INSERT INTO patients (p_title, p_name, p_sex, p_num1, p_num2, p_num3, p_num4, p_mail, p_address, p_occupation, reg_by, reg_at, reg_date, comment) VALUES ('$pTitle', '$pName', '$pSex', '$pNum1', '$pNum2', '$pNum3', '$pNum4', '$pMail', '$pAddress', '$pOccupation', $StaffId, $BranchId, $today, '$pComment');";
	$makepatients = mysqli_query($conn, $make_patients);
	if ($makepatients) {
	//if the record was created successfully, redirect the user to this same page with query string
	// and their values set to alert the staff and show a personalized message
	//get the id of the newly created record so that the specified patient's record can be seen
	//or, in this case, prescription can be added for that specific user
	$patient_id = mysqli_insert_id($conn);
	header("Location: new-patient.php?pid=$patient_id&pt=$pTitle&pn=$pName");
	exit;
	//display the registration form... cool, uhm?
	//if another Patient is to be enrolled
	new_patient();
	} else {
	echo "<div class='text'>Unable to enrol new patient, contact site administrator. Failure after match found</div>\n";
	}

	}

} else {
	//if no match is found, go ahead and register the new record
	$pTitle = test_input($_POST["p_title"]);
	$pName = test_input($_POST["p_name"]);
	$pSex = test_input($_POST["p_sex"]);
	$pNum1 = test_input($_POST["p_number1"]);
	$pNum2 = test_input($_POST["p_number2"]);
	$pNum3 = test_input($_POST["p_number3"]);
	$pNum4 = test_input($_POST["p_number4"]);
	$pMail = test_input($_POST["p_mail"]);
	$pAddress = test_input($_POST["p_address"]);
	$pOccupation = test_input($_POST["p_occupation"]);
	$pComment = test_input($_POST["p_comment"]);
	$today = test_input($_POST["today"]);
	$BranchId = $_SESSION["branchid"];

	$make_patients = "INSERT INTO patients (p_title, p_name, p_sex, p_num1, p_num2, p_num3, p_num4, p_mail, p_address, p_occupation, reg_by, reg_at, reg_date, comment) VALUES ('$pTitle', '$pName', '$pSex', '$pNum1', '$pNum2', '$pNum3', '$pNum4', '$pMail', '$pAddress', '$pOccupation', $StaffId, $BranchId, '$today', '$pComment');";
	$makepatients = mysqli_query($conn, $make_patients);
	if ($makepatients) {
	//get the id of the newly created record and reload the page with query string
	$patient_id = mysqli_insert_id($conn);
	header("Location: new-patient.php?pid=$patient_id&pt=$pTitle&pn=$pName");
	exit;
	//display the registration form
	new_patient();
	} else {
	echo "<div class='text'>Unable to enrol new patient, contact site administrator. NO match, yet failure</div>\n";
	}
	}

} else {
//if a query string is set. All the keys in the query string must have values before the message is
//displayed that why && (AND) is used instead of || (OR)
if(isset($_REQUEST["pt"]) && isset($_REQUEST["pt"]) && ($_REQUEST["pt"] != "") && ($_REQUEST["pt"] != "") && isset($_REQUEST["pid"])) {
	//a message to show that new registration is successful
	//a registration form is displayed below the message and everything still works alrigh
	//if reload is pressed the message is diplayed again but the form is not submitted again
	//if the form is filled, the values is sent to new.patient.php and the previous submission is
	//forgotten
	echo "<div class='text'>" .$_REQUEST["pt"]. " ".$_REQUEST["pn"]. "'s record created successfully!<br/>\n";
	echo "<a href='new-prescription.php?p=".$_REQUEST["pid"]."'>Add prescription</a></div>\n";
}

//if no form has been submitted, if no match was found, display a form with no values with a function
new_patient();

}
echo "<div class='title'>Help</div>\n";
help_new_patient();
echo "</div>\n";

include "footer.php"; ?>
