<?php include "functions.php";

echo "<title>Saved financial records</title>";

echo "<div id='main'>\n";
$BrID = $_SESSION["branchid"];
$StaffId = $_SESSION["staffid"];

//second part for editing specific draft entries
if (isset($_REQUEST["dId"])) {

echo "<div class='title'>Edit saved record</div>\n";

$BrID = $_SESSION["branchid"];
$StaffId = $_SESSION["staffid"];
$draftid = $_REQUEST["dId"];
$show_draft = "SELECT recordid, rec_title, rec_full, rec_amount, rec_type, DATE(rec_date) AS rec_date, rec_status FROM account WHERE rec_status = 'Draft' AND  branchid = $BrID AND staffid = $StaffId AND recordid = $draftid;";
//too many 'unnecessary' conditions here but good 'security' measures
$showdraft = connect($show_draft);

//if 'Submit' button was clicked, set the status as 'Submitted'
if (isset($_POST["Submit"])) {
    $ttitle = test_input($_POST["t_title"]);
    $tdesc = test_input($_POST["t_desc"]);
    $ttype = test_input($_POST["t_type"]);
    $tamount = test_input($_POST["t_amount"]);
    $BranchId = $_SESSION["branchid"];
    $StaffId = $_SESSION["staffid"];
    $RecordId = test_input($_POST["dId"]);
    $tdate = test_input($_POST["t_date"]);
    $date_subm = test_input($_POST["date_submitted"]);

   $make_submit = "UPDATE account SET rec_title='$ttitle', rec_full='$tdesc', rec_amount=$tamount, rec_type='$ttype', rec_date='$tdate', rec_status='Submitted', date_submitted = '$date_subm' WHERE branchid=$BranchId AND staffid=$StaffId AND recordid=$RecordId;";
    $makesubmit = connect($make_submit);
    if ($makesubmit) {
        header("Location: draft.php");
        exit;
    } else {
        echo "<div class='text'>Unable to submit your entry at the moment. Contact site admin</div>\n";
    }
}

//if 'Save_draft' button was clicked, set the status as 'Draft'
if (isset($_POST["Save_draft"])) {
    $ttitle = test_input($_POST["t_title"]);
    $tdesc = test_input($_POST["t_desc"]);
    $ttype = test_input($_POST["t_type"]);
    $tamount = test_input($_POST["t_amount"]);
    $BranchId = $_SESSION["branchid"];
    $StaffId = $_SESSION["staffid"];
    $RecordId = test_input($_POST["dId"]);
    $tdate = test_input($_POST["t_date"]);
    $date_subm = test_input($_POST["date_submitted"]);

   $make_draft = "UPDATE account SET rec_title='$ttitle', rec_full='$tdesc', rec_amount=$tamount, rec_type='$ttype', rec_date='$tdate', date_submitted = '$date_subm', rec_status='Draft' WHERE branchid=$BranchId AND staffid=$StaffId AND recordid=$RecordId;";
    $makedraft = connect($make_draft);
    if ($makedraft) {
        header("Location: draft.php");
        exit;
    } else {
        echo "<div class='text'>Unable to submit your entry at the moment. Contact site admin</div>\n";
    }
}

//Edit draft entry
if (mysqli_num_rows($showdraft) > 0) {
    echo "<div class='text'>\n<form action='draft.php' method='POST'>";
    while ($sd = mysqli_fetch_assoc($showdraft)) {
    echo "Title<br/>\n";
    echo "<input type='text' name='t_title' value='" . $sd["rec_title"] . "' required='required'/><br/>\n";
    echo "Description<br/>\n";
    echo "<textarea name='t_desc'>" . $sd["rec_full"] . "</textarea><br/>\n";
    echo "Amount<br/>\n";
    echo "<input type='number' name='t_amount' value='" . $sd["rec_amount"] . "'/><br/>\n";
    echo "Type:<br/>";
    echo "<select name='t_type' required='required'>\n";
    echo "<option value='Sales'";
        if ($sd["rec_type"] === 'Sales') {
            echo "selected='selected'";}
            echo ">Sale</option>\n";
    echo "<option value='Non-refundable expenditure'";
        if ($sd["rec_type"] === 'Non-refundable expenditure') {
            echo "selected='selected'";}
            echo ">Non-refundable expenditure</option>\n";
    echo "<option value='Refundable expenditure'";
        if ($sd["rec_type"] === 'Refundable expenditure') {
            echo "selected='selected'";}
            echo ">Refundable expenditure</option>\n";
    echo "<option value='Refund'";
        if ($sd["rec_type"] === 'Refund') {
            echo "selected='selected'";}
            echo ">Refund</option>\n";
    echo "<option value='Fund withdrawal'";
        if ($sd["rec_type"] === 'Fund withdrawal') {
            echo "selected='selected'";}
            echo ">Fund withdrawal</option>\n";
    echo "</select><br/>\n";
    echo "Date<br/>\n";
    echo "<input type='text' name='t_date' value='".$sd["rec_date"]."' required='required'><br/>\n";
    echo "<input type='hidden' name='date_submitted' value='";
    echo time_date();
    echo "'><br/>\n";
    echo "<input type='hidden' name='dId' value='".$draftid."'>";
    echo "</table>\n";
    }
    echo "<button type='submit' name='Save_draft'>Save draft</button>\n";
    echo "<button type='submit' name='Submit'>Submit</button>\n";
    echo "</form>\n</div>\n";
}

}

//first part. Show all draft entries
echo "<div class='title'>Saved financial records</div>\n";

$show_draft = "SELECT recordid, rec_title, rec_full, rec_amount, rec_type, DATE(rec_date) AS rec_date, rec_status FROM account WHERE rec_status = 'Draft' AND  branchid = $BrID AND staffid = $StaffId ORDER BY rec_date DESC;";
$showdraft = connect($show_draft);

if (mysqli_num_rows($showdraft) > 0) {
    while ($sd = mysqli_fetch_assoc($showdraft)) {
    echo "<div class='text'>\n<table>";
    echo "<tr>\n<td>Title</td>\n<td>" . $sd["rec_title"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Description</td>\n<td>" . $sd["rec_full"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Amount</td>\n<td>" . $sd["rec_amount"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Type</td>\n<td>" . $sd["rec_type"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Date</td>\n<td>" . $sd["rec_date"] . "</td>\n</tr>\n";
    echo "</table>\n";
    echo "<a href='draft.php?dId=" . $sd["recordid"] . "'><button type='submit'>Edit this record</button></a>";
    echo "</div>\n";
    }
} else {
    echo "<div class='text'>You do not have any saved record at the moment</div>\n";
}

echo "<div class='title'>Help</div>\n";
help_saved_records();
   echo "</div>\n";

include "footer.php";
?>
