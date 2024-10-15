 
<?php
session_start();


include('dbconnection.php');
 if(isset($_POST['submit'])) {
    // Collect form data
     $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $adm = $_POST['stuid'];
    $email = $_POST['stuemail'];
    $class = $_POST['stuclass'];
    $phone = $_POST['connum'];
    $phone1 = $_POST['altconnum'];
    $address = $_POST['address'];
    $username = $_POST['uname'];
    $faname = $_POST['faname'];
    $maname = $_POST['maname'];
    $password = $_POST['password'];
    $image = $_FILES["image"]["name"];
    

 $verificationCode = rand(100000, 999999);
            $result = $con->query("SELECT class,fee FROM classes where id='$class'");
            while($row = $result->fetch_assoc()) {
                $classs = $row['class'];
                  $fees = $row['fee'];
             
$query=mysqli_query($con,"INSERT INTO registration( adm,fname, mname, lname, gender, faname,maname,class,phone,phone1,address,email,fee,t1,t2,t3,dob,image,username,password
                    ) value('$adm', '$fname', '$mname', '$lname', '$gender', '$faname', '$maname', '$classs', '$phone', '$phone1', '$address', '$email', '$fees', '0','0','0', '$dob','$image',$username','$password')");
$query=mysqli_query($con,"INSERT INTO parent( adm,username, password, phone, email ) value('$adm','$gname','$verificationCode','$phone','$email')");


 // $apiUrl = "https://shabanetsms.kesug.com/send.php"; 
 //        $apiKey = "e625fda005add40efa7d4f67751aed96";
 //        $partnerid = "9452";
 //          $shortcode = "TextSMS";
 //          $curl = curl_init();
 //        curl_setopt_array($curl, array(
 //            CURLOPT_URL => $apiUrl,
 //            CURLOPT_RETURNTRANSFER => true,
 //            CURLOPT_POST => true,
 //            CURLOPT_POSTFIELDS => array(
 //                "apikey" => $apiKey,
 //                "partnerid" => $partnerid,
 //                "message" => "Elfema Academy Primary School         Hi ".$gname. "  ".$fname." ".$mname." ".$lname."  Has been admitted to  grade/class ".$class ."              You will use this link to access fee receipt and report forms https://shabanetsms.kesug.com/parentlog.php       Username : ".$gname. "     and password: ".$verificationCode. "         Thank you!!!",
 //                "shortcode" => $shortcode,
 //                "mobile" => $phone
 //            )
 //        ));

 //        $response['success'] = false; 
 //        $responseCurl = curl_exec($curl);
 //        $err = curl_error($curl);



if($query){
echo '<script>alert(" Registration successfull")</script>';
echo "<script>window.location.href='add-students.php'</script>";
} 

else{
echo '<script>alert("Something went wrong. Please try again")</script>';
echo "<script>window.location.href='add-students.php'</script>";
}
}
  
}
 ?>