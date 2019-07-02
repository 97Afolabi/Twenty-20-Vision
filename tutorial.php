<?php
/*
* This page will contain help document for all the pages.
* It will be included at the bottom of the pages, just before </div id main>
* The help document for each page will be written in functions and the functions will be called
* That way, all the help documents will be on this page alone
* Example:
* function login_tut() {
*	echo "This is the login page";
* }
*/


//start help for Homepage - home.php
function help_stock() {
?>
<h4 id='hstock'>Stock:</h4>
<ul>
<li><b>Search</b> through all frames, lenses and, accessories in all branches</li>
<li><b>View all</b> frame, lens and, accessory details and quantities in your local branch</li>
<li><b>Add</b> frames, lenses and accessories from the Warehouse into your local branch</li>
<li><b>Request</b> for additional stock from the Warehouse</li>
</ul>
<div class='text'></div>
<?php
}

function help_account() {
?>
<h4 id='hacc'>Account:</h4>
<ul>
<li><b>Submit or save</b> a new income or expenditure record. Submitted records will be reviewed before they are confirmed. Saved records can be edited before they are submitted</li>
<li><b>View saved</b> income or expenditure records</li>
<li><b>View submitted</b> income or expenditure records awaiting confirmation</li>
</ul>
<div class='text'></div>
<?php
}

function help_finance() {
?>
<h4 id='hfin'>Finance:</h4>
<ul>
<li>View <b>submitted financial records awaiting</b> your confirmation</li>
<li>View a tabular income and expenditure statement</li>
<li>View a detailed income and expenditure history</li>
<li>Change the prices of all the goods in the database</li>
</ul>
<?php
}

function help_patients() {
?>
<h4 id='hpati'>Patients:</h4>
<ul>
<li><b>View patients' info</b> in your local branch or in all branches as the case may be</li>
<li><b>Enrol</b> new patients</li>
<li><b>View all appointments</b> made in your local branch or in all branches as the case may be</li>
<li><b>Schedule</b> a new appointment for patients to be attended to by qualified staff</li>
</ul>
<div class='text'></div>
<?php
}

function help_warehouse() {
?>
<h4 id='hware'>Warehouse:</h4>
<ul>
<li><b>View all stock quantity</b> in the Warehouse and all branches</li>
<li><b>Edit</b> all stock details</li>
<li><b>Add new</b> stock to the Warehouse after which they can be added to the branches</li>
</ul>
<div class='text'></div>
<?php
}

function help_hr() {
?>
<h4 id='humr'>Human resources</h4>
<ul>
<li><b>View and edit</b> staff profiles</li>
<li><b>Add</b> a new staff</li>
<li><b>View, edit and add</b> branches</li>
</ul>
<div class='text'></div>
<?php
}

function help_settings() {
?>
<h4 id='hset'>Settings:</h4>
<ul>
<li><b>Change</b> your password. If you forgot your password, you will have to contact a management staff to reset it for you.</li>
</ul>
<div class='text'></div>
<?php
}
//end help for Homepage - home.php

//start help for Search page search.php
function help_search() {
?>
<h4>Search</h4>
<ul>
<li>You can use this feature to know if an item is in stock</li>
<li>Enter your search query in the box above then, select the category you want to search in. The default category is <b>frames</b></li>
<li>Please, note that the search feature is case-sensitive at the moment. Therefore, <b>Long</b> or <b>ong</b> will return <b>Longines</b> but, <b>long</b> will not</li>
<li>You can search for: a <b>frame</b>'s name, model, or, size; <b>lens</b>' name or, strength; <b>accessory</b> name or, type</li>
<li>The results are listed according to branch in alphabetical order</li>
<li>The result you will see depends on the level of permission granted to you.</li>
<li>If you are permitted to view the quantity of stock in other branches, you will see the quantity of the item you searched for in your branch and other branches too.</li>
<li>If you are not permitted to view stock in other branches, you will only see the quantity of stock in your local branch. If other branches have that item in stock, you will see the message <b>Found some</b> and the name of the branch but you will not see the exact quantity the branch has</li>
<li><b>Out of stock!</b> means that branch has none of the item you searched for</li>
</ul>
<div class='text'></div> 
<?php
}
//end help for Search page search.php

function help_frames() {
?>
<h4>Frames</h4>
<ul>
<li><b>Search</b> for frames, the result will be displayed on the search page</li>
<li>A button to add new frames from the Warehouse</li>
<li>You will see a list of all the frames in your branch with their full details</li>
<li>Click <b>Pictures</b> to view all uploaded pictures for that frame</li>
<li>Click <b>Update</b> to update the quantity of stock you have for each frame. This is important in order to know the accurate number of stock in each branch so we will be able to serve our customers better</li>
</ul>
<div class='text'></div> 
<?php
}
//end help for Frames frames.php

//start help Import frames import-frame.php
function help_import_frame() {
?>
<h4>Import frames</h4>
<ul>
<li>A list of all the frames in the Warehouse that you have not added to your branch yet</li>
<li>You are advised to import only frames that you have physically in your branch at any moment</li>
<li>You need to import a frame only once</li>
<li>The message: <b>There are no new frames for you to import!</b> means that you have imported all available frames in the Warehouse</li>
<li>If you have a frame that is not listed in the Warehouse, you <b>must</b> send the following information to any staff in charge of the Warehouse
<ul>
<li>Brand name</li>
<li>Model</li>
<li>Frame size, and,</li>
<li>Pictures of the frame</li>
</ul>
</li>
</ul>
<div class='text'></div> 
<?php
}
//end help for Import frames import-frame.php

//start help Lenses lenses.php
function help_lenses() {
?>
<h4>Lenses</h4>
<ul>
<li><b>Search</b> for lenses, the result will be displayed on the search page</li>
<li>A button to add new lenses from the Warehouse</li>
<li>You will see a list of all the lenses in your branch with their full details</li>
<li>Click <b>Update</b> to update the quantity of stock you have for each lens. This is important in order to know the accurate number of stock in each branch so we will be able to serve our customers better</li>
</ul>
<div class='text'></div> 
<?php
}
//end help Lenses lenses.php

//help Import lenses import-lens.php
function help_import_lens() {
?>
<h4>Import lenses</h4>
<ul>
<li>A list of all the lenses in the Warehouse that you have not added to your branch yet</li>
<li>You are advised to import only lenses that you have physically in your branch at any moment</li>
<li>You need to import a lens only once</li>
<li>The message: <b>There are no new lenses for you to import!</b> means that you have imported all available lens in the Warehouse</li>
<li>If you have a lens that is not listed in the Warehouse, you <b>must</b> send the following information to any staff in charge of the Warehouse
<ul>
<li>The lens' strength</li>
<li>Type</li>
</ul>
</li>
</ul>
<div class='text'></div> 
<?php
}
//end help 'Import lenses' import-lens.php

//help Accessories accessories.php
function help_accessories() {
?>
<h4>Accessories</h4>
<ul>
<li><b>Search</b> for accessories, the result will be displayed on the search page</li>
<li>A button to add new accessories from the Warehouse</li>
<li>You will see a list of all the accessories in your branch with their full details</li>
<li>Click <b>Update</b> to update the quantity of stock you have for each accessory. This is important in order to know the accurate number of stock in each branch so we will be able to serve our customers better</li>
</ul>
<div class='text'></div> 

<?php
}
//end help Accessories accessories.php

//help Import lenses import-accessory.php
function help_import_accessories() {
?>
<h4>Import accessories</h4>
<ul>
<li>A list of all the accessories in the Warehouse that you have not added to your branch yet</li>
<li>You are advised to import only accessories that you have physically in your branch at any moment</li>
<li>You need to import an accessory only once</li>
<li>The message: <b>There are no new accessories for you to import!</b> means that you have imported all available accessories in the Warehouse</li>
<li>If you have an accessory that is not listed in the Warehouse, you <b>must</b> send the following information to any staff in charge of the Warehouse
<ul>
<li>The accessory's name, and,</li>
<li>Type</li>
</ul>
</li>
</ul>
<div class='text'></div> 
<?php
}
//end help 'Import lenses' import-accessory.php

//help 'New account record' account.php
function help_new_record() {
?>
<h4>New account record</h4>
<ul>
<li>You can <b>view saved records</b> for editing and submission</li>
<li>Create a new record</li>
<li>Write a short title for the record</li>
<li>Give a full description</li>
<li>Specify the record's <b>type</b>
<ul>
<li><b>Refundable expenditures</b> are personal spendings which must be returned to the account later</li>
<li><b>Non-refundable expenditures</b> are those which are used for the branch e.g. rent, electricity fee, fuel, etc.</li>
<li><b>Refunds</b> are re-imbursement for refundable expenditures</li>
<li><b>Fund withdrawals</b> is for any amount evacuated from your branch by a qualified personel</li>
</ul>
</li>
<li>Specify the <b>amount</b> without comma or alphabet, only numbers are allowed</li>
<li>Specify the <b>date</b> in which the transaction occured. The current date is specified <b>automatically</b></li>
<li>You can decide to <b>Saved the record</b> so you can edit and submit it later</li>
<li>Or, <b>Submit the record</b> directly. Submitted records are subject to reviews before confirmation</li>
</ul>
<div class='text'></div>
<?php
}
//end help_new_record() account.php

//edit Saved records draft.php
function help_saved_records() {
?>
<h4>Saved records</h4>
<ul>
<li>All your saved records will be listed here with the most recent at the top</li>
<li>A preview is given for each one</li>
<li>Click <b>Edit this record</b> to edit or submit any of the records</li>
<li>The edit form will be displayed at the top of the page with other draft entries below it</li>
<li>The information you provided when you created the record will be retrieved and displayed in a form</li>
<li>Edit the information as you wish and/or submit it for confirmation</li>
</ul>
<div class='text'></div>
<?php
}
//end help saved records draft.php

//view 'Submitted' records submitted.php
function help_submitted() {
?>
<h4>Submitted records</h4>
<ul>
<li>View all your submitted records awaiting confirmation</li>
<li>Comments made by the person who reviewed your account will also be displayed here</li>
<li>You may be able to edit these records in the future</li>
</ul>
<div class='text'></div>
<?php
}
//end help Submitted records submitted.php

//All 'Patients' patients.php
function help_patients_info() {
?>
<h4>Patients</h4>
<ul>
<li>Except you are permitted, you can only view patients enrolled at your branch</li>
<li>However, you can search for patients enrolled in other branches if you use the search form. This is so that prescription made in one branch can be viewed in other branches without having to contact the person at that branch</li>
<li>There is a search form at the top to search for a patient's name. <b>Do not</b> include the title in the search, the name alone will do</li>
<li>You can also view all names starting with each letter of the Alphabet</li>
<li>Click a patient's name to view the person's full info</li>
<li>Patients' title, names, occupation, and two phone numbers are displayed on this page</li>
<li>Titles, names, and occupations are shown to prevent confusing patients</li>
<li>Two phone numbers are shown to provide quick access to contact patients</li>
<li>You can place a call to the person using your mobile phone by simply clicking the phone number you want to call</li>
<li>Newly registered patients are displayed at the top of the page</li>
</ul>
<div class='text'></div>
<?php
}
//end help 'Patients' patients.php

//help 'Patients' info, prescription and dispense history' prescription.php
function help_info_prescription() {
?>
<h4>Patient's info</h4>
<ul>
<li>The patient's infomation as registered at the time of enrolment or the last profile update is displayed</li>
<li><b>New prescription</b> is used to add a new prescription to the selected patient's medical record</li>
<li><b>Dispense history</b> shows all items dispensed to the patient</li>
<li><b>Edit profile</b> is used to update the information provided in the table above</li>
<li>All prescriptions registered for the selected patient is shown below with the most recent at the top</li>
</ul>
<div class='text'></div>
<?php
}
//end help prescription.php

//help 'New prescription' new-prescription.php
function help_new_prescription() {
?>
<h4>New prescription</h4>
<ul>
<li><b>Complaints:</b> document the patient's complaint at the time of the refraction</li>
<li>If <b>drugs</b> are prescribed, document them here</li>
<li>Be sure to also document your observations and other comments</li>
<li><b>Due date</b> should be filled if items are to be dispensed for that prescription at a certain date. It should be filled in the format: <b>YYYY-MM-DD</b></li>
<li>The fee charged for the refraction and other items dispensed should be filled also</li>
</ul>
<div class='text'></div>
<?php
}
//end help new-prescription.php

//help 'Dispense record' dispenses.php
function help_dispense_record() {
?>
<h4>Dispense record</h4>
<ul>
<li>This page will show all items that has been dispensed to the selected patient in all branches</li>
<li>There is a button to return to the patient's profiles</li>
<li>There is another button to add a new record to the dispense history</li>
</ul>
<div class='text'></div>
<?php
}
//end help dispenses.php

//help 'New dispense record' new-dispense.php
function help_new_dispense() {
?>
<h4>New dispense record</h4>
<ul>
<li>If a frame was dispensed, specify using the <b>Frame</b> input field</li>
<li>Give the full detail of the lens(es) dispensed e.g.<br/>
&nbsp;&nbsp; <b>OD: +000 +000 Axis 180</b>
<br/>&nbsp;&nbsp; <b>OS: -000 -000 Axis 180</b>
</li>
<li>All accessories should be recorded in the <b>Accessories</b> field</li>
<li>The amount charged should be entered in the <b>Amount</b> field</li>
<li>Amount deposited should be entered in the <b>Deposit</b> field</li>
<li>If any balance is to be paid, it should be entered in the <b>Balance</b> field. The total sum of the patient's debt is to be recorded in the patient's profile. Go back and select <b>Edit profile</b> to update that information. This field is for this dispense <b>only</b></li>
<li>The appointed date for the patient to receive the dispensed item(s) should be entered in the <b>Due date</b> field</li>
<li>The status field should be field as follows:<br/>
<b>Pending:</b> if the items ordered by the patient are yet to be prepared by you<br/>
<b>Prepared:</b> if the items are ready for collection but the patient has not come to pick them up<br/>
<b>Dispensed:</b> if the items have been collected by the patient. This is the final state of all items
</li>
<li>For some reasons, the items may not be prepared and dispensed at the same branch. Therefore, it is important that you fill where the items were prepared and dispensed appropriately and also include the date(s)</li>
<li>If you have any comment regarding the dispense record, use the <b>Comment</b> box. This is extremely important if the stock dispensed is different from what was prescribed or ordered. For example, if 000 +250 was dispensed <b>instead</b> of 000 +275</li>
</ul>
<div class='text'></div>
<?php
}
//end help 'New dispense record' new-dispense.php

//help 'Edit patient's profile' edit-patient.php
function help_edit_patient() {
?>
<h4>Edit patient's profile</h4>
<ul>
<li>Use this form to add/update patients' profiles. It will be visible in other branches; other staff can also update the information here</li>
<li>The <b>Debt</b> field is for recording all amounts owed by the patient. If a patient incur a new debt, simply add that amount to the previous amount</li>
<li>Use the <b>Note</b> field to record any comment you have about the patient that you think will be important for all staff to know</li>
</ul>
<div class='text'></div>
<?php
}
//end help 'Edit patient's profile' edit-patient.php

//help 'New patient' new-patient.php
function help_new_patient() {
?>
<h4>New patient</h4>
<ul>
<li>Fill this form appropriately, the information entered here is visible in all branches and can be updated later</li>
<li>It is not compulsory to fill all the fields but input sufficient information to identify the patient easily later</li>
<li>If the <b>Title</b>, <b>Name</b>, and <b>Phone number</b> you entered matches any that has been registered, you will be asked to <b>Register a new profile</b> or <b>View</b> patient's with matching profile information</li>
<li>The aim is to prevent creating multiple profiles for the same patient</li>
<li>A new profile will be created if you select Register a new profile anyway</li>
<li>If you choose to view all matching records, the matches will be displayed in the <b>patients</b> search page</li>
</ul>
<div class='text'></div>
<?php
}
//end help 'New patient' new-patient.php

//help 'New appointment' new-appointment.php
function help_new_appointment() {
?>
<h4>New appointment</h4>
<ul>
<li>Fill this form to schedule appointments for consultation</li>
<li>The <b>Convenient date and time</b> field is to record when the person will be available for the consultation</li>
<li>Fill it in the format: <b>YYYY-MM-DD HH:MM:SS</b></li>
</ul>
<div class='text'></div>
<?php
}
//end help 'New appointment' new-appointment.php

//help 'Frames (Warehouse)' wh-frame.php
function help_warehouse_frames() {
?>
<h4>Frames (Warehouse)</h4>
<ul>
<li>All the frames in the Warehouse -- by extension, all frames since frames are added to the Warehouse first -- will be listed here in the default view</li>
<li>Branches are at the top, select the branch whose stock level you want to view from the drop-down menu</li>
<li>You can view all pictures that has been uploaded for each frame and upload more</li>
<li>The full name of the frame, physical quantity and quantity sold will be shown though the Warehouse is not expected to sell things directly</li>
<li>You can also <b>Update</b> the quantity of stock for the Warehouse</li>
<li>Also, you can <b>Edit</b> each frame's information</li>
</ul>
<div class='text'></div>
<?php
}
//end help 'Frames (Warehouse)' wh-frame.php

//help 'Edit frame' edit-frame.php
function help_edit_frame() {
?>
<h4>Edit frame</h4>
<ul>
<li>Edit the registered information as appropriate and save it</li>
<li>Use the <b>Upload frame image</b> link to upload pictures of the frame</li>
<li>The <b>Set frame's status</b> link is for removing the frame from the active frames list. It is a kind of delete function though it will not be removed completely and can be listed later if there is need</li>
</ul>
<div class='text'></div>
<?php
}
//end help 'Edit frame' edit-frame.php

//help 'Image uploader' image-uploader.php
function help_image_uploader() {
?>
<h4>Image uploader</h4>
<ul>
<li>Upload pictures for frames and accessories using this form</li>
<li>There is no restriction on the maximum image size at the moment but if you can, resize the picture to conserve storage space</li>
<li>You will be directed to the image viewer page where you will see all the pictures uploaded for that particular stock</li>
</ul>
<div class='text'></div>
<?php
}
//end help 'Image uploader' image-uploader.php

//help 'De-list stock' delete.php
function help_delete() {
?>
<h4>De-list stock</h4>
<ul>
<li>Use this page to remove an item from the list of active stock. It is a kind of delete function though it will not be removed completely and can be listed later if there is need</li>
</ul>
<div class='text'></div>
<?php
}
//end help 'De-list stock' delete.php

//help 'Update frame' update-frame.php
function help_update_frame() {
?>
<h4>Update frame</h4>
<ul>
<li>Use this page to update the quantity of stock and import new frame</li>
</ul>
<div class='text'></div>
<?php
}
//end help 'Update frame' update-frame.php

//help 'Update lens' update-lens.php
function help_update_lens() {
?>
<h4>Update lens</h4>
<ul>
<li>Use this page to update the quantity of stock and import new lens</li>
</ul>
<div class='text'></div>
<?php
}
//end help 'Update lens' update-lens.php

//help 'Update accessory' update-accessory.php
function help_update_accessory() {
?>
<h4>Update accessory</h4>
<ul>
<li>Use this page to update the quantity of stock and import new accessory</li>
</ul>
<div class='text'></div>
<?php
}
//end help 'Update accessory' update-accessory

//help 'Lenses (Warehouse)' wh-lenses.php
function help_warehouse_lenses() {
?>
<h4>Lenses (Warehouse)</h4>
<ul>
<li>All the lenses in the Warehouse -- by extension, all lenses since lenses are added to the Warehouse first -- will be listed here in the default view</li>
<li>Branches are at the top, select the branch whose stock level you want to view from the drop-down menu</li>
<li>The lens' type, strength, physical quantity and quantity sold will be shown though the Warehouse is not expected to sell things directly</li>
<li>You can also <b>Update</b> the quantity of stock for the Warehouse</li>
<li>Also, you can <b>Edit</b> each lens' information</li>
</ul>
<div class='text'></div>
<?php
}
//end help 'Lenses (Warehouse)' wh-lenses.php

//help 'Edit lens' edit-lens.php
function help_edit_lens() {
?>
<h4>Edit lens</h4>
<ul>
<li>Edit the registered information as appropriate and save it</li>
<li>The <b>Set lens' status</b> link is for removing the lens from the active lenses list. It is a kind of delete function though it will not be removed completely and can be listed later if there is need</li>
</ul>
<div class='text'></div>
<?php
}
//end help 'Edit lens' edit-lens.php

//help 'Accessories (Warehouse)' wh-accessory.php
function help_warehouse_accessory() {
?>
<h4>Accessories (Warehouse)</h4>
<ul>
<li>All the accessories in the Warehouse -- by extension, all accessories since accessories are added to the Warehouse first -- will be listed here in the default view</li>
<li>Branches are at the top, select the branch whose stock level you want to view from the drop-down menu</li>
<li>The accessories' type, name, physical quantity and quantity sold will be shown though the Warehouse is not expected to sell things directly</li>
<li>You can also <b>Update</b> the quantity of stock for the Warehouse</li>
<li>Also, you can <b>Edit</b> each accessory's information</li>
</ul>
<div class='text'></div>
<?php
}
//end help 'Accessories (Warehouse)' wh-accessory.php

//help 'Edit accessory' edit-accessory.php
function help_edit_accessory() {
?>
<h4>Edit accessory</h4>
<ul>
<li>Edit the registered information as appropriate and save it</li>
<li>The <b>Set accessory's status</b> link is for removing the accessory from the active accessories list. It is a kind of delete function though it will not be removed completely and can be listed later if there is need</li>
</ul>
<div class='text'></div>
<?php
}
//end help 'Edit accessory' edit-accessory.php

//help 'New frame' new-frame.php
function help_new_frame() {
?>
<h4>New frame</h4>
<b>Example:</b><br/>
<u>Solion</u> Eyewear <u>SN-422</u> GOLD <u>53*18-135</u> Solion Italian Design CE
<ul>
<li><b>Brand name:</b> Solion</li>
<li><b>Model:</b> SN-422</li>
<li><b>Frame size:</b> 53*18-135</li>
<li><b>Material:</b> Metal</li>
<li><b>Style:</b> Ordinary</li>
<li><b>Rimp style:</b> Full rimp</li>
</ul>
<div class='text'></div>
<?php
}
//end help 'New frame' new-frame.php

//help 'New lens' new-lens.php
function help_new_lens() {
?>
<h4>New lens</h4>
<b>Example:</b><br/>
Dioptics SPH: <u>+050</u> ADD: <u>+300</u> CYL:
<ul>
<li><b>Strength:</b> +050 +300</li>
<li><b>Type:</b> Spherical</li>
</ul>
<div class='text'></div>
<?php
}
//end help 'New lens' new-lens.php

//help 'New accessory' new-accessory.php
function help_new_accessory() {
?>
<h4>New accessory</h4>
<b>Example:</b><br/>
DG case
<ul>
<li><b>Accessory name:</b> DG</li>
<li><b>Accessory type:</b> Case</li>
</ul>
<div class='text'></div>
<?php
}
//end help 'New accessory' new-accessory.php

//help Pending confirmations 'confirmation.php'
//function help_confirmation () {
?>