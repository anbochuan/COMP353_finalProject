<?php include('include/sessionValidation.php') ?>

<?php
date_default_timezone_set("America/Montreal");

if ($_POST['formCompleted'] == 'initial') {
    include('include/DBConnection.php');

    $prescriptionID = $_POST['prescriptionID'];
	
	$stmt = $conn->prepare("SELECT * FROM medical_prescriptions WHERE Prescription_ID = ?");
    $stmt->bind_param("i", $prescriptionID);
	
	// Executes the statement
    $stmt->execute();
	
	// Gets the result
    $queryResult = $stmt->get_result();

    // Gets the number of rows
    $numOfrows = $queryResult->num_rows;

    if ($numOfrows == 1) {
        $prescriptionInfo = $queryResult->fetch_object();
		$amount = $prescriptionInfo->Price * $prescriptionInfo->quantity;
    }
	else {
		$stmt = $conn->prepare("SELECT * FROM therapy_prescriptions WHERE Prescription_ID = ?");
		$stmt->bind_param("i", $prescriptionID);
		
		// Executes the statement
		$stmt->execute();
		
		// Gets the result
		$queryResult = $stmt->get_result();

		// Gets the number of rows
		$numOfrows = $queryResult->num_rows;

		if ($numOfrows == 1) {
			$prescriptionInfo = $queryResult->fetch_object();
			$amount = $prescriptionInfo->Equipment_Price + $prescriptionInfo->Treatment_Price;
		}
		else {
			// Error Message
			$message = 'The Prescription ID entered does not exist!';
			echo "<script type='text/javascript'>alert('$message');</script>";
		}
	}
	
    $paymentType = $_POST['paymentType'];
    $amount = $_POST['amount'];
    $transactionDate = date('Y-m-d H:i:s');

    if ($paymentType == 'CA' || $paymentType == 'CH') {
        $stmt = $conn->prepare("INSERT INTO payment(Prescription_ID, Payment_Type, Amount, Transaction_Date) VALUES(?, ?, ?, ?)");
        $stmt->bind_param("isd", $prescriptionID, $paymentType, $amount, $transactionDate);
    }
    else {
        $stmt = $conn->prepare("INSERT INTO payment(Prescription_ID, Payment_Type) VALUES(?, ?)");
        $stmt->bind_param("is", $prescriptionID, $paymentType);
    }

    // Executes the statement
    $stmt->execute();

    $paymentID = $conn->insert_id;

    if ($paymentType == 'CC' || $paymentType == 'DC') {

        $cardNumber = $_POST['cardNumber'];
        $bankName = $_POST['bankName'];
        $expireMonth = $_POST['expireMonth'];
        $expireYear = $_POST['expireYear'];

        $stmt = $conn->prepare("INSERT INTO card(Payment_ID, Card_No, Bank_Name, Card_Type, Expire_Year, Expire_Month, Amount, Transaction_Date) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissiids", $paymentID, $cardNumber, $bankName, $paymentType, $expireYear, $expireMonth, $amount, $transactionDate);

        // Executes the statement
        $stmt->execute();
    }

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
    <title>Payment - BSPC</title>

    <?php include("include/styles.php") ?>


</head>
<body id="top">

    <?php include("include/header.php") ?>

    <div class="wrapper row3">
        <main class="hoc container clear">

            <div class="sectiontitle">
                <h3 class="heading">Payment</h3>
                <p>To complete a payment transaction, please fill out the form below.</p>
            </div>

            <div class="pageContent">
			
			<?php if (empty($_POST['formCompleted']) || $_POST['formCompleted'] != 'initial') { ?>
                <form method="POST" action = "#">

                    <input type="hidden" name="formCompleted" value="initial">
                    <!-- Prescription ID -->
    				<div class="formGroup">
    					<label for="prescriptionID">Prescription ID:</label>
    					<input type="text" name="prescriptionID" required>
    				</div>

                    <input type="submit" class="btn">

                </form>
            <?php } ?>

            <?php if ($_POST['formCompleted'] == 'initial') { ?>
    			<form method="post" action = "#">
                    <input type="hidden" name="formCompleted" value="InsertInformation">
                    
					 <!-- Prescription ID -->
    				<div class="formGroup">
    					<label for="prescriptionID">Prescription ID:</label>
    					<input type="text" name="prescriptionID" value="<?= $prescriptionID ?>" readonly>
    				</div>

                    <!-- Amount -->
    				<div class="formGroup">
    					<label for="amount">Amount:</label>
    					<input type="text" name="amount" value="<?= $amount ?>" readonly>
    				</div>

                    <!-- Payment Type -->
    				<div class="formGroup">
    					<label for="paymentType">Payment Type:</label>
    					<select id="paymentType" name="paymentType" required>
                            <option value="">Select an option</option>
                            <option value="CA">Cash</option>
                            <option value="CC">Credit Card</option>
                            <option value="DC">Debit Card</option>
                            <option value="CH">Cheque</option>
                        </select>
    				</div>

                    <div class="paymentCardInfoSection">
                        <!-- Card Number -->
        				<div class="formGroup">
        					<label for="cardNumber">Card Number:</label>
        					<input type="number" id="cardNumber" name="cardNumber" pattern="[0-9]{16}">
        				</div>

                        <!-- Bank Name -->
        				<div class="formGroup">
        					<label for="bankName">Bank Name:</label>
        					<input type="text" id="bankName" name="bankName">
        				</div>

                        <!-- Expire Month -->
        				<div class="formGroup">
        					<label for="expireMonth">Expire Month:</label>
        					<input type="text" id="expireMonth" name="expireMonth">
        				</div>

                        <!-- Expire Year -->
        				<div class="formGroup">
        					<label for="expireYear">Expire Year:</label>
        					<input type="text" id="expireYear" name="expireYear">
        				</div>
                    </div>

    				<input type="submit" class="btn">

    			</form>
            <?php } ?>
            </div>
        </main>
    </div>

    <?php include("include/footer.php") ?>

    <script>
        $('#paymentType').on('change', function() {
            if (this.value == 'CC') {
                $('.paymentCardInfoSection').css('display', 'block');
                $("#cardNumber").prop('required',true);
                $("#bankName").prop('required',true);
                $("#expireMonth").prop('required',true);
                $("#expireYear").prop('required',true);
            }
            else {
                $('.paymentCardInfoSection').css('display', 'none');
                $("#cardNumber").prop('required',false);
                $("#bankName").prop('required',false);
                $("#expireMonth").prop('required',false);
                $("#expireYear").prop('required',false);
            }
        });
    </script>

</body>
</html>
