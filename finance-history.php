<?php include "functions.php";

//can user manage Finance?
isperm_finance();

echo "<title>Financial records</title>";

echo "<div id='main'>";
echo "<div class='title'>Financial records</div>\n";

$show_confirmed = "SELECT account.recordid, account.rec_title, account.rec_full, account.rec_amount, account.rec_type, account.rec_date, account.rec_status, account.branchid, account.staffid, account.rec_comment, (SELECT nameU FROM staff WHERE staffid = account.confirmedby) AS confirmedby, branches.branchName, staff.nameU FROM account JOIN branches ON account.branchid = branches.branchid JOIN staff ON account.staffid = staff.staffid WHERE account.rec_status='Confirmed' ORDER BY account.rec_date DESC;";
$showconfirmed = connect($show_confirmed);

if (mysqli_num_rows($showconfirmed) > 0) {
    while ($sd = mysqli_fetch_assoc($showconfirmed)) {
    echo "<div class='text'>\n<table id='".$sd["recordid"]."'>\n";
    echo "<tr>\n<td>Title</td>\n<td>" . $sd["rec_title"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Description</td>\n<td>" . $sd["rec_full"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Amount</td>\n<td>" . $sd["rec_amount"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Type</td>\n<td>" . $sd["rec_type"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Date</td>\n<td>";
    ?>
    <script type="text/javascript">
    //split returned into JavaScript compatible format for beautiful date and time
    //$rec_date is imaginary returned variable

    var raw_datetime = "<?php echo $sd["rec_date"]; ?>";
    var beaut_date = new Date(raw_datetime);
    //date
    var new_date = beaut_date.toDateString();

    document.write(new_date);
    </script>
    <?php
    echo "</td>\n</tr>\n";
    echo "<tr>\n<td>Branch</td>\n<td>" . $sd["branchName"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Staff</td>\n<td>" . $sd["nameU"] . "</td>\n</tr>\n";
    echo "<tr>\n<td>Comment:</td><td>". $sd["rec_comment"]."</td>\n</tr>";
    echo "<tr>\n<td>Confirmed by:</td><td>". $sd["confirmedby"]."</td>\n</tr>";
    echo "</table>\n";
    echo "</div>";
}
} else {
    echo "<div class='text'>There are no financial records to display at the moment</div>\n";
}
echo "</div>\n";

include "footer.php";
?>
