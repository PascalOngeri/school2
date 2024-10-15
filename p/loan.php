<?php
session_start();

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database Credentials
$servername = "localhost";
$username = "vpbgvvdz_simon";
$password = "40702314Simon?";
$dbname = "vpbgvvdz_pay";

// Create Connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check User Session
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];
$sql = "SELECT * FROM user WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$class = $message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deposit'])) {
    $phone_number = $_POST['phone_number'];
    $amount = $_POST['loan_amount'];

    $base_url = "https://lipia-api.kreativelabske.com/api";
    $endpoint = "/request/stk";
    $api_key = $user['devapi'];

    $data = [
        "phone" => $phone_number,
        "amount" => $amount
    ];

    $json_data = json_encode($data);

    // cURL Request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $base_url . $endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $class = 'alert-error';
        $message = 'Error: ' . curl_error($ch);
    } else {
        curl_close($ch);
        $decoded_response = json_decode($response, true);

        if (isset($decoded_response['message']) && $decoded_response['message'] === 'callback received successfully') {
            $amount = $decoded_response['data']['amount'];
            $phone = $decoded_response['data']['phone'];
            $reference = $decoded_response['data']['refference'];

            $_SESSION["ref"] = $reference;

            try {
               $pdo = new PDO('mysql:host=localhost;dbname=vpbgvvdz_pay', 'vpbgvvdz_simon', '40702314Simon?');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


                $stmt = $pdo->prepare('INSERT INTO till (phone_number, amount, reference, acc, status) VALUES (:phone, :amount, :reference, :id, :status)');
                $stmt->execute([
                    'phone' => $phone,
                    'amount' => $amount,
                    'reference' => $reference,
                    'id' => $user_id,
                    'status' => "COMPLETED"
                ]);

                $class = 'alert-success';
                $message = 'Payment Successful';
            } catch (PDOException $e) {
                $class = 'alert-error';
                $message = 'Error has occurred';
            }
        } else {
            $class = 'alert-error';
            $message = 'Payment Cancelled';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Shabanet Online Banking System</title>
    <link href="fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <style>
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
        }
    </style>
</head>
<body id="page-top">

<!-- Alerts -->
<?php if ($message): ?>
    <div class="alert <?php echo $class; ?> shadow-lg max-w-sm" id="statusAlert" style="width:400px!important;">
        <div><span><?php echo $message; ?></span></div>
    </div>
<?php endif; ?>

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-text mx-3">ADMIN PANEL</div>
        </a>
        <li class="nav-item active"><a class="nav-link" href="home.php"><i class="fas fa-fw fa-home"></i><span>Home</span></a></li>
        <li class="nav-item"><a class="nav-link" href="loan.php"><i class="fas fa-fw fas fa-comment-dollar"></i><span>Deposit</span></a></li>
        <li class="nav-item"><a class="nav-link" href="loan_plan.php"><i class="fas fa-fw fa-piggy-bank"></i><span>My Transactions</span></a></li>
        <li class="nav-item"><a class="nav-link" href="loan_type.php"><i class="fas fa-fw fa-money-check"></i><span>Integration</span></a></li>
        <li class="nav-item"><a class="nav-link" href="user.php"><i class="fas fa-fw fa-user"></i><span>Users</span></a></li>
    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"><i class="fa fa-bars"></i></button>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo htmlspecialchars($user['username']); ?></span>
                            <img class="img-profile rounded-circle" src="image/admin_profile.svg">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Deposit</h1>
                </div>

                <form method="POST" action="loan.php">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="loan_amount">Amount</label>
                            <input type="number" class="form-control" id="loan_amount" name="loan_amount" required>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary btn-block" name="deposit">DEPOSIT</button>
                </form>

                <!-- DataTales Example -->
                 <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                               <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>#</th>
            <th>MPESA REFERENCE</th>
            <th>Received from</th>
            <th>Amount</th>
            <th>Date</th>
          
            <th>State</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $acc = $user['id'];
            $sql = "SELECT * FROM till WHERE acc = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $acc);
            $stmt->execute();
            $result = $stmt->get_result();

            $i = 1; // Initialize counter for row numbers

            while ($row = $result->fetch_assoc()) {
                $userID = $row['reference'];
                $firstName = $row['phone_number'];
                $lastName = $row['amount'];
                $contactNumber = $row['date'];
                  $STUS = $row['status'];
               
        ?>

        <tr>
            <td><?php echo $i++; ?></td> <td><?php echo $userID; ?></td>
            <td><?php echo $firstName; ?></td>
            <td><?php echo $lastName; ?></td>
            <td><?php echo $contactNumber; ?></td>
           
            <td><?php echo $STUS; ?></td>
        </tr>

        <?php
            }
        ?>
    </tbody>
</table>
					
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>&copy; Shabanet Online Banking System</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
<script>
    // Show alert for 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        var alert = document.getElementById('statusAlert');
        if (alert) {
            setTimeout(function() {
                alert.style.display = 'none';
            }, 5000);
        }
    });
</script>

</body>
</html>
