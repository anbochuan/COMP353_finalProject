<?php include('include/sessionValidation.php') ?>

<?php

if ($_POST['formCompleted'] == 'initial') {
    include('include/DBConnection.php');

    // Doctors
    $stmt = $conn->prepare("SELECT Emp_ID, FName, LName FROM employee NATURAL JOIN emp_position WHERE Emp_Type = 'Doctor' ORDER BY LName, FName");

    // Executes the statement
    $stmt->execute();

    // Gets the result
    $doctors = $stmt->get_result();

    // Therapists
    $stmt = $conn->prepare("SELECT Emp_ID, FName, LName FROM employee NATURAL JOIN emp_position WHERE Emp_Type = 'Therapist' ORDER BY LName, FName");

    // Executes the statement
    $stmt->execute();

    // Gets the result
    $therapists = $stmt->get_result();



    $phn = $_POST['phn'];
    $appointmentDate = $_POST['appointmentDate'];
    $appointmentTime = $_POST['appointmentTime'];
    $appointmentDateTime = $appointmentDate . ' ' . $appointmentTime .'%';

    $stmt = $conn->prepare("SELECT * FROM appointment WHERE PHN = ? AND Date_Time LIKE ?");
    $stmt->bind_param("is", $phn, $appointmentDateTime);


    // Executes the statement
    $stmt->execute();

    // Gets the result
    $queryResult = $stmt->get_result();

    if ($queryResult->num_rows == 0) {
        // Error Message
        $message = 'No results. 0 appoinment matched the entered criteria.';
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
    else {
        $appointment = $queryResult->fetch_object();
    }

    // Frees the result
    $stmt->free_result();

    // Closes the statement
    $stmt->close();

    // Closes the connection to the DB
    $conn->close();
}
else if ($_POST['formCompleted'] == 'updatedInformation') {
    include('include/DBConnection.php');

    $appointmentID = $_POST['appointmentID'];
    $phn = $_POST['phn'];
    $doctorTherapist = $_POST['doctorTherapist'];
    $appointmentDate = $_POST['appointmentDate'];
    $appointmentTime = $_POST['appointmentTime'];
    $appointmentDateTime = $appointmentDate . ' ' . $appointmentTime;
    $columnID = explode("-", $doctorTherapist)[0] . '_ID';
    $emp_ID = explode("-", $doctorTherapist)[1];

    if ($columnID == 'Doc_ID') {
        $otherColumnID = 'Ther_ID';
    }
    else {
        $otherColumnID = 'Doc_ID';
    }
	
	$defaultValueID = 0;

    $stmt = $conn->prepare("UPDATE appointment SET Date_Time = ?, PHN = ?, $columnID = ?, $otherColumnID = ? WHERE Appointment_ID = ?;");
    $stmt->bind_param("siiii", $appointmentDateTime, $phn, $emp_ID, $defaultValueID, $appointmentID);

    // Executes the statement
    $stmt->execute();

    // Closes the statement
    $stmt->close();

    // Closes the connection to the DB
    $conn->close();

    // Succesful Message
    $message = 'Appointment updated successfully!';
    echo "<script type='text/javascript'>alert('$message');</script>";
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
    <title>Update Appointment - BSPC</title>

    <?php include("include/styles.php") ?>

</head>
<body id="top">

    <?php include("include/header.php") ?>

    <div class="wrapper row3">
        <main class="hoc container clear">
            <div class="sectiontitle">
                <h3 class="heading">Update Appointment</h3>
                <p>To update an appointment, please fill out the form below.<br>When is your current appointment?</p>
            </div>

            <div class="pageContent">

                <?php if (empty($_POST['formCompleted']) || $_POST['formCompleted'] != 'initial') { ?>
                    <form method="POST" action = "#">

                        <input type="hidden" name="formCompleted" value="initial">
                        <div class="formGroup">
                            <label for="phn">PHN:</label>
                            <input type="number" name="phn">
                        </div>
                        <div class="formGroup">
                            <label for="appointmentDate">Appointment Date:</label>
                            <input type="date" name="appointmentDate">
                        </div>
                        <div class="formGroup">
                            <label for="appointmentTime">Appointment Time:</label>
                            <input type="time" name="appointmentTime">
                        </div>

                        <input type="submit" class="btn">

                    </form>
                    <?php } ?>

                    <?php if ($_POST['formCompleted'] == 'initial') { ?>
                        <form method="POST" action = "#">

                            <input type="hidden" name="formCompleted" value="updatedInformation">
                            <input type="hidden" name="appointmentID" value="<?= $appointment->Appointment_ID ?>">

                            <div class="formGroup">
                                <label for="phn">PHN:</label>
                                <input type="number" name="phn" value="<?= $appointment->PHN ?>">
                            </div>

            				<div class="formGroup">
            					<label for="doctorTherapist">Doctor / Therapist:</label>
            					<select name="doctorTherapist" id="doctorTherapist" required>
            						<option value="">Select an option</option>

            						<optgroup label="Doctors">
                                        <?php
                                        while ($doctor = $doctors->fetch_object()) { ?>
                                            <option value="<?= 'Doc-' . $doctor->Emp_ID ?>" <?= (($appointment->Doc_ID == $doctor->Emp_ID) ? 'selected=selected' : ''); ?>><?=$doctor->FName . ' ' . $doctor->LName ?></option>
                                        <?php } ?>
            						</optgroup>

            						<optgroup label="Therapists">
                                        <?php
                                        while ($therapist = $therapists->fetch_object()) { ?>
                                            <option value="<?= 'Ther-' . $therapist->Emp_ID ?>" <?= (($appointment->Ther_ID == $therapist->Emp_ID) ? 'selected=selected' : ''); ?>><?=$therapist->FName . ' ' . $therapist->LName ?></option>
                                        <?php } ?>
            						</optgroup>
            					</select>
            				</div>

            				<div class="formGroup">
            					<label for="appointmentDate">Date:</label>
            					<input type="date" name="appointmentDate" value="<?= substr($appointment->Date_Time, 0, 10) ?>" required>
            				</div>

            				<div class="formGroup">
            					<label for="appointmentTime">Time:</label>
            					<input type="time" name="appointmentTime" value="<?= substr($appointment->Date_Time, 11) ?>" required>
            				</div>


                            <input type="submit" class="btn">

                        </form>
                        <?php } ?>
                    </div>
                </main>
            </div>

            <?php include("include/footer.php") ?>

        </body>
        </html>
