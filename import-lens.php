<?php
include "functions.php";
echo "<title>Import lenses</title>\n";
echo "<div id='main'>\n";
echo "<div class='title'>Import lenses</div>";

$listlenses = "SELECT lens_stock.lensid, lens_type, lens_strength FROM lenses JOIN lens_stock ON lenses.lensid = lens_stock.lensid WHERE lens_stock.branchid = 1 && lens_stock.imported = 'no' ORDER BY lens_strength;";
$list_lenses = connect($listlenses);

if (mysqli_num_rows($list_lenses) > 0) {
echo "<table>\n<tr>\n<th>Id</th>\n<th>Type</th>\n<th>Strength</th>\n<th>&nbsp;</th>\n</tr>\n";
while ($ll = mysqli_fetch_assoc($list_lenses)) {
echo "<tr>\n<td>".$ll["lensid"]."</td>\n<td>".$ll["lens_type"]."</td>\n<td>".$ll["lens_strength"]."</td>\n<td><a href='update-lens.php?lid=".$ll["lensid"]."'>Import</a></td>\n</tr>\n";
}
echo "</table>\n";
} else {
	echo "<div class='text'>There are no lenses in the database at the moment.</div>\n";
}

//help
echo "<div class='title'>Help</div>\n";
help_import_lens();

echo "</div>\n";
include "footer.php";
?>
