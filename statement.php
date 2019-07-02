<?php include "functions.php";
/* Income and Expenditures tables
*   Default view shows all statements from all branches with branch name indicated
*   There's a drop-down list of branches to select statement for a particular branch
*   In the future, allow for selecting records for a particular time period
*   eg: SELECT * FROM account WHERE date BETWEEN __________ AND __________
*/
//can user manage Finance?
isperm_finance();
echo "<title>Income and expenditures</title>\n";
echo "<div id='main'>\n";
echo "<div class='title'>Income and expenditures</div>\n";
//view statement for a particular branch
$lsBranches = "SELECT branchid, branchName FROM branches ORDER BY branchName;";
$lsB = connect($lsBranches);
echo '<form action="statement.php" method="GET">';
echo '<select name="branch">';
//all branches in a drop-down list
while($row = mysqli_fetch_assoc($lsB)) {
echo "<option value='".$row["branchid"]."' name='branch'";
    if(isset($_GET["branch"])) {
    //ensure that the current branch is selected
    isset_select($_GET["branch"], $row["branchid"]);
    }
    echo ">".$row["branchName"]."</option>\n";
}
echo "</select><br/>";
echo "<button type='submit'>View statement in branch</button>\n";
echo "</form>";
//end of statement in a branch
//display Expenditures and Income statement for the branch selected
if (isset($_GET["branch"])) {
$Branch = $_GET["branch"];
//sum calculation beginning
//sum of Incomes
$sum_of_income = "SELECT sum(rec_amount) AS Income FROM account WHERE (rec_type = 'Sales' OR rec_type = 'Refund' AND rec_status='Confirmed') AND account.branchid = $Branch;";
$sumIncome = connect($sum_of_income);
$sum_inc = mysqli_fetch_assoc($sumIncome);
    $income = $sum_inc["Income"];
//sum of Expenditures
$sum_of_expenditure = "SELECT sum(rec_amount) AS Expenditures FROM account WHERE (rec_type = 'Non-refundable expenditure' OR rec_type = 'Refundable expenditure' OR rec_type = 'Fund withdrawal') AND rec_status='Confirmed' AND account.branchid = $Branch;";
$sumExpenditure = connect($sum_of_expenditure);
    $sum_exp = mysqli_fetch_assoc($sumExpenditure);
    $expenditure = $sum_exp["Expenditures"];
$total = $income - $expenditure; //total
//sum calculation end
//display all Expenditures and Incomes
//fetch expenditures
$expenditure_left = "SELECT account.branchid, recordid, rec_title, rec_amount FROM account JOIN branches ON account.branchid = branches.branchid WHERE (rec_type = 'Non-refundable expenditure' OR rec_type = 'Refundable expenditure' OR rec_type = 'Fund withdrawal') AND rec_status='Confirmed' AND account.branchid = $Branch;";
$expenditureLeft = connect($expenditure_left);
//fetch income
$income_right = "SELECT account.branchid, recordid, rec_title, rec_amount FROM account JOIN branches ON account.branchid = branches.branchid WHERE (rec_type = 'Sales' OR rec_type = 'Refund') AND rec_status = 'Confirmed' AND account.branchid = $Branch;";
$incomeRight = connect($income_right);
//end the display of all Expenditures and Incomes
//calculate the number of rows returned for Expenditures and Incomes
$expenditure_rows = mysqli_num_rows($expenditureLeft);
$income_rows = mysqli_num_rows($incomeRight);
//show table if there are records, if not, display message
if($expenditure_rows === 0 && $income_rows === 0) {
    echo "<div class='text'>There is no income and expenditure statement to show at the moment.</div>\n";
} else {
//show the results in an Income and Expenditures statement table
//the table has two columns -- one for Expenditures,  the other for Incomes
echo "<table 'width:100%;'>\n<tr>\n<td>\n";
//display Expenditures
echo "<div class='incex' style='font-weight:bold;background-color:#0256A8;color:#ffffff;'>Expenditures <span class='Amount'>Amount</span></div>\n";
while ($incL = mysqli_fetch_assoc($expenditureLeft)) {
//display clickable Expenditures with links to view the full detail of that transaction
echo "<div class='incex'><a href='finance-history.php#".$incL["recordid"]."'>".$incL["rec_title"]."</a><span class='Amount'>".$incL["rec_amount"]."</span></div><br/>\n";
}
//if the rows of income and expenditures are not equal, print non-breaking spaces to balance the table
if ($expenditure_rows < $income_rows) {
    for ( ; $expenditure_rows < $income_rows; $expenditure_rows++) {
        echo "<div class='incex'>&nbsp;<span class='Amount'>&nbsp;</span></div><br/>\n";
        continue;
    }
}
//the foot of the table where totals are plus, an empty row
echo "<div class='incex'>&nbsp;<span class='Amount'>&nbsp;</span></div><br/>\n";
echo "<div class='incex'><b>Total:<span class='Amount'>";
//print borders even when there is no value
if($expenditure === NULL) {echo "&nbsp;";} else {echo $expenditure;}
echo "</span></b></div><br/>\n";
echo "<div class='incex'>&nbsp;<span class='Amount'>&nbsp;</span></div><br/>\n";
echo "</td>\n<td>\n";
//display Income
echo "<div class='incex' style='font-weight:bold;background-color:#0256A8;color:#ffffff;'>Income <span class='Amount'>Amount</span></div>\n";
while ($incR = mysqli_fetch_assoc($incomeRight)) {
echo "<div class='incex'><a href='finance-history.php#".$incR["recordid"]."'>".$incR["rec_title"]."</a><span class='Amount'>".$incR["rec_amount"]."</div><br/>\n";
}
//if the rows are not equal print non-breaking spaces to balance the table
if ($income_rows < $expenditure_rows) {
    for ( ;$income_rows < $expenditure_rows; $income_rows++) {
        echo "<div class='incex'>&nbsp;<span class='Amount'>&nbsp;</span></div><br/>\n";
        continue;
    }
}
//the foot of the table where totals are plus, an empty row
echo "<div class='incex'>&nbsp;<span class='Amount'>&nbsp;</span></div><br/>\n";
echo "<div class='incex'><b>Total:<span class='Amount'>";
//print borders even when there is no value
if($income === NULL) {echo "&nbsp;";} else { echo $income;}
echo "</span></b></div><br/>\n";
echo "<div class='incex'><b>Grand total:<span class='Amount'>$total</span></b></div><br/>\n";
echo "</td>\n</tr>\n</table>\n";
}
} else {
//no branch was selected, do this
//sum calculation beginning
//sum of Incomes
$sum_of_income = "SELECT sum(rec_amount) AS Income FROM account WHERE rec_type = 'Sales' OR rec_type = 'Refund' AND rec_status='Confirmed';";
$sumIncome = connect($sum_of_income);
$sum_inc = mysqli_fetch_assoc($sumIncome);
    $income = $sum_inc["Income"];
//sum of Expenditures
$sum_of_expenditure = "SELECT sum(rec_amount) AS Expenditures FROM account WHERE rec_type = 'Non-refundable expenditure' OR rec_type = 'Refundable expenditure' OR rec_type = 'Fund withdrawal' AND rec_status='Confirmed';";
$sumExpenditure = connect($sum_of_expenditure);
$sum_exp = mysqli_fetch_assoc($sumExpenditure);
    $expenditure = $sum_exp["Expenditures"];
$total = $income - $expenditure; //total
//sum calculation end
//fetch expenditures
$expenditure_left = "SELECT account.branchid, account.recordid, account.rec_title, account.rec_amount, branches.bShortName FROM account JOIN branches ON account.branchid = branches.branchid WHERE (rec_type = 'Non-refundable expenditure' OR rec_type = 'Refundable expenditure' OR rec_type = 'Fund withdrawal') AND rec_status='Confirmed';";
$expenditureLeft = connect($expenditure_left);
//fetch income
$income_right = "SELECT account.branchid, account.recordid, account.rec_title, account.rec_amount, branches.bShortName FROM account JOIN branches ON account.branchid = branches.branchid WHERE (rec_type = 'Sales' OR rec_type = 'Refund') AND rec_status='Confirmed';";
$incomeRight = connect($income_right);
//number of rows
$expenditure_rows = mysqli_num_rows($expenditureLeft);
$income_rows = mysqli_num_rows($incomeRight);
//show table if there are records, if not, display message
if($expenditure_rows && $income_rows === NULL) {
    echo "<div class='text'>There is no income and expenditure statement to show at the moment.</div>\n";
} else {
//show table if there are records, if not, display message
if($expenditure_rows === 0 && $income_rows === 0) {
    echo "<div class='text'>There is no income and expenditure statement to show at the moment.</div>\n";
} else {

//table
echo "<table 'width:100%;'>\n<tr>\n<td>\n";
//display Expenditures
echo "<div class='incex' style='font-weight:bold;background-color:#0256A8;color:#ffffff;'><span class='Branch'>Branch</span>Expenditures <span class='Amount'>Amount</span></div>\n";
while ($incL = mysqli_fetch_assoc($expenditureLeft)) {
echo "<div class='incex'><span class='Branch'>".$incL["bShortName"]."</span><a href='finance-history.php#".$incL["recordid"]."'>".$incL["rec_title"]."</a><span class='Amount'>".$incL["rec_amount"]."</span></div><br/>\n";
}
//if the rows are not equal print non-breaking spaces to balance the table
if ($expenditure_rows < $income_rows) {
    for ( ; $expenditure_rows < $income_rows; $expenditure_rows++) {
        echo "<div class='incex'><span class='Branch'>&nbsp;</span>&nbsp;<span class='Amount'>&nbsp;</span></div><br/>\n";
        continue;
    }
}
//the footer
echo "<div class='incex'><span class='Branch'>&nbsp;</span>&nbsp;<span class='Amount'>&nbsp;</span></div><br/>\n";
echo "<div class='incex'><span class='Branch'>&nbsp;</span><b>Total:</b><span class='Amount'><b>$expenditure</b></span></div><br/>\n";
echo "<div class='incex'><span class='Branch'>&nbsp;</span>&nbsp;<span class='Amount'>&nbsp;</span></div><br/>\n";
echo "</td>\n<td>\n";
//display Income
echo "<div class='incex' style='font-weight:bold;background-color:#0256A8;color:#ffffff;'><span class='Branch'>Branch</span>Income <span class='Amount'>Amount</span></div>\n";
while ($incR = mysqli_fetch_assoc($incomeRight)) {
echo "<div class='incex'><span class='Branch'>".$incR["bShortName"]."</span><a href='finance-history.php#".$incR["recordid"]."'>".$incR["rec_title"]."</a><span class='Amount'>".$incR["rec_amount"]."</div><br/>\n";
}
//if the rows are not equal print non-breaking spaces to balance the table
if ($income_rows < $expenditure_rows) {
    for ( ;$income_rows < $expenditure_rows; $income_rows++) {
        echo "<div class='incex'><span class='Branch'>&nbsp;</span>&nbsp;<span class='Amount'>&nbsp;</span></div><br/>\n";
        continue;
    }
}
echo "<div class='incex'><span class='Branch'>&nbsp;</span>&nbsp;<span class='Amount'>&nbsp;</span></div><br/>\n";
echo "<div class='incex'><span class='Branch'>&nbsp;</span><b>Total:</b><span class='Amount'>$income</span></div><br/>\n";
echo "<div class='incex'><span class='Branch'>&nbsp;</span><b>Grand total:</b><span class='Amount'><b>$total</b></span></div><br/>\n";
echo "</td>\n</tr>\n</table>\n";
} //if not "NULL"
} //if not equal 'zero'
} //if no branch was selected

echo "</div>";
include "footer.php";
?>
