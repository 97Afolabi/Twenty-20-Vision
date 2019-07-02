<?php include "functions.php";

//can use access the Warehouse?
isperm_warehouse();

/*
* This is a multi-functional delete page that works depending on the ID sent to it
* if no ID is specified, send the visitor home

* I'm unable to delete because of foreign key constraints
* So I'm thinking of 'delisting' instead of 'deleting'
* Delisting will work like de-activating a staff's account -- the item will not be visible where
* others are listed but can be seen on a special-access page
* that way, it can be easily reversed if there is need for it
* the table will be modified to Status enum('listed', 'delisted')
*/

echo "<div id='main'>\n";

echo "<div class='text'>\n";
if (isset($_REQUEST["m"])) {
if ($_REQUEST["m"] === "l") {
	echo "Stock is now listed! \n";
	if(isset($_REQUEST["fid"])) {
		echo "<a href='wh-frame.php'>All frames (Warehouse)</a>\n";
	} else if (isset($_REQUEST["lid"])) {
		echo "<a href='wh-lenses.php'>All lenses (Warehouse)</a>\n";
	} else if (isset($_REQUEST["aid"])) {
		echo "<a href='wh-accessory.php'>All accessories (Warehouse)</a>\n";
	}
} else if ($_REQUEST["m"] === "d") {
	echo "Stock has been delisted! \n";
	if (isset($_REQUEST["fid"])) {
		echo "<a href='wh-frame.php'>All frames (Warehouse)</a>\n";
	} else if (isset($_REQUEST["lid"])) {
		echo "<a href='wh-lenses.php'>All lenses (Warehouse)</a>\n";
	} else if (isset($_REQUEST["aid"])) {
		echo "<a href='wh-accessory.php'>All accessories (Warehouse)</a>\n";
	}
}
}

if (isset($_REQUEST["fid"])) {
//this is for frames
$frame = $_REQUEST["fid"];

$frame_details = "SELECT frame_name, frame_model, frame_size, frame_status FROM frames WHERE frameid = $frame;";
$frameDetails = connect($frame_details);
if (mysqli_num_rows($frameDetails) > 0) {
	while($finfo = mysqli_fetch_assoc($frameDetails)) {
	echo "<title>Status " . $finfo["frame_name"]." ".$finfo["frame_model"]."</title>";
	echo "<b>" . $finfo["frame_name"]." ".$finfo["frame_model"]."</b><br/>\n";
	echo "Status:</br>\n";
	echo "<form action='delete.php?fid=$frame' method='POST'>\n";
	echo "<input type='radio' name='confirm' value='listed'";
	isset_check($finfo["frame_status"], "listed");
	echo ">Listed<br/>\n";
	echo "<input type='radio' name='confirm' value='de-listed'";
	isset_check($finfo["frame_status"], "de-listed");
	echo ">De-listed<br/>\n";
	echo "<button type='submit' name='submit'>Set status</button>\n";
	echo "</form>";
	echo "</div>\n";

	if (isset($_POST["submit"])) {
		if ($_POST["confirm"] === "de-listed") {
		$delete_frame = "UPDATE frames SET frame_status = 'de-listed' WHERE frameid = $frame;";
		$deleteFrame = connect($delete_frame);
			if ($deleteFrame) {
				header("Location: delete.php?fid=$frame&m=d");
				exit;
			}
		} else if ($_POST["confirm"] === "listed") {
		$list_frame = "UPDATE frames SET frame_status = 'listed' WHERE frameid = $frame;";
		$listFrame = connect($list_frame);
			if($listFrame) {
				header("Location: delete.php?fid=$frame&m=l");
				exit;
			}
		}
	}
	}
}

} else if (isset($_REQUEST["lid"])) {
//this is for lenses
$lens = $_REQUEST["lid"];

$lens_details = "SELECT lens_strenght, lens_type, lens_status FROM lenses WHERE lensid = $lens;";
$lensDetails = connect($lens_details);
if (mysqli_num_rows($lensDetails) > 0) {
	while($linfo = mysqli_fetch_assoc($lensDetails)) {
	echo "<title>Status " . $linfo["lens_strenght"]." ".$linfo["lens_type"]."</title>";
	echo "<b>".$linfo["lens_strenght"]." ".$linfo["lens_type"]."</b><br/>";
	echo "Status:</br>\n";
	echo "<form action='delete.php?lid=$lens' method='POST'>\n";
	echo "<input type='radio' name='confirm' value='listed'";
	isset_check($linfo["lens_status"], "listed");
	echo ">Listed<br/>\n";
	echo "<input type='radio' name='confirm' value='de-listed'";
	isset_check($linfo["lens_status"], "de-listed");
	echo ">De-listed<br/>\n";
	echo "<button type='submit' name='submit'>Set status</button>\n";
	echo "</form>";
	echo "</div>\n";

	if (isset($_POST["submit"])) {
		if ($_POST["confirm"] === "de-listed") {
		$delete_lens = "UPDATE lenses SET lens_status = 'de-listed' WHERE lensid = $lens;";
		$deleteLens = connect($delete_lens);
			if ($deleteLens) {
				header("Location: delete.php?lid=$lens&m=d");
				exit;
			}
		} else if ($_POST["confirm"] === "listed") {
		$list_lens = "UPDATE lenses SET lens_status = 'listed' WHERE lensid = $lens;";
		$listLens = connect($list_lens);
			if($listLens) {
				header("Location: delete.php?lid=$lens&m=l");
				exit;
			}
		}
	}
	}
}


} else if (isset($_REQUEST["aid"])) {
//this is for accessories
$acc = $_REQUEST["aid"];

$acc_details = "SELECT acc_name, acc_type, acc_status FROM accessories WHERE accid = $acc;";
$accDetails = connect($acc_details);
if (mysqli_num_rows($accDetails) > 0) {
	while($ainfo = mysqli_fetch_assoc($accDetails)) {
	echo "<title>Status " . $ainfo["acc_type"]." ".$ainfo["acc_name"]."</title>";
	echo "<b>".$ainfo["acc_type"].": ".$ainfo["acc_name"]."</b><br/>";
	echo "Status:</br>\n";
	echo "<form action='delete.php?aid=$acc' method='POST'>\n";
	echo "<input type='radio' name='confirm' value='listed'";
	isset_check($ainfo["acc_status"], "listed");
	echo ">Listed<br/>\n";
	echo "<input type='radio' name='confirm' value='de-listed'";
	isset_check($ainfo["acc_status"], "de-listed");
	echo ">De-listed<br/>\n";
	echo "<button type='submit' name='submit'>Set status</button>\n";
	echo "</form>";
	echo "</div>\n";

	if (isset($_POST["submit"])) {
		if ($_POST["confirm"] === "de-listed") {
		$delete_acc = "UPDATE accessories SET acc_status = 'de-listed' WHERE accid = $acc;";
		$deleteAcc = connect($delete_acc);
			if ($deleteAcc) {
				header("Location: delete.php?aid=$acc&m=d");
				exit;
			}
		} else if ($_POST["confirm"] === "listed") {
		$list_acc = "UPDATE accessories SET acc_status = 'listed' WHERE accid = $acc;";
		$listAcc = connect($list_acc);
			if($listAcc) {
				header("Location: delete.php?aid=$acc&m=l");
				exit;
			}
		}
	}
	}
}

} else {
//oops! you're empty-handed, go home!
	header("Location: home.php");
	exit;
}

echo "<div class='title'>Help</div>\n";
help_delete();
echo "</div>";
include "footer.php";
?>
