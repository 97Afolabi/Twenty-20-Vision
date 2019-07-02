<?php include "functions.php";

//can user manage Finance?
isperm_finance();

echo "<title>Confirmed financial records</title>";
echo "<div id='main'>";
echo "<div class='title'>Confirmed financial records</div>";

$show_draft = "SELECT recordid, rec_title, rec_full, rec_amount, rec_type, rec_date, rec_comment, rec_status, branchid, branches.branchName, staffid, staff.nameU, rec_comment FROM account JOIN staff ON account.staffid = staff.staffid JOIN branches ON account.branchid = branches.branchid WHERE rec_status='Confirmed' ORDER BY rec_date DESC;";
$showdraft = connect($show_draft);

if (mysqli_num_rows($showdraft) > 0) {
    while ($sd = mysqli_fetch_assoc($showdraft)) {
    echo "<table border-collapse: collapse;>\n";
    echo "<tr>\n<td>Title</td>\n<td>" . $sd["rec_title"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Description</td>\n<td>" . $sd["rec_full"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Amount</td>\n<td>" . $sd["rec_amount"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Type</td>\n<td>" . $sd["rec_type"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Date</td>\n<td>" . $sd["rec_date"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Branch</td>\n<td>" . $sd["branchName"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Staff</td>\n<td>" . $sd["nameU"] . "</td>\n</tr>\n";
    echo "<form action='submitted-fin-rec.php' method='POST'>";
    echo "<tr>\n<td>Comment:</td><td>". $sd["rec_comment"]."</td>\n</tr>";
    echo "</table><hr/>";
}
} else {
    echo "There are no financial records to display at the moment\n";
}
echo "</div>";
include "footer.php";
