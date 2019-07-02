<?php include "functions.php";

//can user access the Warehouse?
isperm_warehouse();

echo "<title>Lenses Warehouse</title>\n";

//get the user's branchid so he can edit from here too
//forget it, is useless. The user can update from his page also
$branchid = $_SESSION["branchid"];

//give him/her a tour of the facility i.e. list all branches
echo "<div id='main'>\n";
$lsBranches = "SELECT branchid, branchName FROM branches ORDER BY branchName;";
$lsB = connect($lsBranches);
echo '<form action="wh-lenses.php" method="GET">';
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
$view_lens = "SELECT lenses.lens_type, lenses.lens_strenght, lenses.lensid, lenses.lens_price, lens_stock.l_physicalq, lens_stock.l_qsold, lens_stock.branchid FROM lenses JOIN lens_stock ON lenses.lensid=lens_stock.lensid WHERE lens_stock.branchid=$branch ORDER BY lenses.lens_strenght;";
$viewLens = connect($view_lens);

$number_of_results = mysqli_num_rows($viewLens);
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


//fetch stock inventory
$view_lens = "SELECT lenses.lens_type, lenses.lens_strenght, lenses.lensid, lenses.lens_price, lens_stock.l_physicalq, lens_stock.l_qsold, lens_stock.branchid FROM lenses JOIN lens_stock ON lenses.lensid=lens_stock.lensid WHERE lens_stock.branchid=$branch ORDER BY lenses.lens_strenght LIMIT ". $offset . ",". $results_per_page.";";
$viewLens = connect($view_lens);

//display the inventory in a table
if (mysqli_num_rows($viewLens) > 0) {
echo "<table>\n";
echo "<tr>\n<th>Strenght</th>\n";
echo "<th>Type</th>\n";
echo "<th>Price</th>\n";
echo "<th>Physical<br/>quantity</th>\n";
echo "<th>Sold</th>\n";
echo "<th>Edit</th>\n</tr>\n";

while ($row = mysqli_fetch_assoc($viewLens)) {
echo "<tr>\n<td>" . $row["lens_strenght"] . "</td>\n";
echo "<td>" . $row["lens_type"] . "</td>\n";
echo "<td class='center'>" . $row["lens_price"] . "</td>\n";
echo "<td class='center'>" . $row["l_physicalq"] . "</td>\n";
echo "<td class='center'>" . $row["l_qsold"] . "</td>\n";

//another hard coding. If the Warehouse is selected in the drop-down list, show the update buttons
if ($branch === '1') {
	echo "<td><a href='update-lens.php?lid=".$row["lensid"]."'>Update</a>\n";
	echo "<a href='edit-lens.php?lid=".$row["lensid"]."'>Edit</a></td></tr>\n";
}
}
echo "<tr>\n<td colspan='6'><div class='navbar'>Pages: \n";
//displaying the navigation link
for ($page = 1; $page <= $number_of_pages; $page++) {
   echo "<a href='wh-lenses.php?branch=$branch&page=".$page."'> $page </a>";
}
echo "</div>\n</td>\n<tr/>\n";
echo "</table>\n";

} else {
//if no lens has been added to that branch, tell the truth
echo "<div class='text'>There are no lenses to display at the moment. <a href='new-lens.php'>Add new lens</a></a></div>\n";
}

} else {

//default show room, Warehouse. If the visitor can enter the warehouse,
//(s)he can update the quantity right? Right
//Warehouse's id was hard-coded '5'
$view_lens = "SELECT lenses.lens_type, lenses.lens_strenght, lenses.lensid, lenses.lens_price, lens_stock.l_physicalq, lens_stock.l_qsold, lens_stock.branchid FROM lenses JOIN lens_stock ON lenses.lensid=lens_stock.lensid WHERE lens_stock.branchid=1 ORDER BY lenses.lens_strenght;";
$viewLens = connect($view_lens);

$number_of_results = mysqli_num_rows($viewLens);
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

$view_lens = "SELECT lenses.lens_type, lenses.lens_strenght, lenses.lensid, lenses.lens_price, lens_stock.l_physicalq, lens_stock.l_qsold, lens_stock.branchid FROM lenses JOIN lens_stock ON lenses.lensid=lens_stock.lensid WHERE lens_stock.branchid=1 ORDER BY lenses.lens_strenght LIMIT ". $offset . ",". $results_per_page.";";
$viewLens = connect($view_lens);

echo "<div class='title'>Warehouse</div>";

if (mysqli_num_rows($viewLens) > 0) {
echo "<table>\n";
echo "<tr>\n<th>Strenght</th>\n";
echo "<th>Type</th>\n";
echo "<th>Price</th>\n";
echo "<th>Physical<br/>quantity</th>\n";
echo "<th>Sold</th>\n";
echo "<th colspan='2'>Edit</th>\n</tr>\n";

while ($row = mysqli_fetch_assoc($viewLens)) {
echo "<tr>\n<td>" . $row["lens_strenght"] . "</td>\n";
echo "<td>" . $row["lens_type"] . "</td>\n";
echo "<td class='center'>" . $row["lens_price"] . "</td>\n";
echo "<td class='center'>" . $row["l_physicalq"] . "</td>\n";
echo "<td class='center'>" . $row["l_qsold"] . "</td>\n";
//a link to the Warehouse update page
echo "<td><a href='update-lens.php?lid=".$row["lensid"]."'>Update</a></td>\n";
if ($row["branchid"] === "1") {
	echo "<td><a href='edit-lens.php?lid=".$row["lensid"]."'>Edit</a>";
}
echo "</td></tr>\n";
}
echo "<tr>\n<td colspan='6'><div class='navbar'>Pages: \n";
//displaying the navigation link
for ($page = 1; $page <= $number_of_pages; $page++) {
   echo "<a href='wh-lenses.php?page=".$page."'> $page </a>";
}
echo "</div>\n</td>\n<tr/>\n";
echo "</table>\n";
} else {
//The site must be brand new if there are no lens in the warehouse either!
echo "<div class='text'>There are no lenses to display at the moment. <a href='new-lens.php'>Add new lens</a></div>\n";
}
}

echo "<div class='title'>Help</div>\n";
help_warehouse_lenses();
echo '</div>';

include "footer.php";
?>
