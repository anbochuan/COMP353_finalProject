<?php
// Start the session
session_start();

include('../pages/include/DBConnection.php');

$validUser = false;
$id = '';
$pass = '';

if ($_POST['submittedForm'] == 'employee') {

    $userInfo['userType'] = "employee";
    $userInfo['empNum'] = $_POST['empNum'];

    $id = $_POST['empNum'];
    $pass = $_POST['pass'];

    $stmt = $conn->prepare("SELECT Password FROM employee WHERE Emp_ID = ?");
    $stmt->bind_param("i", $id);

    // Executes the statement
    $stmt->execute();

    // Gets the result
    $queryResult = $stmt->get_result();

    // Gets the number of rows
    $numOfrows = $queryResult->num_rows;

    if ($numOfrows > 0) {

        $record = $queryResult->fetch_assoc();

        if (password_verify($pass, $record['Password'])) {
            $validUser = true;

            $stmt = $conn->prepare("SELECT FName, LName, Emp_Type FROM employee NATURAL JOIN emp_position WHERE Emp_ID = ?");
            $stmt->bind_param("i", $id);

            // Executes the statement
            $stmt->execute();

            // Gets the result
            $queryResult = $stmt->get_result();

            $record = $queryResult->fetch_assoc();

            $userInfo['firstName'] = $record["FName"];
            $userInfo['lastName'] = $record["LName"];
            $userInfo['empType'] = $record["Emp_Type"];
        }
    }

    // Frees the result
    $stmt->free_result();

    // Closes the statement
    $stmt->close();

    // Closes the connection to the DB
    $conn->close();

    if (!$validUser) {
        $_SESSION["enteredCredentials"] = ["userType" => 'employee', 'empNum' => $_POST['empNum']];
    }
}
else {

    $userInfo['userType'] = "patient";
    $userInfo['phn'] = $_POST['phn'];
    $userInfo['empType'] = "";

    $id = $_POST['phn'];
    $pass = $_POST['pass'];

    $stmt = $conn->prepare("SELECT FName, LName, Password FROM patient WHERE PHN = ?");
    $stmt->bind_param("i", $id);

    // Executes the statement
    $stmt->execute();

    // Gets the result
    $queryResult = $stmt->get_result();

    // Gets the number of rows
    $numOfrows = $queryResult->num_rows;

    if ($numOfrows > 0) {

        $record = $queryResult->fetch_assoc();

        if (password_verify($pass, $record['Password'])) {
            $validUser = true;

            $userInfo['firstName'] = $record["FName"];
            $userInfo['lastName'] = $record["LName"];
        }
    }

    // Frees the result
    $stmt->free_result();

    // Closes the statement
    $stmt->close();

    // Closes the connection to the DB
    $conn->close();

    if (!$validUser) {
        $_SESSION["enteredCredentials"] = ["userType" => 'patient', 'phn' => $_POST['phn']];
    }
}

if ($validUser) {
    $_SESSION["userInfo"] = $userInfo;

    // Redirect to home page
    header("Location: ../pages/home.php");
    die();
}
else {
    // Redirect to login page
    header("Location: ../index.php");
    die();
}

?>
