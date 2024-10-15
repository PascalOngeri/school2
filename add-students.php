<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include('dbconnection.php');
if (strlen($_SESSION['sturecmsaid']==0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        // Collect form data
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $adm = $_POST['stuid'];
        $email = $_POST['stuemail'];
        $class = $_POST['stuclass'];
        $phone = $_POST['connum'];
        $phone1 = $_POST['altconnum'];
        $address = $_POST['address'];
        $username = $_POST['uname'];
        $faname = $_POST['faname'];
        $maname = $_POST['maname'];
        $password = $_POST['password'];
        $image = $_FILES["image"]["name"];
        
        // Get the fee for the selected class
        $ret = "SELECT fee FROM classes WHERE class=:stuclass";
        $query = $dbh->prepare($ret);
        $query->bindParam(':stuclass', $class, PDO::PARAM_STR);
        $query->execute();
        
        $results = $query->fetch(PDO::FETCH_OBJ);
        $fee = $results->fee;

        // Check for duplicate username or student ID
        $ret = "SELECT username FROM registration WHERE username=:uname OR adm=:stuid";
        $query = $dbh->prepare($ret);
        $query->bindParam(':uname', $username, PDO::PARAM_STR);
        $query->bindParam(':stuid', $adm, PDO::PARAM_STR);
        $query->execute();
        
        if ($query->rowCount() == 0) {
            // Validate image file format
            $extension = substr($image, strlen($image)-4, strlen($image));
            $allowed_extensions = array(".jpg", "jpeg", ".png", ".gif");
            if (!in_array($extension, $allowed_extensions)) {
                echo "<script>alert('Image has an invalid format. Only jpg / jpeg / png / gif format allowed');</script>";
            } else {
                // Move image and insert student record
                $image = md5($image) . time() . $extension;
                move_uploaded_file($_FILES["image"]["tmp_name"], "assets/images/" . $image);
                $sql = "INSERT INTO registration (adm, fname, mname, lname, gender, faname, maname, class, phone, phone1, address, email, fee, t1, t2, t3, dob, image, username, password) 
                        VALUES (:stuid, :fname, :mname, :lname, :gender, :faname, :maname, :stuclass, :connum, :altconnum, :address, :stuemail, :fee, '0', '0', '0', :dob, :image, :uname, :password)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':stuid', $adm, PDO::PARAM_STR);
                $query->bindParam(':fname', $fname, PDO::PARAM_STR);
                $query->bindParam(':mname', $mname, PDO::PARAM_STR);
                $query->bindParam(':lname', $lname, PDO::PARAM_STR);
                $query->bindParam(':gender', $gender, PDO::PARAM_STR);
                $query->bindParam(':faname', $faname, PDO::PARAM_STR);
                $query->bindParam(':maname', $maname, PDO::PARAM_STR);
                $query->bindParam(':stuclass', $class, PDO::PARAM_STR);
                $query->bindParam(':connum', $phone, PDO::PARAM_STR);
                $query->bindParam(':altconnum', $phone1, PDO::PARAM_STR);
                $query->bindParam(':address', $address, PDO::PARAM_STR);
                $query->bindParam(':stuemail', $email, PDO::PARAM_STR);
                $query->bindParam(':fee', $fee, PDO::PARAM_STR);
                $query->bindParam(':dob', $dob, PDO::PARAM_STR);
                $query->bindParam(':image', $image, PDO::PARAM_STR);
                $query->bindParam(':uname', $username, PDO::PARAM_STR);
                $query->bindParam(':password', $password, PDO::PARAM_STR);
                $query->execute();                
                $LastInsertId = $dbh->lastInsertId();
                if ($LastInsertId > 0) {
                    echo '<script>alert("Student has been added.")</script>';
                    echo "<script>window.location.href ='add-students.php'</script>";                               
                    
                    
                    ///////////////////////////////////                    
                    
         // $apiUrl = "http://shabanetsms.kesug.com/send.php"; 
        $url = 'https://sms-service.smsafrica.tech/message/send/transactional';
       /// $apiKey = "e625fda005add40efa7d4f67751aed96";
        // Retrieve the latest API key from the database
    $selectQuery = "SELECT apikey FROM api ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($con, $selectQuery);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $token = $row['apikey'];
    } else {
        echo "Error fetching latest API key from the database.\n";
        // Handle this error condition appropriately
        exit();
    }
            
   // Iterate through each phone number and send SMS   
    
   $message = $_SESSION['name'] . " Your registration is complete. Student Name: " . $fname . " " . $mname . " " . $lname . ", Class: " . $class . ". Username: " . $username . ", Password: " . $password . ". Thank you for registering!";

// Prepare the POST data
$postData = json_encode([
    "message" => $message,
    "msisdn" => $phone,  // Use the primary contact number here
    "sender_id" => "SMSAFRICA",
    "callback_url" => "https://callback.io/123/dlr"
]);

 $httpRequest = curl_init($url);
        curl_setopt($httpRequest, CURLOPT_POST, true);
        curl_setopt($httpRequest, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($httpRequest, CURLOPT_TIMEOUT, 60);
        curl_setopt($httpRequest, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($httpRequest, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "api-key: $token"
        ));

   $response = curl_exec($httpRequest);
        $httpCode = curl_getinfo($httpRequest, CURLINFO_HTTP_CODE);
        curl_close($httpRequest);


        if ($httpCode == 200) {
            echo '<div class="popup" style="background-color: green; font-size: 24px; border-radius: 20px;">&#10003; Message sent successfully to ' . $phone_number . '</div>';
        } else {
            echo '<div class="popup" style="background-color: red; font-size: 24px; border-radius: 20px;">&#10007; Failed to send message to ' .    $phone_number . '</div>';
        }        
                    
                    //////////////////////////////
                } else {
                    echo '<script>alert("Something went wrong. Please try again")</script>';
                }
            }
        } else {
            echo "<script>alert('Username or Student ID already exists. Please try again');</script>";
        }
    }

?>

      <!-- partial:partials/_navbar.html -->
     <?php include_once('includes/header.php');?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
      <?php include_once('includes/sidebar.php');?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Add Students </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> Add Students</li>
                </ol>
              </nav>
            </div>
            <div class="row">
          
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                   
                   
                    <form class="forms-sample row" method="post" enctype="multipart/form-data" >
                      
                      <div class="form-group col-md-6">
                        <label for="exampleInputName1">First Name</label>
                        <input type="text" name="fname" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="exampleInputName1">Second Name</label>
                        <input type="text" name="mname" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="exampleInputName1">Last Name</label>
                        <input type="text" name="lname" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="exampleInputName1">Email</label>
                        <input type="text" name="stuemail" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="exampleInputEmail3">Student Class</label>
                        <select  name="stuclass" class="form-control" required='true'>
                          <option value="">Select Class</option>
                         <?php 

$sql2 = "SELECT * from    classes ";
$query2 = $dbh -> prepare($sql2);
$query2->execute();
$result2=$query2->fetchAll(PDO::FETCH_OBJ);

foreach($result2 as $row1)
{          
    ?>  
<option value="<?php echo htmlentities($row1->class);?>"><?php echo htmlentities($row1->class);?> </option>
 <?php } ?> 
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="exampleInputName1">Gender</label>
                        <select name="gender" value="" class="form-control" required='true'>
                          <option value="">Choose Gender</option>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="exampleInputName1">Date of Birth</label>
                        <input type="date" name="dob" value="" class="form-control" required='true'>
                      </div>
                     
                      <div class="form-group col-md-6">
                        <label for="exampleInputName1">Admission Number</label>
                        <input type="text" name="stuid" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="exampleInputName1">Student Photo</label>
                        <input type="file" name="image" value="" class="form-control" required='true'>
                      </div>
                      <h3 class="col-md-12">Parents/Guardian's details</h3>
                      <div class="form-group col-md-6">
                        <label for="exampleInputName1">Father's Name</label>
                        <input type="text" name="faname" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="exampleInputName1">Mother's Name</label>
                        <input type="text" name="maname" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="exampleInputName1">Contact Number</label>
                        <input type="text" name="connum" value="" class="form-control" required='true' maxlength="10" pattern="[0-9]+">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="exampleInputName1">Alternate Contact Number</label>
                        <input type="text" name="altconnum" value="" class="form-control" required='true' maxlength="10" pattern="[0-9]+">
                      </div>
                      <div class="form-group col-md-12">
                        <label for="exampleInputName1">Address</label>
                        <textarea name="address" class="form-control"></textarea>
                      </div>
                    <h3 class="col-md-12">Login details</h3>
                    <div class="form-group col-md-6">
                        <label for="exampleInputName1">User Name</label>
                        <input type="text" name="uname" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="exampleInputName1">Password</label>
                        <input type="Password" name="password" value="" class="form-control" required='true'>
                      </div>
                      <button type="submit" class="btn btn-primary mr-2" name="submit">Add</button>
                     
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
         <?php include_once('includes/footer.php');?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <?php }  ?>
