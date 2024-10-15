<?php
session_start();
error_reporting(0);
include('dbconnection.php');
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid']==0)) {
  header('location:logout.php');
  } else{
    if(isset($_POST['del']))
  {
$cname=$_POST['area'];
$sql="delete from classes where class=:area";
$query=$dbh->prepare($sql);
$query->bindParam(':area',$cname,PDO::PARAM_STR);
$query->execute();
 echo "<script>alert('Data deleted');</script>"; 
  echo "<script>window.location.href = 'add-class.php'</script>";     



  }
   if(isset($_POST['submit']))
  {
 $cname=$_POST['cname'];
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
              <h3 class="page-title"> Assign optional payments </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> optional payments</li>
                </ol>
              </nav>
            </div>
            <div class="row">
          
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                   
                    <form class="forms-sample" method="post" action="optpay.php">
                      
                      <div class="form-group">
                        <label for="exampleInputName1">Enter Admission Number</label>
                        <input type="text" name="adm" value="" class="form-control" >
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail3">Select Payment</label>
                        <select  name="other" class="form-control" >
                          <option value="">Select Payment</option>
                         <?php 

$sql2 = "SELECT * from    other ";
$query2 = $dbh -> prepare($sql2);
$query2->execute();
$result2=$query2->fetchAll(PDO::FETCH_OBJ);

foreach($result2 as $row1)
{          
    ?>  
<option value="<?php echo htmlentities($row1->id);?>"><?php echo htmlentities($row1->type);?></option>
 <?php } ?> 
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail3">Select Period</label>
                        <select  name="oderterm" class="form-control" >
                          <option value="">Select Term</option>
                           <option value="ot1">Term 1</option>
                            <option value="ot2">Term 2</option>
                             <option value="ot3">Term 3</option>
                              <option value="ot1t2">Term 1 & Term 2</option>
                              <option value="owhole">Whole year</option>
                        
                        </select>
                      </div>
                      <button type="submit" class="btn btn-primary mr-2" name="oder">Add</button>
                      <button type="submit" class="btn btn-primary mr-2" name="del">Delete</button>
                     <br><br>

                    </form>
                    <center> <label for="exampleInputName1">Transportation payments</label></center>
                     <form class="forms-sample" method="post" action="optpay.php">
                      
                      <div class="form-group">
                        <label for="exampleInputName1">Enter Admission Number</label>
                        <input type="text" name="adm" value="" class="form-control" >
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail3">Select Area</label>
                        <select  name="area" class="form-control" >
                          <option value="">Select Area</option>
                         <?php 

$sql2 = "SELECT * from    bus ";
$query2 = $dbh -> prepare($sql2);
$query2->execute();
$result2=$query2->fetchAll(PDO::FETCH_OBJ);

foreach($result2 as $row1)
{          
    ?>  
<option value="<?php echo htmlentities($row1->id);?>"><?php echo htmlentities($row1->area);?></option>
 <?php } ?> 
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail3">Select Period</label>
                        <select  name="busp" class="form-control" >
                          <option value="">Select period</option>
                           <option value="bt1">Term 1</option>
                            <option value="bt2">Term 2</option>
                             <option value="bt3">Term 3</option>
                              <option value="bt1t2">Term 1 & Term 2</option>
                              <option value="bwhole">Whole year</option>
                        
                        </select>
                      </div>

                       
                      <div class="form-group">
                        <label for="exampleInputEmail3">Select Time of the day</label>
                        <select  name="bus" class="form-control" >
                          <option value="">Select</option>
                           <option value="Morning">Morning</option>
                            <option value="Evening">Evening</option>
                             <option value="Morning and evening">Morning & Evening</option>
                             
                        
                        </select>
                      </div>
                      <button type="submit" class="btn btn-primary mr-2" name="submit">Add</button>
                      <button type="submit" class="btn btn-primary mr-2" name="removebus">Delete</button>
                     

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