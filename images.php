<?php include "functions.php";

echo "<div id='main'>";

//this is first of many if...else as the page is multi-purpose
//f is for frame, do the following
if (isset($_REQUEST["f"])) {
	$frame = $_REQUEST["f"];

	//search for full description as title
	$frame_info = "SELECT frame_name, frame_model, frame_size FROM frames WHERE frameid = $frame;";
	$frameInfo = connect($frame_info);

	//show the details and if it is not found send the visitor out!
	if (mysqli_num_rows($frameInfo) > 0) {
		while($fi = mysqli_fetch_assoc($frameInfo)) {
			echo "<title>".$fi["frame_name"]." ".$fi["frame_model"]." ".$fi["frame_size"]."</title>\n";
			echo "<div class='title'>".$fi["frame_name"]." ".$fi["frame_model"]." ".$fi["frame_size"]."</div>\n";
		}

	//search for all records with the specified id and use their urls
	$frame_image = "SELECT f_id, f_url FROM frame_images WHERE f_id = $frame ORDER BY f_id DESC;";
	$frameImage = connect($frame_image);

	if (mysqli_num_rows($frameImage) > 0) {
		echo "<div class='text'>";
		while ($fi = mysqli_fetch_assoc($frameImage)) {
			//a floating image gallery
			echo "<img src='images/frames/".$fi["f_url"]."' width='200px' height='150px' alt='".$fi["f_url"]."'/>\n";
		}
		echo "</div>\n";
		if($_SESSION["perm_warehouse"] === "privileged") {
		echo "<div class='text'><a href='image-uploader.php?fid=$frame'> Upload new image</a></div>";
		}
	} else {
		echo "<div class='text'>There are no images for the specified frame";
		if($_SESSION["perm_warehouse"] === "privileged") {
			echo "<a href='image-uploader.php?fid=$frame'> Upload new image</a>";
		}
			echo "</div>\n";
	}

	} else {
		header("Location: wh-frame.php");
		exit;
	}
}
//images for accessories
else if (isset($_REQUEST["a"])) {
	$accessory = $_REQUEST["a"];

	//search for full description as title
	$accessory_info = "SELECT acc_name, acc_type FROM accessories WHERE accid = $accessory;";
	$accessoryInfo = connect($accessory_info);

	//show the details and if it is not found send the visitor out!
	if (mysqli_num_rows($accessoryInfo) > 0) {
		while($ai = mysqli_fetch_assoc($accessoryInfo)) {
			echo "<title>".$ai["acc_type"]." ".$ai["acc_name"]."</title>\n";
			echo "<div class='title'>".$ai["acc_type"]." ".$ai["acc_name"]."</div>\n";
		}

	//search for all records with the specified id and use their urls
	$accessory_image = "SELECT a_id, a_url FROM accessory_images WHERE a_id = $accessory ORDER BY a_id DESC;";
	$accessoryImage = connect($accessory_image);

	if (mysqli_num_rows($accessoryImage) > 0) {
		echo "<div class='text'>";
		while ($ai = mysqli_fetch_assoc($accessoryImage)) {
			//a floating image gallery
			echo "<img src='images/accessories/".$ai["a_url"]."' width='200px' height='150px' alt='".$ai["a_url"]."'/>\n";
		}
		echo "</div>\n";
		if($_SESSION["perm_warehouse"] === "privileged") {
		echo "<div class='text'><a href='image-uploader.php?aid=$accessory'> Upload new image</a></div>";
		}
	} else {
		echo "<div class='text'>There are no images for the specified accessory";
		if($_SESSION["perm_warehouse"] === "privileged") {
			echo "<a href='image-uploader.php?aid=$accessory'> Upload new image</a>";
		}
			echo "</div>\n";
	}

	} else {
		header("Location: wh-accessory.php");
		exit;
	}
}
//not found
else {
	echo "<div class='text'>Sorry, there are no pictures to display.</div>\n";
}

echo "</div>";
include "footer.php";
?>
