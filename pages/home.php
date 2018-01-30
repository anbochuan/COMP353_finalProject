<?php include('include/sessionValidation.php') ?>

<?php

$userInfo = $_SESSION["userInfo"];

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
    <title>Home - BSPC</title>

    <?php include("include/styles.php") ?>

</head>
<body id="top">

    <?php include("include/header.php") ?>

    <div class="wrapper row3">
        <main class="hoc container clear">
            <div class="sectiontitle">
                <h3 class="heading">Welcome to the BSPC Management System</h3>
                <p>Please choose among the following options:</p>
            </div>

            <div class="pageContent">

                <?php if($userInfo['empType'] == 'Receptionist') { ?>
                    <!-- Receptionist's Action Panel -->
                    <div class="userActionPanel">
                        <!-- Patient Actions -->
                        <div class="actionSection">
                            <div class="sectiontitle">
                                <h4>Patient Actions</h4>
                            </div>
                            <ul class="nospace group center actionLine">
                                <li class="one_quarter first">
                                    <article><a href="patient-registration.php"><i class="icon btmspace-30 fa fa-user-plus"></i></a>
                                        <h6 class="heading">Register Patient</h6>
                                    </article>
                                </li>
                                <li class="one_quarter">
                                    <article><a href="patient-update.php"><i class="icon btmspace-30 fa fa-address-card-o"></i></a>
                                        <h6 class="heading">Update Patient Record</h6>
                                    </article>
                                </li>
                                <li class="one_quarter">
                                    <article><a href="patient-record-view.php"><i class="icon btmspace-30 fa fa-address-book-o"></i></a>
                                        <h6 class="heading">View Patient Record</h6>
                                    </article>
                                </li>
                                <li class="one_quarter">
                                    <article><a href="payment.php"><i class="icon btmspace-30 fa fa-credit-card"></i></a>
                                        <h6 class="heading">Receive Payment</h6>
                                    </article>
                                </li>
                            </ul>
                            <ul class="nospace group center actionLine">
                                <li class="one_quarter first">
                                    <article><a href="appointment-new.php"><i class="icon btmspace-30 fa fa-calendar"></i></a>
                                        <h6 class="heading">Make Appointment</h6>
                                    </article>
                                </li>
                                <li class="one_quarter">
                                    <article><a href="appointment-update.php"><i class="icon btmspace-30 fa fa-pencil-square-o"></i></a>
                                        <h6 class="heading">Update Appointment</h6>
                                    </article>
                                </li>
                            </ul>
                        </div>

                        <!-- Employee Actions -->
                        <div class="actionSection">
                            <div class="sectiontitle">
                                <h4>Employee Actions</h4>
                            </div>
                            <ul class="nospace group center actionLine">
                                <li class="one_quarter first">
                                    <article><a href="employee-registration.php"><i class="icon btmspace-30 fa fa-user-plus"></i></a>
                                        <h6 class="heading">Register Employee</h6>
                                    </article>
                                </li>
                                <li class="one_quarter">
                                    <article><a href="employee-update.php"><i class="icon btmspace-30 fa fa-address-card-o"></i></a>
                                        <h6 class="heading">Update Employee Record</h6>
                                    </article>
                                </li>
                                <li class="one_quarter">
                                    <article><a href="staff.php"><i class="icon btmspace-30 fa fa-users"></i></a>
                                        <h6 class="heading">View Staff Details</h6>
                                    </article>
                                </li>
                            </ul>
                        </div>

                        <!-- Other Actions -->
                        <div class="actionSection">
                            <div class="sectiontitle">
                                <h4>Other Actions</h4>
                            </div>
                            <ul class="nospace group center actionLine">
                                <li class="one_quarter first">
                                    <article><a href="reports.php"><i class="icon btmspace-30 fa fa-file-text-o"></i></a>
                                        <h6 class="heading">View Reports</h6>
                                    </article>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php } ?>

                <?php if(in_array($userInfo['empType'], ['Doctor', 'Nurse', 'Therapist'])) { ?>
                    <!-- Doctor/Nurse/Therapist's Action Panel -->
                    <div class="userActionPanel">
                        <!-- Patient Actions -->
                        <div class="actionSection">
                            <div class="sectiontitle">
                                <h4>Patient Actions</h4>
                            </div>
                            <ul class="nospace group center actionLine">
                                <li class="one_quarter first">
                                    <article><a href="patient-record-view.php"><i class="icon btmspace-30 fa fa-address-book-o"></i></a>
                                        <h6 class="heading">View Patient Record</h6>
                                    </article>
                                </li>
                                <li class="one_quarter">
                                    <article><a href="patient-update.php"><i class="icon btmspace-30 fa fa-address-card-o"></i></a>
                                        <h6 class="heading">Update Patient Record</h6>
                                    </article>
                                </li>
                                <?php if ($userInfo['empType'] != 'Nurse') { ?>
                                    <li class="one_quarter">
                                        <article><a href="prescription.php"><i class="icon btmspace-30 fa fa-file-text-o "></i></a>
                                            <h6 class="heading">Create Prescription</h6>
                                        </article>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>

                        <!-- Other Actions -->
                        <div class="actionSection">
                            <div class="sectiontitle">
                                <h4>Other Actions</h4>
                            </div>
                            <ul class="nospace group center actionLine">
                                <li class="one_quarter first">
                                    <article><a href="reports.php"><i class="icon btmspace-30 fa fa-file-text-o"></i></a>
                                        <h6 class="heading">View Reports</h6>
                                    </article>
                                </li>
                                <?php if ($userInfo['empType'] != 'Nurse') { ?>
                                    <li class="one_quarter">
                                        <article><a href="appointments-view.php"><i class="icon btmspace-30 fa fa-calendar"></i></a>
                                            <h6 class="heading">View Appointments</h6>
                                        </article>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>

                <?php if(!is_null($userInfo['phn'])) { ?>
                    <!-- Patient's Action Panel -->
                    <div class="userActionPanel">
                        <div class="actionSection">
                            <ul class="nospace group center actionLine">
                                <li class="one_quarter first">
                                    <article><a href="appointment-new.php"><i class="icon btmspace-30 fa fa-plus"></i></a>
                                        <h6 class="heading">Make Appointment</h6>
                                    </article>
                                </li>
                                <li class="one_quarter">
                                    <article><a href="patientReservation.php"><i class="icon btmspace-30 fa fa-calendar"></i></a>
                                        <h6 class="heading">View Appointments</h6>
                                    </article>
                                </li>
                                <li class="one_quarter">
                                    <article><a href="reports.php"><i class="icon btmspace-30 fa fa-file-text-o"></i></a>
                                        <h6 class="heading">View Reports</h6>
                                    </article>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php } ?>


            </div>
        </main>
    </div>

    <?php include("include/footer.php") ?>

</body>
</html>
