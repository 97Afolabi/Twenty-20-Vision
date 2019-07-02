<?php include "functions.php";

//is user a management staff?
isperm_management();

echo	"<title>Manage branches</title>";

echo "<div id='main'>";
echo "<div class='title'>Manage branches</div>";

//check if user has submitted input then
if (isset($_POST['submit'])) {
	$bName = test_input($_POST['branch_name']);
	$bShort = test_input($_POST['short_name']);
	$regdon = test_input($_POST['today']);

	//insert them into the Branches table
	$newbranch = "INSERT INTO branches (branchName, bShortName, registeredOn) VALUES ('$bName', '$bShort', '$regdon');";
	$add_branch = connect($newbranch);

	if ($add_branch) {
		//reload the page if successful. Branches table will be updated and displayed
		header("Location: branches.php");
		exit;
	} else {
		echo "<div class='text'>There was a problem registering the new branch. Please contact the site admin</div>\n";
	}
} else {
	?>
	<form action="branches.php" method="POST">
		<input type="text" name="branch_name" placeholder="Branch name"><br/>
		<input type="text" name="short_name" placeholder="Branch's short name"><br/>
		<input type="hidden" name="today" value="<?php echo time_date(); ?>"><br/>
		<button type="submit" name="submit">Register new branch</button>
	</form>
<?php
}
//retrieve values from Branches
$branch_details = "SELECT branchid, branchName, bShortName FROM branches;";
$BranchDetails = connect($branch_details);

if (mysqli_num_rows($BranchDetails) > 0) {
	//display branches, id, and staff assigned to the branch
	echo "<table>\n<tr>\n<th>ID</th>\n<th>Name</th>\n<th>Short name</th>\n<th>Staff</th>\n</tr>";
	while ($bdet = mysqli_fetch_assoc($BranchDetails)) {
		echo "<tr>\n<td>" . $bdet['branchid'] . "</td>\n";
		echo "<td>" . $bdet['branchName'] . "</td>\n";
		echo "<td>" . $bdet['bShortName'] . "</td>\n";
		echo "<td>\n";
		//retrieve Staff full names as unordered lists so all staff assigned to a branch will be listed instead of one of them
		$branch = $bdet["branchid"];
		$branch_staff = "SELECT fullName FROM staff WHERE branchid = '$branch';";
		$BranchStaff = connect($branch_staff);
		while ($sfn = mysqli_fetch_assoc($BranchStaff)) {
			echo $sfn['fullName'] . "<br/>\n";
	}
			echo "</td>\n</tr>\n";
}
	echo "</table>\n";
} else {
	echo "<div class'text'>There are no branches yet</div>\n";
}
echo "</div>";

include "footer.php";
?>
