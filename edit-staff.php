<?php include "functions.php";

//is staff a management staff?
isperm_management();

echo "<title>Update staff's profile</title>\n";
echo "<div id='main'>\n";
echo "<div class='title'>Update staff's profile</div>\n";

if (isset($_REQUEST['SId'])) {
//if the form as been submitted then...
$staff_id = $_REQUEST['SId'];

if (isset($_POST['submit'])) {
//assign user inputs to variables
//$user_name = test_input($_POST['user_name']);
$full_name = test_input($_POST['full_name']);
$email = test_input($_POST['email']);
$tele = test_input($_POST['Tele']);
$branchId = test_input($_POST['BranchId']);
$pStock = test_input($_POST['perm_stock']);
$pWarehouse = test_input($_POST['perm_warehouse']);
$pManagement = test_input($_POST['perm_management']);
$pPatients = test_input($_POST['perm_patients']);
$pAppointments = test_input($_POST['perm_appointments']);
$pFinance = test_input($_POST['perm_finance']);


//SQL statement cut to next line -- pythonista-style
//make sure Admin account is always granted all privileges
if ($staff_id === "1") {
    $edit_staff = "UPDATE staff SET branchid='$branchId',
     fullName='$full_name', mailE='$email', phone='$tele',
     perm_stock='global', perm_warehouse='privileged', perm_management='privileged',
     perm_patients='global', perm_appointments = 'privileged', perm_finance = 'privileged' WHERE staffid=$staff_id;";
} else {
$edit_staff = "UPDATE staff SET branchid='$branchId',
 fullName='$full_name', mailE='$email', phone='$tele',
 perm_stock='$pStock', perm_warehouse='$pWarehouse', perm_management='$pManagement',
 perm_patients='$pPatients', perm_appointments = '$pAppointments', perm_finance = '$pFinance' WHERE staffid=$staff_id;";
 }
$editStaff = connect($edit_staff);

 if (!$editStaff) {
	//if user was not added write
	echo "<div class='text'>Unable to update staff's profile now. Contact site admin</div>";
 } else {
	//if profile was edited successfully, reload page
	header("Location: edit-staff.php?SId=$staff_id");
	exit;
 }
} else {
	//default view since user hasn't made any input
?>

<form action="edit-staff.php<?php echo '?SId='.$staff_id; ?>" method="POST">
<table>
	<tr>
	<th>Basic</th>
	</tr>
	<tr>
	<td>
	<?php
$staff_info = "SELECT branchid, fullName, nameU, mailE, phone, status, perm_management, perm_patients, perm_appointments, perm_warehouse, perm_stock, perm_finance FROM staff WHERE staffid=$staff_id;";
$vstaff_info = connect($staff_info);
if (mysqli_num_rows($vstaff_info) > 0) {
	while ($Sinfo = mysqli_fetch_assoc($vstaff_info)) {

//Print a list of all branches into a drop-down for selection
$branches = "SELECT branchid, branchName from branches;";
$vbranches = connect($branches);

//If Branches have been created, print the names and BranchId as values
if (mysqli_num_rows($vbranches) > 0) {
	echo "Assign to branch...<br/>";
	echo "<select name ='BranchId'>\n";
	while ($vb = mysqli_fetch_assoc($vbranches)) {
		echo "<option value='" . $vb['branchid'] . "'";
		isset_select($Sinfo['branchid'], $vb['branchid']);
			echo ">" . $vb['branchName'] . "</option>\n";
	}
	echo "</select>\n";
}
?>
	</td>
	</tr>
	<tr>
	<td>Username: &nbsp;<?php echo $Sinfo['nameU'];?></td>
    </tr>
    <tr>
    <td>Full name:<br/>
    <input type="text" name="full_name" value="<?php echo $Sinfo['fullName'];?>" placeholder="Full name" required="required"></td></tr>
    <tr>
    <td>e-mail:<br/>
    <input type="email" value="<?php echo $Sinfo['mailE'];?>" name="email" placeholder="e-mail"></td></tr>
    <tr>
    <td>Phone number:<br/>
	<input type="text" name="Tele" value="<?php echo $Sinfo['phone'];?>" placeholder="Phone number" required="required"></td></tr>
	</table>
	<table>
	<tr>
	<th>Permissions</th>
	</tr>
	<tr>
	<td>--View Stock inventory in...--<br/>
	<select name="perm_stock">
		<option value="local" <?php isset_select($Sinfo["perm_stock"], "local") ?>>Local branch</option>
		<option value="global" <?php isset_select($Sinfo["perm_stock"], "global") ?>>All branches</option>
	</select>
	</td>
	</tr>
	<tr>
	<td>--Access the Warehouse--<br/>
	<select name="perm_warehouse">
		<option value="unprivileged" <?php isset_select($Sinfo["perm_warehouse"], "unprivileged") ?>>No</option>
		<option value="privileged" <?php isset_select($Sinfo["perm_warehouse"], "privileged") ?>>Yes</option>
	</select>
	</td>
	</tr>
	<tr>
	<td>--View and edit patients' profiles in--<br/>
	<select name="perm_patients">
		<option value="local" <?php isset_select($Sinfo["perm_patients"], "local") ?>>Local branch</option>
		<option value="global" <?php isset_select($Sinfo["perm_patients"], "global") ?>>All branches</option>
	</select>
	</td>
	</tr>
	<tr>
	<td>--Can answer appointments--<br/>
	<select name="perm_appointments">
		<option value="unprivileged" <?php isset_select($Sinfo["perm_appointments"], "unprivileged") ?>>No</option>
		<option value="privileged" <?php isset_select($Sinfo["perm_appointments"], "privileged") ?>>Yes</option>
	</select>
	</td>
	</tr>
	<tr>
	<td>--Manage branches and staff--<br/>
	<select name="perm_management">
		<option value="unprivileged" <?php isset_select($Sinfo["perm_management"], "unprivileged") ?>>No</option>
		<option value="privileged" <?php isset_select($Sinfo["perm_management"], "privileged") ?>>Yes</option>
	</select>
	</td>
	</tr>
	<tr>
	<td>--Manage finance--<br/>
	<select name="perm_finance">
		<option value="unprivileged" <?php isset_select($Sinfo["perm_finance"], "unprivileged") ?>>No</option>
		<option value="privileged" <?php isset_select($Sinfo["perm_finance"], "privileged") ?>>Yes</option>
	</select>
	</td>
	</tr>

	</table>
	<input type="hidden" name="SId" value="<?php echo $_REQUEST['SId'] ?>">
	<button type="submit" name="submit">Update staff's profile</button>
	</form><br/>
	<div class="text">
	<a href="reset-password-admin.php?SId=<?php echo $_REQUEST['SId'] ?>" title="Reset password">Reset password</a><br/>
	<a href="ban.php?SId=<?php echo $_REQUEST['SId'] ?>" title="Set account status">Set account status</a>
	</div>
<?php
}
}
}
} else {
	header("Location: staff.php");
	exit;
}
echo "</div>";

include "footer.php";
?>
