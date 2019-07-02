<?php include "functions.php";
//can user manage Finance?
isperm_finance();
echo "<title>Fix prices</title>\n";
echo "<div id='main'>\n";
/* List all the stock, show previous prices and an input box for new prices
*  Individual buttons are printed for the update
*  The update however, will be processed on another page 'prices.php'
*  When the update is processed, a query string is sent back to this page
*  The user is notified if it failed or was successful
*/
?>
<!--A form to select the category of stock to fix prices for-->
<div class='text'>Select the category of stock you want to fix prices for
<form action='fix-price.php' method='GET'>
<select name='type'>
<option value='Frames' <?php if(isset($_REQUEST["type"])) { isset_select($_GET["type"], "Frames"); } ?>>Frames</option>
<option value='Lenses' <?php if(isset($_REQUEST["type"])) { isset_select($_GET["type"], "Lenses"); } ?>>Lenses</option>
<option value='Accessories' <?php if(isset($_REQUEST["type"])) { isset_select($_GET["type"], "Accessories"); } ?>>Accessories</option>
</select><br/>
<button type='submit'>Fix prices</button>
</form>
</div>
<?php
//if 'Frames' was selected do this
if (isset($_REQUEST["type"]) && $_REQUEST["type"] === "Frames") {
$frame = $_REQUEST["type"];
//check if there are return messages
if (isset($_REQUEST["m"]) && ($_REQUEST["m"] === "s")) {
	echo "<div class='text'>Price updated!</div>\n";
}
if (isset($_REQUEST["m"]) && ($_REQUEST["m"] === "e")) {
	echo "<div class='text'>Price update failed!</div>\n";
}
//end return messages

//show all frames
$show_frame = "SELECT frameid, frame_name, frame_model, frame_size, frame_price FROM frames ORDER BY frame_name;";
$showFrame = connect($show_frame);

$number_of_results = mysqli_num_rows($showFrame);
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

$show_frame = "SELECT frameid, frame_name, frame_model, frame_size, frame_price FROM frames ORDER BY frame_name LIMIT ". $offset . ",". $results_per_page.";";
$showFrame = connect($show_frame);
if(mysqli_num_rows($showFrame) > 0) {
	echo "<table>\n<tr>\n<th>Pictures</th>\n<th>Brand name</th>\n<th>Model</th>\n<th>Size</th><th>Old price</th>\n<th>New price</th\n<th><th>\n</tr>\n";
	while($sf = mysqli_fetch_assoc($showFrame)) {
		echo "<tr>\n<td><a href='images.php?f=".$sf["frameid"]."' title='".$sf["frame_name"].$sf["frame_model"].$sf["frame_size"]."'/>Pictures</a></td>\n";
		echo "<td>".$sf["frame_name"]."</td>\n";
		echo "<td>".$sf["frame_model"]."</td>\n";
		echo "<td>".$sf["frame_size"]."</td>\n";
		echo "<td>".$sf["frame_price"]."</td>\n";
		echo "<form action='prices.php' method='POST'>\n";
		echo "<td><input type='number' name='price' value='".$sf["frame_price"]."'></td>\n";
		echo "<td><input type='hidden' name='fid' value='".$sf["frameid"]."'>\n";
		echo "<button type='submit' name='fix_price'>Fix price</button></td>\n<tr>\n";
		echo "</form>\n";
	}
	echo "<tr>\n<td colspan='6'><div class='navbar'>Pages: \n";
	//displaying the navigation link
	for ($page = 1; $page <= $number_of_pages; $page++) {
	   echo "<a href='fix-price.php?type=$frame&page=".$page."'> $page </a>";
	}
	echo "</div>\n</td>\n<tr/>\n";
	echo "</table>\n";
//if there are no frames in the database, tell
} else {
	echo "<div class='text'>There are no stock in the Warehouse at the moment!</div>\n";
}
//if 'Lenses' was selected
} else if (isset($_REQUEST["type"]) && $_REQUEST["type"] === "Lenses") {
$lens = $_REQUEST["type"];

//return messages
if (isset($_REQUEST["m"]) && ($_REQUEST["m"] === "s")) {
	echo "<div class='text'>Price updated!</div>\n";
}
if (isset($_REQUEST["m"]) && ($_REQUEST["m"] === "e")) {
	echo "<div class='text'>Price update failed!</div>\n";
}

$show_lens = "SELECT lensid, lens_strength, lens_type, lens_price FROM lenses ORDER BY lensid;";
$showLens = connect($show_lens);

$number_of_results = mysqli_num_rows($showLens);
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

$show_lens = "SELECT lensid, lens_strength, lens_type, lens_price FROM lenses ORDER BY lensid LIMIT ". $offset . ",". $results_per_page.";";
$showLens = connect($show_lens);
if(mysqli_num_rows($showLens) > 0) {
	echo "<table>\n<tr>\n<th>Pictures</th>\n<th>Strength</th>\n<th>Type</th><th>Old price</th>\n<th>New price</th\n<th><th>\n</tr>\n";
	while($sl = mysqli_fetch_assoc($showLens)) {
		echo "<tr>\n<td><a href='images.php?l=".$sl["lensid"]."' title='".$sl["lens_strength"].$sl["lens_type"]."'/>Pictures</a></td>\n";
		echo "<td>".$sl["lens_strength"]."</td>\n";
		echo "<td>".$sl["lens_type"]."</td>\n";
		echo "<td>".$sl["lens_price"]."</td>\n";
		echo "<form action='prices.php' method='POST'>\n";
		echo "<td><input type='number' name='price' value='".$sl["lens_price"]."'></td>\n";
		echo "<td><input type='hidden' name='lid' value='".$sl["lensid"]."'>\n";
		echo "<button type='submit' name='fix_price'>Fix price</button></td>\n<tr>\n";
		echo "</form>\n";
	}
	echo "<tr>\n<td colspan='7'><div class='navbar'>Pages: \n";
	//displaying the navigation link
	for ($page = 1; $page <= $number_of_pages; $page++) {
	   echo "<a href='fix-price.php?type=$lens&page=".$page."'> $page </a>";
	}
	echo "</div>\n</td>\n<tr/>\n";
	echo "</table>\n";

} else {
	echo "<div class='text'>There are no stock in the Warehouse at the moment!</div>\n";
}
//if 'Accessories' was selected
} else if (isset($_REQUEST["type"]) && $_REQUEST["type"] === "Accessories") {
$accessories = $_REQUEST["type"];

echo "<div class='title'>Accessory prices</div>\n";

//return messages
if (isset($_REQUEST["m"]) && ($_REQUEST["m"] === "s")) {
	echo "<div class='text'>Price updated!</div>\n";
}
if (isset($_REQUEST["m"]) && ($_REQUEST["m"] === "e")) {
	echo "<div class='text'>Price update failed!</div>\n";
}

$show_acc = "SELECT accid, acc_name, acc_type, acc_price FROM accessories ORDER BY acc_type;";
$showAcc = connect($show_acc);

$number_of_results = mysqli_num_rows($showAcc);
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

$show_acc = "SELECT accid, acc_name, acc_type, acc_price FROM accessories ORDER BY acc_type LIMIT ". $offset . ",". $results_per_page.";";
$showAcc = connect($show_acc);
if(mysqli_num_rows($showAcc) > 0) {
	echo "<table>\n<tr>\n<th>Pictures</th>\n<th>Name</th>\n<th>Type</th><th>Old price</th>\n<th>New price</th\n<th><th>\n</tr>\n";
	while($sa = mysqli_fetch_assoc($showAcc)) {
		echo "<tr>\n<td><a href='images.php?a=".$sa["accid"]."' title='".$sa["acc_name"].$sa["acc_type"]."'/>Pictures</a></td>\n";
		echo "<td>".$sa["acc_name"]."</td>\n";
		echo "<td>".$sa["acc_type"]."</td>\n";
		echo "<td>".$sa["acc_price"]."</td>\n";
		echo "<form action='prices.php' method='POST'>\n";
		echo "<td><input type='number' name='price' value='".$sa["acc_price"]."'></td>\n";
		echo "<td><input type='hidden' name='aid' value='".$sa["accid"]."'>\n";
		echo "<button type='submit' name='fix_price'>Fix price</button></td>\n<tr>\n";
		echo "</form>\n";
	}
	echo "<tr>\n<td colspan='5'><div class='navbar'>Pages: \n";
	//displaying the navigation link
	for ($page = 1; $page <= $number_of_pages; $page++) {
	   echo "<a href='fix-price.php?type=$accessories&page=".$page."'> $page </a>";
	}
	echo "</div>\n</td>\n<tr/>\n";
	echo "</table>\n";

} else {
	echo "<div class='text'>There are no stock in the Warehouse at the moment!</div>\n";
}
}

echo "</div>\n";
include "footer.php";
?>
