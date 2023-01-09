<?php
/*
SHIVAM JANDA
2022-12-07
WEBD 3201
*/
$title = "WEBD3201 Login Page";

session_start();
session_unset();
session_destroy();
session_start();

require("includes/constants.php");
require("includes/db.php");
require("includes/functions.php");

setMessage("You successfully logged out.");
$_SESSION["isVerified"] = false;

redirect("sign-in.php");
?>  