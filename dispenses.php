<?php include "functions.php";
echo "<title>Dispense record</title>\n";

echo "<div id='main'>";

if (isset($_REQUEST["p"])) {
if (isset($_REQUEST["m"]) && $_REQUEST["m"] === "d") {
	echo "<div class='text'>A new dispense record has been created, you can <a href='account.php' title='create new financial record'>create new financial record</a></div>\n";
}
$patient = $_REQUEST["p"];

$patient_name = "SELECT p_title, p_name, p_occupation FROM patients WHERE patientid = $patient;";
$patientName = connect($patient_name);
	if (mysqli_num_rows($patientName) > 0) {
		while ($pN = mysqli_fetch_assoc($patientName)) {
			echo "<div class='title'>Dispense records for " . $pN["p_title"] . " " .$pN["p_name"] . " (" .$pN["p_occupation"]. ")</div>\n";
		}
	} else {
		header("Location: patients.php");
		exit;
	}
echo "<a href='prescription.php?p=$patient'><button type='submit'><< Go back</button></a>
";
echo "<a href='new-dispense.php?p=$patient' title='New dispense record'><button type='submit'>New dispense record</button></a><br/>\n";

$dispense_records = "SELECT dispid, patientid, disp_lens, disp_frame, disp_accessories, disp_amount, disp_deposit, DATE(disp_duedate) AS disp_duedate, disp_status, d_preparedat, DATE(d_preparedon) AS d_preparedon, d_dispensedat, DATE(d_dispensedon) AS d_dispensedon, disp_comment, branches.branchName FROM dispenses JOIN branches ON dispenses.d_preparedat = branches.branchid WHERE patientid = $patient ORDER BY dispid DESC;";
$dispenseRecord = connect($dispense_records);

if (mysqli_num_rows($dispenseRecord) > 0) {
	while($dR = mysqli_fetch_assoc($dispenseRecord)) {
		echo "<table>\n";
		echo "<tr>\n<th colspan='2'>&nbsp;</th>\n</tr>\n";
		echo "<tr>\n<td>Lens:</td>\n<td>".$dR["disp_lens"]."</td>\n</tr>\n";
		echo "<tr>\n<td>Frame:</td>\n<td>".$dR["disp_frame"]."</td>\n</tr>\n";
		echo "<tr>\n<td>Accessories:</td>\n<td>".$dR["disp_accessories"]."</td>\n</tr>\n";
		echo "<tr>\n<td>Amount:</td>\n<td>".$dR["disp_amount"]."</td>\n</tr>\n";
		echo "<tr>\n<td>Deposit:</td>\n<td>".$dR["disp_deposit"]."</td>\n</tr>\n";
		echo "<tr>\n<td>Status:</td>\n<td>".$dR["disp_status"]."</td>\n</tr>\n";
		echo "<tr>\n<td>Due date:</td>\n<td>";
		?>
		<script type="text/javascript">
   		//split returned into JavaScript compatible format for beautiful date and time

	    var raw_datetime = "<?php echo $dR["due_date"]; ?>";
	    var beaut_date = new Date(raw_datetime);
	    //date
	    var new_date = beaut_date.toDateString();

	    document.write(new_date);
	    </script>
    	<?php
		echo "</td>\n</tr>\n";
		echo "<tr>\n<td>Prepared at:</td>\n<td>".$dR["branchName"]."</td>\n</tr>\n";
		echo "<tr>\n<td>Prepared on:</td>\n<td>";
		?>
		<script type="text/javascript">
   		//split returned into JavaScript compatible format for beautiful date and time

	    var raw_datetime = "<?php echo $dR["d_preparedon"]; ?>";
	    var beaut_date = new Date(raw_datetime);
	    //date
	    var new_date = beaut_date.toDateString();

	    document.write(new_date);
	    </script>
    	<?php
		echo "</td>\n</tr>\n";
		echo "<tr>\n<td>Dispensed at:</td>\n<td>".$dR["branchName"]."</td>\n</tr>\n";
		echo "<tr>\n<td>Dispensed on:</td>\n<td>";
		?>
		<script type="text/javascript">
   		//split returned into JavaScript compatible format for beautiful date and time

	    var raw_datetime = "<?php echo $dR["d_dispensedon"]; ?>";
	    var beaut_date = new Date(raw_datetime);
	    //date
	    var new_date = beaut_date.toDateString();

	    document.write(new_date);
	    </script>
    	<?php
		echo "</td>\n</tr>\n";
		echo "<tr>\n<td>Comment:</td>\n<td>".$dR["disp_comment"]."</td>\n</tr>\n";
		if ($dR["disp_status"] != "Dispensed") {
		$dispense = $dR['dispid'];
		$patient = $dR['patientid'];
		echo "<tr><td colspan='2'><a href='edit-dispense.php?d=$dispense&p=$patient' title='Edit dispense record'><button type='submit'>Edit dispense record</button></a></td></tr>\n";
		}
		echo "</table><br/>\n";
	}
} else {
	echo "<div class='text'>There is no dispense record for the specified patient. <a href='new-dispense.php?p=$patient' title='New dispense record'>Create a new dispense record.</a></div>";
}
} else {
	header("Location: patients.php");
	exit;
}
echo "<div class='title'>Help</div>\n";
help_dispense_record();
echo "</div>\n";
include "footer.php";
?>
