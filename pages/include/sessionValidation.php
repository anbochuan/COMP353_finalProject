<?php

// Start the session
session_start();

if (!$_SESSION["userInfo"]) {
    header("Location: ../index.php");
    die();
}


?>
