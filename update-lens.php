<?php include "functions.php";
echo "<title>Update lens quantity</title>";
echo "<div id='main'>";

//this page handles all lens quantity updates -- from the warehouse or the local branch
// if it is from the warehouse, create a new inventory record
// if it is from the local branch or the warehouse; in which case the lens' record
// would have been created. Update that record.

if (isset($_REQUEST["lid"])) {
//do you come holding a frame? what's it's id?
$lensid = $_REQUEST["lid"];
$brId = $_SESSION["branchid"];
$Staff = $_SESSION["staffid"];

//has that lens being added to this branch before?
$fetch_lens = "SELECT lens_stock.l_physicalq, lens_stock.l_qsold, lens_stock.l_qtransferred, lens_stock.l_qreceived, DATE(lens_stock.lastupdatedon) AS lastupdatedon, lens_stock.lastupdateby, lenses.lens_type, lenses.lens_strength, staff.nameU FROM lens_stock JOIN lenses ON lens_stock.lensid = lenses.lensid JOIN staff ON lens_stock.lastupdateby = staff.staffid WHERE lenses.lensid = $lensid AND lens_stock.branchid =$brId;";
$fetchLens = connect($fetch_lens);
if (mysqli_num_rows($fetchLens) > 0) {
//if yes, fix the inventory for that lens into input boxes so user can update them without error messages
while ($vl = mysqli_fetch_assoc($fetchLens)) {
?>
<div class="title">Update lens' quantity</div>
<form action="update-lens.php?lid=<?php echo $lensid;?>" method="POST">
<table>
<tr>
<td>Physical quantity</td>
<td><input type="text" name="physical_q" value="<?php echo $vl["l_physicalq"]; ?>" placeholder="<?php echo $vl["l_physicalq"]; ?>" required="required"/></td>
</tr>
<tr>
<tr>
<td>Quantity sold</td>
<td><input type="text" name="sold_q" value="<?php echo $vl["l_qsold"]; ?>" placeholder="<?php echo $vl["l_qsold"]; ?>" required="required"/></td>
</tr>
<tr>
<tr>
<td>Quantity transferred</td>
<td><input type="text" name="transferred_q" value="<?php echo $vl["l_qtransferred"]; ?>" placeholder="<?php echo $vl["l_qtransferred"]; ?>" required="required"/></td>
</tr>
<tr>
<tr>
<td>Quantity received</td>
<td><input type="text" name="received_q" value="<?php echo $vl["l_qreceived"]; ?>" placeholder="<?php echo $vl["l_qreceived"]; ?>" required="required"/></td>
<input type="hidden" name="lid" value="<?php echo $_REQUEST["lid"]; ?>"/>
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

var raw_datetime = "<?php echo $vl["lastupdatedon"]; ?>";
var beaut_date = new Date(raw_datetime);
//date
var new_date = beaut_date.toDateString();

document.write(new_date);
</script>
</td>
</tr>
<tr>
<td>Updated by:</td>
<td><?php echo $vl["nameU"]; ?></td>
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

$update_lens = "UPDATE lens_stock SET l_physicalq=$physicalq, l_qsold=$soldq, l_qtransferred=$transferredq, l_qreceived=$receivedq, branchid=$brId, lastupdateby = '$Staff', lastupdatedon = '$lastupdate', imported = 'yes' WHERE lensid = $lensid AND branchid = $brId;";
$updateLens = connect($update_lens);
if ($updateLens) {
// return to this page without re-submit dialog box
	header("Location: update-lens.php?lid=$lensid");
	exit;
}
} //ending of updating
} else {
// if the lens has not being added to that branch's inventory. Show this other form
?>
<div class="title">Import new lens from the Warehouse</div>
<form action="update-lens.php?lid=<?php echo $lensid;?>" method="POST">
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
<input type="hidden" name="lId" value="<?php echo $_REQUEST["lid"]; ?>"/>
<input type="hidden" name="lastupdate" value="<?php echo time_date(); ?>"/>
</tr>
<tr>
<tr>
<td colspan="2"><button type="submit" name="insert">Import frame</button></td>
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

$add_lens = "INSERT INTO lens_stock (lensid, l_physicalq, l_qsold, l_qtransferred, l_qreceived, branchid, lastupdateby, lastupdatedon, imported) VALUES ($lensid,$physicalq,$soldq,$transferredq,$receivedq,$brId, $Staff, '$lastupdate', 'yes');";
$addLens = connect($add_lens);
if ($addLens) {
	header("Location: update-lens.php?lid=$lensid");
	exit;
}
}
}
} else {
	//you didn't bring any lens in? Get out!
    header("Location: lenses.php");
    exit;
}
echo "<div class='title'>Help</div>\n";
help_update_lens();
echo "</div>\n";

include "footer.php";

?>
