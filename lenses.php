<?php include "functions.php";
echo "<title>Lenses</title>\n";
echo "<div id='main'>\n";
echo "<div class='title'>Lenses</div>\n";

echo "<div class='text'>\n";
echo "<form action='search.php' method='GET'>\n";
echo "<input type='text' name='q' placeholder='Search lenses'><br/>\n";
echo "<input type='hidden' name='r' value='l'>\n";
echo "<button type='submit'>Search lenses</button>\n";
echo "</form>\n";
echo "</div>\n";

//import lenses
echo "<a href='import-lens.php'><button type='submit'>Import lenses from the Warehouse</button></a>\n";
	//Display data for Staff's branch
$BId = $_SESSION['branchid'];
$viewLenses = "SELECT lenses.lensid, lenses.lens_strength, lenses.lens_type, lenses.lens_price, lens_stock.branchid, lens_stock.l_physicalq, lens_stock.l_qsold, lens_stock.l_qtransferred, lens_stock.l_qreceived FROM lenses LEFT JOIN lens_stock ON lenses.lensid = lens_stock.lensid WHERE lens_stock.branchid=$BId ORDER BY lenses.lens_strength;";
$view_lenses = connect($viewLenses);

$number_of_results = mysqli_num_rows($view_lenses);
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

$viewLenses = "SELECT lenses.lensid, lenses.lens_strength, lenses.lens_type, lenses.lens_price, lens_stock.branchid, lens_stock.l_physicalq, lens_stock.l_qsold, lens_stock.l_qtransferred, lens_stock.l_qreceived FROM lenses LEFT JOIN lens_stock ON lenses.lensid = lens_stock.lensid WHERE lens_stock.branchid=$BId ORDER BY lenses.lens_strength LIMIT ". $offset . ",". $results_per_page.";";
$view_lenses = connect($viewLenses);

//if their is any frame(s) at all
if (mysqli_num_rows($view_lenses) > 0) {
	//display an HTML table
	echo "<table>\n";
	echo "<tr>\n";
	echo "<th>Strength</th>\n";
	echo "<th>Type</th>\n";
	echo "<th>Price</th>\n";
	echo "<th>Physical<br/>quantity</th>\n";
	echo "<th>Quantity<br/>sold</th>\n";
	echo "<th>Quantity<br/>received</th>\n";
	echo "<th>Quantity<br/>transferred</th>\n";
	echo "<th>Quantity</th>\n";
	echo "</tr>\n";
	//scan through all the lenses in order and print their values withing HTML tables
	while ($vL = mysqli_fetch_array($view_lenses)) {
		echo "<tr>\n<td>" . $vL['lens_strength'] . "</td>\n";
		echo "<td>" . $vL['lens_type'] . "</td>\n";
		echo "<td class='center'>" . $vL['lens_price'] . "</td>\n";
		echo "<td class='center'>" . $vL['l_physicalq'] . "</td>\n";
		echo "<td class='center'>" . $vL['l_qsold'] . "</td>\n";
		echo "<td class='center'>" . $vL['l_qtransferred'] . "</td>\n";
		echo "<td class='center'>" . $vL['l_qreceived'] . "</td>\n";
		echo "<td><a href='update-lens.php?lid=".$vL['lensid']."'>Update</a></td>\n";
		echo "</tr>";
	}
	echo "<tr>\n<td colspan='8'><div class='navbar'>Pages: \n";
		//displaying the navigation link
		for ($page = 1; $page <= $number_of_pages; $page++) {
    	echo "<a href='lenses.php?page=".$page."'> $page </a>";
		}
	echo "</div>\n</td>\n<tr/>\n";
	//close the table outside the while loop otherwise a </table> tag will be printed with every result
	echo "</table>";
} else {
	//message to display if there are no lenses
	echo "<div class='text'>There are no lenses to display at the moment.<br/>
	<a href='import-lens.php' title='Add new lens'><button type='submit'>Import lenses from the warehouse</button></a></div>\n";
}

echo "<div class='title'>Help</div>\n";
help_lenses();
echo "</div>";

include "footer.php";
?>
