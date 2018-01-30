<?php

$homeBaseURL = "../";

// Check if isLogin page
if (strpos($_SERVER['REQUEST_URI'], 'pages') === false) {
    $homeBaseURL = "";
}
?>

<script src="<?= $homeBaseURL .'scripts/jquery.min.js' ?>"></script>
<script src="<?= $homeBaseURL .'scripts/jquery.backtotop.js' ?>"></script>
<script src="<?= $homeBaseURL .'scripts/jquery.mobilemenu.js' ?>"></script>
