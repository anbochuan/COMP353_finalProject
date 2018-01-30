<?php include('include/sessionValidation.php') ?>

<!DOCTYPE html>
<!--
Author: BOCHUAN AN
Author ID: 27878745
-->
<html>
<head>
<title>Equipment Price - BSPC</title>
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
		      <h3 class="heading">Equipment Price Report</h3>
		          
		</div>

		<div class="pageContent">

            <!-- ***************
                Your content goes here!

                For example form: look at register-patient.php
            **************** -->
         
             <form action = "equipmentPrice.php"  method = "post">
             <div class = "formGroup">
                <p>The following report shows the differnet kinds of equipments that the prices between  
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

                if(empty($LowPrice) || empty($HighPrice))
                {
                    echo "<script type='text/javascript'>alert('Please specify the price range before your submission!')</script>";
                }
                else
                {
                    $query1 = " SELECT Equipment_Name, Price 
                            FROM equipment 
                            WHERE Price > '$LowPrice' AND Price < '$HighPrice' ";

                    $result1 = mysqli_query($conn, $query1); // run first query

                // output data of each row
                    echo( "<br/>");
                 
echo( "<br/><br/>");
$today = date("Y/m/d");
echo("  <div class=\"invoice-box\">
        <table cellpadding=\"0\" cellspacing=\"0\">
            <tr class=\"top\">
                <td colspan=\"3\">
                    <table>
                        <tr>
                            <td>
                                Equipment Price Report<br>
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
                    All available equipments which are under the given price range are:  <br/>     
                </td>
            </tr>
            
            <tr class=\"heading\">
                <td>
                    Order
                </td>

                <td>
                    Equipment Name
                </td>

                <td>
                    Equipment Price
                </td>
            </tr> ");

            while($row = mysqli_fetch_assoc($result1) ) 
            {
       echo("<tr class=\"item\">

                <td>"
                    .++$count.
                "</td>
                
                <td>"
                    .$row['Equipment_Name'].
                "</td>

                <td>"
                    .$row['Price'].
                "</td>
            
             </tr>");
           }
            
            echo("<tr class=\"heading\">
                <td colspan=\"3\">
                    There are $count different kinds of equipments that under the given price range. </br>
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