<?php include "functions.php" ?>
<title>Frames</title>
<div id='main'>
<div class='title'>Frames</div>

<div class='text'>
<form action='search.php' method="GET">
<input type='text' name='q' placeholder='Search frames'><br/>
<input type='hidden' name='r' value='f'>
<button type='submit'>Search frames</button>
</form>
</div>
<a href='import-frame.php' title='Import frame from the Warehouse'><button type='submit'>Import frame from the Warehouse</button></a>
<?php
	//Display data for Staff's branch
$BId = $_SESSION['branchid'];

$viewFrames = "SELECT frames.frameid, frames.frame_name, frames.frame_model,
 frames.frame_size, frames.frame_price, frame_stock.branchid, frame_stock.f_physicalq, frame_stock.f_qsold, frame_stock.f_qtransferred, frame_stock.f_qreceived FROM frames LEFT JOIN frame_stock ON frames.frameid = frame_stock.frameid WHERE frame_stock.branchid=$BId ORDER BY frames.frame_name;";
$view_frames = connect($viewFrames);

$number_of_results = mysqli_num_rows($view_frames);
$results_per_page = 30;
$number_of_pages = ceil($number_of_results/$results_per_page);

//if the page is not set, set page id to 1
if(!isset($_REQUEST["page"])) {
    $page = 1;
} else {
//if it is set, set page id to the set id
    $page = $_REQUEST["page"];
}

$offset = ($page - 1) * $results_per_page;
//change f_qreceived
$viewFrames = "SELECT frames.frameid, frames.frame_name, frames.frame_model,
 frames.frame_size, frames.frame_price, frame_stock.branchid, frame_stock.f_physicalq, frame_stock.f_qsold, frame_stock.f_qtransferred, frame_stock.f_qreceived FROM frames LEFT JOIN frame_stock ON frames.frameid = frame_stock.frameid WHERE frame_stock.branchid=$BId ORDER BY frames.frame_name LIMIT ". $offset . ",". $results_per_page.";";
$view_frames = connect($viewFrames);

//if there is any frame(s) at all
if (mysqli_num_rows($view_frames) > 0) {

	//display an HTML table
	echo $_SESSION["user_name"] . "<br/>";
	echo "<table>\n";
	echo "<tr>\n";
	echo "<th>Click to<br/>view pictures</th>";
	echo "<th>Brand Name</th>\n";
	echo "<th>Model</th>\n";
	echo "<th>Frame size</th>\n";
	echo "<th>Price</th>\n";
	echo "<th>Physical<br/>quantity</th>\n";
	echo "<th>Quantity<br/>sold</th>\n";
	echo "<th>Quantity<br/>received</th>\n";
	echo "<th>Quantity<br/>transferred</th>\n";
	echo "<th>Quantity</th>\n";
	echo "</tr>\n";
	//scan through all the frames in order and print their values withing HTML tables
	while ($vF = mysqli_fetch_array($view_frames)) {
		echo "<tr>\n<td><a href='images.php?f=".$vF['frameid']."'>Pictures</a></td>\n";
		echo "<td>" . $vF['frame_name'] . "</td>\n";
		echo "<td>" . $vF['frame_model'] . "</td>\n";
		echo "<td>" . $vF['frame_size'] . "</td>\n";
		echo "<td class='center'>" . $vF['frame_price'] . "</td>\n";
		echo "<td class='center'>" . $vF['f_physicalq'] . "</td>\n";
		echo "<td class='center'>" . $vF['f_qsold'] . "</td>\n";
		echo "<td class='center'>" . $vF['f_qtransferred'] . "</td>\n";
		echo "<td class='center'>" . $vF['f_qreceived'] . "</td>\n";
		echo "<td class='link'><a href='update-frame.php?fid=".$vF['frameid']."'>Update</a></td>\n";
		echo "</tr>";
	}
	echo "<tr>\n<td colspan='10'><div class='navbar'>Pages: \n";
		//displaying the navigation link
		for ($page = 1; $page <= $number_of_pages; $page++) {
    	echo "<a href='frames.php?page=".$page."'> $page </a>";
		}
	echo "</div>\n</td>\n<tr/>\n";
	//close the table outside the while loop otherwise a </table> tag will be printed with every result
	echo "</table>";
} else {
	//message to display if there are no frame
	echo "There are no frames to display at the moment.<br/>
	<a href='import-frame.php' title='Add new frame'><button type='submit'>Import frame from the warehouse</button></a>\n";
}

//help
echo "<div class='title'>Help</div>\n";
help_frames();
echo "</div>";

include "footer.php";
?>
