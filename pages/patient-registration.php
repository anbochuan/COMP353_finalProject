<?php include('include/sessionValidation.php') ?>

<?php

date_default_timezone_set("America/Montreal");
$minDoB = date('Y-m-d', strtotime('-18 years'));

if ($_POST) {
    include('include/DBConnection.php');

    $firstName = ucwords($_POST['firstName']);
    $lastName = ucwords($_POST['lastName']);
    $dob = $_POST['DOB'];
    $address = ucwords($_POST['address']);
    $city = ucwords($_POST['city']);
    $state = strtoupper($_POST['state']);
    $zipCode = strtoupper($_POST['zipCode']);
    $phone = $_POST['phone'];
    $pass = bin2hex(openssl_random_pseudo_bytes(6));
    $hashedPass = password_hash($pass, PASSWORD_BCRYPT, ['cost' => 12]);

    $stmt = $conn->prepare("INSERT INTO patient (FName, LName, DateOfBirth, Address, City, State, Zip_Code, Phone_No, Password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);");
    $stmt->bind_param("sssssssss", $firstName, $lastName, $dob, $address, $city, $state, $zipCode, $phone, $hashedPass);

    // Executes the statement
    $stmt->execute();

    $phn = $conn->insert_id;

    // Closes the statement
    $stmt->close();

    // Closes the connection to the DB
    $conn->close();

    // Account Credentials
    $message = 'Patient created successfully! \n\n' .
                'PHN: ' .$phn .'\n' .
                'Temparary Password: ' .$pass;
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
<title>Patient Registration - BSPC</title>

<?php include("include/styles.php") ?>

</head>
<body id="top">

<?php include("include/header.php") ?>

<div class="wrapper row3">
	<main class="hoc container clear">
		<div class="sectiontitle">
		  <h3 class="heading">Patient Registration</h3>
		  <p>To register a new patient, please fill out the form below.</p>
		</div>

		<div class="pageContent">

			<form method="post" action = "#">
                <!-- First Name -->
				<div class="formGroup">
					<label for="firstName">First Name:</label>
					<input type="text" name="firstName" required>
				</div>

                <!-- Last Name -->
				<div class="formGroup">
					<label for="lastName">Last Name:</label>
					<input type="text" name="lastName" required>
				</div>

                <!-- Date of Birth -->
				<div class="formGroup">
					<label for="DOB">Date of Birth:</label>
					<input type="date" name="DOB" max="<?= $minDoB ?>" required>
				</div>

                <!-- Address -->
				<div class="formGroup">
					<label for="address">Address:</label>
					<input type="text" name="address">
				</div>

                <!-- City -->
				<div class="formGroup">
					<label for="city">City:</label>
					<input type="text" name="city">
				</div>

                <!-- State -->
				<div class="formGroup">
					<label for="state">State:</label>
					<input type="text" name="state" pattern="[A-Za-z]{2}" maxlength="2">
				</div>

                <!-- Zip Code -->
				<div class="formGroup zipCode">
					<label for="zipCode">Zip Code:</label>
					<input type="text" name="zipCode" pattern="[A-Za-z][0-9][A-Za-z][0-9][A-Za-z][0-9]" maxlength="6">
                    <span>Pattern: A9A9A9</span>
				</div>

                <!-- Phone Number -->
				<div class="formGroup">
					<label for="phone">Phone Number:</label>
					<input type="text" name="phone" pattern="[0-9]{10}" maxlength="10">
				</div>

				<input type="submit" class="btn">

			</form>
		</div>
	</main>
</div>

<?php include("include/footer.php") ?>

</body>
</html>
