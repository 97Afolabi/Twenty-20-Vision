<?php include "functions.php";

//can user access the Warehouse?
isperm_warehouse();

echo "<div id='main'>\n";

if (isset($_REQUEST["aid"])) {
	$aid = $_REQUEST["aid"];

$show_acc = "SELECT accid, acc_name, acc_type, acc_registeredon FROM accessories WHERE accid = $aid;";
$showAcc = connect($show_acc);
if (mysqli_num_rows($showAcc) > 0) {

	if(isset($_POST["submit"])) {
		$accName = test_input($_POST["acc_name"]);
		$aType = test_input($_POST["acc_type"]);

		$update_acc = "UPDATE accessories SET acc_name = '$accName', acc_type = '$aType' WHERE accid = $aid;";
		$updateAcc = connect($update_acc);
		if($updateAcc) {
			header("Location: edit-accessory.php?aid=$aid");
			exit;
		} else {
			echo "<div class='text'>Unable to update the accessory details at the moment. Contact site admin.</div>\n";
		}
	}

while ($sa = mysqli_fetch_assoc($showAcc)) {;
echo "<title>Edit " . $sa["acc_type"] . " " . $sa["acc_name"] . "</title>\n";
echo "<a href='wh-accessory.php' title='Accessories (Warehouse)'><button type='submit'>Go back</button></a>\n";
echo "<div class='title'> Edit ". $sa["acc_type"] . " " . $sa["acc_name"] . "</div>\n";

?>
<form action='edit-accessory.php?aid=<?php echo $sa["accid"];?>' method='POST'>
Accessory name:<br/>
<input type='text' name='acc_name' value='<?php echo $sa["acc_name"];?>' placeholder='Accessory name' required="required"><br/>
Accessory type:<br/>
<select name='acc_type'>
	<option value='Case' <?php isset_select($sa["acc_type"], "Case"); ?>>Case</option>
	<option value='Duster' <?php isset_select($sa["acc_type"], "Duster"); ?>>Duster</option>
	<option value='Suspender' <?php isset_select($sa["acc_type"], "Suspender"); ?>>Suspender</option>
</select>
<br/>
<button type="submit" name="submit">Edit</button>

</form>
<b>Registered on:</b> 
<script type="text/javascript">
    //split returned into JavaScript compatible format for beautiful date and time
    //$rec_date is imaginary returned variable

    var raw_datetime = "<?php echo $sa["acc_registeredon"]; ?>";
    var beaut_date = new Date(raw_datetime);
    //date
    var new_date = beaut_date.toDateString();

    document.write(new_date);
</script>
<?php
echo "<div class='text'><a href='delete.php?aid=$aid'>Set accessory's status</a></div>\n";
}
echo "</div>\n";
echo "<div class='title'>Help</div>\n";
help_edit_accessory();
} else {
	header("Location: wh-accessory.php");
	exit;
}
} else {
	header("Location: wh-accessory.php");
	exit;
}
include "footer.php";
?>
