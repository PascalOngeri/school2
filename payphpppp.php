<?php session_start();
error_reporting(0);
include('dbconnection.php');
 if(isset($_POST['payfee'])){
    
    $adm = $_POST['adm'];
        $ammount = $_POST['ammount'];
       
 
            $result = $con->query("SELECT fee,phone FROM registration where adm='$adm'");
            while($row = $result->fetch_assoc()) {
                  $feebal = $row['fee'];
                    $phone_number = $row['phone'];
                    $bal = $feebal - $ammount;
                    $sql = "UPDATE registration SET fee =  ? WHERE adm = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ii", $bal, $adm);

            if ($stmt->execute()) {
 $username= $_SESSION['username'];
 //$cname=$_POST['cname'];
 $mess = "recorded ".$ammount." payment of school fees for  admission number ".$adm. "  succsesfully . fee balance is ".$bal;
    $query=mysqli_query($con,"INSERT INTO logs( user , activities ) value('$username','$mess')");

               $query=mysqli_query($con,"INSERT INTO payment( adm,amount,bal
                    ) value('$adm','$ammount','$bal')");

       
        $apiUrl = "http://shabanetsms.kesug.com/send.php"; 
        $apiKey = "e625fda005add40efa7d4f67751aed96";
        $partnerid = "9452";
          $shortcode = "TextSMS";
          $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => array(
                "apikey" => $apiKey,
                "partnerid" => $partnerid,
                "message" => $_SESSION['name']." ".$ammount ."/Ksh    Has been Received  for Admission number  ". $adm. "     Your Fee balance is  ".$bal. "      Thank you!!!!",
                "shortcode" => $shortcode,
                "mobile" => $phone_number
            )
        ));

        $response['success'] = false; 
        $responseCurl = curl_exec($curl);
        $err = curl_error($curl);
        echo '<script>alert("fee updated successfully!")</script>';
        echo "<script>window.location.href='payfee.php'</script>";
         
}}

}


    if(isset($_POST['pay'])){
    
    $adm = $_POST['adm'];
        $ammount = $_POST['ammount'];
       
 
            $result = $con->query("SELECT fee,phone FROM registration where adm='$adm'");
            while($row = $result->fetch_assoc()) {
                  $feebal = $row['fee'];
                    $phone_number = $row['phone'];
                    $bal = $feebal - $ammount;
                $apiurl = "https://infinityschools.xyz/p/api.php";

    // Data ya usajili
    $data = array(
        "publicApi" => "ISpublic_Api_Keysitq2v5mutip95ra.shabanet", // partner id 
        "Token" => "ISSecrete_Token_Keya8x3xi4z32959rt1.shabanet",//
        "Phone" => $phone_number, // phone number
        "username" => "Pascal Ongeri", // username
        "password" => "2222", // password
        "Amount" => $ammount  // amount
    );

    // Badilisha data kuwa JSON
    $data_json = json_encode($data);

    // Anzisha cURL session
    $ch = curl_init($apiurl);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);

    // Tuma ombi
    $response = curl_exec($ch);

    // Angalia makosa
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
        exit; // Kuacha kuendelea ikiwa kuna makosa
    }

    // Funga cURL session
    curl_close($ch);
 if (strpos($response, 'success: Payment received Successful') !== false) {
        // Jibu ni la mafanikio, sasa tunachakata agizo
   $sql = "UPDATE registration SET fee =  ? WHERE adm = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ii", $bal, $adm);

            if ($stmt->execute()) {
 $username= $_SESSION['username'];
 //$cname=$_POST['cname'];
 $mess = "recorded ".$ammount." payment of school fees for  admission number ".$adm. "  succsesfully . fee balance is ".$bal;
    $query=mysqli_query($con,"INSERT INTO logs( user , activities ) value('$username','$mess')");

               $query=mysqli_query($con,"INSERT INTO payment( adm,amount,bal
                    ) value('$adm','$ammount','$bal')");
 echo '<script>alert("fee updated successfully!")</script>';
       echo "<script>window.location.href='pd.php'</script>";
  exit();
}
else {
   
  
        echo '<script>alert("FAILED !  Payment has not been received")</script>';
        echo "<script>window.location.href='payfee.php'</script>";
     exit();
    }



}
else{
    echo '<script>alert("FAILED !  Payment has not been received")</script>';
     echo "<script>window.location.href='payfee.php'</script>";
     
 exit();
}
}
}
 if (isset($_POST['receipt'])) {
    // Set the content type as a downloadable PDF file
    header('Content-Type: application/pdf');
    // Set the file name
    header('Content-Disposition: attachment; filename="course_details.pdf"');

    // Include the necessary files for creating a PDF
    require('fpdf/fpdf.php');

    // Create a new PDF document
    $pdf = new FPDF();
    $pdf->AddPage();

    // Set the font and font size for the document
    $pdf->SetFont('Arial', 'B', 14);

    // Add the logo to the document
    $pdf->Image($_SESSION['icon'], $pdf->GetPageWidth()/2 - 25, 10, 50, 0, 'PNG');
 $adm = $_POST['adm'];
        $ammount = $_POST['ammount'];
    // Write the title of the document
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 50, '', 0, 1, 'C');
    $pdf->Cell(0, 10, $_SESSION['name'], 0, 1, 'C');
    $pdf->Cell(0, 10, 'Admission number  '.$adm.' FEE RECEIPT', 0, 1, 'C');

    // Set the font and font size for the table headers
    $pdf->SetFont('Arial', 'B', 12);

    // Write the headers of the table
   
    $pdf->Cell(38, 10, 'Date', 1);
    $pdf->Cell(38, 10, 'Amount', 1);
    $pdf->Cell(38, 10, 'Balance', 1);
     $pdf->Cell(38, 10, 'Status', 1);
     $pdf->Ln();

 
    // Query to get the school details
    $sql = "SELECT fee FROM registration   Where adm='$adm' ";
    $result = mysqli_query($con, $sql);

    // Set the font and font size for the table rows
    $pdf->SetFont('Arial', '', 10);

    // Loop through the results and write them to the table
    if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
          $pdf->Cell(40, 10, 'today', 1);
        $pdf->Cell(38, 10, $ammount, 1);
        
        $pdf->Cell(38, 10, $row['fee'], 1);
          $pdf->Cell(39, 10, 'received', 1);
        $pdf->Ln();
    }
    }

    // Close the database connection and output the PDF
    mysqli_close($con);
    $pdf->Output('D', 'my statement.pdf');
             //   echo "Units updated successfully!";
            } 


    
 if (isset($_POST['generate'])) {
    // Set the content type as a downloadable PDF file
    header('Content-Type: application/pdf');
    // Set the file name
    header('Content-Disposition: attachment; filename="course_details.pdf"');

    // Include the necessary files for creating a PDF
    require('fpdf/fpdf.php');

    // Create a new PDF document
    $pdf = new FPDF();
    $pdf->AddPage();

    // Set the font and font size for the document
    $pdf->SetFont('Arial', 'B', 14);

    // Add the logo to the document
    $pdf->Image($_SESSION['icon'], $pdf->GetPageWidth()/2 - 25, 10, 50, 0, 'PNG');
$adm= $_POST['adm'];
    // Write the title of the document
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 50, '', 0, 1, 'C');
    $pdf->Cell(0, 10, $_SESSION['name'], 0, 1, 'C');
    $pdf->Cell(0, 10, 'Admission number  '.$adm.' FEE STATEMENT', 0, 1, 'C');

    // Set the font and font size for the table headers
    $pdf->SetFont('Arial', 'B', 12);

    // Write the headers of the table
    $pdf->Cell(40, 10, 'Payment no.', 1);
    $pdf->Cell(38, 10, 'Date', 1);
    $pdf->Cell(38, 10, 'Amount', 1);
    $pdf->Cell(38, 10, 'Balance', 1);
     $pdf->Cell(38, 10, 'Status', 1);
     $pdf->Ln();

 
    // Query to get the school details
    $sql = "SELECT * FROM payment   Where adm='$adm' order by id asc ";
    $result = mysqli_query($con, $sql);

    // Set the font and font size for the table rows
    $pdf->SetFont('Arial', '', 10);

    // Loop through the results and write them to the table
    if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
          $pdf->Cell(40, 10, $row['id'], 1);
        $pdf->Cell(38, 10, $row['date'], 1);
        $pdf->Cell(38, 10, $row['amount'], 1);
        $pdf->Cell(38, 10, $row['bal'], 1);
          $pdf->Cell(39, 10, 'received', 1);
        $pdf->Ln();
    }
    }

    // Close the database connection and output the PDF
    mysqli_close($con);
    $pdf->Output('D', 'my statement.pdf');

        // header('location: ./reports.php');
}
 if (isset($_POST['receipt'])) {
    // Set the content type as a downloadable PDF file
    header('Content-Type: application/pdf');
    // Set the file name
    header('Content-Disposition: attachment; filename="course_details.pdf"');

    // Include the necessary files for creating a PDF
    require('fpdf/fpdf.php');

    // Create a new PDF document
    $pdf = new FPDF();
    $pdf->AddPage();

    // Set the font and font size for the document
    $pdf->SetFont('Arial', 'B', 14);

    // Add the logo to the document
    $pdf->Image($_SESSION['icon'], $pdf->GetPageWidth()/2 - 25, 10, 50, 0, 'PNG');
 $adm = $_POST['adm'];
        

    // Write the title of the document
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 50, '', 0, 1, 'C');
    $pdf->Cell(0, 10, 'infinty', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Admission number  '.$adm.' FEE RECEIPT', 0, 1, 'C');

    // Set the font and font size for the table headers
    $pdf->SetFont('Arial', 'B', 12);

    // Write the headers of the table
   
    $pdf->Cell(38, 10, 'Date', 1);
    $pdf->Cell(38, 10, 'Amount', 1);
    $pdf->Cell(38, 10, 'Balance', 1);
     $pdf->Cell(38, 10, 'Status', 1);
     $pdf->Ln();

 
    // Query to get the school details
    $sql = "SELECT fee FROM registration   Where adm='$adm' ";
    $result = mysqli_query($con, $sql);

    // Set the font and font size for the table rows
    $pdf->SetFont('Arial', '', 10);

    // Loop through the results and write them to the table
    if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $ammount = $_POST['ammount'];
          $pdf->Cell(40, 10, 'today', 1);
        $pdf->Cell(38, 10, $ammount, 1);
        
        $pdf->Cell(38, 10, $row['fee'], 1);
          $pdf->Cell(39, 10, 'received', 1);
        $pdf->Ln();
    }
    }

    // Close the database connection and output the PDF
    mysqli_close($con);
    $pdf->Output('D', 'my statement.pdf');

        // header('location: ./reports.php');
}

        // header('location: ./reports.php');

    if(isset($_POST['download'])){
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
    $pdf->Image($_SESSION['icon'], $pdf->GetPageWidth()/2 - 25, 10, 50, 0, 'PNG');
$adm = $_POST['adm'];
 $sql = "SELECT * FROM registration where adm ='$adm'";
    $result = mysqli_query($con, $sql);

    // Set the font and font size for the table rows
    $pdf->SetFont('Arial', '', 10);

    // Loop through the results and write them to the table
    if (mysqli_num_rows($result) > 0) {
     //    $sn = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $fname = $row['fname'].$row['mname'].$row['lname'];
         $class = $row['class'];
    // Write the title of the document
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 50, '', 0, 1, 'C');
    $pdf->Cell(0, 10, $_SESSION['name'], 0, 1, 'C');
    $pdf->Cell(0, 10, $fname . ' FEE STRUCTURE', 0, 1, 'C');

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
          
        
   
      $pdf->Cell(0, 10, 'Other payments(optional)', 0, 1, );
     $pdf->Cell(15, 10, 'S.NO', 1);
    $pdf->Cell(50, 10, 'PAYMENT NAME', 1);
    $pdf->Cell(82, 10, 'Description', 1);
    $pdf->Cell(50, 10, 'Amount', 1);
   
     $pdf->Ln();
 

    // Query to get the school details
    $sql = "SELECT * FROM otherpayment where adm=$adm ";
    $result = mysqli_query($con, $sql);

    // Set the font and font size for the table rows
    $pdf->SetFont('Arial', '', 10);

    // Loop through the results and write them to the table
    if (mysqli_num_rows($result) > 0) {
     //    $sn = 1;
    while ($row = mysqli_fetch_assoc($result)) {
       
        $pdf->Cell(15, 10, $row['id'],  1);
        $pdf->Cell(50, 10, $row['payname'], 1);
        $pdf->Cell(82, 10, $row['term'], 1);
        $pdf->Cell(50, 10, $row['amount'], 1);
        

        $pdf->Ln();
         
          
       //   SELECT SUM(marks) FROM coursesdone WHERE adm
    }
       $sql = "SELECT (SELECT SUM(amount)  FROM otherpayment where adm ='$adm') AS total ";
    $result = mysqli_query($con, $sql);

    // Set the font and font size for the table rows
    $pdf->SetFont('Arial', '', 10);

    // Loop through the results and write them to the table
    if (mysqli_num_rows($result) > 0) {
     //    $sn = 1;
    while ($row = mysqli_fetch_assoc($result)) {
       // $class = $row['sum'];
     $pdf->Cell(15, 10, 'Total', 1);
          $pdf->Cell(50, 10, '', 1);
           $pdf->Cell(82, 10, '', 1);
            $pdf->Cell(50, 10,    $row['total'], 1);





$other= $row['total'];


 $pdf->Cell(0, 50, '', 0, 1, 'Cgk');
      $pdf->Cell(0, 10, 'Grant Total', 0, 1, 'Cgk');
     $pdf->Cell(30, 10, 'Term 1', 1);
    $pdf->Cell(35, 10, 'Term 2', 1);
    $pdf->Cell(82, 10, 'Term 3', 1);
    $pdf->Cell(50, 10, 'Total', 1);
   
     $pdf->Ln();

   $result = $con->query("SELECT t1,t2,t3,fee FROM classes Where class='$class'");
            while($row = $result->fetch_assoc()) {
  $fee=$row['fee'];
$tot=$fee+$other;
$toth=$tot/3;$pdf->SetFont('Arial', 'B', 12);


                 $pdf->Cell(30, 10, $toth, 1);
    $pdf->Cell(35, 10, $toth, 1);
    $pdf->Cell(82, 10, $toth, 1);
    $pdf->Cell(50, 10, $tot.'.00/ksh', 1);
   


            }










 }
 }
 }
 }
}
    // Close the database connection and output the PDF


    // Close the database connection and output the PDF
    mysqli_close($con);
    $pdf->Output('D', 'fee stucture.pdf');

        // header('location: ./reports.php');
}



    if (isset($_POST['generatefee'])) {
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
        $pdf->Image($_SESSION['icon'], $pdf->GetPageWidth() / 2 - 25, 10, 50, 0, 'PNG');

        $class = $_POST['genclass'];

        // Write the title of the document
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 50, '', 0, 1, 'C');
        $pdf->Cell(0, 10, $_SESSION['name'], 0, 1, 'C');
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
        $sql = "SELECT * FROM feepay WHERE form = '$class'";
        $result = mysqli_query($con, $sql);

        // Set the font and font size for the table rows
        $pdf->SetFont('Arial', '', 10);

        // Loop through the results and write them to the table
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $pdf->Cell(15, 10, $row['id'], 1);
                $pdf->Cell(38, 10, $row['paymentname'], 1);
                $pdf->Cell(38, 10, $row['term1'], 1);
                $pdf->Cell(38, 10, $row['term2'], 1);
                $pdf->Cell(38, 10, $row['term3'], 1);
                $pdf->Cell(30, 10, $row['amount'], 1);
                $pdf->Ln();
            }
        }

        // Fetch classes from the database
        $result = $con->query("SELECT t1, t2, t3, fee FROM classes WHERE class = '$class'");
        while ($row = $result->fetch_assoc()) {
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(15, 10, '', 1);
            $pdf->Cell(38, 10, 'TOTAL', 1);
            $pdf->Cell(38, 10, $row['t1'] . '.00', 1);
            $pdf->Cell(38, 10, $row['t2'] . '.00', 1);
            $pdf->Cell(38, 10, $row['t3'] . '.00', 1);
            $pdf->Cell(30, 10, $row['fee'] . '.00/ksh', 1);
            $pdf->Ln();
        }

        $pdf->Cell(0, 10, 'Optional Payment', 0, 1, 'C');

        // Write the headers of the table for optional payments
        $pdf->Cell(15, 10, 'S.NO', 1);
        $pdf->Cell(38, 10, 'PAYMENT NAME', 1);
        $pdf->Cell(38, 10, 'TERM 1 AMOUNT', 1);
        $pdf->Cell(38, 10, 'TERM 2 AMOUNT', 1);
        $pdf->Cell(38, 10, 'TERM 3 AMOUNT', 1);
        $pdf->Cell(30, 10, 'TOTAL', 1);
        $pdf->Ln();

        // Query to get the optional payment details
        $sql = "SELECT * FROM other";
        $result = mysqli_query($con, $sql);

        // Loop through the results and write them to the table
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $pdf->Cell(15, 10, $row['id'], 1);
                $pdf->Cell(38, 10, $row['type'], 1);
                $pdf->Cell(38, 10, $row['t1'], 1);
                $pdf->Cell(38, 10, $row['t2'], 1);
                $pdf->Cell(38, 10, $row['t3'], 1);
                $pdf->Cell(30, 10, $row['amount'], 1);
                $pdf->Ln();
            }
        }

        $pdf->Cell(0, 10, 'Transportation Fee', 0, 1, 'C');

        // Write the headers of the table for transportation fees
        $pdf->Cell(15, 10, 'S.NO', 1);
        $pdf->Cell(38, 10, 'AREA NAME', 1);
        $pdf->Cell(38, 10, 'TERM 1 AMOUNT', 1);
        $pdf->Cell(38, 10, 'TERM 2 AMOUNT', 1);
        $pdf->Cell(38, 10, 'TERM 3 AMOUNT', 1);
        $pdf->Cell(30, 10, 'TOTAL', 1);
        $pdf->Ln();

        // Query to get the transportation fee details
        $sql = "SELECT * FROM bus";
        $result = mysqli_query($con, $sql);

        // Loop through the results and write them to the table
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $pdf->Cell(15, 10, $row['id'], 1);
                $pdf->Cell(38, 10, $row['area'], 1);
                $pdf->Cell(38, 10, $row['t1'], 1);
                $pdf->Cell(38, 10, $row['t2'], 1);
                $pdf->Cell(38, 10, $row['t3'], 1);
                $pdf->Cell(30, 10, $row['t1'] + $row['t2'] + $row['t3'], 1);
                $pdf->Ln();
            }
        }

        // Close the database connection and output the PDF
        mysqli_close($con);
        $pdf->Output('D', 'feestructure.pdf');
    }
?>


