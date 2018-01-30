<?php include('include/sessionValidation.php') ?>

<!DOCTYPE html>
<!--
Author: BOCHUAN AN
Author ID: 27878745
-->
<html>
<head>
<title>Current Therapist Information - BSPC</title>
<?php include('include/DBConnection.php'); ?>
<?php include("include/styles.php") ?>
<!-- ***************
    Include references to styling (.css) files here!
**************** -->
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
		  <h3 class="heading">Current Therapist Information Report</h3>
		  <p>The following report lists all the information for therapists who work at this center</p>
		</div>

		<div class="pageContent">

            <!-- ***************
                Your content goes here!

                For example form: look at register-patient.php
            **************** -->
           <?php 
            $count = 0;

            $query1 = " SELECT therapist.Emp_ID, FName, LName,Contact_No,Experience
                        FROM employee 
                        INNER JOIN therapist ON employee.Emp_ID = therapist.Emp_ID AND Dimission = 0 " ;

            $result1 = mysqli_query($conn, $query1); // run first query

             // output data of each row
            echo( "<br/> Therapists who work at this center are:  <br/><br/>");
          
            echo("<div class=\"invoice-box\">
                     <table cellpadding=\"0\" cellspacing=\"0\">
                        <tr class=\"top\">
                            <td colspan=\"4\">
                                <table>
                                    <tr>
                                        <td>
                                            <div class=\"sectiontitle\"><h3 class=\"heading\">BSPC Current Therapist Information</h3> </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                                
                        </tr>
                           
                        <tr class=\"heading\">
                            <td>
                                Employee ID
                             </td>
                             <td>
                                Name
                             </td>
                             <td>
                             Contact_No
                             </td>
                             <td>
                             Prior Experience
                             </td>
                                
                            </tr>");
                      
                             while($row = mysqli_fetch_assoc($result1) ) 
                            {
                                echo("<tr class=\"item\">
                                        <td> " .$row['Emp_ID']." </td>
                                        <td> " .$row['FName']."  " .$row['LName']." </td>
                                        <td> " .$row['Contact_No']." </td>
                                        <td> " .$row['Experience']." </td>
                                        </tr>");
                                 ++$count;
                                  
                            }
                                                
                            echo("</table> </div>"); 

            echo ("<br/> The total number of the Therapists who work at this center is: ". $count);

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