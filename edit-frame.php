<?php include "functions.php";

//can user access the Warehouse?
isperm_warehouse();

echo "<title>Edit frame's info</title>\n";
echo "<div id='main'>\n";
echo "<a href='wh-frame.php'><button type='submit'>Go back (Frames Warehouse)</button></a>";

if (!isset($_REQUEST['fid'])) {
	//if a frame is selected
	header("Location: frame.php");
	exit;
} else {
	//if frame is selected validate id and...
	$frameId = test_input($_REQUEST["fid"]);

	//if 'Edit frame' button was clicked
	if (isset($_POST["submit"])) {
		$brandName = test_input($_POST["brand_name"]);
		$model = test_input($_POST["model"]);
		$frameSize = test_input($_POST["frame_size"]);
		$material = $_POST["material"];
		$style = test_input($_POST["style"]);
		$rimp = test_input($_POST["rimp"]);

		$edit_frame = "UPDATE frames SET frame_name = '$brandName', frame_model = '$model', frame_size = '$frameSize', frame_material = '$material', frame_style='$style', frame_rimp = '$rimp' WHERE frameid = '$frameId';";
		$editFrame = connect($edit_frame);
		if ($editFrame) {
			header("Location: edit-frame.php?fid=$frameId");
			exit;
		} else {
			echo "<div class='text'>Unable to update frame's details at the moment. Contact site admin</div>";
		}
	}

	$frame_info = "SELECT frameid, frame_name, frame_model, frame_size, frame_material, frame_style, frame_rimp, frame_status, frame_registeredon FROM frames WHERE frameid = $frameId;";
	$frameInfo = connect($frame_info);
	if (mysqli_num_rows($frameInfo) > 0) {
	while ($finfo = mysqli_fetch_assoc($frameInfo)) {
	echo "<div class='title'> Edit " . $finfo["frame_name"] . "&nbsp;" . $finfo["frame_model"] ."</div>\n";
	echo "<form action='edit-frame.php?fid=$frameId' method='POST'>\n";
	echo "Brand name:<br/>\n";
	echo "<input type='text' name='brand_name' value='".$finfo["frame_name"]."' required='required'><br/>\n";
	echo "Model:<br/>\n";
	echo "<input type='text' name='model' value='".$finfo["frame_model"]."'><br/>\n";
	echo "Frame's size:<br/>\n";
	echo "<input type='text' name='frame_size' value='".$finfo["frame_size"]."'><br/>\n";
	echo "Material:<br/>\n";
	echo "<select name='material'>\n";
	echo "<option value='Metal'";
	isset_select($finfo["frame_material"], "Metal");
	echo ">Metal</option>\n";
	echo "<option value='Plastic'";
	isset_select($finfo["frame_material"], "Plastic");
	echo ">Plastic</option>\n";
	echo "<option value='Metal & Plastic'";
	isset_select($finfo["frame_material"], "Metal & Plastic");
	echo ">Metal & Plastic</option>\n";
	echo "<option value='Wooden'";
	isset_select($finfo["frame_material"], "Wooden");
	echo ">Wooden</option>\n";
	echo "</select><br/>\n";
	echo "Style:<br/>\n";
	echo "<select name='style'>\n";
	echo "<option value='Designer'";
	isset_select($finfo["frame_style"], "Designer");
	echo ">Designer</option>\n";
	echo "<option value='Ordinary'";
	isset_select($finfo["frame_style"], "Ordinary");
	echo ">Ordinary</option>\n";
	echo "</select><br/>\n";
	echo "Rimp:<br/>\n";
	echo "<select name='rimp'>\n";
	echo "<option value='Full rimp'";
	isset_select($finfo["frame_rimp"], "Full rimp");
	echo ">Full rimp</option>\n";
	echo "<option value='Half rimp'";
	isset_select($finfo["frame_rimp"], "Half rimp");
	echo ">Half rimp</option>\n";
	echo "<option value='Rimpless'";
	isset_select($finfo["frame_rimp"], "Rimpless");
	echo ">Rimpless</option>\n";
	echo "</select><br/>\n";
	echo "<b>Status:</b> ".$finfo["frame_status"]."<br/><br/>";
	echo "<input type='hidden' name='frame_id' value='".$_REQUEST["fid"]."'>";
	echo "<button type='submit' name='submit'>Edit frame's details</button>\n";
	echo "</form>\n";
	echo "<br/>\n";
	echo "<b>Registered on:</b> "
	?>
	<script type="text/javascript">
    //split returned into JavaScript compatible format for beautiful date and time
    //$rec_date is imaginary returned variable

    var raw_datetime = "<?php echo $finfo["frame_registeredon"]; ?>";
    var beaut_date = new Date(raw_datetime);
    //date
    var new_date = beaut_date.toDateString();

    document.write(new_date);
    </script>
    <?php
	}
echo "<div class='text'><a href='image-uploader.php?fid=$frameId' title='Upload frame image'>Upload frame image</a><br/>";
echo "<a href='delete.php?fid=$frameId'>Set frame's status</a></div>\n";
} else {
	echo "<div class='text'>There is no frame matching that ID. <a href='wh-frame.php'>Please select a valid frame</a></div>\n";
}
}

echo "<div class='title'>Help</div>\n";
help_edit_frame();
echo "</div>";
include "footer.php";
?>
