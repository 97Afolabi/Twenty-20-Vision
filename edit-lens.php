<?php include "functions.php";

//can user access the Warehouse?
isperm_warehouse();

echo "<div id='main'>\n";

if (isset($_REQUEST["lid"])) {
	$lens = $_REQUEST["lid"];

$show_lens = "SELECT lensid, lens_strength, lens_type, lens_registeredon FROM lenses WHERE lensid = $lens;";
$showLens = connect($show_lens);
if (mysqli_num_rows($showLens) > 0) {

	if(isset($_POST["submit"])) {
		$strength = test_input($_POST["strength"]);
		$lenstype = test_input($_POST["lenstype"]);
		$price = test_input($_POST["price"]);

		$update_lens = "UPDATE lenses SET lens_strength = '$strength', lens_type = '$lenstype' WHERE lensid = $lens;";
		$updateLens = connect($update_lens);
		if($updateLens) {
			header("Location: edit-lens.php?lid=$lens");
			exit;
		} else {
			echo "<div class='text'>Unable to update the lens' details at the moment. Contact site admin.</div>\n";
		}
	}

while ($sl = mysqli_fetch_assoc($showLens)) {;
echo "<title>Edit " . $sl["lens_strength"] . " " . $sl["lens_type"] . "</title>\n";
echo "<a href='wh-lenses.php' title='Lenses (Warehouse)'><button type='submit'>Go back</button></a>\n";
echo "<div class='title'> Edit ". $sl["lens_strength"] . " " . $sl["lens_type"] . "</div>\n";

?>
<form action='edit-lens.php?lid=<?php echo $sl["lensid"];?>' method='POST'>
Strength:<br/>
<input type='text' name='strength' value='<?php echo $sl["lens_strength"];?>' placeholder='Lens strength' required="required"><br/>
Lens type:<br/>
<select name='lenstype'>
	<option value='Cylindrical' <?php isset_select($sl["lens_type"], "Cylindrical"); ?>>Cylindrical</option>
	<option value='Spherical' <?php isset_select($sl["lens_type"], "Spherical"); ?>>Spherical</option>
</select>
<br/>
<button type="submit" name="submit">Edit</button>

</form>
<b>Registered on:</b> 
<script type="text/javascript">
    //split returned into JavaScript compatible format for beautiful date and time
    //$rec_date is imaginary returned variable

    var raw_datetime = "<?php echo $sl["lens_registeredon"]; ?>";
    var beaut_date = new Date(raw_datetime);
    //date
    var new_date = beaut_date.toDateString();

    document.write(new_date);
</script>

<?php
echo "<div class='text'><a href='delete.php?lid=$lens'>Set lens' status</a></div>\n";
}

} else {
	header("Location: wh-lenses.php");
	exit;
}
} else {
	header("Location: wh-lenses.php");
	exit;
}
echo "<div class='title'>Help</div>\n";
help_edit_lens();
echo "</div>\n";
include "footer.php";
?>
