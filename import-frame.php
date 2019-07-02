<?php include "functions.php";
echo "<title>Import frames from the Warehouse</title>";
echo "<div id='main'>";
echo "<div class='title'>Import frames from the Warehouse</div>";

$branch = $_SESSION["branchid"];
$listframes = "SELECT frames.frameid, frames.frame_name, frames.frame_model, frames.frame_size, frame_stock.imported FROM frames JOIN frame_stock ON frames.frameid = frame_stock.frameid WHERE frame_stock.branchid = 1 && frame_stock.imported = 'no' ORDER BY frames.frame_name;"; //remove Warehouse hard coding
$list_frames = connect($listframes);

if (mysqli_num_rows($list_frames) > 0) {
echo "<table>\n<tr>\n<th>Name</th>\n<th>Model</th>\n<th>Size</th>\n<th></th></tr>";
while ($lf = mysqli_fetch_assoc($list_frames)) {
echo "<tr>\n<td>".$lf["frame_name"]."</td>\n<td>".$lf["frame_model"]."</td>\n<td>".$lf["frame_size"]."</td>\n<td><a href='update-frame.php?fid=".$lf["frameid"]."'>Import</a></td></tr>";
}
echo "</table>";
} else {
	echo "<div class='text'>There are no new frames for you to import!</div>\n";
}

//help
echo "<div class='title'>Help</div>\n";
help_import_frame();

echo "</div>";

include "footer.php";
?>
