<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include('dbconnection.php');

$selectQuery = "SELECT name,icon FROM api ";
    $result = mysqli_query($con, $selectQuery);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
     $_SESSION['name'] = $row['name'];
        
      $_SESSION['icon'] = $row['icon'];
    } 

if (strlen($_SESSION['sturecmsaid']==0)) {
  header('location:logout.php');
  } else{
   
      
   if (isset($_POST['send'])) {
        $api = $_POST['apikey'];
        $part = $_POST['partnerid'];
        $name = $_POST['name'];
$icon=basename($_FILES["image"]["name"]);
        // Image upload handling
        $targetDir = "assets/images/"; // Directory where you want to store uploaded images
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            echo '<script>alert("File is not an image.");</script>';
            $uploadOk = 0;
        }

        // Check file size (max 5MB)
        if ($_FILES["image"]["size"] > 5000000) { // Adjust as needed
            echo '<script>alert("Sorry, your file is too large.");</script>';
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($imageFileType, $allowedTypes)) {
            echo '<script>alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");</script>';
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo '<script>alert("Sorry, your file was not uploaded.");</script>';
        } else {
            // Attempt to upload file
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                // Update database with uploaded file name
                $query = mysqli_query($con, "UPDATE api SET apikey='$api', partnerid='$part', name='$name', icon='$targetFile',iname='$icon'");

                if ($query) {
                   // echo '<script>alert("Updated successfully");</script>';
                    echo  $targetFile;
                  //  echo "<script>window.location.href='setting.php'</script>";
                } else {
                    echo '<script>alert("Failed to update");</script>';
                }
            } else {
                echo '<script>alert("Sorry, there was an error uploading your file.");</script>';
            }
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
              <h3 class="page-title"> Message Setting </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> Settings</li>
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                   <!-- <label for="exampleInputName1">Obtain Api key by login in or signing up to shabanetsms Kenya</label> -->
                     <!--  <a for="exampleInputName1" href="https://shabanetsms.kesug.com">By clicking this link : https://shabanetsms.kesug.com</a> -->
                    <form class="forms-sample" method="post" enctype="multipart/form-data">
                      
                      <div class="form-group">
                          <?php 

$sql2 = "SELECT * from    api ";
$query2 = $dbh -> prepare($sql2);
$query2->execute();
$result2=$query2->fetchAll(PDO::FETCH_OBJ);

foreach($result2 as $row1)
{          
    ?>  
     <label for="exampleInputName1">Enter Api Key</label>
                        <input type="text" name="apikey" value="<?php echo htmlentities($row1->apikey);?>" class="form-control" placeholder="Enter api key" >
                      </div>
                       <div class="form-group">
                        <label for="exampleInputName1"><body>Enter partner Id</body></label>
                        <input type="text" name="partnerid" value="<?php echo htmlentities($row1->partnerid);?>" class="form-control"placeholder="Enter partnerid" >

 <?php } ?> 
    

                        
                 
                        
                      </div>
                      <div class="form-group">
        <label for="" class="control-label">System Logo</label>
        <div class="custom-file">
                <input type="file" class="custom-file-input rounded-circle" id="customFile" name="image" onchange="displayImg(this,$(this))">
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
      </div>
      <div class="form-group d-flex justify-content-center">
       <img src="<?php echo $row1->icon;?>" alt="" id="cimg" class="img-fluid img-thumbnail">
      </div>
      <div class="form-group">
          <label for="name" class="control-label">School Name</label>
          <input type="text" class="form-control form-control-sm" name="name" id="name" value="<?php echo htmlentities($row1->name); ?>">
        </div>
                     
                      <button type="submit" class="btn btn-primary mr-2" name="send">Update</button>
                     

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
    <script>
  function displayImg(input,_this) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#cimg').attr('src', e.target.result);
            _this.siblings('.custom-file-label').html(input.files[0].name)
          }

          reader.readAsDataURL(input.files[0]);
      }
  }
  function displayImg2(input,_this) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            _this.siblings('.custom-file-label').html(input.files[0].name)
            $('#cimg2').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
  }
  function displayImg3(input,_this) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            _this.siblings('.custom-file-label').html(input.files[0].name)
            $('#cimg3').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
  }
  $(document).ready(function(){
     $('.summernote').summernote({
            height: 200,
            toolbar: [
                [ 'style', [ 'style' ] ],
                [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
                [ 'fontname', [ 'fontname' ] ],
                [ 'fontsize', [ 'fontsize' ] ],
                [ 'color', [ 'color' ] ],
                [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
                [ 'table', [ 'table' ] ],
                [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
            ]
        })
  })
</script>
    <!-- container-scroller -->
    <!-- plugins:js -->


<?php } ?>