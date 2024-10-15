<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include('dbconnection.php');

if (strlen($_SESSION['sturecmsaid']==0)) {
  header('location:logout.php');
  } else{
   if(isset($_POST['submit']))
  {
  $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $adm = $_POST['stuid'];
        $email = $_POST['stuemail'];
        $class = $_POST['class'];
        $phone = $_POST['connum'];
        $phone1 = $_POST['altconnum'];
        $address = $_POST['address'];
        $username = $_POST['uname'];
        $faname = $_POST['faname'];
        $maname = $_POST['maname'];
        $password = $_POST['password'];
     //   $image = $_FILES["image"]["name"];
 $eid=$_GET['editid'];
 
$sql="update registration set adm=:stuid,fname=:fname,mname=:mname,lname=:lname,gender=:gender,faname=:faname,maname=:maname,class=:stuclass,phone=:connum,phone1=:altconnum,address=:address,email=:stuemail,username=:uname,password=:password,dob=:dob where id=:editid";
                $query->bindParam(':stuid', $adm, PDO::PARAM_STR);
                $query->bindParam(':fname', $fname, PDO::PARAM_STR);
                $query->bindParam(':mname', $mname, PDO::PARAM_STR);
                $query->bindParam(':lname', $lname, PDO::PARAM_STR);
                $query->bindParam(':gender', $gender, PDO::PARAM_STR);
                $query->bindParam(':faname', $faname, PDO::PARAM_STR);
                $query->bindParam(':maname', $maname, PDO::PARAM_STR);
                $query->bindParam(':stuclass', $class, PDO::PARAM_STR);
                $query->bindParam(':connum', $phone, PDO::PARAM_STR);
                $query->bindParam(':altconnum', $phone1, PDO::PARAM_STR);
                $query->bindParam(':address', $address, PDO::PARAM_STR);
                $query->bindParam(':stuemail', $email, PDO::PARAM_STR);
             
               
               
                $query->bindParam(':uname', $username, PDO::PARAM_STR);
                $query->bindParam(':password', $password, PDO::PARAM_STR);
                 $query->bindParam(':dob', $dob, PDO::PARAM_STR);
$query->bindParam(':editid',$eid,PDO::PARAM_STR);
 $query->execute();
  echo '<script>alert("Student has been updated")</script>';
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
              <h3 class="page-title"> Update Students </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> Update Students</li>
                </ol>
              </nav>
            </div>
            <div class="row">
          
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Update Students</h4>
                   
                    <form class="forms-sample" method="post" enctype="multipart/form-data" action="edit.php">
                      <?php
$eid=$_GET['editid'];
$sql="SELECT adm, fname, mname, lname, gender, faname, maname, class, phone, phone1, address, email, fee, t1, t2, t3, dob, image, username, password From registration where id=:eid";
$query = $dbh -> prepare($sql);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                      <div class="form-group">
                        <label for="exampleInputName1">First Name</label>
                        <input type="text" name="fname" value="<?php  echo htmlentities($row->fname);?>" class="form-control" required='true'>
                      </div>
                       <div class="form-group">
                        <label for="exampleInputName1">Middle Name</label>
                        <input type="text" name="mname" value="<?php  echo htmlentities($row->mname);?>" class="form-control" required='true'>
                      </div>
                       <div class="form-group">
                        <label for="exampleInputName1">Last Name</label>
                        <input type="text" name="lname" value="<?php  echo htmlentities($row->lname);?>" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Student Email</label>
                        <input type="text" name="stuemail" value="<?php  echo htmlentities($row->email);?>" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail3">Student Class</label>
                        <select  name="class" class="form-control" required='true'>
                          <option value="<?php  echo htmlentities($row->class);?>"><?php  echo htmlentities($row->class);?> </option>
                         <?php 

$sql2 = "SELECT * from    classes ";
$query2 = $dbh -> prepare($sql2);
$query2->execute();
$result2=$query2->fetchAll(PDO::FETCH_OBJ);

foreach($result2 as $row1)
{          
    ?>  
<option value="<?php echo htmlentities($row1->class);?>"><?php echo htmlentities($row1->class);?> </option>
 <?php } ?> 
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Gender</label>
                        <select name="gender" value="" class="form-control" required='true'>
                          <option value="<?php  echo htmlentities($row->gender);?>"><?php  echo htmlentities($row->gender);?></option>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Date of Birth</label>
                        <input type="date" name="dob" value="<?php  echo htmlentities($row->dob);?>" class="form-control" required='true'>
                      </div>
                     
                      <div class="form-group">
                        <label for="exampleInputName1">Admission Number</label>
                        <input type="text" name="stuid" value="<?php  echo htmlentities($row->adm);?>" class="form-control" readonly='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Student Photo</label>
                        <img src="assets/images/<?php echo $row->image;?>" width="100" height="100" value="<?php  echo $row->image;?>"><a href="changeimage.php?editid=<?php //echo $row->adm;?>"> &nbsp; Edit Image</a>
                      </div>
                      <h3>Parents/Guardian's details</h3>
                      <div class="form-group">
                        <label for="exampleInputName1">Father's Name</label>
                        <input type="text" name="faname" value="<?php  echo htmlentities($row->faname);?>" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Mother's Name</label>
                        <input type="text" name="maname" value="<?php  echo htmlentities($row->maname);?>" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Contact Number</label>
                        <input type="text" name="connum" value="<?php  echo htmlentities($row->phone);?>" class="form-control" required='true' maxlength="10" pattern="[0-9]+">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Alternate Contact Number</label>
                        <input type="text" name="altconnum" value="<?php  echo htmlentities($row->phone1);?>" class="form-control" required='true' maxlength="10" pattern="[0-9]+">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Address</label>
                        <textarea name="address" class="form-control" required='true'><?php  echo htmlentities($row->address);?></textarea>
                      </div>
<h3>Login details</h3>
<div class="form-group">
                        <label for="exampleInputName1">User Name</label>
                        <input type="text" name="uname" value="<?php  echo htmlentities($row->username);?>" class="form-control" >
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Password</label>
                        <input type="Password" name="password" value="<?php  echo htmlentities($row->password);?>" class="form-control" >
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
   
    <!-- container-scroller -->
   <?php }  ?>