<?php include "functions.php";
echo "<title>Update frame's quantity</title>";
echo "<div id='main'>";

//this page handles all frame quantity updates -- from the warehouse or the local branch
// if it is from the warehouse, create a new inventory record
// if it is from the local branch or the warehouse; in which case the frame's record
// would have been created. Update that record.

if (isset($_REQUEST["fid"])) {
//do you come holding a frame? what's it's id?
$FrameId = $_REQUEST["fid"];
$brId = $_SESSION["branchid"];
$Staff = $_SESSION["staffid"];

//has that frame being added to this branch before?
$fetch_frame = "SELECT frame_stock.f_physicalq, frame_stock.f_qsold, frame_stock.f_qtransferred, frame_stock.f_qreceived, frames.frame_name, frames.frame_model, frame_stock.lastupdateby, DATE(frame_stock.lastupdatedon) AS lastupdatedon, staff.nameU FROM frame_stock JOIN frames ON frame_stock.frameid = frames.frameid JOIN staff on frame_stock.lastupdateby = staff.staffid WHERE frames.frameid = $FrameId AND frame_stock.branchid =$brId;";
$fetchframe = connect($fetch_frame);
if (mysqli_num_rows($fetchframe) > 0) {
//if yes, fix the inventory for that frame into input boxes so user can update them without error messages
while ($vf = mysqli_fetch_assoc($fetchframe)) {
?>
<div class="title">Update frame's quantity</div>
<form action="update-frame.php" method="POST">
<table>
<tr>
<td>Physical quantity</td>
<td><input type="text" name="physical_q" value="<?php echo $vf["f_physicalq"]; ?>" placeholder="<?php echo $vf["f_physicalq"]; ?>" required="required"/></td>
</tr>
<tr>
<tr>
<td>Quantity sold</td>
<td><input type="text" name="sold_q" value="<?php echo $vf["f_qsold"]; ?>" placeholder="<?php echo $vf["f_qsold"]; ?>" required="required"/></td>
</tr>
<tr>
<tr>
<td>Quantity transferred</td>
<td><input type="text" name="transferred_q" value="<?php echo $vf["f_qtransferred"]; ?>" placeholder="<?php echo $vf["f_qtransferred"]; ?>" required="required"/></td>
</tr>
<tr>
<tr>
<td>Quantity received</td>
<td><input type="text" name="received_q" value="<?php echo $vf["f_qreceived"]; ?>" placeholder="<?php echo $vf["f_qreceived"]; ?>" required="required"/></td>
<input type="hidden" name="fid" value="<?php echo $_REQUEST["fid"]; ?>"/>
<input type="hidden" name="today" value="<?php date_is(); ?>"/>
</tr>
<tr>
<tr>
<td colspan="2"><input type="submit" name="update" value="Update quantity"/></td>
</tr>
<tr>
<td>Updated on:</td><td>
<script type="text/javascript">
    //split returned into JavaScript compatible format for beautiful date and time
//$rec_date is imaginary returned variable

var raw_datetime = "<?php echo $vf["lastupdatedon"]; ?>";
var beaut_date = new Date(raw_datetime);
//date
var new_date = beaut_date.toDateString();

document.write(new_date);
</script>
</td>
</tr>
<tr>
<td>Updated by:</td><td><?php echo $vf["nameU"]; ?></td>
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
$today = test_input($_POST["today"]);

$update_frame = "UPDATE frame_stock SET f_physicalq=$physicalq, f_qsold=$soldq, f_qtransferred=$transferredq, f_qreceived=$receivedq, branchid=$brId, lastupdateby = '$Staff', lastupdatedon = '$today', imported = 'yes' WHERE frameid = $FrameId AND branchid = $brId;";
$updateframe = connect($update_frame);
if ($updateframe) {
// return to this page without re-submit dialog box
	header("Location: update-frame.php?fid=$FrameId");
	exit;
}
} //ending of updating
} else {
// if the frame has not being added to that branch's inventory. Show this other form
?>
<div class="title">Import new frame from the Warehouse</div>
<form action="update-frame.php" method="POST">
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
<input type="hidden" name="fid" value="<?php echo $_REQUEST["fid"]; ?>"/>
<input type="hidden" name="today" value="<?php date_is(); ?>"/>
</tr>
<tr>
<tr>
<td colspan="2"><button type="submit" name="insert">Import frame</button></td>
</tr>
</table>
</form>

<?php
if (isset($_POST["insert"])) {
// if the user submits this other form (which is very similar to the first), a new inventory record will be created
// for that frame in that particular branch.
$physicalq = test_input($_POST["physical_q"]);
$soldq = test_input($_POST["sold_q"]);
$transferredq = test_input($_POST["transferred_q"]);
$receivedq = test_input($_POST["received_q"]);
$today = test_input($_POST["today"]);

$add_frame = "INSERT INTO frame_stock (frameid, f_physicalq, f_qsold, f_qtransferred, f_qreceived, branchid, lastupdateby, lastupdatedon, imported) VALUES ($FrameId,$physicalq,$soldq,$transferredq,$receivedq,$brId, '$Staff', '$today', 'yes');";
$addframe = connect($add_frame);
if ($addframe) {
	header("Location: update-frame.php?fid=$FrameId");
	exit;
}
}
}
} else {
	//you didn't bring any frame in? Get out!
    header("Location: frames.php");
    exit;
}
echo "<div class='title'>Help</div>\n";
help_update_frame();
echo "</div>\n";

include "footer.php";

?>
