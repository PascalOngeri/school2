<?php date_default_timezone_set("Etc/GMT+8");?>
<!DOCTYPE html>

<html data-theme="forest">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Shabanet banking System</title>

    <link href="css/all.css" rel="stylesheet" type="text/css">
  
   <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
    <link href="css/sb-admin-2.css" rel="stylesheet">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="">Shabanet Online Banking System</a>
        <!-- <a class="navbar-brand" href="">Shabanet Online Banking System</a> -->

    </nav>
    <div class="container">
        <div class="row justify-content-center">
            
                   
                          
                                   
                            <div class="col-lg-6">

                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">REGISTER !!!</h1>
                                    </div>
                                    <form method="POST" class="user" action="login.php">
                                        <div class="form-group">
                                             <h7 class="h4 text-gray-900 mb-4"> Full Names</h7>
                                            <input type="text" class="form-control form-control-user" name="fullname" placeholder="Enter full names here..." required="required" value="">
                                        </div>

                                        <div class="form-group">
                                             <h7 class="h4 text-gray-900 mb-4"> Email</h7>
                                            <input type="email" class="form-control form-control-user" name="email" placeholder="Enter email here..." required="required"  >
                                        </div>
                                         <div class="form-group">
                                             <h7 class="h4 text-gray-900 mb-4"> Phone Number</h7>
                                            <input type="phone" class="form-control form-control-user" name="phone" placeholder="Enter Phone number here..." required="required"  >
                                        </div>
                                        <div class="form-group">
                                             <h7 class="h4 text-gray-900 mb-4"> Identification Number</h7>
                                            <input type="TEXT" class="form-control form-control-user" name="idno" placeholder="Enter id number here..." required="required"  >
                                        </div>
                                         <div class="form-group">
                                             <h7 class="h4 text-gray-900 mb-4">KRA PIN</h7>
                                            <input type="TEXT" class="form-control form-control-user" name="kra" placeholder="Enter kra pin here..." required="required"  >
                                        </div>
                                          <div class="form-group">
                                             <h7 class="h4 text-gray-900 mb-4">Username</h7>
                                            <input type="TECT" class="form-control form-control-user" name="username" placeholder="Enter username pin here..." required="required"  >
                                        </div>
                                          <div class="form-group">
                                             <h7 class="h4 text-gray-900 mb-4">Password</h7>
                                            <input type="password" class="form-control form-control-user" name="password" placeholder="Enter password here..." required="required"  >
                                        </div>
                                          <div class="form-group">
                                             <h7 class="h4 text-gray-900 mb-4">Confirm password</h7>
                                            <input type="password" class="form-control form-control-user" name="password1" placeholder="Confirm password..." required="required"  >
                                        </div>
                                       <!--  <?php 
                                           // session_start();
                                           // if(ISSET($_SESSION['message'])){
                                              //  echo "<center><label class='text-danger'>".$_SESSION['message']."</label></center>";
                                           // }
                                        ?> -->
                                        <button type="submit" class="btn btn-primary btn-user btn-block" name="reg">Save to proceed</button><br>

                                        
                                    </form>
   
  <center><a href="index.php"  class="btn btn-primary btn-user btn-block" style="color: black">  Login ? </a></center>
                                </div>


                            </div>
                        </div>
                    </div>
                
    </div>
    <nav class="navbar fixed-bottom navbar-dark bg-dark">
        <label style="color:#ffffff;">&copy; Copyright Shabanet Technologies</label>
        <label style="color:#ffffff;">All Rights Reserved <?php echo date("Y")?> </label>
    </nav>
</body>

</html>