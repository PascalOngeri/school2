<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include('dbconnection.php');

//require 'PHPExcel/Classes/PHPExcel.php'; // Add this line to include PHPExcel

if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['del'])) {
    $cname = $_POST['area'];
    $sql = "delete from classes where class=:area";
    $query = $dbh->prepare($sql);
    $query->bindParam(':area', $cname, PDO::PARAM_STR);
    $query->execute();
    echo "<script>alert('Data deleted');</script>";
    echo "<script>window.location.href = 'add-class.php'</script>";
  }

  $allPhoneNumbers = '';
  if (isset($_POST['submit'])) {
    $phoneNumbersQuery = mysqli_query($con, "SELECT phone FROM registration");
    $phoneNumbers = array();
    while ($row = mysqli_fetch_assoc($phoneNumbersQuery)) {
      $phoneNumbers[] = $row['phone'];
    }
    $allPhoneNumbers = implode(',', $phoneNumbers);
  }

   if (isset($_POST['teacherexcel'])) {

    $phoneNumbers = array();
    
    if (empty($_FILES['file']['tmp_name'])) {
        echo '<script>alert("Select a file first! ");</script>';
    } else {
        $file = $_FILES['file']['tmp_name'];
        $handle = fopen($file, 'r');
        while (($filesop = fgetcsv($handle, 1000)) !== FALSE) {
            if (!empty($filesop[0])) {
                $phoneNumbers[] = $filesop[0]; // Assuming phone numbers are in the first column
            }
        }
        
        fclose($handle);
        
        // Display phone numbers separated by commas, except the last row
        $allPhoneNumbers = implode(',', $phoneNumbers);
       // echo $allPhoneNumbers;
    }
}


   
  if (isset($_POST['send'])) {

    $mess = $_POST['message'];
    $phone_number = $_POST['phone'];
    
    $url = 'https://sms-service.smsafrica.tech/message/send/transactional';
    
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
 
        $postData = json_encode([
            "message" => $mess,
            "msisdn" => $phone_number,
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
            echo '<div class="popup" style="background-color: red; font-size: 24px; border-radius: 20px;">&#10007; Failed to send message to ' . $phone_number . '</div>';
        }
    
}
?>

<?php include_once('includes/header.php'); ?>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <!-- partial:partials/_sidebar.html -->
  <?php include_once('includes/sidebar.php'); ?>
  <!-- partial -->
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Contact parents </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Contact parents</li>
          </ol>
        </nav>
      </div>
      <div class="row">
        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form class="forms-sample" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="exampleInputName1">Enter phone number</label>
                  <input type="text" name="phone" value="<?php echo $allPhoneNumbers; ?>" class="form-control" placeholder="Enter phone number">
                </div>
                <div class="form-group">
                  <label for="exampleInputName1">Message body</label>
                  <input type="text" name="message" value="" class="form-control" placeholder="Enter message">
                </div>
                <button type="submit" class="btn btn-primary mr-2" name="submit">Select all phone numbers</button>
                <input type="file" name="file" />
                
                <input type="submit" name="teacherexcel" id="teacherexcel" class="btn btn-info btn-lg" value="Import CSV" />
                
                <button type="submit" class="btn btn-primary mr-2" name="send">Send</button>
              </form>
              
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    <?php include_once('includes/footer.php'); ?>
    <!-- partial -->
  </div>
  <!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<?php } ?>
