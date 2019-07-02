<?php
include "functions.php";
?>

<div id='main'>
<div class='title'>Search</div>

<form action='search.php' method='GET'>
<input type='text' name='q' placeholder='Search' value="<?php if(isset($_REQUEST["q"])) {echo $_REQUEST["q"];}?>"><br/>
<!--If the category matches the search query check that
	If no category has been selected, check the 'Frames' box
 -->
<input type='radio' name='r' value='f' <?php if(isset($_REQUEST["r"])) {isset_check($_REQUEST["r"], "f");} else { echo 'checked="checked"'; } ?>>Frames<br/>
<input type='radio' name='r' value='l' <?php if(isset($_REQUEST["r"])) {isset_check($_REQUEST["r"], "l");}?>>Lenses<br/>
<input type='radio' name='r' value='a' <?php if(isset($_REQUEST["r"])) {isset_check($_REQUEST["r"], "a");}?>>Accessories<br/>
<!--
* input type radio must have the same name otherwise, they will all be 'selectable' but only the value of the last one will be sent with the form
-->
<button type='submit'>Search</button>
</form>

<?php
$branch = $_SESSION["branchid"];

//search in frames
if(isset($_GET["q"]) && ($_GET["r"] === 'f') && $_GET["q"] != "") {
	$search = test_input($_GET["q"]);

echo "<title> Search $search</title>\n";

	//allow search in the BrandName, Model and, Frame size columns this may be limited to only
	//Brand name and Model to reduce clutter in the result
	//The advantage, is that particular BrandName, Model, or, Size can be searched for
	$search_frames = "SELECT frame_name, frame_model, frame_size, f_physicalq, frame_stock.branchid, branchName FROM frames JOIN frame_stock ON frames.frameid = frame_stock.frameid JOIN branches ON frame_stock.branchid = branches.branchId WHERE frame_name LIKE '%$search%' OR frame_model LIKE '%$search%' OR frame_size LIKE '%$search%' ORDER BY frame_stock.branchid;";
	//this is the global search without branch restriction. Restrictions below

	$searchFrames = connect($search_frames);
	if(mysqli_num_rows($searchFrames) > 0) {

		//if the result is found, print the result in a table
		echo "<table>\n<tr>\n<th>Name</th>\n<th>Model</th>\n<th>Size</th>\n<th>Quantity</th>\n<th>Branch</th>\n</tr>\n";

		//use the while loop since multiple results (rows) are expected
		while ($sf = mysqli_fetch_assoc($searchFrames)) {

		echo "<title>Search ".$sf["frame_name"]." ".$sf["frame_model"]." ".$sf["frame_size"]."</title>\n";

		if ($sf["f_physicalq"] > 0) {
		//the search is for quantity, otherwise, output "Out of stock!"

		if ($_SESSION["perm_stock"] === "local") {
		//if the current user is not allowed to view stock in other branches

			if ($sf["branchid"] === $branch) {
			//if the branch is the query result is the same as the user's current branch

				echo "<tr>\n<td>".$sf["frame_name"]."</td>\n<td>".$sf["frame_model"]."</td>\n<td>".$sf["frame_size"]."</td>\n<td class='center'>".$sf["f_physicalq"]."</td>\n<td>&nbsp;</td><tr/>\n";
				//print the search result
				//parameters: Physical quantity greater than 0, local stock access, the branch is the same

			} else {
				echo "<tr>\n<td>".$sf["frame_name"]."</td>\n<td>".$sf["frame_model"]."</td>\n<td>".$sf["frame_size"]."</td>\n<td>Found some!</td>\n<td>". $sf["branchName"]."</td>\n</tr>\n";
				//if another branch has more than 0, simply show a message that some stock has
				//been found in that branch without showing the actual quantity the branch has
			}

		} else {

			//if the user is permitted to view stock in other branches or is permitted to access the Warehouse
			echo "<tr>\n<td>".$sf["frame_name"]."</td>\n<td>".$sf["frame_model"]."</td>\n<td>".$sf["frame_size"]."</td>\n<td class='center'>".$sf["f_physicalq"]."</td>\n<td>".$sf["branchName"]."</td>\n<tr/>\n";
			//print the search result and quantity and the branch's name for easy identification
			//staff in charge of the Warehouse can easily how much of each stock is in each branch
			//anyone permitted to access the Warehouse will have global stock access
		}
		} else {
			//if a particular quantity has 0 quantity show the message below and print the branch's name
			echo "<tr>\n<td>".$sf["frame_name"]."</td>\n<td>".$sf["frame_model"]."</td>\n<td>".$sf["frame_size"]."</td>\n<td>Out of stock!</td>\n<td>". $sf["branchName"]."</td>\n</tr>\n";
		}

		} //end the while loop

		echo "</table>\n"; //close the table
	} else {
		//show this if no match was found
		echo "<div class='text'>No match was found for your search query. Try again.</div>\n";
	}
} //end the search for frames
//search lenses
else if(isset($_GET["q"]) && ($_GET["r"] === 'l' && $_GET["q"] != "")) { //begin search for lens
	$search = test_input($_GET["q"]);

echo "<title>Search $search</title>\n";

	//search Strength and Type
	$search_lens = "SELECT lens_strength, lens_type, l_physicalq, lens_stock.branchid, branchName FROM lenses JOIN lens_stock ON lenses.lensid = lens_stock.lensid JOIN branches ON lens_stock.branchid = branches.branchid WHERE lens_strength LIKE '%$search%' OR lens_type LIKE '%$search%' ORDER BY lens_stock.branchid;";
	//this is the global search without branch restriction. Restrictions below

	$searchLens = connect($search_lens);
	if(mysqli_num_rows($searchLens) > 0) {

		//if the result is found, print the result in a table
		echo "<table>\n<tr>\n<th>Strength</th>\n<th>Type</th>\n<th>Quantity</th>\n<th>Branch</th>\n</tr>\n";

		//use the while loop since multiple results (rows) are expected
		while ($sl = mysqli_fetch_assoc($searchLens)) {

		if ($sl["l_physicalq"] > 0) {
		//the search is for quantity, otherwise, output "Out of stock!"

		if ($_SESSION["perm_stock"] === "local") {
		//if the current user is not allowed to view stock in other branches and is not allowed
		//in the Warehouse

			if ($sl["branchid"] === $branch) {
			//if the branch is the query result is the same as the user's current branch

				echo "<tr>\n<td>".$sl["lens_strength"]."</td>\n<td>".$sl["lens_type"]."</td>\n<td class='center'>".$sl["l_physicalq"]."</td>\n<td>&nbsp;</td><tr/>\n";
				//print the search result
				//parameters: Physical quantity greater than 0, local and unprivileged access for
				//	stock and Warehouse respectively, the branch is the same

			} else {
				echo "<tr>\n<td>".$sl["lens_strength"]."</td>\n<td>".$sl["lens_type"]."</td>\n<td>Found some</td>\n<td>". $sl["branchName"]."</td>\n</tr>\n";
				//if another branch has more than 0, simply show a message that some stock has
				//been found in that branch without showing the actual quantity the branch has
			}

		} else {

			//if the user is permitted to view stock in other branches or is permitted to access the Warehouse
			echo "<tr>\n<td>".$sl["lens_strength"]."</td>\n<td>".$sl["lens_type"]."</td>\n<td class='center'>".$sl["l_physicalq"]."</td><td>".$sl["branchName"]."</td>\n<tr/>\n";
			//print the search result and quantity and the branch's name for easy identification
			//staff in charge of the Warehouse can easily how much of each stock is in each branch
		}
		} else {
			//if a particular quantity has 0 quantity show the message below and print the branch's name
			echo "<tr>\n<td>".$sl["lens_strength"]."</td>\n<td>".$sl["lens_type"]."</td>\n<td>Out of stock!</td>\n<td>". $sl["branchName"]."</td>\n</tr>\n";
		}

		} //end the while loop

		echo "</table>\n"; //close the table
	} else {
		//show this if no match was found
		echo "<div class='text'>No match was found for your search query. Try again.</div>\n";
	}
} //end the search for lenses
else if(isset($_GET["q"]) && ($_GET["r"] === 'a' && $_GET["q"] != "")) { //begin search for accessory
	$search = test_input($_GET["q"]);

echo "<title>Search $search</title>\n";

	//search Strength and Type
	$search_acc = "SELECT acc_name, acc_type, a_physicalq, accessories_stock.branchid, branchName FROM accessories JOIN accessories_stock ON accessories.accid = accessories_stock.accid JOIN branches ON accessories_stock.branchid = branches.branchid WHERE acc_name LIKE '%$search%' OR acc_type LIKE '%$search%' ORDER BY accessories_stock.branchid;";
	//this is the global search without branch restriction. Restrictions below

	$searchAcc = connect($search_acc);
	if(mysqli_num_rows($searchAcc) > 0) {

		//if the result is found, print the result in a table
		echo "<table>\n<tr>\n<th>Accessory</th>\n<th>Type</th>\n<th>Quantity</th>\n<th>Branch</th>\n</tr>\n";

		//use the while loop since multiple results (rows) are expected
		while ($sa = mysqli_fetch_assoc($searchAcc)) {

		if ($sa["a_physicalq"] > 0) {
		//the search is for quantity, otherwise, output "Out of stock!"

		if ($_SESSION["perm_stock"] === "local") {
		//if the current user is not allowed to view stock in other branches and is not allowed
		//in the Warehouse

			if ($sa["branchid"] === $branch) {
			//if the branch is the query result is the same as the user's current branch

				echo "<tr>\n<td>".$sa["acc_name"]."</td>\n<td>".$sa["acc_type"]."</td>\n<td class='center'>".$sa["a_physicalq"]."</td>\n<td>&nbsp;</td><tr/>\n";
				//print the search result
				//parameters: Physical quantity greater than 0, local and unprivileged access for
				//	stock and Warehouse respectively, the branch is the same

			} else {
				echo "<tr>\n<td>".$sa["acc_name"]."</td>\n<td>".$sa["acc_type"]."</td>\n<td>Found some</td>\n<td>". $sa["branchName"]."</td>\n</tr>\n";
				//if another branch has more than 0, simply show a message that some stock has
				//been found in that branch without showing the actual quantity the branch has
			}

		} else {

			//if the user is permitted to view stock in other branches or is permitted to access the Warehouse
			echo "<tr>\n<td>".$sa["acc_name"]."</td>\n<td>".$sa["acc_type"]."</td>\n<td class='center'>".$sa["a_physicalq"]."</td><td>".$sa["branchName"]."</td>\n<tr/>\n";
			//print the search result and quantity and the branch's name for easy identification
			//staff in charge of the Warehouse can easily how much of each stock is in each branch
		}
		} else {
			//if a particular quantity has 0 quantity show the message below and print the branch's name
			echo "<tr>\n<td>".$sa["acc_name"]."</td>\n<td>".$sa["acc_type"]."</td>\n<td>Out of stock!</td>\n<td>". $sa["branchName"]."</td>\n</tr>\n";
		}

		} //end the while loop

		echo "</table>\n"; //close the table
	} else {
		//show this if no match was found
		echo "<div class='text'>No match was found for your search query. Try again.</div>\n";
	}
} //end the search for accessories

//show default title
else {
	echo "<title>Search</title>\n";
}

//help
echo "<div class='title'>Help</div>\n";
help_search();

echo "</div>";
include "footer.php";
?>
