<?php include('include/sessionValidation.php') ?>

<?php

include('include/DBConnection.php');

$empType = $_SESSION['userInfo']['empType'];
$empNum = $_SESSION['userInfo']['empNum'];

if ($empType == 'Doctor') {
    $columnID = 'Doc_ID';
}
else {
    $columnID = 'Ther_ID';
}

// Appointments
$stmt = $conn->prepare("SELECT Date_Time, A.PHN, FName, LName FROM appointment A JOIN patient P ON A.PHN = P.PHN WHERE $columnID = ? ORDER BY Date_Time, LName, FName;");
$stmt->bind_param("i", $empNum);


// Executes the statement
$stmt->execute();

// Gets the result
$appointments = $stmt->get_result();

// Frees the result
$stmt->free_result();

// Closes the statement
$stmt->close();

// Closes the connection to the DB
$conn->close();

?>

<!DOCTYPE html>
<!--
Template Name: Jeren
Author: <a href="http://www.os-templates.com/">OS Templates</a>
Author URI: http://www.os-templates.com/
Licence: Free to use under our free template licence terms
Licence URI: http://www.os-templates.com/template-terms
-->
<html>
<head>
<title>View Appointments - BSPC</title>

<?php include("include/styles.php") ?>

</head>
<body id="top">

<?php include("include/header.php") ?>

<div class="wrapper row3">
	<main class="hoc container clear">
		<div class="sectiontitle">
		  <h3 class="heading">View Appointment</h3>
		  <p>List of upcoming appointments.</p>
		</div>

		<div class="pageContent">

            <table>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Patient</th>
                </tr>
                <?php
                while ($appointment = $appointments->fetch_object()) { ?>
                <tr>
                    <td><?= substr($appointment->Date_Time, 0, 10) ?></td>
                    <td><?= substr($appointment->Date_Time, 11, 5) ?></td>
                    <td><?= $appointment->FName . ' ' . $appointment->LName ?></td>
                </tr>
                <?php } ?>
            </table>

		</div>
	</main>
</div>

<?php include("include/footer.php") ?>

</body>
</html>
