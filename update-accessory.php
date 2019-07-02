<?php include "functions.php";
echo "<title>Update accessory quantity</title>";
echo "<div id='main'>";

//this page handles all accessory quantity updates -- from the warehouse or the local branch
// if it is from the warehouse, create a new inventory record
// if it is from the local branch or the warehouse; in which case the lens' record
// would have been created. Update that record.

if (isset($_REQUEST["aid"])) {
//do you come holding a frame? what's it's id?
$accId = $_REQUEST["aid"];
$brId = $_SESSION["branchid"];
$Staff = $_SESSION["staffid"];

//has that lens being added to this branch before?
$fetch_acc = "SELECT accessories_stock.a_physicalq, accessories_stock.a_qsold, accessories_stock.a_qtransferred, accessories_stock.a_qreceived, DATE(accessories_stock.lastupdatedon) AS lastupdatedon, accessories_stock.lastupdateby, accessories.acc_type, accessories.acc_name, staff.nameU FROM accessories_stock JOIN accessories ON accessories_stock.accid = accessories.accid JOIN staff ON accessories_stock.lastupdateby = staff.staffid WHERE accessories.accid = $accId AND accessories_stock.branchid =$brId;";
$fetchAcc = connect($fetch_acc);
if (mysqli_num_rows($fetchAcc) > 0) {
//if yes, fix the inventory for that lens into input boxes so user can update them without error messages
while ($va = mysqli_fetch_assoc($fetchAcc)) {
?>
<div class="title">Update accessories' quantity</div>
<form action="update-accessory.php?aid=<?php echo $accId;?>" method="POST">
<table>
<tr>
<td>Physical quantity</td>
<td><input type="text" name="physical_q" value="<?php echo $va["a_physicalq"]; ?>" placeholder="<?php echo $va["a_physicalq"]; ?>" required="required"/></td>
</tr>
<tr>
<tr>
<td>Quantity sold</td>
<td><input type="text" name="sold_q" value="<?php echo $va["a_qsold"]; ?>" placeholder="<?php echo $va["a_qsold"]; ?>" required="required"/></td>
</tr>
<tr>
<tr>
<td>Quantity transferred</td>
<td><input type="text" name="transferred_q" value="<?php echo $va["a_qtransferred"]; ?>" placeholder="<?php echo $va["a_qtransferred"]; ?>" required="required"/></td>
</tr>
<tr>
<tr>
<td>Quantity received</td>
<td><input type="text" name="received_q" value="<?php echo $va["a_qreceived"]; ?>" placeholder="<?php echo $va["a_qreceived"]; ?>" required="required"/></td>
<input type="hidden" name="aid" value="<?php echo $_REQUEST["aid"]; ?>"/>
<input type="hidden" name="lastupdate" value="<?php echo time_date(); ?>"/>
</tr>
<tr>
<tr>
<td colspan="2"><input type="submit" name="update" value="Update quantity"/><br/><br/></td>
</tr>
<tr>
<td>Last update:</td>
<td>
	<script type="text/javascript">
    //split returned into JavaScript compatible format for beautiful date and time
//$rec_date is imaginary returned variable

var raw_datetime = "<?php echo $va["lastupdatedon"]; ?>";
var beaut_date = new Date(raw_datetime);
//date
var new_date = beaut_date.toDateString();

document.write(new_date);
</script>
</td>
</tr>
<tr>
<td>Updated by:</td>
<td><?php echo $va["nameU"]; ?></td>
</tr>
</table>
</form>

<?php
//we're done listing the inventory
}
if (isset($_POST["update"])) {
	//did the user submit the form? Yes. Update the inventory then
$physicalq = test_input($_POST["physical_q"]);
$soldq = test_input($_POST["sold_q"]);
$transferredq = test_input($_POST["transferred_q"]);
$receivedq = test_input($_POST["received_q"]);
$lastupdate = test_input($_POST["lastupdate"]);

$update_acc = "UPDATE accessories_stock SET a_physicalq=$physicalq, a_qsold=$soldq, a_qtransferred=$transferredq, a_qreceived=$receivedq, branchid=$brId, lastupdateby = '$Staff', lastupdatedon = '$lastupdate', imported = 'yes' WHERE accid = $accId AND branchid = $brId;";
$updateAcc = connect($update_acc);
if ($updateAcc) {
// return to this page without re-submit dialog box
	header("Location: update-accessory.php?aid=$accId");
	exit;
}
} //ending of updating
} else {
// if the lens has not being added to that branch's inventory. Show this other form
?>
<div class="title">Import new accessory from the Warehouse</div>
<form action="update-accessory.php?aid=<?php echo $accId;?>" method="POST">
<table>
<tr>
<td>Physical quantity</td>
<td><input type="number" name="physical_q" value="0" required="required"/></td>
</tr>
<tr>
<tr>
<td>Quantity sold</td>
<td><input type="number" name="sold_q" value="0" required="required"/></td>
</tr>
<tr>
<tr>
<td>Quantity transferred</td>
<td><input type="number" name="transferred_q" value="0" required="required"/></td>
</tr>
<tr>
<tr>
<td>Quantity received</td>
<td><input type="number" name="received_q" value="0" required="required"/></td>
<input type="hidden" name="aid" value="<?php echo $_REQUEST["aid"]; ?>"/>
<input type="hidden" name="lastupdate" value="<?php echo time_date(); ?>"/>
</tr>
<tr>
<tr>
<td colspan="2"><button type="submit" name="insert">Import accessory</button></td>
</tr>
</table>
</form>

<?php
if (isset($_POST["insert"])) {
// if the user submits this other form (which is very similar to the first), a new inventory record will be created for that lens in that particular branch.
$physicalq = test_input($_POST["physical_q"]);
$soldq = test_input($_POST["sold_q"]);
$transferredq = test_input($_POST["transferred_q"]);
$receivedq = test_input($_POST["received_q"]);
$lastupdate = test_input($_POST["lastupdate"]);

$add_acc = "INSERT INTO accessories_stock (accid, a_physicalq, a_qsold, a_qtransferred, a_qreceived, branchid, lastupdateby, lastupdatedon, imported) VALUES ($acccId,$physicalq,$soldq,$transferredq,$receivedq,$brId, $Staff, '$lastupdate', 'yes');";
$addAcc = connect($add_acc);
if ($addAcc) {
	header("Location: update-accessory.php?aid=$acId");
	exit;
}
}
}
} else {
	//you didn't bring an accessory in? Get out!
    header("Location: accessories.php");
    exit;
}
echo "<div class='title'>Help</div>\n";
help_update_accessory();
echo "</div>\n";

include "footer.php";

?>
