<?php
   $servername = "localhost";
$username = "vpbgvvdz_simon";
$password = "40702314Simon?";
$dbname = "vpbgvvdz_pay";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}// Replace with your database connection details
else{
session_start(); // Ensure session is started

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

$con->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Shabanet banking system</title>

    <link href="fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  
   
    <link href="css/sb-admin-2.css" rel="stylesheet">
	
	<!-- Custom styles for this page -->
    <link href="css/dataTables.bootstrap4.css" rel="stylesheet">
    

</head>

<body id="page-top">

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
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo ($user['username']); ?></span>
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
                        <h1 class="h3 mb-0 text-gray-800">Developers Panel</h1>
                    </div>

                    <!-- Content Row -->
                  
                     <div class="row">

                     
                        <div class="col-xl-4 col-md-4 mb-4">
                            <div class="card border-center-primary shadow h-100 py-2">
                           
                                <div class="card-body">
									<form method="POST" action="save_ltype.php">
										<div class="form-group">
											<label>Account Number</label>
											<input type="text" class="form-control" name="phone" required="required" readonly='true' value="<?php echo ($user['paymentno']); ?>" />
										</div>
										<div class="form-group">
    <label>Public Api Key</label>
    <input type="text" class="form-control" name="ltype_name" required="required" readonly="true" value="<?php echo ($user['publicapi']); ?>" />
</div>
<button type="button" onclick="copyApiKey()" style="background-color: lightgreen; color: white; border-radius: 5px; padding: 10px 20px; border: none; cursor: pointer;">Copy public api</button>

<br>
                                        <div class="form-group">
                                            <label>Api Secret Token</label>
                                          <input type="text" class="form-control" name="o" required="required" readonly='true' value="<?php echo ($user['token']); ?>" />
                                        </div>
                                       <button style="background-color: lightgreen; color: white; border-radius: 5px; padding: 10px 20px; border: none; cursor: pointer;" type="button" onclick="copytoken()">Copy Token</button>
                                        <script>
    function copyApiKey() {
        var apiKeyInput = document.querySelector('input[name="ltype_name"]');
        apiKeyInput.select();
        document.execCommand('copy');
        alert('API Key copied to clipboard');

    }
      function copytoken() {
        var apiKeyInput = document.querySelector('input[name="o"]');
        apiKeyInput.select();
        document.execCommand('copy');
        alert('API Key copied to clipboard');
    }
    
</script><br><br>
										
									</form>
                                    <a href="home.php" type="submit" class="btn btn-primary btn-block" >Back</a>
                                </div>
                            </div>
                        </div>
						
									
											
											
											<!-- Delete Loan Type Modal -->
										
											<div class="modal fade" id="deleteltype<?php echo $fetch['ltype_id']?>" tabindex="-1" aria-hidden="true">
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
															<a class="btn btn-danger" href="delete_ltype.php?ltype_id=<?php echo $fetch['ltype_id']?>">Delete</a>
														</div>
													</div>
												</div>
											</div>
											
											<!-- Update Loan Type Modal -->
											
											<div class="modal fade" id="updateltype<?php echo $fetch['ltype_id']?>" tabindex="-1" aria-hidden="true">
												<div class="modal-dialog">
													<form method="POST" action="update_ltype.php">
														<div class="modal-content">
															<div class="modal-header bg-warning">
																<h5 class="modal-title text-white">Edit Loan Type</h5>
																<button class="close" type="button" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">×</span>
																</button>
															</div>
															<div class="modal-body">
																<div class="form-group">
																	<label>Loan Name</label>
																	<input type="text" class="form-control" value="<?php echo $fetch['ltype_name']?>" name="ltype_name" required="required"/>
																	<input type="hidden" class="form-control" value="<?php echo $fetch['ltype_id']?>" name="ltype_id"/>
																</div>
																<div class="form-group">
																	<label>Loan Description</label>
																	<textarea style="resize:none;" class="form-control" name="ltype_desc" required="required"><?php echo $fetch['ltype_desc']?></textarea>
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
											
											
										
									</div>
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

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.js"></script>
	
	<!-- Page level plugins -->
	<script src="js/jquery.dataTables.js"></script>
    <script src="js/dataTables.bootstrap4.js"></script>
	
	<script>
		$(document).ready(function() {
			$('#dataTable').DataTable({
				"order": [[ 1, "asc" ]]
			});
			
		});
	</script>

</body>

</html><?php } ?>