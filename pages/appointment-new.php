<?php include('include/sessionValidation.php') ?>

<?php

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

// Frees the result
$stmt->free_result();

// Closes the statement
$stmt->close();

// Closes the connection to the DB
$conn->close();

if ($_POST) {
    include('include/DBConnection.php');

    $phn = $_POST['phn'];
    $doctorTherapist = $_POST['doctorTherapist'];
    $appointmentDate = $_POST['appointmentDate'];
    $appointmentTime = $_POST['appointmentTime'];
    $appointmentDateTime = $appointmentDate . ' ' . $appointmentTime . ':00';
    $columnID = explode("-", $doctorTherapist)[0] . '_ID';
    $emp_ID = explode("-", $doctorTherapist)[1];
	
	if($columnID == 'Doc_ID') {
		$otherColumn = 'Ther_ID';
	}
	else {
		$otherColumn = 'Doc_ID';
	}
	
	$defaultValueID = 0;

    $stmt = $conn->prepare("INSERT INTO appointment (Date_Time, PHN, $columnID, $otherColumn) VALUES (?, ?, ?, ?);");
    $stmt->bind_param("sssi", $appointmentDateTime, $phn, $emp_ID, $defaultValueID);

    // Executes the statement
    $stmt->execute();

    // Closes the statement
    $stmt->close();

    // Closes the connection to the DB
    $conn->close();

    // Succesful Message
    $message = 'Appointment created successfully!';
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
<title>Make Appointment - BSPC</title>

<?php include("include/styles.php") ?>

</head>
<body id="top">

<?php include("include/header.php") ?>

<div class="wrapper row3">
	<main class="hoc container clear">
		<div class="sectiontitle">
		  <h3 class="heading">Make Appointment</h3>
		  <p>To make an appointment, please fill out the form below.</p>
		</div>

		<div class="pageContent">

			<form method="post" action = "#">

                <?php if ($_SESSION["userInfo"]["userType"] == 'employee') { ?>
                    <div class="formGroup">
                        <label for="phn">PHN:</label>
                        <input type="number" name="phn">
                    </div>
                <?php }
                else { ?>
                    <input type="hidden" name="phn" value="<?= $_SESSION["userInfo"]['phn']; ?>">
                <?php } ?>

				<div class="formGroup">
					<label for="doctorTherapist">Doctor / Therapist:</label>
					<select name="doctorTherapist" id="doctorTherapist" required>
						<option value="">Select an option</option>

						<optgroup label="Doctors">
                            <?php
                            while ($doctor = $doctors->fetch_object()) {
                                echo "<option value='Doc-$doctor->Emp_ID'>" . $doctor->FName . " " . $doctor->LName . "</option>";
                            }
                            ?>
						</optgroup>

						<optgroup label="Therapists">
                            <?php
                            while ($therapist = $therapists->fetch_object()) {
                                echo "<option value='Ther-$therapist->Emp_ID'>" . $therapist->FName . " " . $therapist->LName . "</option>";
                            }
                            ?>
						</optgroup>
					</select>
				</div>

				<div class="formGroup">
					<label for="appointmentDate">Date:</label>
					<input type="date" name="appointmentDate" required>
				</div>

				<div class="formGroup">
					<label for="appointmentTime">Time:</label>
					<input type="time" name="appointmentTime" required>
				</div>


				<input type="submit" class="btn">

			</form>
		</div>
	</main>
</div>

<?php include("include/footer.php") ?>

</body>
</html>
