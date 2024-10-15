<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
include('dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $fname = $_POST['fname'];
      $lname = $_POST['lname'];
        $dob = $_POST['dob'];
        $em = $_POST['stuemail'];
        $eid = $_POST['id'];
$am=$lname+$em+$dob;

        $sql = "UPDATE other SET type=:fname, t1=:lname, t2=:stuemail, t3=:dob,amount=:am WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        
        $query->bindParam(':lname', $lname, PDO::PARAM_STR);
        $query->bindParam(':stuemail', $em, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
         $query->bindParam(':am', $am, PDO::PARAM_STR);
        $query->bindParam(':id', $eid, PDO::PARAM_STR);
        $query->execute();
 
        echo '<script>alert("Payment has been updated")</script>';
         echo "<script>window.location.href='edelete.php'</script>";
    
    }
      // echo "<script>window.location.href='edelete.php'</script>";
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
              <h3 class="page-title"> Edit Other payment </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> Edit Optional payment</li>
                </ol>
              </nav>
            </div>
            <div class="row">
          
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Update optional Payment</h4>
                   
                    <form class="forms-sample" method="post" enctype="multipart/form-data" action="editO.php">
                      <?php
 $eid = $_GET['editid'];
$sql="SELECT t1, t2, t3, amount,id,type From other where id=:eid";
$query = $dbh -> prepare($sql);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
   <input type="text" name="id" value="<?php  echo htmlentities($row->id);?>" class="form-control" hidden="true" >
                      <div class="form-group">
                        <label for="exampleInputName1">Payment Type</label>
                        <input type="text" name="fname" value="<?php  echo htmlentities($row->type);?>" class="form-control" required='true'>
                      </div>
                      
                       <div class="form-group">
                        <label for="exampleInputName1">Term 1</label>
                        <input type="text" name="lname" value="<?php  echo htmlentities($row->t1);?>" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Term 2</label>
                        <input type="text" name="stuemail" value="<?php  echo htmlentities($row->t2);?>" class="form-control" required='true'>
                      </div>
                      
                     
                      <div class="form-group">
                        <label for="exampleInputName1">Term 3</label>
                        <input type="text" name="dob" value="<?php  echo htmlentities($row->t3);?>" class="form-control" required='true'>
                      </div>
                     
                      
                      
                      </div><?php $cnt=$cnt+1;}} ?>
                      <button type="submit" class="btn btn-primary mr-2" name="submit">Update</button>
                     
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