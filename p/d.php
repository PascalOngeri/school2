<?php
	date_default_timezone_set("Etc/GMT+8");
	// require_once'session.php';
	// require_once'class.php';
	// $db=new db_class(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>infinity</title>

    <link href="fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  
   
    <link href="css/sb-admin-2.css" rel="stylesheet">
    
<style>
        
       
     
        
        h1 {
            color: #4CAF50;
            margin-bottom: 20px;
            font-size: 2em;
        }
        p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
            margin-bottom: 30px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input[type="text"], textarea , input[type="email"], input[type="phone"], input[type="password"]{
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }
        button:hover {
            background-color: #45a049;
        }
        @media (max-width: 600px) {
            h1 {
                font-size: 1.5em;

            }
            p {
                font-size: 1em;
            }
            form {
                width: 100%;
                padding: 10px;
            }
            input[type="text"], textarea {
                padding: 8px;

            }
            button {
                width: 100%;
                padding: 12px;
            }
            .header-title {
                font-size: 1.2em;
            }
            .header-buttons {
                justify-content: center;
                padding: 10px 0;
            }
            .header-buttons button {
                padding: 8px 10px;
                margin: 2px;
                font-size: 0.9em;
            }
            .navbar-toggle {
                display: block;
            }
        }
        .logout-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #f44336;
            border: none;
            color: white;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 1em;
        }
        .logout-button:hover {
            background-color: #d32f2f;
        }
       
           
            .content {
                margin-left: 0;
                width: 100%;
                padding: 10px;
            }
        }
        #api-key-section {
            display: none;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
            margin-bottom: 30px;
        }
         #docummentationsec {
            display: none;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
            margin-bottom: 30px;
        }
         #errors {
            display: none;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
            margin-bottom: 30px;
        }
       
         #calender {
            display: none;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
            margin-bottom: 30px;
        }

#outbox{
    display: none;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
            margin-bottom: 30px;

}
        td button {
            font-size: 20px;
            width: 30px;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <div class="sidebar-brand-text mx-3">ADMIN PANEL</div>
            </a>


            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="register.php">
                    <i class="fa fa-user fa-fw"></i>
                    <span>Register</span></a>
            </li>
			<li class="nav-item active">
                <a class="nav-link" href="manage-students.php">
                    <i class="fas fa-fw fas fa-comment-dollar"></i>
                    <span>View Learners</span></a>
            </li>
			<li class="nav-item active">
                <a class="nav-link" href="session.php">
                    <i class="fa fa-calendar fa-fw  " ></i>
                    <span>Send SMS to Parents</span></a>
            </li>
			<li class="nav-item active">
                <a class="nav-link" href="setfee.php">
                    <i class="fa fa-sign-out fa-fw"></i>
                    <span>Register classes</span></a>
            </li>
			<li class="nav-item active">
                <a class="nav-link" href="pay.php">
                    <i class="fas fa-fw fas fa-coins"></i>
                    <span>MANAGE FEE</span></a>
            </li>
			<li class="nav-item active">
                <a class="nav-link" href="busu.php">
                    <i class="fa fa-user fa-fw"></i>
                    <span>Bus users/other services</span></a>
            </li>
			<li class="nav-item active">
                <a class="nav-link" href="user.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Users</span></a>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column" >

            <!-- Main Content -->
            <div id="content" style="background-color: lightblue">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"  >

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
	<img src="d.jpg" alt="School Icon" style="height: 40px; width: auto; margin-right: 10px;">
             <center> <h3 style="color: purple ;"> INFINITY  ACADEMY PRIMARY SCHOOL</h3></center>
					<!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php //echo $db->user_acc($_SESSION['user_id'])
                                ?></span>
                                <img class="img-profile rounded-circle"
                                    src="image/admin_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#profi"onclick="prof(); return false;"  data-toggle="modal" data-target="#profile">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    My profile
                                </a>
                                <a class="dropdown-item" href="#"  data-toggle="modal" data-target="#change">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Change password
                                </a>
                                <a class="dropdown-item" href="#add"onclick="ad(); return false;"  data-toggle="modal" data-target="#adduser">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Add user
                                </a>
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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>
 
                    <!-- Content Row -->
                    <div class="row">

                    
                        <div class="col-xl-4 col-md-4 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                               Total Learners</div>
                                            <div class="h1 mb-0 font-weight-bold text-gray-800">
												<?php 
												// 	$tbl_loan=$db->conn->query("SELECT * FROM `loan` WHERE `status`='2'");
												// 	echo $tbl_loan->num_rows > 0 ? $tbl_loan->num_rows : "0";
												//fa fa-users fa-fw fa-5x ?>
											</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-users fa-fw fa-5x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
								<div class="card-footer d-flex align-items-center justify-content-between">
									<a class="small stretched-link" href="loan.php">View list</a>
									<div class="small">
										<i class="fa fa-arrow-circle-right"></i>
									</div>
								</div>
                            </div>
                        </div>

                      
                        <div class="col-xl-4 col-md-4 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Manage fee</div>
                                            <div class="h1 mb-0 font-weight-bold text-gray-800">
												<?php 
												// 	$tbl_payment=$db->conn->query("SELECT sum(pay_amount) as total FROM `payment` WHERE date(date_created)='".date("Y-m-d")."'");
												// 	echo $tbl_payment->num_rows > 0 ? "&#8369; ".number_format($tbl_payment->fetch_array()['total'],2) : "&#8369; 0.00";
												// ?>
											</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-fw fas fa-coins fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
								<div class="card-footer d-flex align-items-center justify-content-between">
									<a class="small stretched-link" href="payment.php">click here!!</a>
									<div class="small">
										<i class="fa fa-arrow-circle-right"></i>
									</div>
								</div>
                            </div>
                        </div>

                        
                        <div class="col-xl-4 col-md-4 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Administration section
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h1 mb-0 mr-3 font-weight-bold text-gray-800">
														<?php 
														// 	$tbl_borrower=$db->conn->query("SELECT * FROM `borrower`");
														// 	echo $tbl_borrower->num_rows > 0 ? $tbl_borrower->num_rows : "0";
														// ?>
													</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-file  fa-5x"></i>
                                        </div>
                                    </div>
                                </div>
								<div class="card-footer d-flex align-items-center justify-content-between">
									<a class="small stretched-link" href="borrower.php">manage users</a>
									<div class="small">
										<i class="fa fa-arrow-circle-right"></i>
									</div>
								</div>
                            </div>
                        </div>



                        <div class="col-xl-4 col-md-4 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                               REGISTER LEARNERS</div>
                                            <div class="h1 mb-0 font-weight-bold text-gray-800">
                                                <?php 
                                                //  $tbl_loan=$db->conn->query("SELECT * FROM `loan` WHERE `status`='2'");
                                                //  echo $tbl_loan->num_rows > 0 ? $tbl_loan->num_rows : "0";
                                                //fa fa-users fa-fw fa-5x ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-users fa-fw fa-5x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small stretched-link" href="register.php">click here!!!</a>
                                    <div class="small">
                                        <i class="fa fa-arrow-circle-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
            </div>



<br><br>
<br>
            <!-- Footer -->
            <footer class="stocky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span style="color: purple; background-color: grey">Copyright &copy; Pascal ongeri <?php echo date("Y")?></span>
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
     <div class="modal fade" id="change" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">System Information</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">

          <form method="POST" >
            <label for="username">Username:</label>
   
            <input type="text" id="username" name="username" value="<?php //echo htmlspecialchars($user['username']); ?>">
            
            <label for="email">Email:</label>
        
            <input type="email" id="email" name="email" value="<?php //echo htmlspecialchars($user['email']); ?>" >
            
             <label for="confirm_password">Phone number:</label>
        
            <input type="phone" id="phone" name="phone" value="<?php //echo htmlspecialchars($user['phone']); ?>" >
            
            <label for="password">Password:</label>
          
            <input type="password" id="password" name="password" value="<?php //echo htmlspecialchars($user['password']); ?>" >
            
            <label for="confirm_password">Confirm Password:</label>
          
            <input type="password" id="confirm_password" name="confirm_password"value="<?php //echo htmlspecialchars($user['password']); ?>" >
           <button type="submit">Update</button>
        </form>
                   
                </div>
            </div>
        </div>
    </div>
     <div class="modal fade" id="profile" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">System Information</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">My Profile</div>
                <div class="modal-footer">
                     <label for="username">Username:</label>
   
            <input type="text" id="username" name="username" value="<?php //echo htmlspecialchars($user['username']); ?>">
            
            <label for="email">Email:</label>
        
            <input type="email" id="email" name="email" value="<?php //echo htmlspecialchars($user['email']); ?>" >
            
             <label for="confirm_password">Phone number:</label>
        
            <input type="phone" id="phone" name="phone" value="<?php //echo htmlspecialchars($user['phone']); ?>" >
            
                </div>
            </div>
        </div>
    </div>


     <div class="modal fade" id="adduser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">System Information</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">add new user?</div>
                <div class="modal-footer">
                     <form method="POST" >
            <label for="username">Username:</label>
   
            <input type="text" id="username" name="username" value="<?php //echo htmlspecialchars($user['username']); ?>">
            
            <label for="email">Email:</label>
        
            <input type="email" id="email" name="email" value="<?php //echo htmlspecialchars($user['email']); ?>" >
            
             <label for="confirm_password">Phone number:</label>
        
            <input type="phone" id="phone" name="phone" value="<?php //echo htmlspecialchars($user['phone']); ?>" >
            
            <label for="password">Password:</label>
          
            <input type="password" id="password" name="password" value="<?php //echo htmlspecialchars($user['password']); ?>" >
            
            <label for="confirm_password">Confirm Password:</label>
          
            <input type="password" id="confirm_password" name="confirm_password"value="<?php //echo htmlspecialchars($user['password']); ?>" >
           <button type="submit">Add user</button>
        </form>
                   
                </div>
            </div>
        </div>
    </div>
    <script>
    // Smooth scroll to section
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Toggle navigation for small screens
        document.querySelector('.navbar-toggle').addEventListener('click', function() {
            document.querySelector('.sidebar-nav').classList.toggle('show');
        });

        // Toggle API Key section visibility
        function toggleApiKey() {
            var apiKeySection = document.getElementById('api-key-section');
            if (apiKeySection.style.display === 'none' || apiKeySection.style.display === '') {
                apiKeySection.style.display = 'block';
            } else {
                apiKeySection.style.display = 'none';
            }
        }
         function prof() {
            var docksec = document.getElementById('profi');
            if (docksec.style.display === 'none' || docksec.style.display === '') {
                docksec.style.display = 'block';
            } else {
                docksec.style.display = 'none';
            }
        }
         function ad() {
            var errorr = document.getElementById('add');
            if (errorr.style.display === 'none' || errorr.style.display === '') {
                errorr.style.display = 'block';
            } else {
                errorr.style.display = 'none';
            }
        }
        
        function che() {
            var chen = document.getElementById('change');
            if (chen.style.display === 'none' || chen.style.display === '') {
                chen.style.display = 'block';
            } else {
                chen.style.display = 'none';
            }
        }
         function cal() {
            var cali = document.getElementById('calender');
            if (cali.style.display === 'none' || cali.style.display === '') {
                cali.style.display = 'block';
            } else {
                cali.style.display = 'none';
            }
        }
        function out() {
            var o = document.getElementById('outbox');
            if (o.style.display === 'none' || o.style.display === '') {
                o.style.display = 'block';
            } else {
                o.style.display = 'none';
            }
        }
        
    </script>
    <!-- Bootstrap core JavaScript-->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.bundle.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="js/jquery.easing.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.js"></script>


</body>

</html>