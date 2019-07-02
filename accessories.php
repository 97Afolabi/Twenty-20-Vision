<?php include "functions.php";
echo "<title>Accessories</title>\n";
echo "<div id='main'>\n";
echo "<div class='title'>Accessories</div>\n";

echo "<div class='text'>\n";
echo "<form action='search.php' method='GET'>\n";
echo "<input type='text' name='q' placeholder='Search accessories'><br/>\n";
echo "<input type='hidden' name='r' value='a'>\n";
echo "<button type='submit'>Search accessories</button>\n";
echo "</form>\n";
echo "</div>\n";

echo "<a href='import-accessory.php' title='Add new accessory'><button type='submit'>Import accessories from the warehouse</button></a>";

	//Display data for Staff's branch
$BId = $_SESSION['branchid'];

$viewAccessories = "SELECT accessories.accid, accessories.acc_name, accessories.acc_type, accessories.acc_price, accessories_stock.branchid, accessories_stock.a_physicalq, accessories_stock.a_qsold, accessories_stock.a_qtransferred, accessories_stock.a_qreceived FROM accessories LEFT JOIN accessories_stock ON accessories.accid = accessories_stock.accid WHERE accessories_stock.branchid=$BId ORDER BY accessories.acc_name;";
$view_accessories = connect($viewAccessories);

$number_of_results = mysqli_num_rows($view_accessories);
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

$viewAccessories = "SELECT accessories.accid, accessories.acc_name, accessories.acc_type, accessories.acc_price, accessories_stock.branchid, accessories_stock.a_physicalq, accessories_stock.a_qsold, accessories_stock.a_qtransferred, accessories_stock.a_qreceived FROM accessories LEFT JOIN accessories_stock ON accessories.accid = accessories_stock.accid WHERE accessories_stock.branchid=$BId ORDER BY accessories.acc_name LIMIT ". $offset . ",". $results_per_page.";";
$view_accessories = connect($viewAccessories);

//if there is any frame(s) at all
if (mysqli_num_rows($view_accessories) > 0) {
	//display an HTML table
	echo "<table>\n";
	echo "<tr>\n";
	echo "<th>Click to<br/>view pictures</th>";
	echo "<th>Accessory</th>\n";
	echo "<th>Type</th>\n";
	echo "<th>Price</th>\n";
	echo "<th>Physical<br/>quantity</th>\n";
	echo "<th>Quantity<br/>sold</th>\n";
	echo "<th>Quantity<br/>received</th>\n";
	echo "<th>Quantity<br/>transferred</th>\n";
	echo "<th>Quantity</th>\n";
	echo "</tr>\n";
	//scan through all the lenses in order and print their values withing HTML tables
	while ($va = mysqli_fetch_array($view_accessories)) {
		echo "<tr>\n<td><a href='images.php?a=".$va['accid']."'>Pictures</a></td>\n";
		echo "<td>" . $va['acc_name'] . "</td>\n";
		echo "<td>" . $va['acc_type'] . "</td>\n";
		echo "<td class='center'>" . $va['acc_price'] . "</td>\n";
		echo "<td class='center'>" . $va['a_physicalq'] . "</td>\n";
		echo "<td class='center'>" . $va['a_qsold'] . "</td>\n";
		echo "<td class='center'>" . $va['a_qtransferred'] . "</td>\n";
		echo "<td class='center'>" . $va['a_qrecieved'] . "</td>\n";
		echo "<td><a href='update-accessory.php?aid=".$va['accid']."'>Update</a></td>\n";
		echo "</tr>";
	}
	echo "<tr>\n<td colspan='9'><div class='navbar'>Pages: \n";
		//displaying the navigation link
		for ($page = 1; $page <= $number_of_pages; $page++) {
    	echo "<a href='accessories.php?page=".$page."'> $page </a>";
		}
	echo "</div>\n</td>\n<tr/>\n";
	//close the table outside the while loop otherwise a </table> tag will be printed with every result
	echo "</table>";
} else {
	//message to display if there are no lenses
	echo "<div class='text'>There are no accessories to display at the moment. <a href='import-accessory.php' title='Add new accessory'>Import accessories from the warehouse</a></div>";
}

echo "<div class='title'>Help</div>\n";
help_accessories();
echo "</div>";

echo "</div>";

include "footer.php";
?>
