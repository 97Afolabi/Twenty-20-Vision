<?php include "functions.php";

echo "<title>Appointments</title>\n";
echo "<div id='main'>\n";
echo "<div class='title'>Scheduled appointments</div>\n";
echo "<div class='text'><a href='new-appointment.php' title='Schedule new appointment'><button type='submit'>Schedule new appointment</button></a></div>\n";

$branch = $_SESSION["branchid"];
if ($_SESSION["perm_appointments"] === "privileged") {
	//if the staff can answer appointments, show appointments from all branches
	$show_appointments = "SELECT appointments.ap_id, appointments.ap_staff, appointments.ap_branch, DATE(appointments.ap_today) AS ap_today, appointments.ap_name, appointments.ap_num1, appointments.ap_num2, appointments.ap_convdate, appointments.ap_address, appointments.ap_complaints, appointments.ap_comment, appointments.ap_urgency, appointments.ap_status, staff.nameU, branches.branchName FROM appointments JOIN branches ON appointments.ap_branch  = branches.branchid JOIN staff ON appointments.ap_staff = staff.staffid ORDER BY appointments.ap_today DESC;";
	$showAppointments = connect($show_appointments);
	global $showAppointments;
} else {
	//if not, show only the current branch
	$show_appointments = "SELECT appointments.ap_id, appointments.ap_staff, appointments.ap_branch, DATE(appointments.ap_today) AS ap_today, appointments.ap_name, appointments.ap_num1, appointments.ap_num2, DATE(appointments.ap_convdate) AS ap_convdate, appointments.ap_address, appointments.ap_complaints, appointments.ap_comment, appointments.ap_urgency, appointments.ap_status, staff.nameU, branches.branchName FROM appointments JOIN branches ON appointments.ap_branch  = branches.branchid JOIN staff ON appointments.ap_staff = staff.staffid WHERE appointments.ap_branch = $branch;";
	$showAppointments = connect($show_appointments);
	global $showAppointments;
}

if (mysqli_num_rows($showAppointments) > 0) {
	while ($sa = mysqli_fetch_assoc($showAppointments)) {
		echo "<table>\n";
		echo "<tr>\n<th colspan='2'>";
		?>
		<script type="text/javascript">
   		//split returned into JavaScript compatible format for beautiful date and time
		//$rec_date is imaginary returned variable

		var raw_datetime = "<?php echo $sa["ap_today"]; ?>";
		var beaut_date = new Date(raw_datetime);
		//date
		var new_date = beaut_date.toDateString();

		document.write(new_date);
		</script>
		<?php
		echo "</th>\n</tr>\n";
		echo "<tr>\n<td>Branch:</td><td>".$sa["branchName"]."</td>\n</tr>";
		echo "<tr>\n<td>Name:</td><td>".$sa["ap_name"]."</td>\n</tr>";
		echo "<tr>\n<td>Phone 1:</td><td>".$sa["ap_num1"]."</td>\n</tr>";
		echo "<tr>\n<td>Phone 2:</td><td>".$sa["ap_num2"]."</td>\n</tr>";
		echo "<tr>\n<td>Convenient date:</td><td>";
		?>
		<script type="text/javascript">
   		//split returned into JavaScript compatible format for beautiful date and time
		//$rec_date is imaginary returned variable

		var raw_datetime = "<?php echo $sa["ap_convdate"]; ?>";
		var beaut_date = new Date(raw_datetime);
		//date
		var new_date = beaut_date.toDateString();

		document.write(new_date);
		</script>
		<?php
		echo "</td>\n</tr>";
		echo "<tr>\n<td>Address:</td><td>".$sa["ap_address"]."</td>\n</tr>";
		echo "<tr>\n<td>Complaint:</td><td>".$sa["ap_complaints"]."</td>\n</tr>";
		echo "<tr>\n<td>Urgency:</td><td>".$sa["ap_urgency"]."</td>\n</tr>";
		echo "<tr>\n<td>Status:</td><td>".$sa["ap_status"]."</td>\n</tr>";
		echo "<tr>\n<td>Comment:</td><td>".$sa["ap_comment"]."</td>\n</tr>";
		echo "<tr>\n<td>Scheduled by:</td><td>".$sa["nameU"]."</td>\n</tr>";
		echo "</table><br/>\n";
	}
} else {
	echo "<div class='text'>There are no appointments scheduled at the moment.</div>\n";
}

echo "</div>\n";
include "footer.php";
?>
