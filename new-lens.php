<?php include "functions.php";

//can user access the Warehouse?
isperm_warehouse();

echo "<title>Add new lens</title>\n";
echo "<div id='main'>\n";

//check if the form has been submitted or if the user got to the page
//with with a frame id
if (isset($_POST['submit'])) {

//sanitize form input
$strength = test_input($_POST["strength"]);
$lenstype = test_input($_POST["lenstype"]);
$updatedon = test_input($_POST["registered_on"]);
$staff = $_SESSION["staffid"];

//SQL query to add frame to the Frame Description table
$new_lens = "INSERT INTO lenses (lens_strength, lens_type, lens_registeredon) VALUES ('$strength', '$lenstype', '$updatedon');";
//the connect($...) function is not used in order to get the id
$newLens = mysqli_query($conn, $new_lens);

//retrieve the id of the frame inserted into the Frame Description table
//this will be inserted into the FrameStock table to be used for Joined tables
$newlensid = mysqli_insert_id($conn);

//the next line should retrieve the id of the query above and insert it into the frameId
//zeros are specified as default values to prevent issues with Not Null and Null
$lens_stock = "INSERT INTO lens_stock (lensid, branchid, l_dbquantity, l_physicalq, l_qsold, l_qtransferred, l_qreceived, lastupdateby, lastupdatedon, imported) VALUES ($newlensid, 1, 0, 0, 0, 0, 0, $staff, '$updatedon', 'yes');";
//manually include the BranchId for Warehouse so that frames are added to the warehouse first
//in the future, warehouses will have Id = 1 -- it will be created during setup
//the connect() function can be used now because $conn variable is not needed now
$lensStock = connect($lens_stock);

if ($lensStock) {
	header("Location: new-lens.php?l=$lenstype&s=$strength");
	exit;
} else {
	echo "<div class='text'>Unable to register the new lens, contact site admin\n.</div>\n";
}
}
if (isset($_REQUEST["l"]) && isset($_REQUEST["s"])) {
	$lens = $_REQUEST["l"];
	$strength = $_REQUEST["s"];
	echo "<div class='text'>$lens $strength added successfully! <a href='wh-lenses.php'>View lenses (Warehouse)</a></div>\n";
}
?>

<div class='title'>Add a new lens</div>
<form action="new-lens.php" method="POST">
Strength:<br/>
<input type="text" name="strength" placeholder="Lens' strength" required="required"><br/>
Lens type:<br/>
<select name="lenstype">
	<option value="Cylindrical">Cylindrical</option>
	<option value="Spherical">Spherical</option>
</select>
<br/>
<input type='hidden' name='registered_on' value='<?php echo time_date(); ?>'><br/>
<button type="submit" name="submit">Add new lens</button>

</form>
<?php
echo "<div class='title'>Help</div>\n";
help_new_lens();
echo "</div>";
include "footer.php";
?>
