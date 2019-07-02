<?php include "functions.php";

//can user access the Warehouse?
isperm_warehouse();
?>
<title>New frame</title>
<div id="main">
<div class="title">Add a new frame</div>
<?php
if (isset($_REQUEST["m"])) {
	if($_REQUEST["m"] === "s") {
		$fId = $_REQUEST["fId"];
		$fname = $_REQUEST['fname'];
		$fmodel = $_REQUEST['fmodel'];
	echo "<div class='text'>$fname $fmodel has been added successfully. <a href='image-uploader.php?fid=$fId' title='Upload images'>Upload images</a><br/>\n <a href='wh-frame.php'>View all frames</a></div>";
	} else if ($_REQUEST["m"] === "f") {
		echo "<div class='text'>Unable to register the new frames, contact the Site Admin\n";
	}
}
?>
<fieldset>
<legend><button type='submit'>Add a new frame</button></legend>
<form action="new-frame.php" method="POST">
Brand name:<br/>
<input type="text" name="brand_name" placeholder="Frame's brand name" required="required"> <br/>
Model number:<br/>
<input type="text" name="model_number" placeholder="Frame's model number"> <br/>
Frame size:<br/>
<input type="text" name="frame_size" placeholder="Frame's size: 51*17-135"> <br/>
Frame's material:<br/>
<select name="material">
	<option value="Metal &amp; Plastic">Metal & Plastic</option>
	<option value="Metal">Metal</option>
	<option value="Plastic">Plastic</option>
	<option value="Wood">Wood</option>
</select><br/>
Style:<br/>
<select name="style">
	<option value="Designer">Designer</option>
	<option value="Ordinary">Ordinary</option>
</select><br/>
Rimp style:<br/>
<select name="rimp">
	<option value="Full rimp">Full rimp</option>
	<option value="Half rimp">Half rimp</option>
	<option value="Rimpless">Rimpless</option>
</select><br/>
<input type='hidden' name='today' value='<?php date_is();?>'/>
<button type="submit" name="submit">Add new frame</button>

</form>

</fieldset>

<?php
//check if the form has been submitted or if the user got to the page
//with with a frame id
if (isset($_POST['submit'])) {

//sanitize form input
$BrandName = test_input($_POST["brand_name"]);
$ModelNumber = test_input($_POST["model_number"]);
$FrameSize = test_input($_POST["frame_size"]);
$Material = test_input($_POST["material"]);
$Style = test_input($_POST["style"]);
$Rimp = test_input($_POST["rimp"]);
$today = test_input($_POST["today"]);
$Staff = $_SESSION["staffid"];

//SQL query to add frame to the Frame Description table
$add_frame = "INSERT INTO frames (frame_name, frame_model, frame_size, frame_material, frame_style, frame_rimp) VALUES ('$BrandName', '$ModelNumber', '$FrameSize', '$Material', '$Style', '$Rimp');";
//the connect($...) function is not used in order to get the id
$tconn = mysqli_query($conn, $add_frame);

//retrieve the id of the frame inserted into the Frame Description table
//this will be inserted into the FrameStock table to be used for Joined tables
$newframeid = mysqli_insert_id($conn);

//the next line should retrieve the id of the query above and insert it into the frameId
//zeros are specified as default quantities to prevent issues with Not Null and Null
$frame_stock = "INSERT INTO frame_stock (frameid, f_dbquantity, f_physicalq, f_qsold, f_qtransferred, f_qreceived, branchid, lastupdateby, lastupdatedon, imported) VALUES ($newframeid, 0, 0, 0, 0, 0, 1, $Staff, '$today', 'no');";
//	manually include the BranchId for Warehouse so that frames are added to the warehouse first
//in the future, warehouses will have Id = 1 -- it will be created during setup
//the connect() function can be used now because $conn variable is not needed now
$framestock = connect($frame_stock);

if ($framestock) {
	header("Location: new-frame.php?m=s&fId=$newframeid&fname=$BrandName&fmodel=$ModelNumber");
	exit;
} else {
	header("Location: new-frame.php?m=f");
	exit;
}
}
echo "<div class='title'>Help</div>\n";
help_new_frame();
echo '</div>';

include "footer.php";
?>
