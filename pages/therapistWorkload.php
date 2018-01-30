<?php include('include/sessionValidation.php') ?>

<!DOCTYPE html>
<!--
Author: BOCHUAN AN
Author ID: 27878745
-->
<html>
<head>
<title>Therapist Workload - BSPC</title>
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
		      <h3 class="heading">Therapist Workload Report</h3>
		          
		</div>

		<div class="pageContent">

            <!-- ***************
                Your content goes here!

                For example form: look at register-patient.php
            **************** -->
         <p>The following report lists How many patients has each Therapist seen in a specified period of time</p> 
             <form action = "therapistWorkload.php"  method = "post">

            Start from:
               
            <div class = "formGroup">
                    <label for="sday">Start Date:</label>
                    <input type="date" name="sday" id="sday">
                    
            </div>
            <div class = "formGroup">
                    <label for="stime">Start Time:</label>
                    <input type="time" name="stime" id="stime">
            </div>

                To:
            <div class = "formGroup">
                
                    <label for="eday">End Date:</label>
                    <input type="date" name="eday" id="eday">
                    
            </div>
            <div class = "formGroup">
                    <label for="etime">End Time:</label>
                    <input type="time" name="etime" id="etime">
            </div>
            
                    <input type="submit" class = "btn" value="Submit" name = "submit"/>

            </form>

        <?php 
            if(isset($_POST['submit'] ))
            {
                $sDate = $_POST['sday'];
                $sTime = $_POST['stime'];
                $eDate = $_POST['eday'];
                $eTime = $_POST['etime'];
                $sDate_Time = $sDate." ".$sTime;
                $eDate_Time = $eDate." ".$eTime;
                $count = 0;

                if(empty($sDate) || empty($sTime) || empty($eDate) || empty($eTime) )
                {
                    echo "<script type='text/javascript'>alert('Please fill the form completely before your submission!')</script>";
                }
                else
                {

                $query1 = " SELECT Emp_ID AS Therapist_ID, FName, LName, COUNT(t1.Appointment_ID) AS Patient_Number
                            FROM employee
                            INNER JOIN(
                            SELECT Appointment_ID, Ther_ID, appointment.Date_Time 
                            FROM appointment
                            WHERE Date_Time > '$sDate_Time' AND Date_Time < '$eDate_Time' ) AS t1
                            ON employee.Emp_ID = Ther_ID
                            GROUP BY Therapist_ID" ;

                $result1 = mysqli_query($conn, $query1); // run first query

                // output data of each row

echo( "<br/><br/>");
$today = date("Y/m/d");
echo("  <div class=\"invoice-box\">
        <table cellpadding=\"0\" cellspacing=\"0\">
            <tr class=\"top\">
                <td colspan=\"5\">
                    <table>
                        <tr>
                            <td>
                                Therapist Workload Report<br>
                                Created: $today <br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class=\"information\">
                <td colspan=\"5\">
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
                <td colspan=\"5\">
                    How many patients has each Therapist seen in a specified period of time:  <br/>     
                </td>
            </tr>
            
            <tr class=\"heading\">
                <td>
                    Order
                </td>

                <td>
                    Therapist ID
                </td>

                <td>
                    First Name
                </td>

                <td>
                    Last Name
                </td>

                <td>
                    Patient Number
                </td>
            </tr> ");

            while($row = mysqli_fetch_assoc($result1) ) 
            {
       echo("<tr class=\"item\">

                <td>"
                    .++$count.
                "</td>
                
                <td>"
                    .$row['Therapist_ID'].
                "</td>

                <td>"
                    .$row['FName'].
                "</td>

                <td>"
                    .$row['LName'].
                "</td>

                <td>"
                    .$row['Patient_Number'].
                "</td>
            
             </tr>");
           }
        echo("</table>
    </div>");
            }// end of else




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