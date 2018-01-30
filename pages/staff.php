<?php include('include/sessionValidation.php') ?>

<?php

include('include/DBConnection.php');

$stmt = $conn->prepare("SELECT FName, LName, Emp_Type, Contact_No, Dimission FROM employee NATURAL JOIN emp_position ORDER BY Emp_Type, LName, FName;");

// Executes the statement
$stmt->execute();

// Gets the result
$queryResult = $stmt->get_result();

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
<title>Staff Details - BSPC</title>

<?php include("include/styles.php") ?>

</head>
<body id="top">

<?php include("include/header.php") ?>

<div class="wrapper row3">
	<main class="hoc container clear">
		<div class="sectiontitle">
		  <h3 class="heading">Staff Details</h3>
          <p>The following is all the staff information.</p>
		</div>

		<div class="pageContent">

            <table>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Position</th>
                    <th>Phone Number</th>
                    <th>Employee Status</th>
                </tr>
                <?php
                while ($employee = $queryResult->fetch_object()) {
                    echo "<tr>";
                    echo "<td>" . $employee->FName . "</td>";
                    echo "<td>" . $employee->LName . "</td>";
                    echo "<td>" . $employee->Emp_Type . "</td>";
                    echo "<td>" . "(" . substr($employee->Contact_No, 0, 3) .") " . substr($employee->Contact_No, 3, 3) ."-" . substr($employee->Contact_No, 6) . "</td>";
                    echo "<td>" . (($employee->Dimission == 0) ? 'Current' : 'Past')  . "</td>";
                    echo "</tr>";
                }

                ?>
            </table>
		</div>
	</main>
</div>

<?php include("include/footer.php") ?>

</body>
</html>
