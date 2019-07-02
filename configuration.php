<!DOCTYPE html>
<html>
<head>
<title>Configuration</title>
<link rel='icon' type='image/png' href='images/mercy.png'/>
<link rel='stylesheet' type='text/css' href='style/style.css'/>
<script type="text/javascript">
var sumbconf = document.getElementById("submit");
sumbconf.addEventListener("click", validate_conf());

function validate_conf() {
var fullname = document.getElementById("full_name").value;
var username = document.getElementById("username").value;
var phone = document.getElementById("phone").value;
var email = document.getElementById("email").value;
var password = document.getElementById("password").value;
var passwordtwo = document.getElementById("passwordtwo").value;

var allinput = document.getElementsByTagName("input").value;
if (allinput.length < 6) {
	this.placeholder = "The length is too short";
}
return false;
}
</script>
</head>

<body>

<div id="header">
<h1 id="title">Twenty-20 Vision</h1>
</div>
<div id='main'>
<?php //include "functions.php";

function connect($sqlQuery) {
	$conn = mysqli_connect("localhost", "root", "password", "twenty_20");
	$exQuery = mysqli_query($conn, $sqlQuery) OR die(mysqli_error($conn));
	echo "<br/>"; //print a line break after an error
	return $exQuery;
}

//date and time function in MySQL format
function time_date() {
	echo date("Y-m-d h:i:s");
}

//define test_input() function
function test_input($data) {
	//$conn = mysqli_connect("localhost", "root", "password", "twenty_20");
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = mysqli_real_escape_string($conn, $data);
	return $data;
}

//check if tables have been created in the database
$check_tables = "SHOW TABLES;";
$checkTables = connect($check_tables);


//if none has been created ie === 0
if(mysqli_num_rows($checkTables) < 1) {

//show the admin profile registration form
echo "<form method='POST' action='configuration.php'>\n"; 
echo "<label for='full_name'>Full name:</label><br/>\n";
echo "<input type='text' name='full_name' required='required' id='full_name'><br/>\n";
echo "<label for='username'>Choose a username:</label><br/>\n";
echo "<input type='text' name='username' required='required' id='username'><br/>\n";
echo "<label for='phone'>Phone:</label><br/>\n";
echo "<input type='number' name='phone' required='required' id='phone'><br/>\n";
echo "<label for='email'>e-mail:</label><br/>\n";
echo "<input type='email' name='email' required='required' id='email'><br/>\n";
echo "<label for='password'>Choose a password:</label><br/>\n";
echo "<input type='password' name='password' required='required' id='password'><br/>\n";
echo "<i>Minimum of 8 characters, you can combine letters and numbers</i><br/>\n";
echo "<label for='passwordtwo'>Enter the password again:</label><br/>\n";
echo "<input type='password' name='passwordtwo' required='required' id='passwordtwo'><br/>\n";
echo "<input type='hidden' name='registeredon' value='";
//echo time_date();
echo "'><br/>\n";
echo "<button type='submit' name='submit' id='submit'>Start setup</button>\n";

//if tables have been created, go to the login page
//this is a lazy method because if only one table is created the script will stop
//and redirect to the login page. The best, I think, would be test the existence of each
//table 'DESC table_name' then create the table if it doesn't exist already
//I think triggers can be used too
} else {
	header("Location: index.php");
	exit;
}

//if the admin profile has been created
if (isset($_POST["submit"])) {

//display an unordered list with progress messages
echo "<div class='text'>Preparing to setup<br/>\n";
echo "<ul>\n";
echo "<li>Setting up branches</li>\n";

//create the branches table first
$create_branches = "CREATE TABLE branches (
branchid int not null auto_increment,
branchName varchar(100) not null unique,
bShortName varchar(10) not null unique,
registeredOn datetime default now(),
primary key (branchid)
) ENGINE = InnoDB;";


$createBranches = connect($create_branches);
if($createBranches) {
	echo "<li>Branches setup completed</li>\n";
	echo "<li>Setting up Staff</li>\n";

	//create the staff table only if branches has been created
	//I'm feeling too lazy to test if a table has been created before creating the next one
	$create_staff = "CREATE TABLE staff (
	staffid int not null auto_increment,
	branchid int,
	fullName varchar(100) not null,
	nameU varchar(20) not null,
	mailE varchar(100),
	phone varchar(14),
	passU varchar(150) not null,
	status enum('Active', 'De-activated') default 'Active',
	registeredOn datetime default now(),
	perm_management enum('unprivileged','privileged') default 'unprivileged',
	perm_finance enum('unprivileged','privileged') default 'unprivileged',
	perm_warehouse enum('unprivileged','privileged') default 'unprivileged',
	perm_appointments enum('unprivileged','privileged') default 'unprivileged',
	perm_patients enum('local', 'global') default 'local',
	perm_stock enum('local', 'global') default 'local',
	primary key (staffid),
	foreign key (branchid) references branches(branchid)
	) ENGINE = InnoDB;";

	$createStaff = connect($create_staff);
	if ($createStaff) {
		echo "<li>Staff setup completed</li>\n";
	}
}

echo "<li>Setting up Account</li>\n";
//create the account table
$create_account = "CREATE TABLE account (
recordid int not null auto_increment,
rec_title varchar(250) not null,
rec_full text,
rec_amount int default '0',
rec_type enum('Sales', 'Refund', 'Refundable expenditure', 'Non-refundable expenditure', 'Fund withdrawal') default 'Sales',
rec_date datetime default now(),
date_submitted datetime default now(),
rec_status enum('Draft', 'Submitted', 'Confirmed') default 'Draft',
rec_comment text,
confirmedby int,
branchid int not null,
staffid int not null,
primary key (recordid),
foreign key (staffid) references staff(staffid),
foreign key (confirmedby) references staff(staffid)
) ENGINE=InnoDB;";

$createAccount = connect($create_account);
if($createAccount) {
	echo "<li>Account setup completed</li>\n";
}

echo "<li>Setting up Patients</li>\n";
//create the patients table
//a success message is only displayed if all the four tables relating to patients
//were created successfully
$create_patients = "CREATE TABLE patients (
patientid int not null auto_increment,
p_title enum('Mr', 'Mrs', 'Miss'),
p_name varchar(100) not null,
p_sex enum('Male', 'Female', 'Other'),
p_num1 varchar(14),
p_num2 varchar(14),
p_num3 varchar(14),
p_num4 varchar(14),
p_mail varchar(100),
p_occupation varchar(200),
p_address text,
p_debt int,
comment text,
reg_date datetime default now(),
reg_at int,
reg_by int,
primary key (patientid),
foreign key (reg_at) references branches(branchid),
foreign key (reg_by) references staff(staffid)
) ENGINE = InnoDB;";

$createPatients = connect($create_patients);

//create the prescriptions table
$create_prescriptions = "CREATE TABLE prescriptions (
prescid int not null auto_increment,
patientid int not null,
pat_age int,
presc_date datetime default now(),
pres_od varchar(50),
pres_os varchar(50),
complaints text,
drugs text,
comment text,
tinting text,
to_pay int default '0',
branchid int,
primary key (prescid),
foreign key (patientid) references patients(patientid),
foreign key (branchid) references branches(branchid)
) ENGINE = InnoDB;";

$createPrescriptions = connect($create_prescriptions);

//create the dispenses table
$create_dispenses = "CREATE TABLE dispenses (
dispid int not null auto_increment,
patientid int not null,
disp_frame varchar(200),
disp_lens varchar(150),
disp_accessories varchar(250),
disp_status enum('Pending', 'Prepared', 'Dispensed') default 'Prepared',
disp_duedate datetime default now(),
disp_amount int default '0',
disp_deposit int default '0',
d_preparedon datetime,
d_preparedat int,
d_dispensedon datetime,
d_dispensedat int,
disp_comment text,
primary key (dispid),
foreign key (patientid) references patients(patientid),
foreign key (d_preparedat) references branches(branchid),
foreign key (d_dispensedat) references branches(branchid)
) ENGINE = InnoDB;";

$createDispenses = connect($create_dispenses);


//create the appointments table
$create_appointments = "CREATE TABLE appointments (
ap_id int not null auto_increment,
ap_staff int not null,
ap_branch int not null,
ap_today datetime default now(),
ap_name varchar(150) not null,
ap_num1 varchar(14),
ap_num2 varchar(14),
ap_convdate datetime default now(),
ap_address text,
ap_complaints text,
ap_comment text,
ap_urgency enum('High', 'Moderate', 'Low') default 'Moderate',
ap_status enum('New', 'Old'),
primary key (ap_id),
foreign key (ap_staff) references staff(staffid),
foreign key (ap_branch) references branches(branchid)
) ENGINE = InnoDB;";

$createAppointments = connect($create_appointments);

if ($createPatients && $createPrescriptions && $createDispenses && $createAppointments) {
	echo "<li>Patients setup completed</li>\n";
}

echo "<li>Setting up Stock</li>\n";

//creating the stock tables
//a success message is only displayed if all the table relating to stock were created successfully
$create_frames = "CREATE TABLE frames (
frameid int not null auto_increment,
frame_name varchar(50) not null,
frame_model varchar(50),
frame_size varchar(50),
frame_material enum('Metal', 'Plastic', 'Metal & Plastic', 'Wood'),
frame_style enum('Designer', 'Ordinary'),
frame_rimp enum('Full rimp', 'Half rimp', 'Rimpless'),
frame_price int default '0',
frame_status enum('listed', 'de-listed') default 'listed',
frame_registeredon datetime default now(),
primary key (frameid)
) ENGINE = InnoDB;";

$createFrames = connect($create_frames);

$create_frame_stock = "CREATE TABLE frame_stock (
f_stockid int not null auto_increment,
frameid int,
branchid int,
f_dbquantity int default '0',
f_physicalq int default '0',
f_qsold int default '0',
f_qtransferred int default '0',
f_qreceived int default '0',
lastupdateby int not null,
lastupdatedon datetime default now(),
imported enum('yes', 'no') default 'no',
primary key (f_stockid),
foreign key (frameid) references frames(frameid),
foreign key (branchid) references branches(branchid)
) ENGINE = InnoDB;";

$createFrameStock = connect($create_frame_stock);

$create_frame_images = "CREATE TABLE frame_images (
fimg_id int not null auto_increment,
f_id int not null,
f_url varchar(250) not null,
primary key (fimg_id),
foreign key (f_id) references frames(frameid)
) ENGINE = InnoDB;";

$createFrameImages = connect($create_frame_images);

$create_lenses = "CREATE TABLE lenses (
lensid int not null auto_increment,
lens_strength varchar(150) not null,
lens_type enum('Cylindrical', 'Spherical'),
lens_price int,
lens_registeredon datetime default now(),
lens_status enum('listed', 'de-listed') default 'listed',
primary key (lensid)
) ENGINE = InnoDB;";

$createLenses = connect($create_lenses);

$create_lens_stock = "CREATE TABLE lens_stock (
l_stockid int not null auto_increment,
lensid int,
branchid int,
l_dbquantity int default '0',
l_physicalq int default '0',
l_qsold int default '0',
l_qtransferred int default '0',
l_qreceived int default '0',
lastupdateby int not null,
lastupdatedon datetime default now(),
imported enum('yes', 'no') default 'no',
primary key (l_stockid),
foreign key (lensid) references lenses(lensid),
foreign key (branchid) references branches(branchid)
) ENGINE = InnoDB;";

$createLensStock = connect($create_lens_stock);

$create_accessories = "CREATE TABLE accessories (
accid int not null auto_increment,
acc_name varchar(200) not null,
acc_type enum('Case', 'Duster', 'Suspender'),
acc_price int default '0',
acc_registeredon datetime default now(),
acc_status enum('listed', 'de-listed'),
primary key (accid)
) ENGINE = InnoDB;";

$createAccessories = connect($create_accessories);

$create_accessories_stock = "CREATE TABLE accessories_stock (
acc_stockid int not null auto_increment,
accid int,
branchid int,
a_dbquantity int default '0',
a_physicalq int default '0',
a_qsold int default '0',
a_qtransferred int default '0',
a_qreceived int default '0',
lastupdateby int not null,
lastupdatedon datetime default now(),
imported enum('yes', 'no') default 'no',
primary key (acc_stockid),
foreign key (accid) references accessories(accid),
foreign key (branchid) references branches(branchid)
) ENGINE = InnoDB;";

$createAccessoriesStock = connect($create_accessories_stock);

$create_accessory_images = "CREATE TABLE accessory_images (
aimg_id int not null auto_increment,
a_id int not null,
a_url varchar(250) not null,
primary key (aimg_id),
foreign key (a_id) references accessories(accid)
) ENGINE = InnoDB;";

$createAccessoriesImages = connect($create_accessory_images);

$create_stock_requisition = "CREATE TABLE stock_requisition (
req_id int not null auto_increment,
req_stock text not null,
req_date datetime default now(),
req_staff int,
req_branch int,
req_status enum('Sent', 'Acknowledged', 'Treated') default 'Sent',
status_setby int,
status_seton datetime default now(),
primary key (req_id),
foreign key (req_staff) references staff(staffid),
foreign key (status_setby) references staff(staffid),
foreign key (req_branch) references branches(branchid)
) ENGINE = InnoDB;";

$createStockRequisition = connect($create_stock_requisition);

if ($createFrames && $createFrameStock && $createFrameImages && $createLenses && $createLensStock && $createAccessories && $createAccessoriesStock && $createAccessoriesImages && $createStockRequisition) {
	echo "<li>Stock setup completed</li>\n";
}


echo "<li>Setting up the Warehouse</li>\n";

$fullname = test_input($_POST["full_name"]);
$username = test_input($_POST["username"]);
$regdon = test_input($_POST["registeredon"]);
$phone = test_input($_POST["phone"]);
$email = test_input($_POST["email"]);
if ($_POST["password"] === $_POST["passwordtwo"]) {
	if (strlen($_POST["passwordtwo"]) > 8) {
		$password = test_input($_POST["passwordtwo"]);
		global $password;
	} else {
		echo "Password is too short!<br/>\n";
	}
} else {
	echo "Passwords do not match!<br/>\n";
}

$create_warehouse = "INSERT INTO branches (branchName, bShortName, registeredOn) VALUES ('Warehouse', 'WHS', '$regdon');";
$createWarehouse = connect($create_warehouse);

if($createWarehouse) {
	echo "<li>Warehouse setup completed</li>\n";
}

echo "<li>Setting up your account</li>\n";
$create_admin = "INSERT INTO staff (branchid, fullName, nameU, mailE, phone, passU, status, registeredOn, perm_management, perm_finance, perm_warehouse, perm_appointments, perm_patients, perm_stock) VALUE (1, '$fullname', '$username', '$email', '$phone', '$password', 'Active', '$regdon', 'privileged', 'privileged', 'privileged', 'privileged', 'global', 'global');";
$createAdmin = connect($create_admin);

if($createAdmin) {
	echo "<li>Your account is ready now!</li>\n";
	echo "</ul>";
	echo "<div class='navbar'><a href='index.php'>Proceed to login page</div>\n";

}
}

echo "</div>\n";

//since $conn is my global variable for MySQLi connections, I
//can simply close it here
mysqli_close($conn);

?>
</div>
</body>
</html>
