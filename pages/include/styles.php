<?php

$homeBaseURL = "../";

// Check if isLogin page
if (strpos($_SERVER['REQUEST_URI'], 'pages') === false) {
    $homeBaseURL = "";
}
?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="<?= $homeBaseURL .'styles/layout.css' ?>" rel="stylesheet" type="text/css" media="all">
<link href="<?= $homeBaseURL .'styles/customStyle.css' ?>" rel="stylesheet" type="text/css" media="all">
