<?php include "functions.php";

echo "<div id='main'>";
//make sure a patient is selected (otherwise, return to patients' list) and retrieve info about that patient
if (isset($_REQUEST["p"])) {
	$patientId = $_REQUEST["p"];
	$patient_details = "SELECT patientid, p_title, p_name, p_sex, p_occupation, p_num1, p_num2, p_num3, p_num4, p_mail, p_debt, p_address, comment, reg_at, DATE(reg_date) AS rDate, branches.branchName FROM patients JOIN branches ON patients.reg_at = branches.branchid WHERE patientid = $patientId;";
	$patientDetails = connect($patient_details);

//display basic info about the selected patient
if (mysqli_num_rows($patientDetails) > 0) {
	echo "<table>\n";
	echo "<tr>\n<th colspan='2'>Patient's info</th>\n</tr>";
	$pD = mysqli_fetch_assoc($patientDetails);
		echo "<title>".$pD["p_title"]."&nbsp;".$pD["p_name"]."</title>";
		echo "<tr>\n<td>Name</td>\n<td>".$pD["p_title"]." ".$pD["p_name"]."</td>\n</tr>\n";
		echo "<tr>\n<td>Sex</td>\n<td>".$pD["p_sex"]."</td>\n</tr>\n";
		echo "<tr>\n<td>Occupation</td>\n<td>".$pD["p_occupation"]."</td>\n</tr>\n";
		echo "<tr>\n<td>Phone number 1</td>\n<td>0".$pD["p_num1"]."</td>\n</tr>\n";
		echo "<tr>\n<td>Phone number 2</td>\n<td>".$pD["p_num2"]."</td>\n</tr>\n";
		echo "<tr>\n<td>Phone number 3</td>\n<td>".$pD["p_num3"]."</td>\n</tr>\n";
		echo "<tr>\n<td>Phone number 4</td>\n<td>".$pD["p_num4"]."</td>\n</tr>\n";
		echo "<tr>\n<td>e-mail</td>\n<td>".$pD["p_mail"]."</td>\n</tr>\n";
		echo "<tr>\n<td>Address</td>\n<td>".$pD["p_address"]."</td>\n</tr>\n";
		echo "<tr>\n<td>Owing:</td>\n<td>N ". $pD["p_debt"]."</td>\n</tr>\n";
		echo "<tr>\n<td>Comment:</td>\n<td>". $pD["comment"]."</td>\n</tr>\n";
		echo "<tr>\n<td>Registered on:</td>\n<td>";
		?>
		<script type="text/javascript">
	    //split returned into JavaScript compatible format for beautiful date and time

	    var raw_datetime = "<?php echo $pD["rDate"]; ?>";
	    var beaut_date = new Date(raw_datetime);
	    //date
	    var new_date = beaut_date.toDateString();

	    document.write(new_date);
	    </script>
		<?php
		echo "</td>\n</tr>\n";
		echo "<tr>\n<td>Registered at:</td>\n<td>". $pD["branchName"]."</td>\n</tr>\n";
		$patId = $pD["patientid"];
	echo "</table><br/>\n";

echo "&nbsp;<a href='new-prescription.php?p=$patientId'><button type='submit'>New prescription</button></a>\n";
echo "<a href='dispenses.php?p=$patId'><button type='submit'>Dispense history</button></a>\n";
echo "<a href='edit-patient.php?p=$patId'><button type='submit'>Edit profile</button></a><br/>\n";

//list all prescription history for the selected patient
$prescription_history = "SELECT presc_date, pat_age, pres_od, pres_os, comment, tinting, complaints, drugs, to_pay, patientid, branchName FROM prescriptions JOIN branches ON branches.branchid=prescriptions.branchId WHERE patientId = $patientId ORDER BY presc_date DESC;";
$prescriptionHistory = connect($prescription_history);
if (mysqli_num_rows($prescriptionHistory) > 0) {
	while ($pH = mysqli_fetch_assoc($prescriptionHistory)) {
		echo "<table border-collapse: collapse;>\n";
		echo "<tr>\n<th colspan='2'>";
		?>
		<script type="text/javascript">
	    //split returned into JavaScript compatible format for beautiful date and time

	    var raw_datetime = "<?php echo $pH["presc_date"]; ?>";
	    var datetime_split = raw_datetime.split(" ");
    var date = datetime_split[0];
    var time = datetime_split[1];

    var new_datetime = date + "T" + time + "+01:00"; //YYYY-MM-MMTHH:MM:SS+01:00

    var beaut_date = new Date(new_datetime);

    //time
    var new_time = beaut_date.toLocaleTimeString();
    //date
    var new_date = beaut_date.toDateString();

    document.write(new_time + " " + new_date);
	    </script>
		<?php
		echo "</th>\n</tr>";
		echo "<tr>\n<td>Branch:</td><td>".$pH["branchName"]."</td>\n</tr>";
		echo "<tr>\n<td>Age:</td><td>".$pH["pat_age"]."</td>\n</tr>";
		echo "<tr>\n<td>OD:</td><td>".$pH["pres_od"]."</td>\n</tr>";
		echo "<tr>\n<td>OS:</td><td>".$pH["pres_os"]."</td>\n</tr>";
		echo "<tr>\n<td>Tinting:</td><td>".$pH["tinting"]."</td>\n</tr>";
		echo "<tr>\n<td>Complaints:</td><td>".$pH["complaints"]."</td>\n</tr>";
		echo "<tr>\n<td>Comment:</td><td>".$pH["comment"]."</td>\n</tr>";
		echo "<tr>\n<td>Drugs:</td><td>".$pH["drugs"]."</td>\n</tr>";
		echo "<tr>\n<td>Fee:</td><td>".$pH["to_pay"]."</td>\n</tr>";
		echo "</table><br/>";
	}
} else {
	echo "<div class='text'>There is no prescription history for the selected patient.</div>\n";
}

} else {
	//if no user is found go to patients.php
	header("Location: patients.php");
	exit;
}
} else {
	//if no user is selected in the query string, go to patients.php
	header("Location: patients.php");
	exit;
}
echo "<div class='title'>Help</div>\n";
help_info_prescription();
echo "</div>\n";

include "footer.php";
?>
