<?php include "functions.php";

//can user access the Warehouse?
isperm_warehouse();

echo "<title>Add new accessory</title>\n";
echo "<div id='main'>\n";

//check if the form has been submitted
if (isset($_POST['submit'])) {

//sanitize form input
$accName = test_input($_POST["acc_name"]);
$accType = test_input($_POST["acc_type"]);
$updatedon = test_input($_POST["registered_on"]);
$staff = test_input($_SESSION["staffid"]);

//SQL query to add frame to the Frame Description table
$new_accessory = "INSERT INTO accessories (acc_name, acc_type, acc_registeredon, acc_status) VALUES ('$accName', '$accType', '$updatedon', 'listed');";
//the connect($...) function is not used in order to get the id
$newAccessory = mysqli_query($conn, $new_accessory);

//retrieve the id of the frame inserted into the Frame Description table
//this will be inserted into the FrameStock table to be used for Joined tables
$newaccid = mysqli_insert_id($conn);

//the next line should retrieve the id of the query above and insert it into the aId
//zeros are specified as default values to prevent issues with Not Null and Null
$accessory_stock = "INSERT INTO accessories_stock (accid, branchid, a_dbquantity, a_physicalq, a_qsold, a_qtransferred, a_qreceived, lastupdateby, lastupdatedon, imported) VALUES ($newaccid, 1, 0, 0, 0, 0, 0, $staff, '$updatedon', 'yes');";
//manually include the BranchId for Warehouse so that frames are added to the warehouse first
//in the future, warehouses will have Id = 1 -- it will be created during setup
//the connect() function can be used now because $conn variable is not needed now
$AccessoryStock = connect($accessory_stock);

if ($AccessoryStock) {
	header("Location: new-accessory.php?t=$accType&n=$accName");
	exit;
} else {
	echo "<div class='text'>Unable to register the new accessory, contact site admin\n.</div>\n";
}
}

//check if a new accessory has been registered and display it's name and type
if (isset($_REQUEST["t"]) && isset($_REQUEST["n"]) && ($_REQUEST["t"] != "") && ($_REQUEST["n"] != "")) {
	$accType = $_REQUEST["t"];
	$accName = $_REQUEST["n"];
	echo "<div class='text'>$accType: $accName added successfully! <a href='wh-accessory.php'>View accessories (Warehouse)</a></div>\n";
}
?>

<div class='title'>Add new accessory</div>
<form action="new-accessory.php" method="POST">
Accessory name:<br/>
<input type="text" name="acc_name" placeholder="Accessory name" required="required"><br/>
Accessory type:<br/>
<select name="acc_type">
	<option value="Case">Case</option>
	<option value="Duster">Duster</option>
	<option value="Suspender">Suspender</option>
</select>
<input type='hidden' name='registered_on' value='<?php echo time_date(); ?>'><br/>
<button type="submit" name="submit">Add new accessory</button>

</form>
<?php
echo "<div class='title'>Help</div>\n";
help_new_accessory();
echo "</div>\n";
include "footer.php";
?>
