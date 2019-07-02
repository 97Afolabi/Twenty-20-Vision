<?php include "functions.php";

echo "<title>Awaiting confirmation</title>";

echo "<div id='main'>";
echo "<div class='title'>Records awaiting confirmation</div>\n";

$Staff = $_SESSION["staffid"];
$show_confirmed = "SELECT recordid, rec_title, rec_full, rec_amount, rec_type, DATE(rec_date) AS rec_date, rec_status, account.branchid, account.staffid, rec_comment, date_submitted, staff.nameU, branches.branchName FROM account JOIN staff ON account.staffid = staff.staffid JOIN branches ON account.branchid = branches.branchid WHERE rec_status='Submitted' ORDER BY rec_date DESC;"; // && StaffId = $Staff
$showconfirmed = connect($show_confirmed);

if (mysqli_num_rows($showconfirmed) > 0) {
    while ($sd = mysqli_fetch_assoc($showconfirmed)) {
    echo "<div class='text'>\n<table>\n";
    echo "<tr>\n<td>Title:</td>\n<td>" . $sd["rec_title"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Description:</td>\n<td>" . $sd["rec_full"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Amount:</td>\n<td>" . $sd["rec_amount"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Type:</td>\n<td>" . $sd["rec_type"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Date:</td>\n<td>" . $sd["rec_date"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Comment:</td><td>". $sd["rec_comment"]."</td>\n</tr>";
    echo "<tr>\n<td>Submitted by:</td><td>". $sd["nameU"]."</td>\n</tr>";
    echo "<tr>\n<td>Submitted at:</td><td>". $sd["branchName"]."</td>\n</tr>";
    echo "<tr>\n<td>Submitted on:</td><td>". $sd["date_submitted"]."</td>\n</tr>";
    echo "</table>\n";
    echo "</div>";
}
} else {
    echo "<div class='text'>All the records you submitted have been confirmed!</div>\n";
}
echo "<div class='title'>Help</div>\n";
help_submitted();
echo "</div>\n";

include "footer.php";
?>
