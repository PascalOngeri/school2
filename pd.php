<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
include('dbconnection.php');
if (strlen($_SESSION['sturecmsaid']==0)) {
  header('location:logout.php');
  } else{
   
     if(isset($_POST['update']))
  {
    $adm = $_POST['adm'];
  $username = $_POST['username'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];
       
        

 
 $sql = "UPDATE registration SET username = ?, password = ?,phone=? WHERE adm = ?";
    $stmt = $con->prepare($sql);

    // Bind parameters to the prepared statement
     $stmt->bind_param("ssss",$username ,$password, $phone,  $adm);

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Data updated successfully
        echo '<div class="popup" style="background-color: yellow; font-size: 24px; border-radius: 20px;">&#10003; Data updated successfully.</div>';
         echo '<script>hideLoader();</script>';
         echo "<script>window.location.href ='pd.php'</script>";
} else {
    // Error occurred
        echo '<div class="popup error-popup" style="background-color: red; font-size: 24px; border-radius: 20px;">Error updating data: ' . $stmt->error . '</div>';
 echo '<script>hideLoader();</script>';
          echo "<script>window.location.href ='pd.php'</script>";

}

    // Close the statement and connection
  
}
    if (isset($_POST['generate'])) {
    // Set the content type as a downloadable PDF file
    header('Content-Type: application/pdf');
    // Set the file name
    header('Content-Disposition: attachment; filename="course_details.pdf"');

    // Include the necessary files for creating a PDF
    require('fpdf/fpdf.php');

    // Create a new PDF document
    $pdf = new FPDF();
    $pdf->AddPage();

    // Set the font and font size for the document
    $pdf->SetFont('Arial', 'B', 14);

    // Add the logo to the document
    $pdf->Image('assets/images/logo.png', $pdf->GetPageWidth()/2 - 25, 10, 50, 0, 'PNG');
  $adm = $_SESSION['adm'];
    // Write the title of the document
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 50, '', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Elfema Academy primary school', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Admission number  '.$adm.' FEE STATEMENT', 0, 1, 'C');

    // Set the font and font size for the table headers
    $pdf->SetFont('Arial', 'B', 12);

    // Write the headers of the table
    $pdf->Cell(40, 10, 'Payment no.', 1);
    $pdf->Cell(38, 10, 'Date', 1);
    $pdf->Cell(38, 10, 'Amount', 1);
    $pdf->Cell(38, 10, 'Balance', 1);
     $pdf->Cell(38, 10, 'Status', 1);
     $pdf->Ln();

 
    // Query to get the school details
    $sql = "SELECT * FROM payment   Where adm='$adm' order by id asc desc";
    $result = mysqli_query($con, $sql);

    // Set the font and font size for the table rows
    $pdf->SetFont('Arial', '', 10);

    // Loop through the results and write them to the table
    if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
          $pdf->Cell(40, 10, $row['id'], 1);
        $pdf->Cell(38, 10, $row['date'], 1);
        $pdf->Cell(38, 10, $row['amount'], 1);
        $pdf->Cell(38, 10, $row['bal'], 1);
          $pdf->Cell(39, 10, 'received', 1);
        $pdf->Ln();
    }
    }

    // Close the database connection and output the PDF
    mysqli_close($con);
    $pdf->Output('D', 'my statement.pdf');

        // header('location: ./reports.php');
}
 
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>  <?php echo strtoupper("Welcome"." ".htmlentities($_SESSION['username']));?> </title>
    <style>
        /* CSS for loader */
        .loader {
            border: 16px solid #f3f3f3; /* Light grey */
            border-top: 16px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 1.5s linear infinite;
            margin: auto;
            margin-top: 20%;
            display: none; /* Initially hidden */
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Basic styling */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: green;
            overflow: hidden;
        }
        .navbar .list {
            margin: 0;
            padding: 0;
            list-style-type: none;
            overflow: hidden;
        }
        .navbar .list li {
            float: left;
        }
        .navbar .list li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .navbar .list li a:hover {
            background-color: #ddd;
            color: black;
        }
        /* Responsive styling */
        @media screen and (max-width: 600px) {
            .navbar .list {
                float: none;
                overflow: hidden;
            }
            .navbar .list li {
                float: none;
                width: 100%;
            }
        }
    </style>

    <script>
        var sessionTimeout = 600; // Session timeout in seconds (10 minutes)

        function redirectToLogout() {
            window.location.href = 'logout.php'; // Change 'logout.php' to your logout page
        }

        function startSessionTimer() {
            var timer = setTimeout(redirectToLogout, sessionTimeout * 1000);

            window.addEventListener('mousemove', function() {
                clearTimeout(timer);
                timer = setTimeout(redirectToLogout, sessionTimeout * 1000);
            });
            window.addEventListener('keypress', function() {
                clearTimeout(timer);
                timer = setTimeout(redirectToLogout, sessionTimeout * 1000);
            });
        }

        window.onload = function() {
            startSessionTimer();
        };

        function showLoader() {
            document.getElementById("loader").style.display = "block";
        }

        function hideLoader() {
            document.getElementById("loader").style.display = "none";
        }
    </script>
</head>
<body>
    <nav class="navbar navbar-inverse" style="position:sticky;top:0;z-index:99999 ">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><h3 style="color:greenyellow;">Infinityschools Analytics<h3></a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="https://www.infinitytechafrica.com" style="color: white"  onclick="showLoader();"><i class="fas fa-globe"></i> Visit Website</a></li>
                   
                    <li><a href="#"style="color: white"  onclick="showLoader();"><i class="fa fa-file-pdf"></i> Download fee structure</a></li>
                    
                  <!-- 
<li><a href="contact.php" style="color: white" onclick="showLoader();"><i class="https://www.infinitytechafrica.com"></i> Contact Us</a></li>
-->

                    
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#" style="color: white" data-toggle="modal" data-target="#updateModal"  onclick="showLoader();" ><i class="fa fa-user"></i> Settings</a></li>
                    <li><a href="logout.php" style="color: white"  onclick="showLoader();"><i class="fa fa-sign-out-alt" ></i> Log out</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="loader" id="loader"></div>
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="settings-form" method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
                        <div class="form-group">
                            <?php
         $aid= $_SESSION['sturecmsaid'];
$sql="SELECT * from registration where id=:aid";

$query = $dbh -> prepare($sql);
$query->bindParam(':aid',$aid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?> <input type="hidden" class="input3" name="adm" value="<?php echo htmlspecialchars($_SESSION["adm"]); ?>">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" value=<?php echo htmlentities($row->username); ?>>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="text" class="form-control" id="password" name="password" value=<?php echo htmlentities($row->password); ?>>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number:</label>
                            <input type="text" class="form-control" id="phone" name="phone" value= <?php echo htmlentities($row->phone); ?>>
                        </div>
                        <button type="submit" class="btn btn-primary"  name="update"onclick="showLoader();">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="section">
        <center>
            <h3 class="text" style="text-align:center;">Welcome <?php echo htmlentities($row->username); ?></h3>
            <label>Student Admission number <?php echo htmlentities($row->adm); ?></label>
            <br><br>
             <label>Your fee balance is <?php echo htmlentities($row->fee); ?></label>

        </center>
        <br><br><hr><br>
        <div class="row">
            <?php $cnt=$cnt+1;}} ?>
            <div class="col-md-6">
                <div class="content">
                     <center>
                        <h3>PAY FEE</h3>
                        <form method="post" action="p.php">
                            <div class="lbox1">    
                                <input type="hidden" class="input3" name="adm" value="<?php echo htmlspecialchars($_SESSION["adm"]); ?>"><br>
                            </div>
                           
                          
                             <div class="lbox1">    
                                <input style="
                                 border-radius: 20px;height:40px;"  class="input3" name="ammount" placeholder="enter amount"><br>
                            </div>
                           <br>
                             <button type="submit" class="btn" name="pay" style="background-color: green; color:white;border-radius: 20px;height:40px;" onclick="showLoader(); showMesage()">PAY</button>
                            
                        </form>
                    </center><br>
                    <center>
                        <h3>Click to download</h3>
                        <form method="post" action="p.php">
                            <div class="lbox1">    
                                <input type="hidden" class="input3" name="adm" value="<?php echo htmlspecialchars($_SESSION["adm"]); ?>"><br>
                            </div>
                            <button type="submit" class="btn" name="generate" style="background-color: lightblue; border-radius: 20px;height:40px;" onclick="showLoader(); showMessage()">Download Fee Statement!!!!!</button>
                             <button type="submit" class="btn" name="generate" style="background-color: lightblue; border-radius: 20px;height:40px;" onclick="showLoader(); showMessage()">My Fee Structure</button>
                            
                        </form>
                    </center>
                </div>
            </div>
            <div class="col-md-6">
                <div class="right-pdf">
                    <br><br>
                     <h3>Public Notice</h3>
                    <table class="table table-striped">
                       <thead>
                          <tr>
                            <th class="font-weight-bold">S.No</th>
                            <th class="font-weight-bold">Notice Title</th>
                            <th class="font-weight-bold">Notice Date</th>
                            <th class="font-weight-bold">Description</th>
                            
                          </tr>
                        </thead>
                         <tbody>
                           <?php
                            if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        // Formula for pagination
        $no_of_records_per_page =15;
        $offset = ($pageno-1) * $no_of_records_per_page;
       $ret = "SELECT ID FROM tblpublicnotice";
$query1 = $dbh -> prepare($ret);
$query1->execute();
$results1=$query1->fetchAll(PDO::FETCH_OBJ);
$total_rows=$query1->rowCount();
$total_pages = ceil($total_rows / $no_of_records_per_page);
$sql="SELECT * from tblpublicnotice";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>   
                          <tr>
                           
                            <td><?php echo htmlentities($cnt);?></td>
                            <td><?php  echo htmlentities($row->NoticeTitle);?></td>
                            <td><?php  echo htmlentities($row->CreationDate);?></td>
                                                       <td><?php  echo htmlentities($row->NoticeMessage);?></td>
 
                          </tr><?php $cnt=$cnt+1;}} ?>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <h3>Payment History</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Receipt no.</th>
                                                <th>RegNo</th>
                                                <th>Date</th>
                                                <th>Amount Received</th>
                                                <th>Balance</th>
                                               
                                                <th>Status</th>
                            </tr>
                        </thead>
                         <tbody>
                                            <?php 
                                           $user_id = $_SESSION['adm'];

  
                                            $query = mysqli_query($con, "SELECT * FROM payment where adm=$user_id order by id desc");
                                            $sn = 1;
                                            while ($res = mysqli_fetch_array($query)) {
                                            ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo htmlentities(strtoupper($res['id'])); ?></td>
                                                <td><?php echo htmlentities(strtoupper($res['adm'])); ?></td>
                                                <td><?php echo htmlentities(strtoupper($res['date'] )); ?></td>
                                                <td><?php echo htmlentities(strtoupper($res['amount'])); ?></td>
                                                <td><?php echo htmlentities($res['bal']); ?></td>
                                               
                                                <td width="100">
                                                   
                                                    &nbsp;&nbsp;
                                                    <a href="
                                                    " class="btn btn-primary btn-xs" style="background-color: green" >Received</a>
                                                </td>
                                            </tr>
                                            <?php 
                                                $sn++;
                                           } 

                                       

                                            ?>    
                                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<br><br>
    <?php include_once('includes/footer.php');?>

    <style>
        /* Styling for the pop-up message */
        .popup {
            display: none;
            position: fixed;
            left: 0;
            top: 50%;
            width: 100%;
            text-align: center;
            z-index: 9999;
        }
        .popup-content {
            display: inline-block;
            padding: 20px;
            background-color: lightgreen;
            border-radius: 5px;
            animation: slideIn 0.5s forwards;
        }
        @keyframes slideIn {
            from { left: -100%; opacity: 0; }
            to { left: 0; opacity: 1; }
        }
    </style>

    <script>
        function showMessage() {
            alert(" generation Started please wait !!");
        }
          function showMesage() {
            alert(" Payment initiated please wait !!");
        }

        // Function to show loader
        function showLoader() {
            document.getElementById("loader").style.display = "block";
            fetchData();
        }

        // Function to simulate fetching data
        function fetchData() {
            setTimeout(hideLoader, 1000);
        }

        // Function to hide loader
        function hideLoader() {
            document.getElementById("loader").style.display = "none";
        }

        window.onload = function() {
            var popup = document.querySelector('.popup');
            if (popup) {
                popup.style.display = 'block';
                setTimeout(function() {
                    popup.style.display = 'none';
                }, 1000); // Disappear after 4 seconds
            }
        };

        document.addEventListener("DOMContentLoaded", function() {
            var settingsLink = document.getElementById("settings-link");
            var settingsDiv = document.getElementById("settings");
            var settingsForm = document.getElementById("settings-form");

            settingsLink.addEventListener("click", function(event) {
                event.preventDefault();
                settingsDiv.style.display = (settingsDiv.style.display === "none") ? "block" : "none";
            });

            settingsForm.addEventListener("submit", function(event) {
                event.preventDefault();
                var username = document.getElementById("username").value;
                var password = document.getElementById("password").value;
                var phone = document.getElementById("phone").value;
                // Perform validation and update logic here
                // Use AJAX to send the form data to the server for processing
            });
        });
    </script>
</body>
</html>
<?php } ?>