<?php include "functions.php";

//can user access the Warehouse?
isperm_management();

echo "<title>Enroll new staff</title>\n";
echo "<div id='main'>\n";
echo "<div class='title'>Enroll new staff</div>\n";

//if the form as been submitted then...
if (isset($_POST['submit'])) {
//assign user inputs to variables
$user_name = $_POST['user_name'];
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$tele = $_POST['Tele'];
$branchId = $_POST['BranchId'];
$pStock = test_input($_POST['perm_stock']);
$pWarehouse = test_input($_POST['perm_warehouse']);
$pManagement = test_input($_POST['perm_management']);
$pPatients = test_input($_POST['perm_patients']);
$pAppointments = test_input($_POST['perm_appointments']);
$pFinance = test_input($_POST['perm_finance']);

//password
$passwordone = $_POST['password'];
$passwordtwo = $_POST['passwordtwo'];
if(($passwordone != "" && $passwordtwo != "") && ($passwordone === $passwordtwo) && (strlen($passwordtwo) > 5)) {
	$password = $passwordtwo;
	global $password;
} else {
	echo "<div class='text'>Passwords do not match or the length was too short!</div>\n";
}

//SQL statement cut to next line -- pythonista-style
$query = "INSERT INTO staff (branchid, nameU, fullName, mailE, phone, passU, perm_stock, perm_warehouse, perm_management, perm_patients, perm_appointments, perm_finance)
VALUES ($branchId, '$user_name', '$full_name', '$email', '$tele', '$password', '$pStock', '$pWarehouse' , '$pManagement', '$pPatients', '$pAppointments', '$pFinance');";
$newU = connect($query);

 if (!$newU) {
	//if user was not added write
	echo "<div class='text'>Unable to register new staff profile. Contact site admin.</div>";
 } else {
	//if user was added, show staff list
	header("Location: staff.php");
	exit;
 }
} else {
	//default view since user hasn't made any input
	?>

<form action="new-staff.php" method="POST">
	<table>
	<tr>
	<th colspan="2">Bio</th>
	</tr>
	<tr>
	<td>User name:<br/>
	<input type="text" name="user_name" placeholder="User name" required="required"></td>
	</tr>
	<tr>
	<td>Full name:<br/>
	<input type="text" name="full_name" placeholder="Full name" required="required"></td>
	</tr>
	<tr>
	<td>e-mail:<br/>
	<input type="email" name="email" placeholder="e-mail"><br/></td>
	</tr>
	<tr>
	<td>Phone number:<br/>
	<input type="text" name="Tele" placeholder="Phone number" required="required"></td>
	</tr>
	<tr>
	<td>Password:<br/>
	<input type="password" name="password" placeholder="Password" required="required"><br/>
	<i>Minimum of 6 characters, you can use alphabets and numbers</i>
	</td>
	</tr>
	<tr>
	<td>Password again:<br/>
	<input type="password" name="passwordtwo" placeholder="Password again" required="required"></td>
	</tr>
	</table>
	<table>
	<tr>
	<th>Permissions</th>
	</tr>
	<tr>
	<td>
	Assign to branch
	<?php
//Print a list of all branches into a drop-down for selection
$branches = "SELECT branchid, branchName from branches;";
$vbranches = connect($branches);

//If Branches have been created, print the names and BranchId as values
if (mysqli_num_rows($vbranches) > 0) {
	echo "<select name ='BranchId'>\n";
	while ($vb = mysqli_fetch_assoc($vbranches)) {
		echo "<option value='" . $vb['branchid'] . "'>" . $vb['branchName'] . "</option>\n";
	}
	echo "</select>\n";
}

?>
 	</td>
 	</tr>
 	<tr>
	<td>View Stock inventory in<br/>
	<select name="perm_stock">
		<option value="local">Local branch</option>
		<option value="global">All branches</option>
	</select>
	</td>
	</tr>
	<tr>
	<td>Access the Warehouse<br/>
	<select name="perm_warehouse">
		<option value="unprivileged">No</option>
		<option value="privileged">Yes</option>
	</select>
	</td>
	</tr>
	<tr>
	<td>View and edit patients' profiles in<br/>
	<select name="perm_patients">
		<option value="local">Local branch</option>
		<option value="global">All branches</option>
	</select>
	</td>
	</tr>
	<tr>
	<td>Can answer appointments<br/>
	<select name="perm_appointments">
		<option value="unprivileged">No</option>
		<option value="privileged">Yes</option>
	</select>
	</td>
	</tr>
	<tr>
	<td>Manage branches and staff<br/>
	<select name="perm_management">
		<option value="unprivileged">No</option>
		<option value="privileged">Yes</option>
	</select>
	</td>
	</tr>
	<tr>
	<td>Manage finance<br/>
	<select name="perm_finance">
		<option value="unprivileged">No</option>
		<option value="privileged">Yes</option>
	</select>
	</td>
	</tr>

	</table><br/>

	<button type="submit" name="submit">Enroll new staff</button><br/>

</form>
<?php
}

echo "</div>";

include "footer.php";
?>
