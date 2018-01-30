<?php include('include/sessionValidation.php') ?>

<!DOCTYPE html>
<!--
Author: BOCHUAN AN
Author ID: 27878745
-->
<html>
<head>
<title>Unused Equipments - BSPC</title>
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
		  <h3 class="heading">Unused Equipments Report</h3>
		  <p>The following report shows the Unused Equipments</p>
		</div>

		<div class="pageContent">

            <!-- ***************
                Your content goes here!

                For example form: look at register-patient.php
            **************** -->

            <?php 
            $count = 0;
            $query1 = " SELECT Equipment_Name AS Unused_Equipment 
                        FROM equipment 
                        WHERE Equipment_Name 
                        NOT IN (
                                SELECT Equipment_Name FROM t_prescribe)";

            $result1 = mysqli_query($conn, $query1); // run first query

            // output data of each row
            
        echo( "<br/>");
$today = date("Y/m/d");
echo("  <div class=\"invoice-box\">
        <table cellpadding=\"0\" cellspacing=\"0\">
            <tr class=\"top\">
                <td colspan=\"2\">
                    <table>
                        <tr>
                            <td>
                                Unused Equipments Report<br>
                                Created: $today <br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class=\"information\">
                <td colspan=\"2\">
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
                <td colspan=\"2\">
                    All the Unused Equipments are:  <br/>     
                </td>
            </tr>
            
            <tr class=\"heading\">
                <td>
                    Order
                </td>

                <td>
                    Equipment Name
                </td>
            </tr> ");

            while($row = mysqli_fetch_assoc($result1) ) 
            {
       echo("<tr class=\"item\">

                <td>"
                    .++$count.
                "</td>
                
                <td>"
                    .$row['Unused_Equipment'].
                "</td>
            
             </tr>");
           }
            
            echo("<tr class=\"heading\">
                <td colspan=\"2\">
                    The total number of the Unused Equipment is:  $count </br>
                </td>
            </tr>
        </table>
    </div>");
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