<?php include "functions.php";

echo "<title>New account record</title>\n";

echo "<div id='main'>\n";
echo "<div class='title'>New account record</div>\n";

if (isset($_REQUEST["m"]) && ($_REQUEST["m"] === "s")) {
    echo "<div class='text'>Record submitted!</div>\n";
} else if (isset($_REQUEST["m"]) && ($_REQUEST["m"] === "d")) {
    echo "<div class='text'>Record saved!</div>\n";
}

//if 'Draft' button is clicked, set the status as 'Draft'
if (isset($_POST["Draft"])) {
    $ttitle = test_input($_POST["t_title"]);
    $tdesc = test_input($_POST["t_desc"]);
    $ttype = test_input($_POST["t_type"]);
    $tamount = test_input($_POST["t_amount"]);
    $tdate = test_input($_POST["t_date"]);
    $date_subm = test_input($_POST["date_subm"]);
    $BranchId = $_SESSION["branchid"];
    $StaffId = $_SESSION["staffid"];

	$make_draft = "INSERT INTO account (rec_title, rec_full, rec_amount, rec_type, rec_date, rec_status, date_submitted, branchid, staffid) VALUES ('$ttitle','$tdesc', $tamount, '$ttype', '$tdate', 'Draft', '$date_subm', $BranchId, $StaffId);";
    $makedraft = connect($make_draft);
    if ($makedraft) {
        header("Location: account.php?m=d");
        exit;
    } else {
        echo "<div class='text'>Unable to save your draft entry at the moment. Contact site admin</div>\n";
    }
}

//if 'Submit' button is clicked, set the status as 'Submitted'
if (isset($_POST["Submit"])) {
    $ttitle = test_input($_POST["t_title"]);
    $tdesc = test_input($_POST["t_desc"]);
    $ttype = test_input($_POST["t_type"]);
    $tamount = test_input($_POST["t_amount"]);
    $tdate = test_input($_POST["t_date"]);
    $date_subm = test_input($_POST["date_subm"]);
    $BranchId = $_SESSION["branchid"];
    $StaffId = $_SESSION["staffid"];

   $make_submit = "INSERT INTO account (rec_title, rec_full, rec_amount, rec_type, rec_date, rec_status, date_submitted, branchid, staffid) VALUES ('$ttitle','$tdesc',$tamount,'$ttype','$tdate','Submitted', '$date_subm', '$BranchId', '$StaffId');";
    $makesubmit = connect($make_submit);
    if ($makesubmit) {
        header("Location: account.php?m=s");
        exit;
    } else {
        echo "<div class='text'>Unable to submit your entry at the moment. Contact site admin</div>\n";
    }
}
?>
<!-- The form below is displayed by default so successive entries can be made without reloading the page.
     user gets the message on top of the page too -->
<a href="draft.php"><button type='submit'>View saved records</button></a><br/>
<form action="account.php" method="POST">
Title:<br/>
<input type="text" name="t_title" placeholder="Transaction's title" required="required"><br/>
Description:<br/>
<textarea name="t_desc" placeholder="Full description" required="required"></textarea><br/>
Type:<br/>
<select name="t_type" required="required">
    <option value="Sales">Sale</option><br/>
    <option value="Non-refundable expenditure">Non-refundable expenditure</option><br/>
    <option value="Refundable expenditure">Refundable expenditure</option><br/>
    <option value="Refund">Refund</option><br/>
    <option value="Fund withdrawal">Fund withdrawal</option>
</select><br/>
Amount:<br/>
<input type="number" name="t_amount" placeholder="Amount" required="required"><br/>
Date:<br/>
<input type="text" name="t_date" placeholder="YYYY-MM-DD" value="<?php echo date_is();?>"><br/>
<input type="hidden" name="date_subm" value="<?php echo time_date();?>"><br/>
<input type="submit" name="Draft" value="Save as draft"/> &nbsp;
<input type="submit" name="Submit" value="Submit"/>
</form>
<br/>

<div class='title'>Help</div>
<?php
help_new_record();
echo "</div>";
include "footer.php";
?>
