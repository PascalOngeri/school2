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
 $cname=$_POST['adm'];

$amount=$_POST['amount'];

$sql="update tblstudent set fee = fee- :amount where stuID=:adm";
$query=$dbh->prepare($sql);
$query->bindParam(':amount',$amount,PDO::PARAM_STR);
$query->bindParam(':adm',$cname,PDO::PARAM_STR);

 $query->execute();

$sql="insert into payment( adm,amount,bal)values(:adm,:amount,:v,:v,:v)";
$query=$dbh->prepare($sql);
$query->bindParam(':cname',$cname,PDO::PARAM_STR);
$query->bindParam(':v',$v,PDO::PARAM_STR);
$query->bindParam(':v',$v,PDO::PARAM_STR);
$query->bindParam(':v',$v,PDO::PARAM_STR);
$query->bindParam(':v',$v,PDO::PARAM_STR);
 $query->execute();


 
    echo '<script>alert("Updated succesfully.")</script>';
echo "<script>window.location.href ='payfee.php'</script>";
  
}




  if(isset($_POST['fee'])){
    // Set the content type as a downloadable PDF file
    header('Content-Type: application/pdf');
    // Set the file name
    header('Content-Disposition: attachment; filename="feestructure.pdf"');

    // Include the necessary files for creating a PDF
    require('fpdf/fpdf.php');

    // Create a new PDF document
    $pdf = new FPDF();
    $pdf->AddPage();

    // Set the font and font size for the document
    $pdf->SetFont('Arial', 'B', 14);

    // Add the logo to the document
    $pdf->Image('assets/images/logo.png', $pdf->GetPageWidth()/2 - 25, 10, 50, 0, 'PNG');


$class = $_POST['genclass'];
    // Write the title of the document
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 50, '', 0, 1, 'C');
    $pdf->Cell(0, 10, 'ELFEMA ACADEMY', 0, 1, 'C');
    $pdf->Cell(0, 10, $class . ' FEE STRUCTURE', 0, 1, 'C');

    // Set the font and font size for the table headers
    $pdf->SetFont('Arial', 'B', 12);

    // Write the headers of the table
    $pdf->Cell(15, 10, 'S.NO', 1);
    $pdf->Cell(38, 10, 'PAYMENT NAME', 1);
    $pdf->Cell(38, 10, 'TERM 1 AMOUNT', 1);
    $pdf->Cell(38, 10, 'TERM 2 AMOUNT', 1);
    $pdf->Cell(38, 10, 'TERM 3 AMOUNT', 1);
    $pdf->Cell(30, 10, 'TOTAL', 1);
     $pdf->Ln();
 

    // Query to get the school details
    $sql = "SELECT * FROM feepay where form ='$class'";
    $result = mysqli_query($con, $sql);

    // Set the font and font size for the table rows
    $pdf->SetFont('Arial', '', 10);

    // Loop through the results and write them to the table
    if (mysqli_num_rows($result) > 0) {
     //    $sn = 1;
    while ($row = mysqli_fetch_assoc($result)) {
       
        $pdf->Cell(15, 10, $row['id'],  1);
        $pdf->Cell(38, 10, $row['paymentname'], 1);
        $pdf->Cell(38, 10, $row['term1'], 1);
        $pdf->Cell(38, 10, $row['term2'], 1);
         $pdf->Cell(38, 10, $row['term3'], 1);
          $pdf->Cell(30, 10, $row['amount'], 1);
        $pdf->Ln();

    }

    }
    
            // Fetch classes from the database
           
            $result = $con->query("SELECT t1,t2,t3,fee FROM classes Where class='$class'");
            while($row = $result->fetch_assoc()) {
                 $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(15, 10, '',  1);
        $pdf->Cell(38, 10, ' TOTAL ', 1);
        $pdf->Cell(38, 10, $row['t1'].'.00', 1);
        $pdf->Cell(38, 10, $row['t2'].'.00', 1);
         $pdf->Cell(38, 10, $row['t3'].'.00', 1);
          $pdf->Cell(30, 10, $row['fee'].'.00/ksh', 1);
          $pdf->Ln();
            }
            $pdf->Cell(0, 10,  '   ', 0, 1, 'Ck');
          //$pdf->Cell(0, 10, 'ELFEMA ACADEMY', 0, 1, 'C');
    $pdf->Cell(0, 10,  ' Optional payment', 0, 1, 'Ck');

    // Set the font and font size for the table headers
    $pdf->SetFont('Arial', 'B', 12);

    // Write the headers of the table
    $pdf->Cell(15, 10, 'S.NO', 1);
    $pdf->Cell(38, 10, 'PAYMENT NAME', 1);
    $pdf->Cell(38, 10, 'TERM 1 AMOUNT', 1);
    $pdf->Cell(38, 10, 'TERM 2 AMOUNT', 1);
    $pdf->Cell(38, 10, 'TERM 3 AMOUNT', 1);
    $pdf->Cell(30, 10, 'TOTAL', 1);
     $pdf->Ln();
 

    // Query to get the school details
    $sql = "SELECT * FROM other ";
    $result = mysqli_query($con, $sql);

    // Set the font and font size for the table rows
    $pdf->SetFont('Arial', '', 10);

    // Loop through the results and write them to the table
    if (mysqli_num_rows($result) > 0) {
     //    $sn = 1;
    while ($row = mysqli_fetch_assoc($result)) {
       
        $pdf->Cell(15, 10, $row['id'],  1);
        $pdf->Cell(38, 10, $row['type'], 1);
        $pdf->Cell(38, 10, $row['t1'], 1);
        $pdf->Cell(38, 10, $row['t2'], 1);
         $pdf->Cell(38, 10, $row['t2'], 1);
          $pdf->Cell(30, 10, $row['amount'], 1);
        $pdf->Ln();

    }

    }
    
     $pdf->Cell(0, 10,  ' Transportation fee', 0, 1, 'Ck');

    // Set the font and font size for the table headers
    $pdf->SetFont('Arial', 'B', 12);

    // Write the headers of the table
    $pdf->Cell(15, 10, 'S.NO', 1);
    $pdf->Cell(38, 10, 'Area NAME', 1);
    $pdf->Cell(38, 10, 'TERM 1 AMOUNT', 1);
    $pdf->Cell(38, 10, 'TERM 2 AMOUNT', 1);
    $pdf->Cell(38, 10, 'TERM 3 AMOUNT', 1);
    $pdf->Cell(30, 10, 'TOTAL', 1);
     $pdf->Ln();
 

    // Query to get the school details
    $sql = "SELECT * FROM bus ";
    $result = mysqli_query($con, $sql);

    // Set the font and font size for the table rows
    $pdf->SetFont('Arial', '', 10);

    // Loop through the results and write them to the table
    if (mysqli_num_rows($result) > 0) {
     //    $sn = 1;
    while ($row = mysqli_fetch_assoc($result)) {
       
        $pdf->Cell(15, 10, $row['id'],  1);
        $pdf->Cell(38, 10, $row['area'], 1);
        $pdf->Cell(38, 10, $row['t1'], 1);
        $pdf->Cell(38, 10, $row['t2'], 1);
         $pdf->Cell(38, 10, $row['t3'], 1);
          $pdf->Cell(30, 10,  $row['t1']+ $row['t2']+ $row['t3'], 1);
        $pdf->Ln();

    }

    }
    
            // Fetch classes from the database
           
          
          
        
     
    
 
    // Close the database connection and output the PDF


    // Close the database connection and output the PDF
    mysqli_close($con);
    $pdf->Output('D', 'fee stucture.pdf');

        // header('location: ./reports.php');
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
              <h3 class="page-title"> Pay fee</h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> Pay fee</li>
                </ol>
              </nav>
            </div>
            <div class="row">
          
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                   
                    <form class="forms-sample" method="post" action="payphp.php">
                      
                      <div class="form-group">
                        <label for="exampleInputName1">Admission Number</label>
                        <input type="text" name="adm" value="" class="form-control" >
                      </div>
                        <div class="form-group">
                        <label for="exampleInputName1">Amount </label>
                        <input type="text" name="ammount" value="0.00" class="form-control" > 
                      </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary mr-2" name="payfee">Pay cash</button>
                    </div> or <div class="form-group"><button type="submit" class="btn btn-primary mr-2" name="pay">mpesa pay</button></div>
      <div class="form-group">
                     <button type="submit" class="btn btn-primary mr-2" name="generate">Download my fee statement</button>
                     <br>
                   </div>
                       <button type="submit" class="btn btn-primary mr-2" name="download">Download my fee Structure</button>
                    </form>
                    <form>
                       
                    </form>

                  </div>
                </div>
              </div>
            </div>
             <div class="row">
          
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                   
                    <form  method="POST" action="payphp.php" >
                      
                     
                       <center><h1 style="text-decoration: line-below; color: black">Generate Fee structure</h1></center>  
                    
     
            
          
            <div class="col-lg-4">
            <select class="form-control" name="genclass"  >
        <option VALUE=""> SELECT CLASS </option>
          <?php
            // Fetch classes from the database
           
            $result = $con->query("SELECT id,class FROM classes");
            while($row = $result->fetch_assoc()) {
                echo "<option VALUE='".$row['class']."'>".$row['class']."</option>";
            }


        
            ?>
        
        
       </select>
            </div>  
            <div class="form-group">
   
            <button class="btn btn-primary" name="generatefee" > GENERATE FEE STRUCTURE</button>
        <br>
        <br>
                    <center>  <h3 style="text-decoration: line-below; color: black">Recently paid fee</h3></center>

                       </form>
                   <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>SNo</th>
                                                <th>RegNo</th>
                                                <th>Date</th>
                                                <th>Amount Received</th>
                                                <th>Balance</th>
                                                 <th>PAYMENT TYPE</th>
                                                 <th>MPESA/PAY REF</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                           
  
                                            $query = mysqli_query($con, "SELECT * FROM payment  order by id desc");
                                            $sn = 1;
                                            while ($res = mysqli_fetch_array($query)) {
                                            ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $sn; ?></td>
                                                <td><?php echo htmlentities(strtoupper($res['adm'])); ?></td>
                                                <td><?php echo htmlentities(strtoupper($res['date'] )); ?></td>
                                                <td><?php echo htmlentities(strtoupper($res['amount'])); ?></td>
                                                <td><?php echo htmlentities($res['bal']); ?></td>
                                               <td><?php echo htmlentities($res['paytype']); ?></td>
                                                      <td><?php echo htmlentities($res['reference']); ?></td>
                                                <td width="100">
                                                   
                                                    &nbsp;&nbsp;
                                                    <a href="payfee.php?del=<?php echo htmlentities($res['id']); ?>" class="btn btn-danger btn-xs" onclick="return confirm('Do you really want to delete?');">Delete</a>
                                                </td>
                                            </tr>
                                            <?php 
                                                $sn++;
                                           } 

                                       

                                            ?>    
                                        </tbody>
                                    </table>
                  
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