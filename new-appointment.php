<?php include "functions.php";
echo "<title>New appointment</title>\n";
echo "<div id='main'>\n";

echo "<div class='title'>New appointment</div>\n";
echo "<div class='text'><a href='appointments.php' title='Scheduled appointments'><button type='submit'>Scheduled appointments</button></a><br/>";
//feedback after form submission
if (isset($_REQUEST["m"])) {
	if($_REQUEST["m"] === "s") {
		$name = $_REQUEST["n"];
		echo "An appointment has been scheduled for $name successfully!";
	} else if($_REQUEST["m"] === "f") {
		echo "Unable to schedule the appointment, contact site admin";
	}
}

echo "</div>\n";

$staff = $_SESSION["staffid"];
$branch = $_SESSION["branchid"];
if (isset($_POST["make_appointment"])) {
	$todayDate = test_input($_POST["app_date"]);
	$name = test_input($_POST["app_name"]);
	$pnum1 = test_input($_POST["app_num1"]);
	$pnum2 = test_input($_POST["app_num2"]);
	$convDate = test_input($_POST["app_conv"]);
	$address = test_input($_POST["app_address"]);
	$complaint = test_input($_POST["app_complaints"]);
	$comment = test_input($_POST["comment"]);
	$custStatus = test_input($_POST["app_cust"]);
	$urgency = test_input($_POST["app_urgency"]);

	$make_appointment = "INSERT INTO appointments (ap_staff, ap_branch, ap_today, ap_name, ap_num1, ap_num2, ap_convdate, ap_address, ap_complaints, ap_comment, ap_urgency, ap_status) VALUES ($staff, $branch, '$todayDate', '$name', '$pnum1', '$pnum2', '$convDate', '$address', '$complaint', '$comment', '$urgency', '$custStatus');";
	$makeAppointment = connect($make_appointment);
	if($makeAppointment) {
		header("Location: new-appointment.php?m=s&n=$name");
		exit;
	} else {
		header("Location: new-appointment.php?m=f");
		exit;
	}

}

?>
<form action='new-appointment.php' method='POST'>
<table>
<tr>
Today's date:<br/>
<input type='text' name='app_date' placeholder='YYYY-MM-DD' value='<?php echo date_is(); ?>' required="required"><br/>
</tr>
<tr>
Name:<br/>
<input type='text' name='app_name' placeholder="Full name" required="required"><br/>
</tr>
<tr>
Phone number 1:<br/>
<input type='number' name='app_num1' placeholder='Phone number' required="required"><br/>
</tr>
<tr>
Phone number 2:<br/>
<input type='number' name='app_num2' placeholder='Phone number'><br/>
</tr>
<tr>
Convenient date and time:<br/>
<input type='text' name='app_conv' placeholder='YYYY-MM-DD HH:MM:SS'><br/>
</tr>
<tr>
Address:<br/>
<textarea name='app_address' placeholder='Address'></textarea><br/>
</tr>
<tr>
Complaint(s):<br/>
<textarea name='app_complaints' placeholder='Complaint(s)'></textarea><br/>
</tr>
<tr>
Comment:<br/>
<textarea name='comment' placeholder='Your comment'></textarea><br/>
</tr>
<tr>
New or Old customer:<br/>
<select name='app_cust'>
<option value='New'>New</option>
<option valeu='Old'>Old</option>
</select><br/>
</tr>
<tr>
Urgency:<br/>
<select name='app_urgency'>
<option value='High'>High</option>
<option value='Moderate'>Moderate</option>
<option value='Low'>Low</option>
</select><br/><br/>
</tr>
<tr>
<button type='submit' name='make_appointment'>Schedule appointment</button>
</tr>
</table>
</form>

<div class='title'>Help</div>
<?php help_new_appointment(); ?>
</div>
<?php include "footer.php"; ?>
