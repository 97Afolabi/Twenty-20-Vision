<?php include "functions.php";
//is a dispense record and patient selected?
if (isset($_REQUEST["d"]) && isset($_REQUEST["p"])) {
echo "<title>Edit dispense record</title>\n";
echo "<div id='main'>\n";
echo "<div class='title'>Edit dispense record</div>\n";
if (isset($_REQUEST["m"])) {
	echo "<div class='text'>\n";
	if($_REQUEST["m"] === "s") {
		echo "Dispense record edited successfully!";
	} else {
		echo "Unable to edit record. Contact site admin";
	}
	echo "</div>\n";
}
$dispense = test_input($_REQUEST["d"]);
$patient = test_input($_REQUEST["p"]);
//show dispense details
$dispense_records = "SELECT dispid, patientid, disp_lens, disp_frame, disp_accessories, disp_amount, disp_deposit, DATE(disp_duedate) AS disp_duedate, disp_status, d_preparedat, DATE(d_preparedon) AS d_preparedon, d_dispensedat, DATE(d_dispensedon) AS d_dispensedon, disp_comment, branches.branchid FROM dispenses JOIN branches ON dispenses.d_preparedat = branches.branchid WHERE patientid = $patient AND dispid = $dispense;";
$dispenseRecord = connect($dispense_records);
//show branches
$show_branches = "SELECT branchName, branchid FROM branches WHERE branchName != 'Warehouse';";
$showBranches = connect($show_branches);
$branchesAgain = connect($show_branches);
//display results
if (mysqli_num_rows($dispenseRecord) > 0) {
	$dispid = $_REQUEST["d"];
	$patient = $_REQUEST["p"];
	//'Back' button
	echo "<a href='dispenses.php?p=$patient' title='Dispense history'><button type='submit'><< Go back</button></a><br/><br/>\n";
	while($dR = mysqli_fetch_assoc($dispenseRecord)) {
		echo "<form action='edit-dispense.php?d=$dispid&p=$patient' method='POST'>\n";
        echo "Frame:<br/>\n";
        echo "<input type='text' name='disp_frame' value='".$dR["disp_frame"]."'/><br/>\n";
        echo "Lens:<br/>\n";
        echo "<textarea name='disp_lens'>".$dR["disp_lens"]."</textarea><br/>\n";
        echo "Accessories:<br/>\n";
        echo "<textarea name='disp_accessories'>".$dR["disp_accessories"]."</textarea><br/>\n";
        echo "Amount:<br/>\n";
        echo "<input type='text' name='disp_amount' value='".$dR["disp_amount"]."'/><br/>\n";
        echo "Deposit:<br/>\n";
        echo "<input type='text' name='disp_deposit' value='".$dR["disp_deposit"]."'/><br/>\n";
        echo "Status:<br/>\n";
        echo "<select name='disp_status'>\n";
        echo "<option value='Pending'";
        isset_select($dR["disp_status"],'Pending');
        echo ">Pending</option>\n";
        echo "<option value='Prepared'";
        isset_select($dR["disp_status"],'Prepared');
        echo ">Prepared</option>\n";
        echo "<option value='Dispensed'";
        isset_select($dR["disp_status"],'Dispensed');
        echo ">Dispensed</option>\n";
        echo "</select><br/>\n";
        echo "Due date:<br/>\n";
        echo "<input type='text' name='due_date' value='".$dR["disp_duedate"]."'/><br/>\n";
		echo "Prepared at:<br/>\n";
		echo "<select name='prepared_at'>";
		while($ba =mysqli_fetch_assoc($branchesAgain)) {
			$branchid = $ba["branchid"]; //for select 'branches'
			$branch = $dR["branchid"]; //for dispense detail
			echo "<option value='".$ba["branchid"]."'";
			isset_select($branch, $branchid);
			echo ">".$ba["branchName"]."</option>\n";
		}
		echo "</select><br/>\n";
		echo "Prepared on:<br/>\n";
		echo "<input type='text' name='prepared_on' value='".$dR["d_preparedon"]."'/><br/>\n";
		echo "Dispensed at:<br/>\n";
		echo "<select name='dispensed_at'>";
		while($sb =mysqli_fetch_assoc($showBranches)) {
			$branchid = $sb["branchid"]; //for select 'branches'
			$branch = $dR["branchid"]; //for dispense detail
			echo "<option value='".$sb["branchid"]."'";
			isset_select($branch, $branchid);
			echo ">".$sb["branchName"]."</option>\n";
		}
		echo "</select><br/>\n";
		echo "Dispensed on:<br/>\n";
		echo "<input type='text' name='dispensed_on' value='".$dR["d_dispensedon"]."'/><br/>\n";
        echo "Comment:<br/>\n";
        echo "<textarea name='comment'>".$dR["disp_comment"]."</textarea><br/>\n";
		echo "<button type='submit' name='edit'>Edit dispense record</button><br/>\n";
		echo "</form>\n";
}
if (isset($_POST["edit"])) {
	$frame = test_input($_POST['disp_frame']);
	$lenses = test_input($_POST['disp_lens']);
	$accessories = test_input($_POST['disp_accessories']);
	$amount = test_input($_POST['disp_amount']);
	$deposit = test_input($_POST['disp_deposit']);
	$status = test_input($_POST['disp_status']);
	$due_date = test_input($_POST['due_date']);
	$prepared_at = test_input($_POST['prepared_at']);
	$prepared_on = test_input($_POST['prepared_on']);
	$dispensed_at = test_input($_POST['dispensed_at']);
	$dispensed_on = test_input($_POST['dispensed_on']);
	$comment = test_input($_POST['comment']);
	$dispid = $_REQUEST["d"];
	$patient = $_REQUEST["p"];

	$update_dispense = "UPDATE dispenses SET disp_frame = '$frame', disp_lens = '$lenses', disp_accessories = '$accessories', disp_amount = '$amount', disp_deposit = '$deposit', disp_status = '$status', disp_duedate = '$due_date', d_preparedat = $prepared_at, d_preparedon = '$prepared_on', d_dispensedat = '$dispensed_at', d_dispensedon = '$dispensed_on', disp_comment = '$comment' WHERE dispid = $dispid AND patientid = $patient;";
	$updateDispense = connect($update_dispense);
	if($updateDispense) {
		header("Location: edit-dispense.php?p=$patient&d=$dispid&m=s");
		exit;
	} else {
		header("Location: edit-dispense.php?p=$patient&d=$dispid&m=f");
		exit;
	}
}
}
} else {
    //if a patient and dispense record is not specified, go to the Patients page
    header("Location: patients.php");
    exit;
}

echo "</div>\n";
include "footer.php";
