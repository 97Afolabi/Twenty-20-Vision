<?php include "functions.php";
?>
<title>Stock requisition</title>
<div id='main'>
<?php
if(isset($_REQUEST["m"]) && $_REQUEST["m"] === "s") {
	echo "<div class='text'>Your stock request has been sent!</div>\n";
} else if(isset($_REQUEST["m"]) && $_REQUEST["m"] === "f") {
	echo "<div class='text'>Stock requisition status changed!</div>\n";
}
?>
<div class='title'>Stock requisition</div>
<form action="stock-requisition.php" method="POST">
Enter the quantity and name of stock you want<br/>
Separate each name and quantity by a comma (,)<br/>
<textarea name='stock' placeholder='2 Solion SN-422 frame, 6 +050 +300 lens, 4 dusters' cols='20' rows='10' required="required"></textarea><br/>
<input type='hidden' name='tdate' value='<?php date_is();?>'/>
<button type='submit' name='request'>Request stock</button>
</form>

<?php
if(isset($_POST["request"])) {
	$stock = test_input($_POST["stock"]);
	$tdate = test_input($_POST["tdate"]);
	$staff = $_SESSION["staffid"];
	$branch = $_SESSION["branchid"];

	$new_request = "INSERT INTO stock_requisition (req_stock, req_date, req_staff, req_branch, req_status) VALUES ('$stock', '$tdate', $staff, $branch, 'Sent');";
	$newRequest = connect($new_request);

	if ($newRequest) {
		header("Location: stock-requisition.php?m=s");
		exit;
	} else {
		echo "<div class='text'>Unable to submit your stock request at the moment. Please, contact the site admin</div>\n";
	}
}

//can user access the Warehouse? If yes, show requisition history
if ($_SESSION["perm_warehouse"] === "privileged") {
echo "<br/><a href='requisition-history.php' title='Stock requisition history'><button type='submit'>Stock requisition history</button></a><br/>\n";

$show_srequests = "SELECT req_id, req_stock, DATE(req_date) AS tdate, staff.nameU, branches.branchName, stock_requisition.req_status FROM stock_requisition JOIN branches ON stock_requisition.req_branch = branches.branchid JOIN staff ON stock_requisition.req_staff = staff.staffid WHERE stock_requisition.req_status != 'Treated' ORDER BY stock_requisition.req_id DESC;";
$showSRequests = connect($show_srequests);
if(mysqli_num_rows($showSRequests) > 0) {
	while ($sr = mysqli_fetch_assoc($showSRequests)) {
		echo "<table>\n<tr>\n<th colspan='2'></th></tr>\n";
		echo "<tr>\n<td>Date:</td><td>".$sr["tdate"]."</td>\n<tr>\n";
		echo "<tr>\n<td>Branch:</td><td>".$sr["branchName"]."</td>\n<tr>\n";
		echo "<tr>\n<td>Sent by:</td><td>".$sr["nameU"]."</td>\n<tr>\n";
		echo "<tr>\n<td>Stock:</td><td>";
		//assign the value to a variable
		$stri = $sr["req_stock"];
		//convert the value to an array, break the string after a comma
		$str = explode(',',$stri);
		//print each item on a separate line
		foreach ($str as $item) {
			echo $item . "<br/>\n";
		}
		echo "</td>\n<tr>\n";
		echo "<tr>\n<td>Mark as:</td>\n<td>\n";
		echo "<form action='stock-requisition.php' method='POST'>\n";
		echo "<input type='radio' name='status' value='Acknowledged' checked='checked'>Acknowledged<br/>\n";
		echo "<input type='radio' name='status' value='Treated'>Treated<br/>\n";
		echo "<input type='hidden' name='sid' value='".$sr["req_id"]."'>\n";
		echo "<input type='hidden' name='sdate' value='";
		echo time_date();
		echo "'>";
		echo "<button type='submit' name='submit'>Set</button>\n";
		echo "</form>\n";
		echo "<td>\n<tr>\n";
		echo "</table><br/>\n";
	}
}

//set the status
if(isset($_POST["submit"])) {
	$status = test_input($_POST["status"]);
	$stockid = test_input($_POST["sid"]);
	$setby = $_SESSION["staffid"];
	$seton = test_input($_POST["sdate"]);

	$set_status = "UPDATE stock_requisition SET req_status = '$status', status_setby = '$setby', status_seton = '$seton' WHERE req_id = $stockid;";
	$setStatus = connect($set_status);

	if ($setStatus) {
		header("Location: stock-requisition.php?m=f");
		exit;
	}
}
} //end permission Warehouse
echo "</div>\n";
include "footer.php";
?>
