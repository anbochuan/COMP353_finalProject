<?php include('include/sessionValidation.php') ?>

<?php

if ($_POST['formCompleted'] == 'initial') {
    include('include/DBConnection.php');

    $phn = $_POST['phn'];

    // Patient Info
    $stmt = $conn->prepare("SELECT FName, LName, DateOfBirth, Address, City, State, Zip_Code, Phone_No FROM patient WHERE PHN = ?");
    $stmt->bind_param("i", $phn);


    // Executes the statement
    $stmt->execute();

    // Gets the result
    $queryResult = $stmt->get_result();

    // Gets the number of rows
    $numOfrows = $queryResult->num_rows;

    if ($numOfrows > 0) {
        $patientInfo = $queryResult->fetch_object();
    }

    // Appointments
    $stmt = $conn->prepare("SELECT Date_Time, FName, LName, Emp_Type FROM appointment JOIN employee ON Doc_ID = Emp_ID OR Ther_ID = Emp_ID NATURAL JOIN emp_position WHERE PHN = ? ORDER BY Date_Time, LName, FName;");
    $stmt->bind_param("i", $phn);


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
}

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
    <title>Patient Record - BSPC</title>

    <?php include("include/styles.php") ?>
</head>
<body id="top">

    <?php include("include/header.php") ?>

    <div class="wrapper row3">
        <main class="hoc container clear">
            <div class="sectiontitle">
                <h3 class="heading">Patient Record</h3>
                <p>To view a patient's record, please enter the PHN number of the patient.</p>
            </div>

            <div class="pageContent">

                <?php if (empty($_POST['formCompleted']) || $_POST['formCompleted'] != 'initial') { ?>
                    <form method="POST" action = "#">

                        <input type="hidden" name="formCompleted" value="initial">
                        <div class="formGroup">
                            <label for="phn">PHN:</label>
                            <input type="number" name="phn">
                        </div>

                        <input type="submit" class="btn">

                    </form>
                <?php } ?>

                <?php if ($_POST['formCompleted'] == 'initial') { ?>

                    <h4>Patient Information:</h4>
                    <table>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Date of Birth</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Zip Code</th>
                            <th>Phone Number</th>
                        </tr>
                        <tr>
                            <td><?= $patientInfo->FName ?></td>
                            <td><?= $patientInfo->LName ?></td>
                            <td><?= $patientInfo->DateOfBirth ?></td>
                            <td><?= $patientInfo->Address ?></td>
                            <td><?= $patientInfo->City ?></td>
                            <td><?= $patientInfo->State ?></td>
                            <td><?= $patientInfo->Zip_Code ?></td>
                            <td><?= "(". substr($patientInfo->Phone_No, 0, 3) .") " . substr($patientInfo->Phone_No, 3, 3) ."-" . substr($patientInfo->Phone_No, 6) ?></td>
                        </tr>
                    </table>

                    <br>
                    <h4>Appointments:</h4>

                    <table>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Specialist</th>
                        </tr>
                        <?php
                        while ($appointment = $appointments->fetch_object()) { ?>
                        <tr>
                            <td><?= substr($appointment->Date_Time, 0, 10) ?></td>
                            <td><?= substr($appointment->Date_Time, 11, 5) ?></td>
                            <td><?= $appointment->FName . ' ' . $appointment->LName . ' (' . $appointment->Emp_Type .')' ?></td>
                        </tr>
                        <?php } ?>
                    </table>


                <?php } ?>
            </div>
        </main>
    </div>

    <?php include("include/footer.php") ?>

</body>
</html>
