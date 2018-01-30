<?php include('include/sessionValidation.php') ?>

<?php

if ($_POST['formCompleted'] == 'initial') {
    include('include/DBConnection.php');

    $empID = $_POST['empID'];

    $stmt = $conn->prepare("SELECT FName, LName, Contact_No, Dimission, Emp_Type FROM employee NATURAL JOIN emp_position WHERE Emp_ID = ?;");
    $stmt->bind_param("i", $empID);

    // Executes the statement
    $stmt->execute();

    // Gets the result
    $queryResult = $stmt->get_result();

    // Gets the number of rows
    $numOfrows = $queryResult->num_rows;

    if ($numOfrows > 0) {
        $employeeInfo = $queryResult->fetch_object();

        if ($employeeInfo->Emp_Type == 'Doctor') {

            $stmt = $conn->prepare("SELECT Experience FROM doctor WHERE Emp_ID = ?;");
            $stmt->bind_param("i", $empID);

            // Executes the statement
            $stmt->execute();

            // Gets the result
            $queryResult = $stmt->get_result();

            // Gets the number of rows
            $numOfrows = $queryResult->num_rows;

            if ($numOfrows > 0) {
                $employeeExperience = $queryResult->fetch_object();
            }

        }

        if ($employeeInfo->Emp_Type == 'Therapist') {

            $stmt = $conn->prepare("SELECT Experience FROM therapist WHERE Emp_ID = ?;");
            $stmt->bind_param("i", $empID);

            // Executes the statement
            $stmt->execute();

            // Gets the result
            $queryResult = $stmt->get_result();

            // Gets the number of rows
            $numOfrows = $queryResult->num_rows;

            if ($numOfrows > 0) {
                $employeeExperience = $queryResult->fetch_object();
            }

        }
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

    $empID = $_POST['empID'];
    $firstName = ucwords($_POST['firstName']);
    $lastName = ucwords($_POST['lastName']);
    $phone = $_POST['phone'];
    $prevJobTitle = $_POST['prevJobTitle'];
    $jobTitle = $_POST['jobTitle'];
    $yearsExperience = $_POST['yearsExperience'];

    $stmt = $conn->prepare("UPDATE employee SET FName = ?, LName = ?, Contact_No = ? WHERE Emp_ID = ?;");
    $stmt->bind_param("sssi", $firstName, $lastName, $phone, $empID);

    // Executes the statement
    $stmt->execute();

    if ($prevJobTitle == $jobTitle) {
        if ($jobTitle == 'Doctor' || $jobTitle == 'Therapist') {
            $tableName = strtolower($jobTitle);
            $stmt = $conn->prepare("UPDATE $tableName SET Experience = ? WHERE Emp_ID = ?;");
            $stmt->bind_param("ii", $yearsExperience, $empID);

            // Executes the statement
            $stmt->execute();
        }
    }
    else {
        $prevTableName = strtolower($prevJobTitle);
        $tableName = strtolower($jobTitle);

        // Delete old emp position
        $stmt = $conn->prepare("DELETE FROM $prevTableName WHERE Emp_ID = ?;");
        $stmt->bind_param("i", $empID);

        // Executes the statement
        $stmt->execute();


        if ($jobTitle == 'Doctor' || $jobTitle == 'Therapist') {
            // Insert new emp position
            $stmt = $conn->prepare("INSERT INTO $tableName (Emp_ID, Experience) VALUES (?, ?);");
            $stmt->bind_param("ii", $empID, $yearsExperience);

            // Executes the statement
            $stmt->execute();
        }
        else {
            // Insert new emp position
            $stmt = $conn->prepare("INSERT INTO $tableName (Emp_ID) VALUES (?);");
            $stmt->bind_param("i", $empID);

            // Executes the statement
            $stmt->execute();
        }
    }


    if ($jobTitle == 'Doctor') {

        $stmt = $conn->prepare("INSERT INTO doctor(Emp_ID, Experience) VALUES(?, ?);");
        $stmt->bind_param("ii", $empID, $yearsExperience);
    }
    else if ($jobTitle == 'Nurse') {

        $stmt = $conn->prepare("INSERT INTO nurse(Emp_ID) VALUES(?);");
        $stmt->bind_param("i", $empID);
    }
    else if ($jobTitle == 'Therapist') {

        $stmt = $conn->prepare("INSERT INTO therapist(Emp_ID, Experience) VALUES(?, ?);");
        $stmt->bind_param("ii", $empID, $yearsExperience);
    }
    else {
        $stmt = $conn->prepare("INSERT INTO receptionist(Emp_ID) VALUES(?);");
        $stmt->bind_param("i", $empID);
    }

    // Closes the statement
    $stmt->close();

    // Closes the connection to the DB
    $conn->close();

    // Succesful Message
    $message = 'Employee updated successfully!';
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
<title>Employee Update - BSPC</title>

<?php include("include/styles.php") ?>

</head>
<body id="top">

<?php include("include/header.php") ?>

<div class="wrapper row3">
	<main class="hoc container clear">
		<div class="sectiontitle">
		  <h3 class="heading">Employee Update</h3>
		  <p>To update an employee's information, please fill out the form below.</p>
		</div>

		<div class="pageContent">

            <?php if (empty($_POST['formCompleted']) || $_POST['formCompleted'] != 'initial') { ?>
                <form method="POST" action = "#">

                    <input type="hidden" name="formCompleted" value="initial">
                    <div class="formGroup">
                        <label for="empID">Employee Number:</label>
                        <input type="number" name="empID">
                    </div>

                    <input type="submit" class="btn">

                </form>
            <?php } ?>

            <?php if ($_POST['formCompleted'] == 'initial') { ?>
    			<form method="post" action = "#">
                    <input type="hidden" name="formCompleted" value="updatedInformation">
                    <input type="hidden" name="empID" value="<?= $_POST['empID']; ?>">
                    <input type="hidden" name="prevJobTitle" value="<?= $employeeInfo->Emp_Type ?>">
                    <!-- First Name -->
                    <div class="formGroup">
                        <label for="firstName">First Name:</label>
                        <input type="text" name="firstName" value="<?= $employeeInfo->FName ?>" required>
                    </div>

                    <!-- Last Name -->
                    <div class="formGroup">
                        <label for="lastName">Last Name:</label>
                        <input type="text" name="lastName" value="<?= $employeeInfo->LName ?>" required>
                    </div>

                    <!-- Phone Number -->
                    <div class="formGroup">
                        <label for="phone">Phone Number:</label>
                        <input type="text" name="phone" value="<?= $employeeInfo->Contact_No ?>" pattern="[0-9]{10}" maxlength="10">
                    </div>

                    <!-- Job Title -->
                    <div class="formGroup">
                        <label for="jobTitle">Job Title:</label>
                        <select id="jobTitle" name="jobTitle" required>
                            <option value="">Select an option</option>
                            <option value="Receptionist" <?= $employeeInfo->Emp_Type == 'Receptionist' ? ' selected="selected"' : ''; ?>>Receptionist</option>
                            <option value="Nurse" <?= $employeeInfo->Emp_Type == 'Nurse' ? ' selected="selected"' : ''; ?>>Nurse</option>
                            <option value="Doctor" <?= $employeeInfo->Emp_Type == 'Doctor' ? ' selected="selected"' : ''; ?>>Doctor</option>
                            <option value="Therapist" <?= $employeeInfo->Emp_Type == 'Therapist' ? ' selected="selected"' : ''; ?>>Therapist</option>
                        </select>
                    </div>

                    <!-- Years of Experience -->
                    <div class="formGroup yearsExperienceDIV">
                        <label for="yearsExperience">Years of Experience:</label>
                        <input type="number" id="yearsExperience" name="yearsExperience" value="<?= $employeeExperience->Experience ?>" required>
                    </div>

    				<input type="submit" class="btn">

    			</form>
            <?php } ?>
		</div>
	</main>
</div>

    <?php include("include/footer.php") ?>

    <script>
    $(function () {
        $("#jobTitle").change();
    });
    $('#jobTitle').on('change', function() {
        if (this.value == 'Doctor') {
            $("#yearsExperience").attr({"min" : 6});
            $("#yearsExperience").prop('required',true);
            $(".yearsExperienceDIV").css('display', 'flex');
        }
        else if (this.value == 'Therapist') {
            $("#yearsExperience").attr({"min" : 2});
            $("#yearsExperience").prop('required',true);
            $(".yearsExperienceDIV").css('display', 'flex');
        }
        else {
            $("#yearsExperience").removeProp("min");
            $("#yearsExperience").prop('required',false);
            $(".yearsExperienceDIV").css('display', 'none');
        }
    });
    </script>

</body>
</html>
