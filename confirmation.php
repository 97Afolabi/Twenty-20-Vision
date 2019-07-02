<?php include "functions.php";

//can user manage Finance?
isperm_finance();

echo "<title>Submitted financial records</title>";

echo "<div id='main'>";
echo "<div class='title'>Records awaiting your confirmation</div>\n";

//show all Account records with status = 'Submitted'
$show_submitted = "SELECT recordid, rec_title, rec_full, rec_amount, rec_type, DATE(rec_date) AS rec_date, rec_status, branchid, staffid, rec_comment, date_submitted FROM account WHERE rec_status='Submitted' ORDER BY rec_date DESC;";
$showsubmitted = connect($show_submitted);

if (mysqli_num_rows($showsubmitted) > 0) {
    while ($sd = mysqli_fetch_assoc($showsubmitted)) {
        //prematurely fetch the returned Branch and Staff IDs
        $Branch = $sd["branchid"];
        $Staff = $sd["staffid"];
        //use those IDs in a multiple select statement to fetch their names instead of just the IDs
        //I suppose I could use JOIN for these but this is novel
        $BranchAndStaff = "SELECT (SELECT branchName FROM branches WHERE branchid='$Branch') AS Branch, (SELECT nameU FROM staff WHERE staffid='$Staff') AS Staff;";
        $BranchStaff = connect($BranchAndStaff);
    echo "<div class='text'>\n<table>\n";
    echo "<tr>\n<td>Title:</td>\n<td>" . $sd["rec_title"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Description:</td>\n<td>" . $sd["rec_full"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Amount:</td>\n<td>" . $sd["rec_amount"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Type:</td>\n<td>" . $sd["rec_type"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Date:</td>\n<td>";
 
    ?>
    <script type="text/javascript">
    //split returned into JavaScript compatible format for beautiful date and time
    
    var raw_datetime = "<?php echo $sd["rec_date"]; ?>";
    var beaut_date = new Date(raw_datetime);
    //date
    var new_date = beaut_date.toDateString();

    document.write(new_date);
    </script>

    <?php
    echo "</td>\n</tr>\n";
    //print the branch and Staff name here
    $bs = mysqli_fetch_assoc($BranchStaff);
    echo "<tr>\n<td>Branch:</td>\n<td>" . $bs["Branch"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Staff:</td>\n<td>" . $bs["Staff"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Submitted:</td>\n<td>";
    ?>
    <script type="text/javascript">
    //split returned into JavaScript compatible format for beautiful date and time
    //$rec_date is imaginary returned variable

    var raw_datetime = "<?php echo $sd["date_submitted"]; ?>";
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
    echo "</td>\n</tr>\n";
    //a form for the 'boss' to make comment
    echo "<form action='confirmation.php' method='POST'>";
    echo "<tr>\n<td>Comment:</td><td><textarea name='bosscomment'>". $sd["rec_comment"]."</textarea></td>\n</tr>";
    echo "<tr>\n<td><input type='hidden' name='dId' value='".$sd["recordid"]."''></td>\n<td>";
    echo "<button type='submit' name='Save_draft'>Save draft</button>\n";
    echo "<button type='submit' name='Confirm'>Confirm</button></td>\n</tr>\n";
    echo "</table>\n";
    echo "</form>\n";
    echo "</div>\n";
} //end printing results

//if 'boss' confirms set status = 'Confirmed'
if (isset($_POST["Confirm"])) {
$BComment = test_input($_POST["bosscomment"]);
$RecordId = test_input($_POST["dId"]);
$confirmedby = $_SESSION["staffid"];

$make_confirm = "UPDATE account SET rec_status='Confirmed', rec_comment='$BComment', confirmedby='$confirmedby' WHERE recordid=$RecordId;";
$makeconfirm = connect($make_confirm);
if ($makeconfirm) {
	header("Location: confirmation.php");
	exit;
}
} //end confirm

// if 'boss' no confirm, leave status = 'Submitted' and save the comment
if (isset($_POST["Save_draft"])) {
$BComment = test_input($_POST["bosscomment"]);
$RecordId = test_input($_POST["dId"]);

$make_draft = "UPDATE account SET rec_status='Submitted', rec_comment='$BComment' WHERE recordid=$RecordId;";
$makedraft = connect($make_draft);
if ($makedraft) {
	header("Location: confirmation.php");
	exit;
}
} //end save draft

} else {
    echo "<div class='text'>There are no records for you to confirm at the moment!</div>\n";
}
echo "</div>";

include "footer.php";

?>
