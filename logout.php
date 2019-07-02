<?php
//start a session
session_start();

//remove all session variables
session_unset();

//destroy the session
session_destroy();

//redirect
header("Location: index.php");

?>
