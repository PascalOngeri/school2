<?php
    date_default_timezone_set("Etc/GMT+8");
    
?>
<?php
include('config.php');
session_start(); // Ensure session is started



if(ISSET($_POST['edit'])){

$api = $_POST['api'];
    $id= $_POST['id'];

 $updateSql = "UPDATE user SET devapi = '$api' WHERE id = ?";
    $stmt = $con->prepare($updateSql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Redirect back to admin dashboard after updating
    header("Location: adminhome.php");
    exit();


}


$sql = "SELECT * FROM user";
$result = $con->query($sql);

// Check if any clients exist
if ($result->num_rows > 0) {
    $user = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $user = [];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button{ 
            -webkit-appearance: none; 
        }

    </style>
    
    
    
<!-- Bootstrap CSS -->
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Shabanet Online Banking System</title>
    <link href="fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link href="css/sb-admin-2.css" rel="stylesheet">
</head>

<body id="page-top">
 <span>
        <?php
       if (isset($_POST['deposit'])) {
  $phone_number = $_POST['phone_number'];
  $amount = $_POST['loan_amount'];
 

  $base_url = "https://lipia-api.kreativelabske.com/api";
$endpoint = "/request/stk";
$api_key = $user['devapi']; // Replace with your actual API key

// Data to be sent in JSON format
$data = [
    "phone" =>  $phone_number,
    "amount" => $amount
];

// Encode the data to JSON
$json_data = json_encode($data);

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $base_url . $endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key
]);

// Execute cURL session
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    // Handle the error as per your requirement (e.g., log it, notify someone)
} else {
    // Close cURL session
    curl_close($ch);

    // Decode the response JSON
    $decoded_response = json_decode($response, true);

    // Check if the response indicates success or failure
    if (isset($decoded_response['message']) && $decoded_response['message'] === 'callback received successfully') {
        // Extract data to be inserted into the database
        $amount = $decoded_response['data']['amount'];
        $phone = $decoded_response['data']['phone'];
        $reference = $decoded_response['data']['refference']; // Note: 'refference' might be a typo, should it be 'reference'?
  $_SESSION["ref"]= $reference;
        // Now, insert this data into your database
        // Example assuming you are using PDO for database operations
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=shabanetbank', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare SQL statement
            $stmt = $pdo->prepare('INSERT INTO till (phone_number, amount, reference,acc,status) VALUES (:phone, :amount, :reference,:id,:status)');
            $stmt->execute(array(
                'phone' => $phone,
                'amount' => $amount,
                'reference' => $reference,
                 'id' => $user_id,
                  'status' => "COMPLETED"

            ));
           $class = 'alert-success';
            $message = 'Payment Successful';
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } else {

        // $decoded_response = json_decode($response, true);
         
         $class = 'alert-error';
            $message = 'Payment Cancelled';
    }

}




 

     
         
      
        ?>
          <div class="alert <?php echo $class; ?> shadow-lg max-w-sm" id="statusAlert" style="width:400px!important;">
            <div>
              <span><?php echo $message; ?></span>
            
            
            </div>
          </div>
        <?php } ?>
      </span>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-text mx-3">ADMIN PANEL</div>
            </a>


            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="home.php">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Home</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="loan.php">
                    <i class="fas fa-fw fas fa-comment-dollar"></i>
                    <span>Deposit</span></a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="loan_plan.php">
                    <i class="fas fa-fw fa-piggy-bank"></i>
                    <span>My Transactions</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="loan_type.php">
                    <i class="fas fa-fw fa-money-check"></i>
                    <span>Intergration</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="user.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Users</span></a>
            </li>
              <li class="nav-item">
                <a class="nav-link" href="adminhome.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Adminhome</span></a>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
    
                   
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> Admin</span>
                                <img class="img-profile rounded-circle"
                                    src="image/admin_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Assign Developer Api</h1>
                    </div>
             <form method="POST" action="adminhome.php">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="phone_number">Enter Id</label>
                            <input type="text" class="form-control" id="id" name="id" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="loan_amount">Api Key</label>
                            <input type="text" class="form-control" id="api" name="api" required>
                        </div>

                    </div>
                    <hr>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                   
                    <button type="submit" class="btn btn-primary btn-block" name="edit">Save</button>
                </div>
            </form>


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                               <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
                <tr>
                    <th>ID</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Phone</th>
                    <th>Business Name</th>
                    <th>Payment Type</th>
                    <th>Payment No</th>
                    <th>Developer Api</th>
                    <th>Subscription</th>
                    <th>Verified</th>
                    <th class="actions-column">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($user as $r): ?>
                    <tr>
                        <td><?php echo $r['id']; ?></td>
                        <td><?php echo $r['fullname']; ?></td>
                        <td><?php echo $r['email']; ?></td>
                        <td><?php echo $r['username']; ?></td>
                        <td><?php echo $r['phone']; ?></td>
                        <td><?php echo $r['bname']; ?></td>
                        <td><?php echo $r['payname']; ?></td>
                        <td><?php echo $r['paymentno']; ?></td>
                        <td><?php echo $r['devapi']; ?></td>
                        <td><?php echo $r['subscription']; ?></td>
                        <td><?php echo $r['very']; ?></td>
                        <td class="actions-column">
                            <a href="approve_client.php?id=<?php echo $r['id']; ?>">Approve</a>
                            <a href="suspend_client.php?id=<?php echo $r['id']; ?>">Suspend</a>
                           
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>                         <!-- Update User Modal -->
                                        <div class="modal fade" id="updateloan<?php echo $fetch['loan_id']?>" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <form method="POST" action="updateLoan.php">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-warning">
                                                            <h5 class="modal-title text-white">Edit Loan</h5>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-6 col-md-6">
                                                                    <label>Borrower</label>
                                                                    <br />
                                                                    <input type="hidden" value="<?php echo $fetch['loan_id']?>" name="loan_id"/>
                                                                    <select name="borrower" class="borrow" required="required" style="width:100%;">
                                                                        <?php
                                                                            $tbl_borrower=$db->display_borrower();
                                                                            while($row=$tbl_borrower->fetch_array()){
                                                                        ?>
                                                                            <option value="<?php echo $row['borrower_id']?>" <?php echo ($fetch['borrower_id']==$row['borrower_id'])?'selected':''?>><?php echo $row['lastname'].", ".$row['firstname']." ".substr($row['middlename'], 0, 1)?>.</option>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-xl-6 col-md-6">
                                                                    <label>Loan type</label>
                                                                    <br />
                                                                    <select name="ltype" class="loan" required="required" style="width:100%;">
                                                                        <?php
                                                                            $tbl_ltype=$db->display_ltype();
                                                                            while($row=$tbl_ltype->fetch_array()){
                                                                        ?>
                                                                            <option value="<?php echo $row['ltype_id']?>" <?php echo ($fetch['ltype_id']==$row['ltype_id'])?'selected':''?>><?php echo $row['ltype_name']?></option>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-6 col-md-6">
                                                                    <label>Loan Plan</label>
                                                                    <select name="lplan" class="form-control" required="required" id="ulplan">
                                                                        <?php
                                                                            $tbl_lplan=$db->display_lplan();
                                                                            while($row=$tbl_lplan->fetch_array()){
                                                                        ?>
                                                                            <option value="<?php echo $row['lplan_id']?>" <?php echo ($fetch['lplan_id']==$row['lplan_id'])?'selected':''?>><?php echo $row['lplan_month']." months[".$row['lplan_interest']."%, ".$row['lplan_penalty']."%]"?></option>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                    <label>Months[Interest%, Penalty%]</label>
                                                                </div>
                                                                <div class="form-group col-xl-6 col-md-6">
                                                                    <label>Loan Amount</label>
                                                                    <input type="number" name="loan_amount" class="form-control" id="uamount" value="<?php echo $fetch['amount']?>" required="required"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-6 col-md-6">
                                                                    <label>Purpose</label>
                                                                    <textarea name="purpose" class="form-control" style="resize:none; height:200px;" required="required"><?php echo $fetch['purpose']?></textarea>
                                                                </div>
                                                                <div class="form-group col-xl-6 col-md-6">
                                                                    <button type="button" class="btn btn-primary btn-block" id="updateCalculate">Calculate Amount</button>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-xl-4 col-md-4">
                                                                    <center><span>Total Payable Amount</span></center>
                                                                    <center><span id="utpa"><?php echo "&#8369; ".number_format($totalAmount, 2)?></span></center>
                                                                </div>
                                                                <div class="col-xl-4 col-md-4">
                                                                    <center><span>Monthly Payable Amount</span></center>
                                                                    <center><span id="umpa"><?php echo "&#8369; ".number_format($monthly, 2)?></span></center>
                                                                </div>
                                                                <div class="col-xl-4 col-md-4">
                                                                    <center><span>Penalty Amount</span></center>
                                                                    <center><span id="upa"><?php echo "&#8369; ".number_format($penalty, 2)?></span></center>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-6 col-md-6">
                                                                    <label>Status</label>
                                                                    <select class="form-control" name="status">
                                                                        <?php
                                                                            if($fetch['status']==4){
                                                                        ?>
                                                                            <option value="0" <?php echo ($fetch['status']==0)?'selected':''?>>For Approval</option>
                                                                            <option value="1" <?php echo ($fetch['status']==1)?'selected':''?>>Approved</option>
                                                                            <option value="4" <?php echo ($fetch['status']==4)?'selected':''?>>Denied</option>
                                                                        <?php
                                                                            }else if($fetch['status']==2){
                                                                        ?>
                                                                            <option value="2" readonly="readonly">Released</option>
                                                                        <?php
                                                                            }else{
                                                                        ?>
                                                                            <option value="0" <?php echo ($fetch['status']==0)?'selected':''?>>For Approval</option>
                                                                            <option value="1" <?php echo ($fetch['status']==1)?'selected':''?>>Approved</option>
                                                                            <option value="2" <?php echo ($fetch['status']==2)?'selected':''?>>Released</option>
                                                                            <option value="4" <?php echo ($fetch['status']==4)?'selected':''?>>Denied</option>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" name="update" class="btn btn-warning">Update</a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        <!-- Delete Loan Modal -->
                                        
                                        <div class="modal fade" id="deleteborrower<?php echo $fetch['loan_id']?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-white">System Information</h5>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">Are you sure you want to delete this record?</div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                        <a class="btn btn-danger" href="deleteLoan.php?loan_id=<?php echo $fetch['loan_id']?>">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- View Payment Schedule -->
                                        <div class="modal fade" id="viewSchedule<?php echo $fetch['loan_id']?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info">
                                                        <h5 class="modal-title text-white">Payment Schedule</h5>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-5 col-xl-5">
                                                                <p>Reference No:</p>
                                                                <p><strong><?php echo $fetch['ref_no']?></strong></p>
                                                            </div>
                                                            <div class="col-md-7 col-xl-7">
                                                                <p>Name:</p>
                                                                <p><strong><?php echo $fetch['firstname']." ".substr($fetch['middlename'], 0, 1).". ".$fetch['lastname']?></strong></p>
                                                            </div>
                                                        </div>
                                                        <hr />
                                                        
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-sm-6"><center>Months</center></div>
                                                                <div class="col-sm-6"><center>Monthly Payment</center></div>
                                                            </div>
                                                            <hr />
                                                            <?php 
                                                                $tbl_schedule=$db->conn->query("SELECT * FROM `loan_schedule` WHERE `loan_id`='".$fetch['loan_id']."'");
                                                                
                                                                while($row=$tbl_schedule->fetch_array()){
                                                            ?>
                                                            <div class="row">
                                                                <div class="col-sm-6 p-2 pl-5" style="border-right: 1px solid black; border-bottom: 1px solid black;"><strong><?php echo date("F d, Y" ,strtotime($row['due_date']));?></strong></div>
                                                                <div class="col-sm-6 p-2 pl-5" style="border-bottom: 1px solid black;"><strong><?php echo "&#8369; ".number_format($monthly, 2); ?></strong></div>
                                                            </div>
                                                            
                                                        
                                                        </div>  
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                       
                    </div>
                </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="stocky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Loan Management System <?php echo date("Y")?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    
    
    <!-- Add Loan Modal-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="addModalLabel">Loan Application</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal Body -->
           
        </div>
    </div>
</div>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">System Information</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to logout?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.bundle.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="js/jquery.easing.js"></script>
    <script src="js/select2.js"></script>


    <!-- Page level plugins -->
    <script src="js/jquery.dataTables.js"></script>
    <script src="js/dataTables.bootstrap4.js"></script>
    

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
function showDepositModal() {
    // Onyesha div ya depositModal
    document.getElementById('depositModal').style.display = 'block';
}
</script>

    <script>
        $(document).ready(function() {
    // JavaScript code for handling modal actions if needed
});

        $(document).ready(function() {
            $("#calcTable").hide();
            
            
            $('.borrow').select2({
                placeholder: 'Select an option'
            });
            
            $('.loan').select2({
                placeholder: 'Select an option'
            });
            
            
            
           
    </script>

</body>

</html>
