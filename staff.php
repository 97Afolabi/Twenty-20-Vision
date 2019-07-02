<?php include "functions.php";

//can user access the Warehouse?
isperm_management();

echo "<title>All staff</title>\n";
echo "<div id='main'\n>";
echo "<div class='title'>All staff</div>\n";

echo  "<a href='new-staff.php'><button type='submit'>Register a new staff</button></a>";

//print Staff info and the branch they work at
$vStaff = "SELECT staff.staffid, staff.fullName, staff.nameU, staff.mailE, staff.phone, branches.branchName FROM staff LEFT JOIN branches ON staff.branchid=branches.branchid;";

$viewstaff = connect($vStaff);

if (mysqli_num_rows($viewstaff) > 0) {
 while ($vs = mysqli_fetch_assoc($viewstaff)) {
	echo "<div class='text'>\n<table>\n";
	echo "<tr>\n<td>ID:</td><td>" . $vs['staffid'] . "</td></tr>\n";
	echo "<tr>\n<td>Branch:</td><td>" . $vs['branchName'] . "</td>\n</tr>\n";
	echo "<tr>\n<td>Name:</td><td>" . $vs['fullName'] . "</td></tr>\n";
	echo "<tr>\n<td>Username:</td><td>" . $vs['nameU'] . "</td></tr>\n";
	echo "<tr>\n<td>e-mail:</td><td>" . $vs['mailE'] . "</td</tr>\n";
	echo "<tr>\n<td>Phone:</td><td><a href='tel:" . $vs['phone'] . "'>" . $vs['phone'] . "</a></td></tr>\n";
	echo "</table><br/>\n";
	echo "<a href='edit-staff.php?SId=".$vs['staffid']."'><button type='submit'>Edit info</button></a>\n";
	echo "</div>\n";
 }
} else {
	echo "<div class='text'>Staff list currently unavailable!</div>\n";
}

echo "</div>\n";

include "footer.php";

?>
