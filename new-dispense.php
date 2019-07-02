<?php include "functions.php";
echo "<title>New dispense record</title>";
if (isset($_REQUEST["p"])) {
	$patient = $_REQUEST["p"];
	$branch = $_SESSION["branchid"];

	$show_branches = "SELECT branchName, branchid FROM branches WHERE branchName != 'Warehouse';";
	$showBranches = connect($show_branches);
	$branchesAgain = connect($show_branches);

if (isset($_POST["new_dispense"])) {
	$lens = test_input($_POST["lens"]);
	$frame = test_input($_POST["frame"]);
	$accessories = test_input($_POST["accessories"]);
	$amount = test_input($_POST["amount"]);
	$deposit = test_input($_POST["deposit"]);
	$dueDate = test_input($_POST["due_date"]);
	$status = test_input($_POST["status"]);
	$preparedAt = test_input($_POST["prepared_at"]);
	$preparedOn = test_input($_POST["prepared_on"]);
	$dispensedAt = test_input($_POST["dispensed_at"]);
	$dispensedOn = test_input($_POST["dispensed_on"]);
	$comment = test_input($_POST["comment"]);

	$new_dispense = "INSERT INTO dispenses (patientid, disp_lens, disp_frame, disp_accessories, disp_amount, disp_deposit, disp_duedate, disp_status, d_preparedat, d_preparedon, d_dispensedat, d_dispensedon, disp_comment) VALUES ($patient, '$lens', '$frame', '$accessories', $amount, $deposit, '$dueDate', '$status', '$preparedAt', '$preparedOn', '$dispensedAt', '$dispensedOn', '$comment');";
	$newDispense = connect($new_dispense);
	if ($newDispense) {
		header("Location: dispenses.php?p=$patient&m=d");
		exit;
	}
}
?>
<div id='main'>
<div class='title'>New dispense record</div>
<a href='prescription.php?p=<?php echo $patient; ?>'><button type='submit'>Go back</button></a>

<form action='new-dispense.php?p=<?php echo $patient; ?>' method='POST'>
Frame: <br/>
<input type='text' name='frame' placeholder='Frame'><br/>
Lens:<br/>
<textarea name='lens' placeholder='+000 -000'></textarea><br/>
Accessories:<br/>
<textarea name='accessories' placeholder='Cases, Dusters, Suspenders etc'></textarea><br/>
Amount:<br/>
<input type='number' name='amount' value='0'><br/>
Deposit:<br/>
<input type='number' name='deposit' value='0'><br/>
Due date:<br/>
<input type='text' name='due_date' value='<?php date_is(); ?>' placeholder='YYYY-MM-DD'><br/>
Status:<br/>
<select name='status'>
<option value='Pending'>Pending</option>
<option value='Prepared'>Prepared</option>
<option value='Dispensed'>Dispensed</option>
</select><br/>
Prepared at:<br/>
<select name='prepared_at'>
<?php
while($sb =mysqli_fetch_assoc($showBranches)) {
	$branchid = $sb["BranchId"];
	echo "<option value='".$sb["branchid"]."'>".$sb["branchName"]."</option>\n";
}
?>
</select><br/>
Prepared on:<br/>
<input type='text' name='prepared_on' value='<?php date_is(); ?>'><br/>
Dispensed at:<br/>
<select name='dispensed_at'>
<?php
while($ba =mysqli_fetch_assoc($branchesAgain)) {
	$branchid = $sb["BranchId"];
	echo "<option value='".$ba["branchid"]."'>".$ba["branchName"]."</option>\n";
}
?>
</select><br/>
Dispensed on:<br/>
<input type='text' name='dispensed_on' value='<?php date_is(); ?>'><br/>
Comment:<br/>
<textarea name='comment' placeholder='Your comment'></textarea><br/>
<button type='submit' name='new_dispense'>Submit</button>
</form>

<?php
} else {
	header("Location:patients.php");
	exit;
}

echo "<div class='title'>Help</div>\n";
help_new_dispense();
echo "</div>\n";
include "footer.php";?>
