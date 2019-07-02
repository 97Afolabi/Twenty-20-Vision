<?php include "functions.php";

//can user access the Warehouse?
isperm_warehouse();

echo "<title>Frames Warehouse</title>\n";

//get the user's branchid so he can edit from here too
//forget it, is useless. The user can update from his page also
$branchid = $_SESSION["branchid"];

//give him/her a tour of the facility i.e. list all branches
echo "<div id='main'>\n";

//view stock in a particular branch
$lsBranches = "SELECT branchid, branchName FROM branches ORDER BY branchName;";
$lsB = connect($lsBranches);
echo '<form action="wh-frame.php" method="GET">';
echo '<select name="branch">';
while($row = mysqli_fetch_assoc($lsB)) {
echo "<option value='".$row["branchid"]."' name='branch'";
	if(isset($_GET["branch"])) {
	isset_select($_GET["branch"], $row["branchid"]);
	}
	echo ">".$row["branchName"]."</option>\n";
}
echo "</select><br/>";
echo "<button type='submit'>View stock in branch</button>\n";
echo "</form>";
//end viewing of stock in a branch

//the stock inventory for the selected branch is displayed, default Warehouse
if (isset($_GET["branch"])) {
$branch = $_GET["branch"];
$printBranchName = "SELECT branchName FROM branches WHERE branchid = $branch;";
$printBr = connect($printBranchName);
while($pBr = mysqli_fetch_assoc($printBr)) {
echo "<div class='title'>".$pBr["branchName"]."</div>";
}

//retrieve branch Id
$branch = $_GET["branch"];
//fetch stock inventory
$vf = "SELECT frame_stock.branchid, frames.frame_name, frames.frame_model, frames.frameid, frames.frame_price, frame_stock.f_physicalq, frame_stock.f_qsold FROM frames LEFT JOIN frame_stock ON frames.frameid=frame_stock.frameid WHERE frame_stock.branchid=$branch ORDER BY frames.frame_name;";
$vframe = connect($vf);

$number_of_results = mysqli_num_rows($vframe);
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

$vf = "SELECT frame_stock.branchid, frames.frame_name, frames.frame_model, frames.frameid, frames.frame_price, frame_stock.f_physicalq, frame_stock.f_qsold FROM frames LEFT JOIN frame_stock ON frames.frameid=frame_stock.frameid WHERE frame_stock.branchid=$branch ORDER BY frames.frame_name LIMIT ". $offset . ",". $results_per_page.";";
$vframe = connect($vf);

//display the inventory in a table
if (mysqli_num_rows($vframe) > 0) {
echo "<table>\n";
echo "<tr><th>Click to<br>view pictures</th>\n";
echo "<th>Brand name</th>\n";
echo "<th>Model</th>\n";
echo "<th>Price</th>\n";
echo "<th>Physical<br/>quantity</th>\n";
echo "<th>Sold</th>\n";
echo "<th>Edit</th>\n</tr>\n";


while ($row = mysqli_fetch_assoc($vframe)) {
echo "<tr>\n<td><a href='images.php?f=".$row["frameid"]."'>Pictures</a></td>\n";
echo "<td>" . $row["frame_name"] . "</td>\n";
echo "<td>" . $row["frame_model"] . "</td>\n";
echo "<td>" . $row["frame_price"] . "</td>\n";
echo "<td class='center'>" . $row["f_physicalq"] . "</td>\n";
echo "<td class='center'>" . $row["f_qsold"] . "</td>\n";

//another hard coding. If the Warehouse is selected in the drop-down list, show the update buttons
if ($branch === '1') {
	echo "<td><a href='update-frame.php?fid=".$row["frameid"]."'>Update</a>";
	echo "<a href='edit-frame.php?fid=".$row["frameid"]."'>Edit</a></td></tr>\n";
}
}
echo "<tr>\n<td colspan='7'><div class='navbar'>Pages: \n";
//displaying the navigation link
for ($page = 1; $page <= $number_of_pages; $page++) {
   echo "<a href='wh-frame.php?branch=$branch&page=".$page."'> $page </a>";
}
echo "</div>\n</td>\n<tr/>\n";
echo "</table>\n";

} else {
//if no frames has been added to that branch, tell the truth
echo "<div class='text'>No frames</div>\n";
}

} else {

//default show room, Warehouse. If the visitor can enter the warehouse,
//(s)he can update the quantity right? Right
//Warehouse's id was hard-coded '5' including the frame id prevents multiple display of records
//from the FrameStock table
$vf = "SELECT frame_stock.branchid, frames.frame_name, frames.frame_model, frames.frameid, frames.frame_price, frame_stock.f_physicalq, frame_stock.f_qsold FROM frames LEFT JOIN frame_stock ON  frames.frameid=frame_stock.frameid WHERE frame_stock.branchid=1 ORDER BY frame_name;";
$vframe = connect($vf);

$number_of_results = mysqli_num_rows($vframe);
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

$vf = "SELECT frame_stock.branchid, frames.frame_name, frames.frame_model, frames.frameid, frames.frame_price, frame_stock.f_physicalq, frame_stock.f_qsold FROM frames LEFT JOIN frame_stock ON  frames.frameid=frame_stock.frameid WHERE frame_stock.branchid=1 ORDER BY frame_name LIMIT ". $offset . ",". $results_per_page.";";
$vframe = connect($vf);

echo "<div class='title'>Warehouse</div>";

if (mysqli_num_rows($vframe) > 0) {
echo "<table>\n";
echo "<tr><th>Click to<br>view pictures</th>\n";
echo "<th>Brand name</th>\n";
echo "<th>Model</th>\n";
echo "<th>Price</th>\n";
echo "<th>Physical<br/>quantity</th>\n";
echo "<th>Sold</th>\n";
echo "<th colspan='2'>Edit</th>\n</tr>\n";

while ($row = mysqli_fetch_assoc($vframe)) {
echo "<tr>\n<td><a href='images.php?f=".$row["frameid"]."'>Pictures</a></td>\n";
echo "<td>" . $row["frame_name"] . "</td>\n";
echo "<td>" . $row["frame_model"] . "</td>\n";
echo "<td class='center'>" . $row["frame_price"] . "</td>\n";
echo "<td class='center'>" . $row["f_physicalq"] . "</td>\n";
echo "<td class='center'>" . $row["f_qsold"] . "</td>\n";
//a link to the Warehouse update page
echo "<td><a href='update-frame.php?fid=".$row["frameid"]."'>Update</a></td>\n";
echo "<td><a href='edit-frame.php?fid=".$row["frameid"]."'>Edit</a>";
echo "</td></tr>\n";
}
echo "<tr>\n<td colspan='7'><div class='navbar'>Pages: \n";
//displaying the navigation link
for ($page = 1; $page <= $number_of_pages; $page++) {
   echo "<a href='wh-frame.php?page=".$page."'> $page </a>";
}
echo "</div>\n</td>\n<tr/>\n";
echo "</table>\n";
} else {
//The site must be brand new if there are no frames in the warehouse either!
echo "<div class='text'>There are no frames to display at the moment. <a href='new-frame.php'>Add new frame</a></div>\n";
}
}

echo "<div class='title'>Help</div>\n";
help_warehouse_frames();
echo "</div>\n";

include "footer.php";
?>
