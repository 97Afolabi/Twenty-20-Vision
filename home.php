<?php include "functions.php"; ?>

	<title>Twenty-20 Vision</title>

<div id="main">
<p> <?php echo "Welcome, ". $_SESSION['user_name'].". How're you?";
//include "search.php";
 ?></p>

<div class="title">Stock  <a href='#hstock'>?</a></div>
<ul>
<li><a href="search.php" title="Search stock">Search stock</a></li>
<li><a href="frames.php" title="View all frames">Frames</a></li>
<li><a href="lenses.php" title="View all lenses">Lenses</a></li>
<li><a href="accessories.php" title="View all accessories">Accessories</a></li>
<li><a href="import-frame.php" title="Import frame">Import frame</a></li>
<li><a href="import-lens.php" title="Import lens">Import lens</a></li>
<li><a href="import-accessory.php" title="Import accessory">Import accessory</a></li>
<li><a href="stock-requisition.php" title="Stock requisition">Stock requisition</a></li>
</ul>


<div class="title">Account  <a href='#hacc'>?</a></div>
<ul>
<li><a href="account.php" title="New financial record">New financial record</a></li>
<li><a href="draft.php" title="Saved financial records">Saved financial records</a></li>
<li><a href="submitted.php" title="Submitted financial records">Submitted financial records</a></li>
</ul>

<div class="title">Patients  <a href='#hpati'>?</a></div>
<ul>
<li><a href="patients.php" title="Patients' info and medical record">Patients' info and medical record</a></li>
<li><a href="new-patient.php" title="Register a new patient">New patient</a></li>
<li><a href="appointments.php" title="Scheduled appointments">Scheduled appointments</a></li>
<li><a href="new-appointment.php" title="New appointment">New appointment</a></li>
</ul>

<?php if($_SESSION["perm_warehouse"] === "privileged") {
?>
<div class="title">Warehouse  <a href='#hware'>?</a></div>
<ul>
<li><a href="wh-frame.php" title="View all frames warehouse">View all frames (warehouse)</a></li>
<li><a href="wh-lenses.php" title="View all lenses warehouse">View all lenses (warehouse)</a></li>
<li><a href="wh-accessory.php" title="View all accessories warehouse">View all accessories (warehouse)</a></li>
<li><a href="new-frame.php" title="Add a new frame to the warehouse">Add frame to the warehouse</a></li>
<li><a href="new-lens.php" title="Add a new lens to the warehouse">Add lens to the warehouse</a></li>
<li><a href="new-accessory.php" title="Add a new accessory to the warehouse">Add accessory to the warehouse</a></li>
</ul>
<?php } ?>

<?php if($_SESSION["perm_finance"] === "privileged") {
?>
<div class="title">Finance  <a href='#hfin'>?</a></div>
<ul>
<li><a href="confirmation.php" title="Pending confirmations">Pending confirmations</a></li>
<li><a href="statement.php" title="Income statement">Income statement</a></li>
<li><a href="finance-history.php" title="Financial history">Financial history</a></li>
<li><a href="fix-price.php" title="Fix stock prices">Fix stock prices</a></li>
</ul>
<?php } ?>

<?php if($_SESSION["perm_management"] === "privileged") {
?>
<div class="title">Human resources  <a href='#humr'>?</a></div>
<ul>
<li><a href="staff.php" title="View the staff list">All staff</a></li>
<li><a href="new-staff.php" title="Enroll new staff">Enroll new staff</a></li>
<li><a href="branches.php" title="View all branches">Manage branches</a></li>
</ul>
<?php } ?>

<div class='title'>Settings  <a href='#hset'>?</a></div>
<ul>
<li><a href="change-password.php" title="Change your password">Change your password</a></li>
</ul>

<?php
echo "<div class='title'>Help</div>\n";
help_stock();
help_account();
help_patients();
//Warehouse crew only
if($_SESSION["perm_warehouse"] === "privileged") {
help_warehouse();
}
//Finance team only
if($_SESSION["perm_finance"] === "privileged") {
help_finance();
}
//Management team only
if($_SESSION["perm_management"] === "privileged") {
help_hr();
}
help_settings();
?>

</div>

<?php include "footer.php"; ?>
