<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include('dbconnection.php');
if (strlen($_SESSION['sturecmsaid']==0)) {
  header('location:logout.php');
  } else{
    if(isset($_POST['compdel']))
  {
// $cname=$_POST['class'];
//  $payname=$_POST['area'];
     $rid = intval($_GET['compdel']);
 $result = $con->query("SELECT amount,term1,term2,term3,form FROM feepay where id='$rid' ");
            while($row = $result->fetch_assoc()) {
                  $classs = $row['form'];
                    $amount = $row['amount'];
 $term1 = $row['term1'];
                    $term2 = $row['term2'];
                     $term3 = $row['term3'];
                   

         $query=mysqli_query($con,"update  classes SET fee = fee - $amount,t1=t1-$term1, t2=t2-$term2,t3=t3-$term3 where class='$classs'");
        $query=mysqli_query($con,"delete from feepay where form='$cname' && paymentname='$payname' ");
        echo '<script>alert("record  deleted")</script>';
        echo "<script>window.location.href='regfee.php'</script>";


    }

  }
     if(isset($_POST['compupdate']))
  {
$cname=$_POST['class'];
 $payname=$_POST['area'];
 $term1=$_POST['term1'];
 $term2=$_POST['term2'];
 $term3=$_POST['term3'];
 $amount=$term1+$term2+$term3;
 $sql="update feepay set amount=:amount,term1=:term1,term2=:term2,term3=:term3 where form=:class && paymentname=:area";
$query=$dbh->prepare($sql);
$query->bindParam(':amount',$amount,PDO::PARAM_STR);
$query->bindParam(':term1',$term1,PDO::PARAM_STR);
$query->bindParam(':term2',$term2,PDO::PARAM_STR);
$query->bindParam(':term3',$term3,PDO::PARAM_STR);
$query->bindParam(':class',$cname,PDO::PARAM_STR);
$query->bindParam(':area',$payname,PDO::PARAM_STR);
 $query->execute();
 
    echo '<script>alert("Updated succesfully.")</script>';
echo "<script>window.location.href ='regfee.php'</script>";
  


  }
   if(isset($_POST['submit']))
  {
 $cname=$_POST['class'];
 $payname=$_POST['payname'];
 $term1=$_POST['term1'];
 $term2=$_POST['term2'];
 $term3=$_POST['term3'];
 $amount=$term1+$term2+$term3;
$sql="insert into feepay(form,paymentname,term1,term2,term3,amount)values(:class,:payname,:term1,:term2,:term3,:amount)";
$query=$dbh->prepare($sql);
$query->bindParam(':class',$cname,PDO::PARAM_STR);
$query->bindParam(':payname',$payname,PDO::PARAM_STR);
$query->bindParam(':term1',$term1,PDO::PARAM_STR);
$query->bindParam(':term2',$term2,PDO::PARAM_STR);
$query->bindParam(':term3',$term3,PDO::PARAM_STR);
$query->bindParam(':amount',$amount,PDO::PARAM_STR);
 $query->execute();
   $LastInsertId=$dbh->lastInsertId();
  $sql="update classes set fee=fee+:amount,t1=t1+:term1,t2=t2+:term2,t3=t3+:term3 where class=:class";
$query=$dbh->prepare($sql);
$query->bindParam(':amount',$amount,PDO::PARAM_STR);
$query->bindParam(':term1',$term1,PDO::PARAM_STR);
$query->bindParam(':term2',$term2,PDO::PARAM_STR);
$query->bindParam(':term3',$term3,PDO::PARAM_STR);
$query->bindParam(':class',$cname,PDO::PARAM_STR);
 $query->execute();
   if ($LastInsertId>0) {
    echo '<script>alert("Updated succesfully.")</script>';
echo "<script>window.location.href ='regfee.php'</script>";
  }
  else
    {
         echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}
if(isset($_POST['otherupdate']))
  {
     $payname=$_POST['area'];

 $term1=$_POST['term1'];
 $term2=$_POST['term2'];
 $term3=$_POST['term3'];
 $amount=$term1+$term2+$term3;
$sql="update other set amount=:amount,t1=:term1,t2=:term2,t3=:term3 where type=:area ";
$query=$dbh->prepare($sql);
$query->bindParam(':amount',$amount,PDO::PARAM_STR);
$query->bindParam(':term1',$term1,PDO::PARAM_STR);
$query->bindParam(':term2',$term2,PDO::PARAM_STR);
$query->bindParam(':term3',$term3,PDO::PARAM_STR);

$query->bindParam(':area',$payname,PDO::PARAM_STR);
 $query->execute();
 
    echo '<script>alert("Updated succesfully.")</script>';
echo "<script>window.location.href ='regfee.php'</script>";
    }
    if(isset($_POST['otherdel'])){
 $payname=$_POST['area'];
$sql="delete from other where type=:otherdel ";
$query=$dbh->prepare($sql);

$query->bindParam(':otherdel',$payname,PDO::PARAM_STR);
$query->execute();
 echo "<script>alert('Data deleted');</script>"; 
  echo "<script>window.location.href = 'regfee.php'</script>";

    }
 if(isset($_POST['other'])){


 $payname=$_POST['payname'];

 $term1=$_POST['term1'];
 $term2=$_POST['term2'];
 $term3=$_POST['term3'];
 $amount=$term1+$term2+$term3;
$sql="insert into other(type,t1,t2,t3,amount)values(:payname,:term1,:term2,:term3,:amount)";
$query=$dbh->prepare($sql);

$query->bindParam(':payname',$payname,PDO::PARAM_STR);
$query->bindParam(':term1',$term1,PDO::PARAM_STR);
$query->bindParam(':term2',$term2,PDO::PARAM_STR);
$query->bindParam(':term3',$term3,PDO::PARAM_STR);
$query->bindParam(':amount',$amount,PDO::PARAM_STR);
 $query->execute();
   $LastInsertId=$dbh->lastInsertId();
   if ($LastInsertId>0) {
    echo '<script>alert("Updated succesfully..")</script>';
echo "<script>window.location.href ='regfee.php'</script>";
  }
  else
    {
         echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }


  }
  if(isset($_POST['bdel'])){
$payname=$_POST['area'];
$sql="delete from bus where area=:area";
$query=$dbh->prepare($sql);
$query->bindParam(':area',$payname,PDO::PARAM_STR);
$query->execute();
 echo "<script>alert('Data deleted');</script>"; 
  echo "<script>window.location.href = 'regfee.php'</script>";     


  }
  if(isset($_POST['bus'])){


 $payname=$_POST['payname'];
 $term1=$_POST['term1'];
 $term2=$_POST['term2'];
 $term3=$_POST['term3'];
 $amount=$term1+$term2+$term3;
$sql="insert into bus(area,t1,t2,t3,amount)values(:payname,:term1,:term2,:term3,:amount)";
$query=$dbh->prepare($sql);

$query->bindParam(':payname',$payname,PDO::PARAM_STR);
$query->bindParam(':term1',$term1,PDO::PARAM_STR);
$query->bindParam(':term2',$term2,PDO::PARAM_STR);
$query->bindParam(':term3',$term3,PDO::PARAM_STR);
$query->bindParam(':amount',$amount,PDO::PARAM_STR);
 $query->execute();

   $LastInsertId=$dbh->lastInsertId();

   if ($LastInsertId>0) {

    echo '<script>alert("Updated succesfully..")</script>';
echo "<script>window.location.href ='regfee.php'</script>";
  }
  else
    {
         echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }


  }
  if(isset($_POST['bupdate'])){
$payname=$_POST['area'];
 $term1=$_POST['term1'];
 $term2=$_POST['term2'];
 $term3=$_POST['term3'];
 $amount=$term1+$term2+$term3;
 
  $sql="update bus set amount=:amount,t1=:term1,t2=:term2,t3=:term3 where area=:payname";
$query=$dbh->prepare($sql);
$query->bindParam(':amount',$amount,PDO::PARAM_STR);
$query->bindParam(':term1',$term1,PDO::PARAM_STR);
$query->bindParam(':term2',$term2,PDO::PARAM_STR);
$query->bindParam(':term3',$term3,PDO::PARAM_STR);
$query->bindParam(':payname',$payname,PDO::PARAM_STR);
 $query->execute();
 
    echo '<script>alert("Updated succesfully.")</script>';
echo "<script>window.location.href ='regfee.php'</script>";
  
  

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
              <h3 class="page-title"> Set fee </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> Set fee</li>
                </ol>
              </nav>
            </div>
            <div class="row">
          
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                   <center> <label for="exampleInputEmail3">Compulsory payment</label></center> 
                    <form class="forms-sample" method="post">
                      
                     
                      <div class="form-group">
                        <label for="exampleInputEmail3">Select class/grade</label>
                        <select  name="class" class="form-control" required='true'>
                          <option value="">Select Class</option>
                         <?php 

$sql2 = "SELECT * from    classes ";
$query2 = $dbh -> prepare($sql2);
$query2->execute();
$result2=$query2->fetchAll(PDO::FETCH_OBJ);

foreach($result2 as $row1)
{          
    ?>  
<option value="<?php echo htmlentities($row1->class);?>"><?php echo htmlentities($row1->class);?></option>
 <?php } ?> 
                        </select>
                      </div>
                      
                       <div class="form-group">
                        <label for="exampleInputName1">Payment Name</label>
                        <input type="text" name="payname" placeholder="abcd...." class="form-control" >
                      </div>
                      <div class="form-group">
                       <label for="exampleInputName1">Term 1</label>
                        <input type="text" name="term1" value="0" class="form-control" >
                      </div>
                      <div class="form-group">
                       <label for="exampleInputName1">Term 2</label>
                        <input type="text" name="term2" value="0" class="form-control" >
                      </div>
                      <div class="form-group">
                       <label for="exampleInputName1">Term 3</label>
                        <input type="text" name="term3" value="0" class="form-control" >
                      </div>
                      
                      <button type="submit" class="btn btn-primary mr-2" name="submit">Save</button>
                      
                     <br>
                     <br>
                        <br>
                     <br>
                    </form>

<center><label for="exampleInputEmail3">OTHER PAYMENTS (optional)</label></center>
  
                     <form class="forms-sample" method="post">
                     
                    
                       <div class="form-group ">
                        <label for="exampleInputName1">Payment Name</label>
                        <input type="text" name="payname" value="" class="form-control" >
                      </div>
                      <div class="form-group">
                       <label for="exampleInputName1">Term 1</label>
                        <input type="text" name="term1" value="0" class="form-control" >
                      </div>
                      <div class="form-group">
                       <label for="exampleInputName1">Term 2</label>
                        <input type="text" name="term2" value="0" class="form-control" >
                      </div>
                      <div class="form-group">
                       <label for="exampleInputName1">Term 3</label>
                        <input type="text" name="term3" value="0" class="form-control" >
                      </div>
                      
                      <button type="submit" class="btn btn-primary mr-2" name="other">Save</button>
                     
                     <br><br>
                    </form>




                    <center><label for="exampleInputEmail3">Transportation fee(optional)</label></center>
  
                     <form class="forms-sample" method="post">
                      
                     
                    
                       
                     
                      
                      <br>

                      <div class="form-group ">
                        <label for="exampleInputName1">Add Area</label>
                        <input type="text" name="payname" value="" class="form-control" >
                      </div>
                      <div class="form-group">
                       <label for="exampleInputName1">Term 1</label>
                        <input type="text" name="term1" value="0" class="form-control" >
                      </div>
                      <div class="form-group">
                       <label for="exampleInputName1">Term 2</label>
                        <input type="text" name="term2" value="0" class="form-control" >
                      </div>
                      <div class="form-group">
                       <label for="exampleInputName1">Term 3</label>
                        <input type="text" name="term3" value="0" class="form-control" >
                      </div>
                      
                      <button type="submit" class="btn btn-primary mr-2" name="bus">Save</button>
                      
                     
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