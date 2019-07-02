<?php
include "functions.php";
echo "<title>Import accessories</title>\n";
echo "<div id='main'>\n";
echo "<div class='title'>Accessories</div>";

$list_accessories = "SELECT accessories_stock.accid, accessories_stock.branchid, acc_type, acc_name FROM accessories JOIN accessories_stock ON accessories.accid = accessories_stock.accid WHERE accessories_stock.branchid = 1 && accessories_stock.imported = 'no' ORDER BY acc_name;";
$listAccessories = connect($list_accessories);

if (mysqli_num_rows($listAccessories) > 0) {
echo "<table>\n<tr>\n<th>Id</th>\n<th>Type</th>\n<th>Accessory name</th>\n<th>&nbsp;</th>\n</tr>\n";
while ($la = mysqli_fetch_assoc($listAccessories)) {
echo "<tr>\n<td>".$la["accid"]."</td>\n<td>".$la["acc_type"]."</td>\n<td>".$la["acc_name"]."</td>\n<td><a href='update-accessory.php?aid=".$la["accid"]."'>Import</a></td>\n</tr>\n";
}
echo "</table>\n";
} else {
	echo "<div class='text'>There are no new accessories for you to import!</div>\n";
}

echo "<div class='title'>Help</div>\n";
help_import_accessories();
echo "</div>\n";

echo "</div>\n";
include "footer.php";
?>
