<?php include('include/sessionValidation.php') ?>

<?php

if ($_POST) {
    include('include/DBConnection.php');

    $firstName = ucwords($_POST['firstName']);
    $lastName = ucwords($_POST['lastName']);
    $phone = $_POST['phone'];
    $jobTitle = $_POST['jobTitle'];
    $yearsExperience = $_POST['yearsExperience'];
    $dimission = 0;
    $pass = bin2hex(openssl_random_pseudo_bytes(6));
    $hashedPass = password_hash($pass, PASSWORD_BCRYPT, ['cost' => 12]);


    $stmt = $conn->prepare("INSERT INTO employee(FName, LName, Contact_No, Password, Dimission) VALUES(?, ?, ?, ?, ?);");
    $stmt->bind_param("ssssi", $firstName, $lastName, $phone, $hashedPass, $dimission);

    // Executes the statement
    $stmt->execute();

    $empID = $conn->insert_id;

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

    // Executes the statement
    $stmt->execute();

    // Closes the statement
    $stmt->close();

    // Closes the connection to the DB
    $conn->close();

    // Account Credentials
    $message = 'Employee created successfully! \n\n' .
                'Emp_ID: ' .$empID .'\n' .
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
    <title>Employee Registration - BSPC</title>

    <?php include("include/styles.php") ?>

</head>
<body id="top">

    <?php include("include/header.php") ?>

    <div class="wrapper row3">
        <main class="hoc container clear">
            <div class="sectiontitle">
                <h3 class="heading">Employee Registration</h3>
                <p>To register a new employee, please fill out the form below.</p>
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

                    <!-- Phone Number -->
                    <div class="formGroup">
                        <label for="phone">Phone Number:</label>
                        <input type="text" name="phone" pattern="[0-9]{10}" maxlength="10">
                    </div>

                    <!-- Job Title -->
                    <div class="formGroup">
                        <label for="jobTitle">Job Title:</label>
                        <select id="jobTitle" name="jobTitle" required>
                            <option value="">Select an option</option>
                            <option value="Receptionist">Receptionist</option>
                            <option value="Nurse">Nurse</option>
                            <option value="Doctor">Doctor</option>
                            <option value="Therapist">Therapist</option>
                        </select>
                    </div>

                    <!-- Years of Experience -->
                    <div class="formGroup yearsExperienceDIV">
                        <label for="yearsExperience">Years of Experience:</label>
                        <input type="number" id="yearsExperience" name="yearsExperience" required>
                    </div>

                    <input type="submit" class="btn">
                </form>
            </div>
        </main>
    </div>

    <?php include("include/footer.php") ?>

    <script>
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
