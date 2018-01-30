<?php include('include/sessionValidation.php') ?>

<?php

date_default_timezone_set("America/Montreal");
$minDoB = date('Y-m-d', strtotime('-18 years'));

if ($_POST['formCompleted'] == 'initial') {
    include('include/DBConnection.php');

    $phn = $_POST['phn'];

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

    // Frees the result
    $stmt->free_result();

    // Closes the statement
    $stmt->close();

    // Closes the connection to the DB
    $conn->close();
}
else if ($_POST['formCompleted'] == 'updatedInformation') {
    include('include/DBConnection.php');

    $phn = $_POST['phn'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dob = $_POST['DOB'];
    $address = ucwords($_POST['address']);
    $city = ucwords($_POST['city']);
    $state = strtoupper($_POST['state']);
    $zipCode = strtoupper($_POST['zipCode']);
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("UPDATE patient SET FName = ?, LName = ?, DateOfBirth = ?, Address = ?, City = ?, State = ?, Zip_Code = ?, Phone_No = ? WHERE PHN = ?;");
    $stmt->bind_param("ssssssssi", $firstName, $lastName, $dob, $address, $city, $state, $zipCode, $phone, $phn);

    // Executes the statement
    $stmt->execute();

    // Closes the statement
    $stmt->close();

    // Closes the connection to the DB
    $conn->close();

    // Succesful Message
    $message = 'Patient updated successfully!';
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
    <title>Patient Update - BSPC</title>

    <?php include("include/styles.php") ?>

</head>
<body id="top">

    <?php include("include/header.php") ?>

    <div class="wrapper row3">
        <main class="hoc container clear">
            <div class="sectiontitle">
                <h3 class="heading">Patient Update</h3>
                <p>To update a patient's information, please fill out the form below.</p>
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
                    <form method="POST" action = "#">

                        <input type="hidden" name="formCompleted" value="updatedInformation">
                        <input type="hidden" name="phn" value="<?= $_POST['phn']; ?>">
                        <!-- First Name -->
        				<div class="formGroup">
        					<label for="firstName">First Name:</label>
        					<input type="text" name="firstName" value="<?= ($patientInfo) ? $patientInfo->FName : '' ?>" required>
        				</div>

                        <!-- Last Name -->
        				<div class="formGroup">
        					<label for="lastName">Last Name:</label>
        					<input type="text" name="lastName" value="<?= ($patientInfo) ? $patientInfo->LName : '' ?>" required>
        				</div>

                        <!-- Date of Birth -->
        				<div class="formGroup">
        					<label for="DOB">Date of Birth:</label>
        					<input type="date" name="DOB" value="<?= ($patientInfo) ? $patientInfo->DateOfBirth : '' ?>" max="<?= $minDoB ?>" required>
        				</div>

                        <!-- Address -->
        				<div class="formGroup">
        					<label for="address">Address:</label>
        					<input type="text" name="address" value="<?= ($patientInfo) ? $patientInfo->Address : '' ?>">
        				</div>

                        <!-- City -->
        				<div class="formGroup">
        					<label for="city">City:</label>
        					<input type="text" name="city" value="<?= ($patientInfo) ? $patientInfo->City : '' ?>">
        				</div>

                        <!-- State -->
        				<div class="formGroup">
        					<label for="state">State:</label>
        					<input type="text" name="state" value="<?= ($patientInfo) ? $patientInfo->State : '' ?>" pattern="[A-Za-z]{2}" maxlength="2">
        				</div>

                        <!-- Zip Code -->
        				<div class="formGroup zipCode">
        					<label for="zipCode">Zip Code:</label>
        					<input type="text" name="zipCode" value="<?= ($patientInfo) ? $patientInfo->Zip_Code : '' ?>" pattern="[A-Za-z][0-9][A-Za-z][0-9][A-Za-z][0-9]" maxlength="6">
                            <span>Pattern: A9A9A9</span>
        				</div>

                        <!-- Phone Number -->
        				<div class="formGroup">
        					<label for="phone">Phone Number:</label>
        					<input type="text" name="phone" value="<?= ($patientInfo) ? $patientInfo->Phone_No : '' ?>" pattern="[0-9]{10}" maxlength="10">
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
