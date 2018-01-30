<?php include('include/sessionValidation.php') ?>

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
<title>Register Patient - BSPC</title>

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
					<input type="text" name="firstName">
				</div>

                <!-- Last Name -->
				<div class="formGroup">
					<label for="lastName">Last Name:</label>
					<input type="text" name="lastName">
				</div>

                <!-- Date of Birth -->
				<div class="formGroup">
					<label for="DOB">Date of Birth:</label>
					<input type="date" name="DOB">
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

                <!-- Country -->
				<div class="formGroup">
					<label for="country">Country:</label>
					<input type="text" name="country">
				</div>

                <!-- Zip Code -->
				<div class="formGroup zipCode">
					<label for="zipCode">Zip Code:</label>
					<input type="text" name="zipCode" pattern="[A-Za-z][0-9][A-Za-z][ ]?[0-9][A-Za-z][0-9]">
                    <span>Pattern: A9A 9A9</span>
				</div>

                <!-- Phone Number -->
				<div class="formGroup">
					<label for="phone">Phone Number:</label>
					<input type="text" name="phone" pattern="[0-9]{10}">
				</div>



				<input type="submit" class="btn">

			</form>
		</div>
	</main>
</div>

<?php include("include/footer.php") ?>

</body>
</html>
