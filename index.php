<?php
// Start the session
session_start();

if ($_SESSION["userInfo"]) {
    header("Location: pages/home.php");
    die();
}

$enteredCredentials = $_SESSION['enteredCredentials'];
$noCredentials = is_null($enteredCredentials);
unset($_SESSION['enteredCredentials']);

?>

<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="styles/layout.css" rel="stylesheet" type="text/css" media="all">
    <link href="styles/customStyle.css" rel="stylesheet" type="text/css" media="all">
    <link href="styles/login.css" rel="stylesheet">
</head>
<body>

    <?php include("pages/include/header.php") ?>

    <div class="login-page">
        <div class="form">
            <div class="userType">
                <button class="loginEmpBtn <?= ($noCredentials || $enteredCredentials['userType'] == 'employee') ? 'selectedBtn' : '' ?>">Employee</button>
                <button class="loginPatientBtn <?= ($enteredCredentials['userType'] == 'patient') ? 'selectedBtn' : '' ?>">Patient</button>
            </div>
            <form class="login-form-patient <?= ($enteredCredentials['userType'] == 'patient') ? 'showForm' : '' ?>"
                action="php/loginAuthenticator.php" method="POST">
                <input type="hidden" name="submittedForm" value="patient" />
                <input type="number" id="phn" name="phn" placeholder="Personal Health Number (PHN)" value="<?= $enteredCredentials['phn'] ?>" required/>
                <input type="password" name="pass" placeholder="Password" required/>
                <button>login</button>
            </form>
            <form class="login-form-emp <?= ($noCredentials || $enteredCredentials['userType'] == 'employee') ? 'showForm' : '' ?>"
                action="php/loginAuthenticator.php" method="POST">
                <input type="hidden" name="submittedForm" value="employee" />
                <input type="number" id="empNum" name="empNum" placeholder="Employee Number" value="<?= $enteredCredentials['empNum'] ?>" required/>
                <input type="password" name="pass" placeholder="Password" required/>
                <button>login</button>
            </form>

            <p class="errorMessage" style="<?= ($noCredentials) ? 'display:none;' : '' ?>">Invalid credentials. Try again.</p>
        </div>
    </div>
    <script src="scripts/jquery.min.js"></script>
    <script src="scripts/login.js"></script>
</body>
</html>
