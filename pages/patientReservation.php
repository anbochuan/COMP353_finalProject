<?php include('include/sessionValidation.php') ?>

<!DOCTYPE html>
<!--
Author: BOCHUAN AN
Author ID: 27878745
-->
<html>
<head>
<title>Patient's Reservation - BSPC</title>
<?php include('include/DBConnection.php'); ?>
<?php include("include/styles.php") ?>
<!-- ***************
    Include references to styling (.css) files here!
**************** -->
<!--   <link rel = "stylesheet" type = "text/css" href = "viewReports.css">   -->
<link rel = "stylesheet" type = "text/css" href = "reportsDecorator.css">

</head>
<body id="top">

<?php include("include/header.php") ?>

<div class="wrapper row3">
	<main class="hoc container clear">

        <!-- ***************
            Page title and instructions!
        **************** -->
        <a href = "reports.php"> Back to View reports Page </a> <br/><br/><br/><br/>

		<div class="sectiontitle">
		      <h3 class="heading">Patient's Reservation Report</h3>
		          
		</div>

		<div class="pageContent">

            <!-- ***************
                Your content goes here!

                For example form: look at register-patient.php
            **************** -->
         
             <form action = "patientReservation.php"  method = "post">
             <div class = "formGroup">
                <p>The following report shows the reservation details about a patient whose Personal Health Number is
                    <?php 
                    if($_SESSION['userInfo']['userType'] == 'patient')
                    {
                        $phn = $_SESSION['userInfo']['phn'];

                        echo(" <input type = \"text\" name = \"PHN\" size = \"20\" maxlength = \"20\" value = \"$phn\" readonly = \"true\" /> ");
                    }
                    else
                    {
                        echo(" <input type = \"text\"  name = \"PHN\" size = \"20\" maxlength = \"20\" placeholder=\"PHN..\"/> ");
                    }
                    ?>
                    
                </p>
            </div>
            
                    <input type="submit" class = "btn" value="Submit" name = "submit"/>

            </form>

        <?php 
            if(isset($_POST['submit'] ))
            {
                $count = 0;
                $PHN = $_POST['PHN'];

                if(empty($PHN) )
                {
                    echo "<script type='text/javascript'>alert('Please enter your PHN before submission!')</script>";
                }
                else
                {

                $query1 = "SELECT PHN, Appointment_ID, Date_Time, FName, LName  FROM appointment INNER JOIN employee ON PHN = '$PHN' AND Doc_ID = Emp_ID "; // for doctor
                $query2 = "SELECT PHN, Appointment_ID, Date_Time, FName, LName  FROM appointment INNER JOIN employee ON PHN = '$PHN' AND Ther_ID = Emp_ID "; // for therapist
                // Get result
                $result1 = mysqli_query($conn, $query1); // run first query for doctor
                $result2 = mysqli_query($conn, $query2); // run second query for therapist

                // output data of each row

                    echo( "<br/><br/>");
$today = date("Y/m/d");
echo("  <div class=\"invoice-box\">
        <table cellpadding=\"0\" cellspacing=\"0\">
            <tr class=\"top\">
                <td colspan=\"7\">
                    <table>
                        <tr>
                            <td>
                                Patient's Reservation Report<br>
                                Created: $today <br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class=\"information\">
                <td colspan=\"7\">
                    <table>
                        <tr>
                            <td>
                                Bahamas Sports Physio Center<br>
                                1234 Beach Street<br>
                                Nassau, Bahamas 12345
                            </td>
                            
                            <td>
                                BCPS Corp.<br>
                                Bochuan An<br>
                                info@bspc.com
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
          
            <tr class=\"heading\">
                <td colspan=\"7\">
                    Patient's reservation details:  <br/>     
                </td>
            </tr>
            
            <tr class=\"heading\">
                <td>
                    Order
                </td>

                <td>
                    PHN
                </td>

                <td>
                    Appointment ID
                </td>

                <td>
                    Appointment Schedule
                </td>

                <td>
                    Position
                </td>

                <td>
                    First Name
                </td>

                <td>
                    Last Name
                </td>
            </tr> ");

            while($row = mysqli_fetch_assoc($result1) ) // for doctor
            {
       echo("<tr class=\"item\">

                <td>"
                    .++$count.
                "</td>
                
                <td>"
                    .$row['PHN'].
                "</td>

                <td>"
                    .$row['Appointment_ID'].
                "</td>

                <td>"
                    .$row['Date_Time'].
                "</td>

                <td>
                     Doctor
                </td>

                <td>"
                    .$row['FName'].
                "</td>

                <td>"
                    .$row['LName'].
                "</td>
            
             </tr>");
           }

           while($row = mysqli_fetch_assoc($result2) ) // for therapist
            {
       echo("<tr class=\"item\">

                
                <td>"
                    .++$count.
                "</td>
                
                <td>"
                    .$row['PHN'].
                "</td>

                <td>"
                    .$row['Appointment_ID'].
                "</td>

                <td>"
                    .$row['Date_Time'].
                "</td>

                <td>
                     Therapist
                </td>

                <td>"
                    .$row['FName'].
                "</td>

                <td>"
                    .$row['LName'].
                "</td>
            
             </tr>");
           }
            
            echo("<tr class=\"heading\">
                <td colspan=\"7\">
                    You have  $count appointments </br>
                </td>
            </tr>
        </table>
    </div>");

                } // end else


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