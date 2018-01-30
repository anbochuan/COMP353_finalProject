<?php include('include/sessionValidation.php') ?>

<!DOCTYPE html>
<!--
Author: BOCHUAN AN
Author ID: 27878745
-->
<html>
<head>
<title>Medication Price - BSPC</title>
<?php include('include/DBConnection.php'); ?>
<?php include("include/styles.php"); ?>
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
		      <h3 class="heading">Medication Price Report</h3>
		          
		</div>

		<div class="pageContent">

            <!-- ***************
                Your content goes here!

                For example form: look at register-patient.php
            **************** -->
         
             <form action = "medicationPrice.php"  method = "post">
             <div class = "formGroup">
                <p>The following report shows the differnet kinds of medicines that the prices between  
                    <input type = "text"  name = "Lprice" size = "20" maxlength = "20" placeholder="lowest price.."/> and 
                    <input type = "text"  name = "Hprice" size = "20" maxlength = "20" placeholder="highest price.."/></p>
            </div>
            
                    <input type="submit" class = "btn" value="Submit" name = "submit"/>

            </form>

            <?php 
            if (isset($_POST['submit']) )
            {
                $count = 0;
                $LowPrice = $_POST['Lprice'];
                $HighPrice = $_POST['Hprice'];

                if(empty($LowPrice) || empty($HighPrice) )
                {
                    echo "<script type='text/javascript'>alert('Please enter the price range before submission!')</script>";
                }
                else
                {

                    $query1 = " SELECT Medicine_Code, Price 
                             FROM medicine 
                             WHERE Price > '$LowPrice' AND Price < '$HighPrice' ";

                    $result1 = mysqli_query($conn, $query1); // run first query

                // output data of each row
             

                echo( "<br/><br/>");
$today = date("Y/m/d");
echo("  <div class=\"invoice-box\">
        <table cellpadding=\"0\" cellspacing=\"0\">
            <tr class=\"top\">
                <td colspan=\"3\">
                    <table>
                        <tr>
                            <td>
                                Medication Price Report<br>
                                Created: $today <br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class=\"information\">
                <td colspan=\"3\">
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
                <td colspan=\"3\">
                    All kinds of medicines that under the given price range:  <br/>     
                </td>
            </tr>
            
            <tr class=\"heading\">
                <td>
                    Order
                </td>

                <td>
                    Medicine Code
                </td>

                <td>
                    Medicine Price
                </td>
            </tr> ");

            while($row = mysqli_fetch_assoc($result1) ) 
            {
       echo("<tr class=\"item\">

                <td>"
                    .++$count.
                "</td>
                
                <td>"
                    .$row['Medicine_Code'].
                "</td>

                <td>"
                    .$row['Price'].
                "</td>
            
             </tr>");
           }
            
            echo("<tr class=\"heading\">
                <td colspan=\"3\">
                    There are  $count different kinds of medicines that under the given price range. </br>
                </td>
            </tr>
        </table>
    </div>");

                } // end the else

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