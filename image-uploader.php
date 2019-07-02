<?php include "functions.php";

//can user access the Warehouse?
isperm_warehouse();

echo "<title>Upload image</title>\n";
echo "<div id='main'>\n";

if (isset($_REQUEST["fid"])) {

$frame = $_REQUEST["fid"];
echo "<a href='edit-frame.php?fid=$frame'><button type='submit'>Go back</button></a>";
//search for the name, model and size of the specified frame to prevent mistake
$fetch_frame = "SELECT frame_name, frame_model, frame_size FROM frames WHERE frameid = $frame;";
$fetchFrame = connect($fetch_frame);

if (mysqli_num_rows($fetchFrame) > 0) {
//if the frame is not found, send the visitor out!
while($fd = mysqli_fetch_assoc($fetchFrame)) {
    echo "<div class='title'>Upload image for ".$fd["frame_name"]." ".$fd["frame_model"]." ".$fd["frame_size"]."</div>";
    $fname = $fd["frame_name"]."-".$fd["frame_model"]."-".$fd["frame_size"];
    //$fname = urlencode($fname);
    global $fname;
}
} else {
    header("Location: wh-frame.php");
    exit;
}

//when the form is submitted
if (isset($_POST['submit'])) {
    //assign the file array to variables
    $file = $_FILES["image"]; //a shortcut
    $fileName = $file["name"];
    $fileType = $file["type"];
    $fileError = $file["error"];
    $fileSize = $file["size"];
    $fileTempName = $file["tmp_name"];

    //an array of allowed file types, checking for file type is better than trusting the format
    //submitted by the user else, I can upload a song by changing .mp3 to .jpg
    $allowedType = array("image/png", "image/jpg", "image/jpeg", "image/pjpeg", "image/gif");

    //is the file type allowed?
    if (in_array($fileType, $allowedType)) {
        if ($fileError == 0) {
            //if there is no error, continue processing. Else, notify the user

            //check if the file exists in the 'frame_images' table and return the number of
            //occurrence of that particular frame in the table. This will be used for renaming
            //the image
            $check_file_exist = "SELECT count(f_id) AS Count FROM frame_images WHERE f_id = $frame;";
            $checkFileExist = connect($check_file_exist);

            while($cfe = mysqli_fetch_assoc($checkFileExist)) {
                //if there is no occurence, return 0 and add 1
                $count = $cfe["Count"] + 1;
                //$fileName is the raw file name from the user
                //explode() splits $fileName into an array from the '.' mark
                //end() moves the array pointer to the last element in the array i.e. the file extension
                //strtolower() makes sure the file extension is in lower case i.e. jpg instead of JPG
                $fileExt = strtolower(end(explode(".", $fileName)));
                //the new name: f for frame, $count for number, $fileExt for the extension
                $frameName = $frame."-".$count.".".$fileExt;
                //merge them into a global variable to the inserted into the frame_images table
                global $frameName;
            }
            //move the image from it's temporary location to the frames folder inside images
            $moveUpload = move_uploaded_file($fileTempName, "images/frames/".$frameName);
            if ($moveUpload) {
            //if the move is successful, write the new name for url and id into the table
            $record_in_db = "INSERT INTO frame_images (f_id, f_url) VALUES ($frame, '$frameName');";
            $recordInDB = connect($record_in_db);
            //when it is done, go to a one-for-all image-displaying page
                header("Location: images.php?f=$frame");
                exit;
            }
        } else {
            echo "<div class='text'>There is an error in that file</div>\n";
        }
    } else {
        echo "<div class='text'>Invalid file type</div>\n";
    }
}

echo "<div class='text'>\n";
echo "<form action='image-uploader.php?fid=$frame' method='POST' enctype='multipart/form-data'>\n";
echo "<input type='file' name='image'><br/><br/>\n";
echo "<button type='submit' name='submit'>Upload image</button><br/>\n";
echo "</form>\n";
echo "</div>\n";

}

//accessories
else if (isset($_REQUEST["aid"])) {

$accessory = $_REQUEST["aid"];
echo "<a href='edit-accessory.php?aid=$accessory'><button type='submit'>Go back</button></a>";
//search for the name, model and size of the specified frame to prevent mistake
$fetch_accessory = "SELECT acc_name, acc_type FROM accessories WHERE accid = $accessory;";
$fetchAccessory = connect($fetch_accessory);

if (mysqli_num_rows($fetchAccessory) > 0) {
//if the frame is not found, send the visitor out!
while($ad = mysqli_fetch_assoc($fetchAccessory)) {
    echo "<div class='title'>Upload image for ".$ad["acc_type"].": ".$ad["acc_name"]."</div>";
}
} else {
    header("Location: wh-accessory.php");
    exit;
}

//when the form is submitted
if (isset($_POST['submit'])) {
    //assign the file array to variables
    $file = $_FILES["image"]; //a shortcut
    $fileName = $file["name"];
    $fileType = $file["type"];
    $fileError = $file["error"];
    $fileSize = $file["size"];
    $fileTempName = $file["tmp_name"];

    //an array of allowed file types, checking for file type is better than trusting the format
    //submitted by the user else, I can upload a song by changing .mp3 to .jpg
    $allowedType = array("image/png", "image/jpg", "image/jpeg", "image/pjpeg", "image/gif");

    //is the file type allowed?
    if (in_array($fileType, $allowedType)) {
        if ($fileError == 0) {
            //if there is no error, continue processing. Else, notify the user

            //check if the file exists in the 'frame_images' table and return the number of
            //occurrence of that particular frame in the table. This will be used for renaming
            //the image
            $check_file_exist = "SELECT count(a_id) AS Count FROM accessory_images WHERE a_id = $accessory;";
            $checkFileExist = connect($check_file_exist);

            while($cfe = mysqli_fetch_assoc($checkFileExist)) {
                //if there is no occurence, return 0 and add 1
                $count = $cfe["Count"] + 1;
                //$fileName is the raw file name from the user
                //explode() splits $fileName into an array from the '.' mark
                //end() moves the array pointer to the last element in the array i.e. the file extension
                //strtolower() makes sure the file extension is in lower case i.e. jpg instead of JPG
                $fileExt = strtolower(end(explode(".", $fileName)));
                //the new name: f for frame, $count for number, $fileExt for the extension
                $accessoryName = $accessory."-".$count.".".$fileExt;
                //merge them into a global variable to the inserted into the frame_images table
                global $accessoryName;
            }
            //move the image from it's temporary location to the frames folder inside images
            $moveUpload = move_uploaded_file($fileTempName, "images/accessories/".$accessoryName);
            if ($moveUpload) {
            //if the move is successful, write the new name for url and id into the table
            $record_in_db = "INSERT INTO accessory_images (a_id, a_url) VALUES ($accessory, '$accessoryName');";
            $recordInDB = connect($record_in_db);
            //when it is done, go to a one-for-all image-displaying page
                header("Location: images.php?a=$accessory");
                exit;
            }
        } else {
            echo "<div class='text'>There is an error in that file</div>\n";
        }
    } else {
        echo "<div class='text'>Invalid file type</div>\n";
    }
}

echo "<div class='text'>\n";
echo "<form action='image-uploader.php?aid=$accessory' method='POST' enctype='multipart/form-data'>\n";
echo "<input type='file' name='image'><br/><br/>\n";
echo "<button type='submit' name='submit'>Upload image</button><br/>\n";
echo "</form>\n";
echo "</div>\n";

} else {
    echo "<div class='text'>Sorry, you cannot upload images for that</div>\n";
}
echo "<div class='title'>Help</div>\n";
help_image_uploader();
echo "</div>\n";

include "footer.php";
?>
