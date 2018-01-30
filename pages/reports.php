<?php include('include/sessionValidation.php') ?>


<!DOCTYPE html>
<!--
Author: BOCHUAN AN
Author ID: 27878745
-->
<html>
<head>
<title>View Reports - BSPC</title>
<?php include('include/DBConnection.php'); ?>
<?php include("include/styles.php") ?> 
<!-- ***************
    Include references to styling (.css) files here!
**************** -->
<link rel = "stylesheet" type = "text/css" href = "viewReports.css">


</head>
<body id="top">

<?php include("include/header.php") ?>

<div class="wrapper row3">
	<main class="hoc container clear">

        <!-- ***************
            Page title and instructions!
        **************** -->
		<div class="sectiontitle">
		  <h3 class="heading">BSPC Reports</h3>
		  <p>The following reports categories are available for you.</p>
		</div>

		<div class="pageContent">

            <!-- ***************
                Your content goes here!

                For example form: look at register-patient.php
            **************** -->
            <?php  

            if($_SESSION['userInfo']['userType'] == 'employee')
            {
                if($_SESSION['userInfo']['empType'] == 'Doctor' || $_SESSION['userInfo']['empType'] == 'Nurse') // 2 = doctor, 3 = nurse
                {
                    $userType = $_SESSION['userInfo']['empType'];
                    echo("Welcome, now you are under the  ". $userType . " authority extent");

                    echo(" <table><tr><td>   <a class = \"body\" href = \"patientPrescription.php\" ><img class = \"body\" src = \"images/Prescription.png\" alt = \"image not found\"></a> <br/>
                    <h4> Patient's Medical History</h4> </td>");

                    echo(" <td>   <a class = \"body\" href = \"medicationPrice.php\" ><img class = \"body\" src = \"images/Medicine.png\" alt = \"image not found\"></a> <br/>
                    <h4> Medication Details</h4> </td></tr></table>");
                }
                else if($_SESSION['userInfo']['empType'] == 'Therapist')  // 4 = therapist
                {
                    $userType = $_SESSION['userInfo']['empType'];
                    echo("Welcome, now you are under the  ". $userType . " authority extent");

                    echo(" <table><tr><td>   <a class = \"body\" href = \"patientPrescription.php\" ><img class = \"body\" src = \"images/Prescription.png\" alt = \"image not found\"></a> <br/>
                    <h4> Patient's Medical History</h4> </td>");

                    echo(" <td>   <a class = \"body\" href = \"equipmentPrice.php\" ><img class = \"body\" src = \"images/Equipment.png\" alt = \"image not found\"></a> <br/>
                    <h4> Equipment Details</h4> </td>");

                    echo(" <td>   <a class = \"body\" href = \"treatmentDetails.php\" ><img class = \"body\" src = \"images/Treatment.png\" alt = \"image not found\"></a> <br/>
                    <h4> Treatment Details</h4> </td></tr>");

                    echo(" <tr><td>   <a class = \"body\" href = \"unusedEquipment.php\" ><img class = \"body\" src = \"images/Equipment.png\" alt = \"image not found\"></a> <br/>
                    <h4> Unused Equipment</h4> </td></tr></table>");

                }
                else if ($_SESSION['userInfo']['empType'] == 'Receptionist') // 1 = receptionist
                {
                    $userType = $_SESSION['userInfo']['empType'];
                    echo("Welcome, now you are under the  ". $userType . " authority extent");

                    echo(" <table><tr><td>   <a class = \"body\" href = \"patientInfo.php\" ><img class = \"body\" src = \"images/patientInfo.jpg\" alt = \"image not found\"></a> <br/>
                    <h4> Patient's Information</h4> </td>");

                    echo(" <td>   <a class = \"body\" href = \"availability.php\" ><img class = \"body\" src = \"images/DoctorAvailable.jpg\" alt = \"image not found\"></a> <br/>
                    <h4> Doctor/Therapist Availability</h4> </td>");

                    echo(" <td>   <a class = \"body\" href = \"unusedEquipment.php\" ><img class = \"body\" src = \"images/Equipment.png\" alt = \"image not found\"></a> <br/>
                    <h4> Unused Equipment</h4> </td>");

                    echo(" <td>   <a class = \"body\" href = \"bill.php\" ><img class = \"body\" src = \"images/Bill.png\" alt = \"image not found\"></a> <br/>
                    <h4> Bill</h4> </td></tr>");

                    echo(" <tr><td>   <a class = \"body\" href = \"pastTherapist.php\" ><img class = \"body\" src = \"images/PastTherapist.png\" alt = \"image not found\"></a> <br/>
                    <h4> Former Therapist Information</h4> </td>");

                    echo(" <td>   <a class = \"body\" href = \"currentTherapist.php\" ><img class = \"body\" src = \"images/CurrentTherapist.png\" alt = \"image not found\"></a> <br/>
                    <h4> Current Therapist Information</h4> </td>");

                    echo(" <td>   <a class = \"body\" href = \"therapistWorkload.php\" ><img class = \"body\" src = \"images/HowManyPatient.png\" alt = \"image not found\"></a> <br/>
                    <h4> Therapist's Workload</h4> </td>");

                    echo(" <td>   <a class = \"body\" href = \"patientReservation.php\" ><img class = \"body\" src = \"images/Appointment.png\" alt = \"image not found\"></a> <br/>
                    <h4> Patient's Reservation</h4> </td></tr></table>");
                }
            }
            else // user is a patient so only can see bill and reservation reports
            {
                $userType = $_SESSION['userInfo']['userType'];
                echo("Welcome, now you are under the  ". $userType . " authority extent");

                echo(" <table><tr><td>   <a class = \"body\" href = \"patientReservation.php\" ><img class = \"body\" src = \"images/Appointment.png\" alt = \"image not found\"></a> <br/>
                            <h4> Patient's Reservation</h4> </td>");

                echo(" <td>  <a class = \"body\" href = \"bill.php\" ><img class = \"body\" src = \"images/Bill.png\" alt = \"image not found\"></a> <br/>
                            <h4> Bill</h4> </td></tr></table> ");
            }


            ?>
          


		</div>
	</main>
</div>

<?php include("include/footer.php") ?>

<!-- ***************
    Include references to javascript (.js) files here!
**************** -->

</body>
</html>
