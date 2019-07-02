<?php include "functions.php";
echo "<title>Patients</title>";

echo "<div id='main'>";

echo "<form action='patients.php' action='POST'>\n";
echo "<input type='text' name='s' placeholder='Search for patient' required='required'><br/>\n";
echo "<button type='submit'>Search patients</button>\n";
echo "</form><br/>\n";

// this page is not perfect yet -- the search function and splitting search result into pages
//a cool way to show all patients in alphabetical order by clicking links
// the array below removes the redundancy of typing all the letters as links
echo "<div class='text'>Show names starting with: <br/>";
$Alphabet = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");

foreach ($Alphabet as $letter) {
	$letter = test_input($letter);
    echo "<a href='patients.php?pn=$letter' title='Names starting with $letter'> $letter </a>";
}
echo "</div>";

//from the Alpha-links above, fetch the value of the 'pn' query string
if (isset($_REQUEST["pn"])) {
	$query = test_input($_REQUEST["pn"]);
	//search for the patient with that id
	$searchPatients = "SELECT patientid, p_title, p_name, p_occupation, p_num1, p_num2 FROM patients WHERE p_name LIKE '$query%';";
	$search = connect($searchPatients);
	if (mysqli_num_rows($search) > 0) {

	//print the patient's info
	while ($aP = mysqli_fetch_assoc($search)) {
	echo "<div class='text'>\n<a href='prescription.php?p=".$aP["patientid"]."'>".$aP["p_title"]." ".$aP["p_name"]."</a><br/>\n";
	echo $aP["p_occupation"] . "&nbsp;" . "<a href='tel:".$aP["p_num1"]."'>".$aP["p_num1"]."</a>&nbsp;" . "<a href='tel:".$aP["p_num2"]."'>".$aP["p_num2"]."</a></div>\n";
	}
	} else {
		echo "There are no patients to display at the moment";
	}
} else if (isset($_GET["s"])) {
	//if the search button was clicked, the query string name is 's'
	//fetch that and query the database for the users info
	$query = test_input($_GET["s"]);
	if($query != "") {
	//ensure that the input field is not blank. If blank, the user will be able to view all patients if the Search button is clicked twice
	$searchPatients = "SELECT patientid, p_title, p_name, p_occupation, p_num1, p_num2 FROM patients WHERE p_name LIKE '%$query%';";
	$search = connect($searchPatients);
	if (mysqli_num_rows($search) > 0) {
	while ($aP = mysqli_fetch_assoc($search)) {
	echo "<div class='text'>\n<a href='prescription.php?p=".$aP["patientid"]."'>".$aP["p_title"]." ".$aP["p_name"]."</a><br/>\n";
	echo $aP["p_occupation"] . "&nbsp;" . "<a href='tel:".$aP["p_num1"]."'>".$aP["p_num1"]."</a>&nbsp;" . "<a href='tel:".$aP["p_num2"]."'>".$aP["p_num2"]."</a></div>\n";
	}
	} else {
		echo "There are no patients to display at the moment";
	}
	}
}

 else {
//if the query string is empty, list all patients, starting with the most recent
// the same result is achieved if the search button is clicked twice without entering any value in the input field
$branch = $_SESSION["branchid"];
//can the user view patients registered in other branches?
if(	$_SESSION['perm_patients'] === "global") {
	$searchPatients = "SELECT patientid, p_title, p_name, p_occupation, p_num1, p_num2 FROM patients ORDER BY reg_date DESC;";
} else {
$searchPatients = "SELECT patientid, p_title, p_name, p_occupation, p_num1, p_num2 FROM patients WHERE reg_at = $branch ORDER BY reg_date DESC;";
}
$search = connect($searchPatients);
if (mysqli_num_rows($search) > 0) {
while ($aP = mysqli_fetch_assoc($search)) {
echo "<div class='text'>\n<a href='prescription.php?p=".$aP["patientid"]."'>".$aP["p_title"]." ".$aP["p_name"]."</a><br/>\n";
echo $aP["p_occupation"] . "&nbsp;" . "<a href='tel:".$aP["p_num1"]."'>".$aP["p_num1"]."</a>&nbsp;" . "<a href='tel:".$aP["p_num2"]."'>".$aP["p_num2"]."</a></div>\n";
}

} else {
	echo "There are no patients to display at the moment";
}
}
echo "<div class='title'>Help</div>\n";
help_patients_info();
echo "</div>";

include "footer.php";
?>
