<?php

$isLogin = false;
$homeBaseURL = "";

// Check if isLogin page
if (strpos($_SERVER['REQUEST_URI'], 'pages') === false) {
    $isLogin = true;
    $homeBaseURL = "pages/";
}
?>


<div class="wrapper row1">
    <header id="header" class="hoc clear">
        <div id="logo">
            <a href="<?= $homeBaseURL ."home.php" ?>">
                <h1>BSPC</h1>
                <h2>Bahamas Sports Physio Center</h2>
            </a>
        </div>

        <?php
            if (!$isLogin) {
        ?>
            <div id="mainav">
                <ul class="clear">
                    <li><a href="../php/logout.php">Logout</a></li>
                </ul>
            </div>
        <?php
            }
        ?>
    </header>
</div>
