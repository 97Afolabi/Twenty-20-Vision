<?php include "functions.php";
//can user access the Warehouse?
isperm_warehouse();
echo "<title>Stock requisition history</title>\n";
echo "<div id='main'>\n";

$show_srequests = "SELECT req_id, status_setby, status_seton, req_stock, req_status, req_staff, req_branch, DATE(req_date) AS tdate, staff.nameU, branches.branchName FROM stock_requisition JOIN branches ON stock_requisition.req_branch = branches.branchid JOIN staff ON stock_requisition.req_staff = staff.staffid WHERE stock_requisition.req_status = 'Treated' ORDER BY stock_requisition.req_id DESC;";
$showSRequests = connect($show_srequests);
if(mysqli_num_rows($showSRequests) > 0) {
	while ($sr = mysqli_fetch_assoc($showSRequests)) {
		echo "<table>\n<tr>\n<th colspan='2'></th></tr>\n";
		echo "<tr>\n<td>Date:</td><td>";
		?>
	    <script type="text/javascript">
	    //split returned into JavaScript compatible format for beautiful date and time
    
	    var raw_datetime = "<?php echo $sr["tdate"]; ?>";
	    var beaut_date = new Date(raw_datetime);
	    //date
	    var new_date = beaut_date.toDateString();

	    document.write(new_date);
	    </script>

    <?php
		echo "</td>\n<tr>\n";
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
		echo "<tr>\n<td>Treated by:</td><td>".$sr["nameU"]."</td>\n<tr>\n";
		echo "<tr>\n<td>Treated on:</td><td>";
		?>
	    <script type="text/javascript">
	    //split returned into JavaScript compatible format for beautiful date and time
    
		var raw_datetime = "<?php echo $sr["status_seton"]; ?>";
	    var datetime_split = raw_datetime.split(" ");
	    var date = datetime_split[0];
	    var time = datetime_split[1];

	    var new_datetime = date + "T" + time + "+01:00"; //YYYY-MM-MMTHH:MM:SS+01:00

	    var beaut_date = new Date(new_datetime);

	    //time
	    var new_time = beaut_date.toLocaleTimeString();
	    //date
	    var new_date = beaut_date.toDateString();

	    document.write(new_time + " " + new_date);
	    </script>

	    <?php
		echo "</td>\n<tr>\n";
		echo "</table><br/>\n";
	}
} else {
    echo "<div class='text'>There is no stock requisition history to display yet</div>";
}

echo "</div>\n";
include "footer.php";
?>
