<?php include('include/sessionValidation.php') ?>

<!DOCTYPE html>
<!--

Author: BOCHUAN AN
Author ID: 27878745
-->
<html>
<head>
<title>Patient's Bill - BSPC</title>
<?php include('include/DBConnection.php'); ?>
<?php include("include/styles.php") ?>
<!-- ***************
    Include references to styling (.css) files here!
**************** -->
<!-- ***************<link rel = "stylesheet" type = "text/css" href = "viewReports.css">**************** Avoid conflict with the other css file -->
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
		      <h3 class="heading">Patient's Bill Report</h3>        
		</div>

		<div class="pageContent">

            <!-- ***************
                Your content goes here!

                For example form: look at register-patient.php
            **************** -->
         
             <form action = "bill.php"  method = "post">
             <div class = "formGroup">
                <p>The following report shows the bill details about a patient whose Prescription Number is
                    <input type = "text"  name = "PresNo" size = "20" maxlength = "20" placeholder="Prescription No.."/>
                </p>
            </div>
            
                    <input type="submit" class = "btn" value="Submit" name = "submit"/>

            </form>


            <?php
            if(isset($_POST['submit'] ))
            {
                if(!empty($_POST['PresNo']))
                {

                    $sum = 0; //use to calculate total price
                     $prescriptionId = $_POST['PresNo'];
                    //this query used to find patient information
                     $query1 = " SELECT PHN, FName, LName, DateOfBirth, Address, City, Zip_Code, Phone_No 
                            FROM patient WHERE PHN 
                            = (SELECT DISTINCT PHN FROM doctor_prescription WHERE Prescription_ID = $prescriptionId 
                                UNION
                                SELECT DISTINCT PHN FROM therapist_prescription WHERE Prescription_ID = $prescriptionId ) ";
                //this query used to find presctiption detail (medicine, equipment and treatment)
                $query2 = " SELECT Prescription_ID, 'equipment' AS TYPE, e.Equipment_Name AS PRESCRIPTION, Price AS PRICE, 1 AS QUANTITY 
                           FROM t_prescribe  JOIN equipment e 
                           ON t_prescribe.Prescription_ID = $prescriptionId AND t_prescribe.Equipment_Name = e.Equipment_Name 
                           UNION
                           SELECT Prescription_ID, 'treatment', t.Treatment_Name, Price, 1
                           FROM t_prescribe JOIN treatment t
                           ON t_prescribe.Prescription_ID = $prescriptionId AND t_prescribe.Treatment_Name = t.Treatment_Name
                           UNION
                           SELECT Prescription_ID, 'medicine', m.Medicine_Code, Price, d_prescribe.quantity
                           FROM d_prescribe JOIN medicine m
                           ON d_prescribe.Prescription_ID = $prescriptionId AND d_prescribe.Medicine_Code=m.Medicine_Code  " ;
                //this query used to find the date of the specific prescription 
                $query3 = " SELECT Date FROM prescription WHERE Prescription_ID = $prescriptionId";

                // Get result
                $result1 = mysqli_query($conn, $query1); // run first query
                $result2 = mysqli_query($conn, $query2); // run second query
                $result3 = mysqli_query($conn, $query3); // run third query

                // contain the patient information
                $row = mysqli_fetch_assoc($result1);
                    
                        echo "<br/><br/>";
                   
                // output data of each row
                   
                if( mysqli_num_rows($result2)==0){
                    echo("<div class=\"sectiontitle\"><p>Cannot find this Prescription ID, Please enter the Prescription number again!</p></div>");
                }
                else{
                echo("  <div class=\"invoice-box\">
                        <table cellpadding=\"0\" cellspacing=\"0\">
                            <tr class=\"top\">
                                <td colspan=\"4\">
                                    <table>
                                        <tr>
                                            <td>
                                                Prescription #: $prescriptionId<br>
                                                Date: ");
                                                 while($row3 = mysqli_fetch_assoc($result3))
                                                    {
                                                        echo($row3['Date']);
                                                    }
                                                echo("<br>
                                                    PHN: ".$row['PHN']."
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
                                                Address: <br>
                                               ".$row['Address']." <br>
                                                
                                                ". $row['City'] . " , ". $row['Zip_Code']. "
                                            </td>
                                            
                                            <td>
                                                Patient Information: <br>
                                                " .$row['FName']. " " .$row['LName']. "<br>
                                                 Date Of Birth: ". $row['DateOfBirth']."<br>
                                                Phone Number: ". $row['Phone_No']. "
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                
                            </tr>
                           
                            <tr class=\"heading\">
                                <td>
                                    Type
                                </td>
                                 <td>
                                    Prescription
                                </td>
                                <td>
                                    Price
                                </td>
                                
                                <td>
                                    Quantity
                                </td>
                            </tr>");

                             while($row = mysqli_fetch_assoc($result2) ) {
                                echo("<tr class=\"item\">
                                        <td> " .$row['TYPE']." </td>
                                        <td> " .$row['PRESCRIPTION']." </td>
                                        <td> " .$row['PRICE']." </td>
                                        <td> " .$row['QUANTITY']." </td>
                                        </tr>");
                                $sum += $row['PRICE']*$row['QUANTITY'];

                             }
                                    
                            echo("
                            <tr class=\"total\">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                   Total: $sum
                                </td>
                            </tr>
                        </table>
                    </div>"); 

                    }
                   
                }

                //if submit without enter value or enter 0, the alert will pop up
                else
                    echo "<script type='text/javascript'>alert('Prescription ID is empty!')</script>";  
                                    
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