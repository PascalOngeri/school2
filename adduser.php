<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include('dbconnection.php');
if (strlen($_SESSION['sturecmsaid']==0)) {
  header('location:logout.php');
  } else{
     if(isset($_POST['del']))
  {
    $username=$_POST['username'];

    $sql="delete from tbladmin where UserName=:username";
$query=$dbh->prepare($sql);
$query->bindParam(':username',$username,PDO::PARAM_STR);
$query->execute();
 $u= $_SESSION['username'];
 //$cname=$_POST['cname'];
 $mess = "Deleted  ".$username." from accessing the system";
    $query=mysqli_query($con,"INSERT INTO logs( user , activities ) value('$u','$mess')");

 echo "<script>alert('Data deleted');</script>"; 
  echo "<script>window.location.href = 'adduser.php'</script>";     

  }
    if(isset($_POST['submit']))
  {
    
    $AName=$_POST['adminname'];
  $mobno=$_POST['mobilenumber'];
  $email=$_POST['email'];
  
   $pass=$_POST['password'];
$username=$_POST['username'];
  $sql="insert into tbladmin(AdminName,Email,UserName,password,MobileNumber)values(:adminname,:email,:username,:password,:mobilenumber)";
     $query = $dbh->prepare($sql);
     $query->bindParam(':adminname',$AName,PDO::PARAM_STR);
     $query->bindParam(':email',$email,PDO::PARAM_STR);
        $query->bindParam(':username',$username,PDO::PARAM_STR);
         
     $query->bindParam(':password',$pass,PDO::PARAM_STR);
     $query->bindParam(':mobilenumber',$mobno,PDO::PARAM_STR);
$query->execute();
 $u= $_SESSION['username'];
 //$cname=$_POST['cname'];
 $mess = "Added  ".$username." As system user";
    $query=mysqli_query($con,"INSERT INTO logs( user , activities ) value('$u','$mess')");

    echo '<script>alert("Request Completed")</script>';
    echo "<script>window.location.href ='adduser.php'</script>";

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
              <h3 class="page-title"> Manage Users </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Add Users</li>
                </ol>
              </nav>
            </div>
            <div class="row">
          
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Add Users</h4>
                   
                    <form class="forms-sample" method="post">
                     
                      <div class="form-group">
                        <label for="exampleInputName1">Admin Name</label>
                        <input type="text" name="adminname" value="" class="form-control" >
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail3">User Name</label>
                        <input type="text" name="username" value="" class="form-control" >
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword4">Contact Number</label>
                        <input type="text" name="mobilenumber" value=""  class="form-control" maxlength='10' pattern="[0-9]+">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputCity1">Email</label>
                         <input type="email" name="email" value="" class="form-control" >
                      </div>
                      <div class="form-group">
                        <label for="exampleInputCity1">Password</label>
                         <input type="Password" name="password" value="" class="form-control" >
                      </div>
                      
                      <button type="submit" class="btn btn-primary mr-2" name="submit">Add</button>
                      <!-- <button type="submit" class="btn btn-primary mr-2" name="del">Delete By username</button>-->
                       <button type="submit" class="btn btn-primary mr-2" name="del" style="background-color: red; border-color: red;">Delete By username</button>

                     
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
      </div><!--  Orginal Author Name: Mayuri.K. 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mdkhairnar92@gmail.com  
 Visit website : https://mayurik.com --> 
      <!-- page-body-wrapper ends -->
   
  <?php }  ?>