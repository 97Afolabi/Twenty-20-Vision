<?php
include "functions.php";

echo "<title>Change password</title>";
echo "<div id='main'>";
echo "<div class='title'>Change password</div>";
if (isset($_POST['submit'])) {
$oldpass = $_POST["oldpassword"];
$newpassword = $_POST["newpassword"];
$newpasswordagain = $_POST["newpasswordagain"];
$staff = $_SESSION['staffid'];
$staffPassword = "SELECT passU, staffid FROM staff WHERE staffid='$staff';";
$staffPwd = connect($staffPassword);
if (mysqli_num_rows($staffPwd) > 0){
	while ($st = mysqli_fetch_assoc($staffPwd)) {
		$oldpwd = $st["passU"];
		if ($oldpass != $oldpwd) {
			echo "<div class='text'>Old password did not match!</div>";
		}
		if ($newpassword != $newpasswordagain) {
			echo "<div class='text'>The new password you enter did not match, try again</div>";
		}
		if (($oldpass === $oldpwd) && $newpassword === $newpasswordagain) {
			$changePassword = "UPDATE staff SET passU = '$newpassword' WHERE staffid = '$staff';";
			$changePwd = connect($changePassword);
			if ($changePwd) {
				echo "<div class='text'>Your password has been changed successfully.</div>";
			}
		}
	}

}

}
?>
<form action='change-password.php' method='POST'>
Old password:<br/>
<input type='password' name='oldpassword' required="required"><br/>
New password:<br/>
<input type='password' name='newpassword' required="required"><br/>
New password again:<br/>
<input type='password' name='newpasswordagain' required="required"><br/>
<button type='submit' name='submit'>Change password</button>
</form>
<?php

echo "</div>";
include "footer.php";
?>
