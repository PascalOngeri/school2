<?php date_default_timezone_set("Etc/GMT+8");?>

<?php
 require_once'config.php';
if(ISSET($_POST['reg'])){

 $id= intval($_GET['editid']); 
   


 $payname = $_POST['gender'];
    $paymentno= $_POST['paymentno'];
   
   
  $sql = "UPDATE user SET payname = ?, paymentno = ? WHERE idno = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("sss", $payname, $paymentno, $id);


 if ($stmt->execute()) {
                   // echo "SMS sent successfully!";
                     echo '<script>alert("Registration succsessfull pay set up fee to proceed!")</script>';
        echo "<script>window.location.href='index.php'</script>";
                } else {
                   // echo "Error updating units: " . $stmt->error;
                    echo '<script>alert("Error ")</script>';
        echo "<script>window.location.href='reg.php'</script>";
                }

}
?>




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
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            
                   
                          
                                   
                            <div class="col-lg-6">

                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Payment details!!!</h1>
                                    </div>
                                    
                                    <form method="POST" class="user" >
                                        <div class="form-group">
                                             <h7 class="h4 text-gray-900 mb-4"> Account type</h7>
                                             <select name="gender" value="" class="form-control" required='true'>
                          <option value="">Choose Account type</option>
                          <option value="PAYBILL">PAYBILL</option>
                          <option value="TILL">TILL</option>
                           <option value="KCB">KCB</option>
                            <option value="EQUITY">EQUITY</option>
                        </select>
                                        </div>

                                        <div class="form-group">
                                             <h7 class="h4 text-gray-900 mb-4"> Paybill/Till/Acc No.</h7>
                                            <input type="text" class="form-control form-control-user" name="paymentno" placeholder="Enter acount/payment  number here..." required="required"  >
                                        </div>
                                      
                                        <button type="submit" class="btn btn-primary btn-user btn-block" name="reg">REGISTER</button>
                                        
                                    </form>

<br>
  <center><a href="reg1.php" style="color: red">  back ? </a></center>
  <br><br><br><br>
                                </div>


                            </div>
                        </div>
                    </div>
                
    </div>
    <nav class="navbar fixed-bottom navbar-dark bg-dark">
        <label style="color:#ffffff;">&copy; Copyright Shabanet Technologies</label>
        <label style="color:#ffffff;">All Rights Reserved <?php echo date("Y")?> </label>
    </nav>
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

</body>

</html>