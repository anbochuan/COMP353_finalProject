<?php include('include/sessionValidation.php') ?>

<!DOCTYPE html>
<!--
Author: BOCHUAN AN
Author ID: 27878745
-->
<html>
<head>
<title>Patient's Medical History - BSPC</title>
<?php include('include/DBConnection.php'); ?>
<?php include("include/styles.php") ?>
<!-- ***************
    Include references to styling (.css) files here!
**************** -->
<!--<link rel = "stylesheet" type = "text/css" href = "viewReports.css">-->

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
		      <h3 class="heading">Patient's Medical History Report</h3>
		          
		</div>

		<div class="pageContent">

            <!-- ***************
                Your content goes here!

                For example form: look at register-patient.php
            **************** -->
         
             <form action = "patientPrescription.php"  method = "post">
             <div class = "formGroup">
                <p>The following report shows all the personal medical history about a patient whose Personal Health Number is
                    <input type = "text"  name = "PHN" size = "20" maxlength = "20" placeholder="PHN.."/>
                </p>
            </div>
            
                    <input type="submit" class = "btn" value="Submit" name = "submit"/>

            </form>

        <?php  
            if(isset($_POST['submit']) )
            {
                if(empty($_POST['PHN'])){
                     echo "<script type='text/javascript'>alert('PHN cannot be empty!')</script>";
                }
                else{
                     $count = 0;
                     $phn = $_POST['PHN'];

                      //this query used to find patient information
                     $query = " SELECT FName, LName, DateOfBirth 
                            FROM patient WHERE PHN = $phn ";
                     // query to find all prescription on this patient show the diagnose and doctor notes
                     $query1 = " SELECT T1.Prescription_ID, Content, Diagnose, Date
                                FROM prescription
                                INNER JOIN 
                                ((SELECT therapist_prescription.Prescription_ID, 'T_Notes' AS Category, Therapist_Note AS Content FROM therapist_prescription WHERE therapist_prescription.PHN = $phn )
                                UNION 
                                 (SELECT doctor_prescription.Prescription_ID, 'D_Notes', Doctor_Note FROM doctor_prescription WHERE doctor_prescription.PHN = $phn ) )AS T1
                                ON T1.Prescription_ID = prescription.Prescription_ID" ;

                     $result = mysqli_query($conn, $query);
                     $result1 = mysqli_query($conn, $query1); // run second query
                     if( mysqli_num_rows($result)==0){
                        echo("<div class=\"sectiontitle\"><p>Cannot find this Patient, Please enter the correct PHN.</p></div>");
                     }
                     else if( mysqli_num_rows($result1)==0){
                        echo("<div class=\"sectiontitle\"><p>Cannot find any the Medical History of This Patient</p></div>");
                     }
                     else{
                         // output data of each row
                        echo( "<br/><br/>");
                       
                        $patient = mysqli_fetch_assoc($result);
                        echo("  <div class=\"invoice-box\">
                        <table cellpadding=\"0\" cellspacing=\"0\">
                            <tr class=\"top\">
                                <td colspan=\"4\">
                                    <table>
                                        <tr>
                                            <td>
                                                PHN #: $phn<br>
                                                Patient Name: " .$patient['FName']. " " .$patient['LName']. "<br>
                                                Date Of Birth: " .$patient['DateOfBirth']. "<br>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                
                            </tr>
                            <tr class=\"heading\">
                                <td colspan=\"4\">
                                Medical History
                                </td>
                            <tr>
                           
                            <tr class=\"heading\">
                                <td>
                                    Prescription ID
                                </td>
                                 <td>
                                    Content
                                </td>
                                <td>
                                    Diagnose
                                </td>
                                
                                <td>
                                    Date
                                </td>
                            </tr>");

                             while($row = mysqli_fetch_assoc($result1)) {
                                echo("<tr class=\"item\">
                                        <td> " .$row['Prescription_ID']." </td>
                                        <td> " .$row['Content']." </td>
                                        <td> " .$row['Diagnose']." </td>
                                        <td> " .$row['Date']." </td>
                                        </tr>");
                                ++$count;

                             }
                                    
                            echo("</table> </div>"); 
                         echo ("<br/> The total number of the personal medical history is: ". $count);


                     }

               
                }
               

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