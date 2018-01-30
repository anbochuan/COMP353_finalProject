
<?php include('include/sessionValidation.php') ?>

<!DOCTYPE html>
<!--

Author: BOCHUAN AN
Author ID: 27878745

-->
<html>
<head>
<title>Doctor/Therapist Availability - BSPC</title>
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
		      <h3 class="heading">Doctor/Therapist Availability Report</h3>
		          
		</div>

		<div class="pageContent">

            <!-- ***************
                Your content goes here!

                For example form: look at register-patient.php
            **************** -->
         




         <p>The following report lists availability for physio therapist/doctor during a specified period of time</p> 
             <form action = "availability.php"  method = "post">
           
               <div class = "formGroup">
                 <label>Position:</label>
                 <select name = "position" id = "position">
                 <option value = "no"> </option>
                 <option value = "Doctor"> Doctor </option>
                 <option value = "Therapist"> Therapist </option>
                 </select>
            </div> 

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
                $count = 0;
                $position = $_POST['position'];
                $sDate = $_POST['sday'];
                $sTime = $_POST['stime'];
                $eDate = $_POST['eday'];
                $eTime = $_POST['etime'];
                $sDate_Time = $sDate." ".$sTime;
                $eDate_Time = $eDate." ".$eTime;

                if($position == 'Doctor') 
                {
                    $query1 = " SELECT Fname, LName, t2.available 
                            FROM employee JOIN (
                                                SELECT Emp_ID, t1.Date_Time as available FROM appointment 
                                                        RIGHT JOIN (SELECT Emp_ID, Date_Time FROM doctor, schedule WHERE Date_Time BETWEEN '$sDate_Time' AND '$eDate_Time') AS t1 
                                                        ON appointment.Doc_ID = t1.Emp_ID AND appointment.Date_Time = t1.Date_Time WHERE appointment.Doc_ID IS NULL) AS t2 
                                          ON employee.Emp_ID = t2.Emp_ID AND employee.Dimission <> 1 ORDER BY FName";

                    $result = mysqli_query($conn, $query1); // run first query

                    // output data of each row
                   
                }
                if($position == 'Therapist')
                {
                    $query2 = " SELECT Fname, LName, t2.available 
                            FROM employee JOIN (
                                                SELECT Emp_ID, t1.Date_Time as available FROM appointment 
                                                        RIGHT JOIN (SELECT Emp_ID, Date_Time FROM therapist, schedule WHERE Date_Time BETWEEN '$sDate_Time' AND '$eDate_Time') AS t1 
                                                        ON appointment.Ther_ID = t1.Emp_ID AND appointment.Date_Time = t1.Date_Time WHERE appointment.Ther_ID IS NULL) AS t2 
                                          ON employee.Emp_ID = t2.Emp_ID AND employee.Dimission <> 1 ORDER BY FName";

                    $result = mysqli_query($conn, $query2); // run first query

                    // output data of each row
                 
                }
               
echo( "<br/><br/>");
$today = date("Y/m/d");
echo("  <div class=\"invoice-box\">
        <table cellpadding=\"0\" cellspacing=\"0\">
            <tr class=\"top\">
                <td colspan=\"4\">
                    <table>
                        <tr>
                            <td>
                                $position Availability Report<br>
                                Created: $today <br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class=\"information\">
                <td colspan=\"4\">
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
                <td colspan=\"4\">
                    All available therapists who are under the given schedule range are:  <br/>     
                </td>
            </tr>
            
            <tr class=\"heading\">
                <td>
                    Order
                </td>

                <td>
                    First Name
                </td>

                <td>
                    Last Name
                </td>

                <td>
                    Available Time
                </td>
            </tr> ");

            while($row = mysqli_fetch_assoc($result) ) 
            {
       echo("<tr class=\"item\">

                <td>"
                    .++$count.
                "</td>
                
                <td>"
                    .$row['Fname'].
                "</td>

                <td>"
                    .$row['LName'].
                "</td>

                <td>"
                    .$row['available'].
                "</td>
            
             </tr>");
           }
            
            echo("<tr class=\"heading\">
                <td colspan=\"4\">
                    The total number of the Available time slots is:  $count </br>
                </td>
            </tr>
        </table>
    </div>");

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