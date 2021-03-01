<?php
//to end the session and log out 
session_start();
unset($_SESSION);
session_destroy();
header("location:login.php");
?>