<?php include('include/sessionValidation.php') ?>

<?php

$empType = $_SESSION['userInfo']['empType'];
$empNum = $_SESSION['userInfo']['empNum'];

include('include/DBConnection.php');

$stmt = $conn->prepare("SELECT * from medicine;");

// Executes the statement
$stmt->execute();

$medicines = $stmt->get_result();

if ($_POST) {
    include('include/DBConnection.php');

    $phn = $_POST['phn'];
    $prescriptionDate = $_POST['prescriptionDate'];
    $diagnosis = $_POST['diagnosis'];
	$prescriptionNote = $_POST['prescriptionNote'];
	
	if($empType == 'Doctor') {
		$prescriptionColumn = 'Doc_ID';
		$prescriptionColumnNote = 'Doctor_Note';
		$prescriptionTable = 'doctor_prescription';
	}
	else {
		$prescriptionColumn = 'Ther_ID';
		$prescriptionColumnNote = 'Therapist_Note';
		$prescriptionTable = 'therapist_prescription';
	}
	
	// Prescriptin table
    $stmt = $conn->prepare("INSERT INTO prescription (Diagnose, Date) VALUES (?, ?);");
    $stmt->bind_param("ss", $diagnosis, $prescriptionDate);

    // Executes the statement
    $stmt->execute();
	
	$prescriptionID = $conn->insert_id;
	
	// empType_prescription table
	$stmt = $conn->prepare("INSERT INTO $prescriptionTable (Prescription_ID, $prescriptionColumnNote, $prescriptionColumn, PHN) VALUES (?, ?, ?, ?);");
    $stmt->bind_param("isii", $prescriptionID, $prescriptionNote, $empNum, $phn);

    // Executes the statement
    $stmt->execute();
	
	
	// empType_prescribe table
	if($empType == 'Doctor') {
		$medicine = $_POST['medicine'];
		$medicineQuantity = $_POST['medicineQuantity'];
		
		$stmt = $conn->prepare("INSERT INTO d_prescribe (Prescription_ID, Medicine_Code, quantity) VALUES (?, ?, ?);");
		$stmt->bind_param("isi", $prescriptionID, $medicine, $medicineQuantity);

		// Executes the statement
		$stmt->execute();
	}
	else {
		$equipment = $_POST['equipment'];
		$treatment = $_POST['treatment'];
		
		$stmt = $conn->prepare("INSERT INTO d_prescribe (Prescription_ID, Equipment_Name, Treatment_Name) VALUES (?, ?, ?);");
		$stmt->bind_param("isi", $prescriptionID, $medicine, $medicineQuantity);

		// Executes the statement
		$stmt->execute();
	}

    // Closes the statement
    $stmt->close();

    // Closes the connection to the DB
    $conn->close();

    // Succesful Message
    $message = 'Prescription added successfully!';
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
<title>Prescription - BSPC</title>

<?php include("include/styles.php") ?>


</head>
<body id="top">

<?php include("include/header.php") ?>

<div class="wrapper row3">
	<main class="hoc container clear">

		<div class="sectiontitle">
		  <h3 class="heading">Prescription</h3>
		  <p>Fill out the form below to create a prescription.</p>
		</div>

		<div class="pageContent">

            <form method="post" action = "#">
                <!-- PHN-->
                <div class="formGroup">
                    <label for="phn">PHN:</label>
                    <input type="text" name="phn" required>
                </div>
                <!-- Date-->
                <div class="formGroup">
                    <label for="prescriptionDate">Date:</label>
                    <input type="date" name="prescriptionDate" required>
                </div>
                <!-- Diagnosis-->
                <div class="formGroup">
                    <label for="diagnosis">Diagnosis:</label>
                    <input type="text" name="diagnosis" required>
                </div>

                <?php if ($empType == 'Doctor') { ?>
                    <!-- Medicine-->
                    <div class="formGroup">
                        <label for="medicine">Medicine:</label>
						<select name="medicine" required>
						 <?php
							while ($medicine = $medicines->fetch_object()) { ?>
								<option value='<?= $medicine->Medicine_Code ?>'><?= $medicine->Medicine_Code ?></option>
						<?php } ?>
						</select>
                    </div>
                    <!-- Quantity-->
                    <div class="formGroup">
                        <label for="medicineQuantity">Quantity:</label>
                        <input type="text" name="medicineQuantity" required>
                    </div>
                <?php }
                else { ?>
                    <!-- Equipment-->
                    <div class="formGroup">
                        <label for="equipment">Equipment:</label>
                        <input type="text" name="equipment" required>
                    </div>
                    <!-- Treatment-->
                    <div class="formGroup">
                        <label for="treatment">Treatment:</label>
                        <input type="text" name="treatment" required>
                    </div>
                <?php } ?>
				
				<!-- Note-->
                <div class="formGroup wordCountDIV">
                    <label for="prescriptionNote"><?= $empType . ' Note:' ?><p class="wordCount">Word count: <span id="wordCount"></span></p></label>
                    <textarea type="text" id="prescriptionNote" name="prescriptionNote" rows="4" cols="40"></textarea>
                </div>

                <input type="submit" class="btn">
            </form>
		</div>
	</main>
</div>

<?php include("include/footer.php") ?>

<script>
    $(function () {
        counter();
    });
    counter = function() {
        var value = $('#prescriptionNote').val();

        if (value.length == 0) {
            $('#wordCount').html(0);
            return;
        }

        var regex = /\s+/gi;
        var wordCount = value.trim().replace(regex, ' ').split(' ').length;

        $('#wordCount').html(wordCount);

        if (wordCount > 100) {
			$('#wordCount').css('color', 'red');
            $('input[type="submit"]').prop('disabled', true);
        }
        else {
			$('#wordCount').css('color', 'black');
            $('input[type="submit"]').prop('disabled', false);
        }
    };

    $(document).ready(function() {
        $('#prescriptionNote').keypress(counter);
        $('#prescriptionNote').keyup(counter);
    });
</script>

</body>
</html>
