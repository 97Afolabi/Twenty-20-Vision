<?php include "functions.php";
//can user manage Finance?
isperm_finance();
//change frame price
if (isset($_REQUEST["fix_price"]) && isset($_REQUEST["fid"])) {
	$frameId = $_REQUEST["fid"];
	$price = $_REQUEST["price"];
	$fix_price = "UPDATE frames SET frame_price = $price WHERE frameid = $frameId;";
	$fixPrice = connect($fix_price);

	if($fixPrice) {
		header("Location: fix-price.php?type=Frames&m=s");
		exit;
	} else {
		header("Location: fix-price.php?type=Frames&m=e");
		exit;
	}
}
//change lens price
if (isset($_REQUEST["fix_price"]) && isset($_REQUEST["lid"])) {
	$lensId = $_REQUEST["lid"];
	$price = $_REQUEST["price"];
	$fix_price = "UPDATE lenses SET lens_price = $price WHERE lensid = $lensId;";
	$fixPrice = connect($fix_price);

	if($fixPrice) {
		header("Location: fix-price.php?type=Lenses&m=s");
		exit;
	} else {
		header("Location: fix-price.php?type=Lenses&m=e");
		exit;
	}
}
//change accessory price
if (isset($_REQUEST["fix_price"]) && isset($_REQUEST["aid"])) {
	$accId = $_REQUEST["aid"];
	$price = $_REQUEST["price"];
	$fix_price = "UPDATE accessories SET acc_price = $price WHERE accid = $accId;";
	$fixPrice = connect($fix_price);

	if($fixPrice) {
		header("Location: fix-price.php?type=Accessories&m=s");
		exit;
	} else {
		header("Location: fix-price.php?type=Accessories&m=e");
		exit;
	}
}

?>
