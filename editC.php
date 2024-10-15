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
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $dob = $_POST['dob'];
        $em = $_POST['stuemail'];
        $eid = $_POST['id'];
$am=$lname+$em+$dob;
 $result = $con->query("SELECT amount,term1,term2,term3,form FROM feepay where id='$eid' ");
            while($row = $result->fetch_assoc()) {
                  $classs = $row['form'];
                    $amount = $row['amount'];
 $term1 = $row['term1'];
                    $term2 = $row['term2'];
                     $term3 = $row['term3'];

                 $query=mysqli_query($con,"update  classes SET fee = fee - $amount,t1=t1-$term1, t2=t2-$term2,t3=t3-$term3 where class='$classs'"); 
                    
        $sql = "UPDATE feepay SET paymentname=:fname, form=:mname, term1=:lname, term2=:stuemail, term3=:dob,amount=:am WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':mname', $mname, PDO::PARAM_STR);
        $query->bindParam(':lname', $lname, PDO::PARAM_STR);
        $query->bindParam(':stuemail', $em, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
         $query->bindParam(':am', $am, PDO::PARAM_STR);
        $query->bindParam(':id', $eid, PDO::PARAM_STR);
        $query->execute();
 $query=mysqli_query($con,"update  classes SET fee = fee + $am,t1=t1+$lname, t2=t2+$em,t3=t3+$dob where class='$classs'"); 
        echo '<script>alert("Payment has been updated")</script>';
          echo "<script>window.location.href='edelete.php'</script>";
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
              <h3 class="page-title"> Edit payment </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> Edit Compulsory payment</li>
                </ol>
              </nav>
            </div>
            <div class="row">
          
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Update Payment</h4>
                   
                    <form class="forms-sample" method="post" enctype="multipart/form-data" action="editC.php">
                      <?php
 $eid = $_GET['editid'];
$sql="SELECT term1, term2, term3, amount, paymentname,form,id From feepay where id=:eid";
$query = $dbh -> prepare($sql);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
   <input type="text" name="id" value="<?php  echo htmlentities($row->id);?>" class="form-control" >
                      <div class="form-group">
                        <label for="exampleInputName1">Payment name</label>
                        <input type="text" name="fname" value="<?php  echo htmlentities($row->paymentname);?>" class="form-control" required='true'>
                      </div>
                       <div class="form-group">
                        <label for="exampleInputName1">Form/class/grade</label>
                        <input type="text" name="mname" value="<?php  echo htmlentities($row->form);?>" class="form-control" required='true'>
                      </div>
                       <div class="form-group">
                        <label for="exampleInputName1">Term 1</label>
                        <input type="text" name="lname" value="<?php  echo htmlentities($row->term1);?>" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Term 2</label>
                        <input type="text" name="stuemail" value="<?php  echo htmlentities($row->term2);?>" class="form-control" required='true'>
                      </div>
                      
                     
                      <div class="form-group">
                        <label for="exampleInputName1">Term 3</label>
                        <input type="text" name="dob" value="<?php  echo htmlentities($row->term3);?>" class="form-control" required='true'>
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