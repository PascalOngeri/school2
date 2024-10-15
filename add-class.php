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
$cname=$_POST['area'];
$username= $_SESSION['username'];
$sql="delete from classes where class=:area";
$query=$dbh->prepare($sql);
$query->bindParam(':area',$cname,PDO::PARAM_STR);
$query->execute();
$mess = "Deleted ".$cname." class succsesfully";
 $query=mysqli_query($con,"INSERT INTO logs( user , activities ) value('$username','$mess')");

 echo "<script>alert('Data deleted');</script>"; 
  echo "<script>window.location.href = 'add-class.php'</script>";     



  }
   if(isset($_POST['submit']))
  {
    $username= $_SESSION['username'];
 $cname=$_POST['cname'];
 $mess = "Added ".$cname." class succsesfully";
 $v=0;
$sql="insert into classes(class,fee,t1,t2,t3)values(:cname,:v,:v,:v,:v)";
$query=$dbh->prepare($sql);
$query->bindParam(':cname',$cname,PDO::PARAM_STR);
$query->bindParam(':v',$v,PDO::PARAM_STR);
$query->bindParam(':v',$v,PDO::PARAM_STR);
$query->bindParam(':v',$v,PDO::PARAM_STR);
$query->bindParam(':v',$v,PDO::PARAM_STR);
 $query->execute();
   $LastInsertId=$dbh->lastInsertId();
   if ($LastInsertId>0) {
   $query=mysqli_query($con,"INSERT INTO logs( user , activities ) value('$username','$mess')");

    echo '<script>alert("Class has been added.")</script>';
echo "<script>window.location.href ='add-class.php'</script>";
  }
  else
    {
         echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}
  ?>

     <?php include_once('includes/header.php');?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
      <?php include_once('includes/sidebar.php');?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Add Class </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> Add Class</li>
                </ol>
              </nav>
            </div>
            <div class="row">
          
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                   
                    <form class="forms-sample" method="post">
                      
                      <div class="form-group">
                        <label for="exampleInputName1">Class Name</label>
                        <input type="text" name="cname" value="" class="form-control" >
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
    <!-- plugins:js -->
   <?php }  ?>