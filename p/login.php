<?php
	require_once'config.php';
	session_start();

	if(ISSET($_POST['reg'])){
	  $fullname = $_POST['fullname'];
    $email= $_POST['email'];
    $phone = $_POST['phone'];
    $id = $_POST['idno'];
    $kra = $_POST['kra'];
    $username = $_POST['username'];

    $password1 = $_POST['password1'];
      $password =$_POST['password']; // User-supplied password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);


  // $verificationCode = rand(100000, 999999);
	 // $publicapi="ISpublic_Api_Key".$verificationCode.".shabanet"
if ($password !== $password1) {
        echo '<script>alert("Passwords do not match")</script>';
        echo "<script>window.location.href='add-students.php'</script>";
        exit(); // Stop further execution
    }

 if (empty($fullname) || empty($email) || empty($phone) || empty($id) || empty($kra) || empty($username) || empty($password) || empty($password1)) {
        echo '<script>alert("Please fill in all fields")</script>';
        echo "<script>window.location.href='reg.php'</script>";
        exit(); // Stop further execution
    }
function generateRandomCode($length = 16) {
    // Define the characters you want to include in the random string
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';

    // Loop through and select a random character from the $characters string
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}
function gen($length = 16) {
    // Define the characters you want to include in the random string
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';

    // Loop through and select a random character from the $characters string
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

// Generate the random code
$randomCode = generateRandomCode();
$ran = gen();
$publicapi="ISpublic_Api_Key".$randomCode.".shabanet";


	 // $ve = rand(100000, 999999);
	  $token="ISSecrete_Token_Key".$ran.".shabanet";
	 

    $sql = "SELECT id FROM user WHERE email = '$email'  ";
                    $result = $con->query($sql);
                $sql = "SELECT id FROM user WHERE phone = '$phone'  ";
                    $rt = $con->query($sql);  

                     $sql = "SELECT id FROM user WHERE username = '$username'  ";
                    $res = $con->query($sql);

                    if ($result->num_rows > 0) {
                    
                         echo '<script>alert(" Email already registered.")</script>';
                        echo "<script>window.location.href='reg.php'</script>";
        exit(); 
                    }
                     if ($res->num_rows > 0) {
                        
                                                   echo '<script>alert(" Username already taken try another one.")</script>';

                        echo "<script>window.location.href='reg.php'</script>";
        exit(); 
                        }
                         if ($rt->num_rows > 0) {
                      
                           echo '<script>alert(" Phone Number already Exist in our system.")</script>';
                        echo "<script>window.location.href='reg.php'</script>";
        exit(); 
                        }
                        else{
 $query=mysqli_query($con,"INSERT INTO user( fullname,email, phone, idno, kra,username,password,token,publicapi,nationality,phone2,image,bname ,bal,paymentno,payname,devapi,subscription,very) value('$fullname','$email','$phone','$id','$kra','$username','$hashed_password','$token','$publicapi',0,0,'gfgfsrt','abc',0,0,0,0,0,0)");

if($query){
echo '<script>alert(" Proceed to the next page")</script>';
echo "<script>window.location.href='reg1.php?editid=$id'</script>";
} 

else{

echo '<script>alert("Something went wrong. Please try again")</script>';
echo "<script>window.location.href='reg.php'</script>";
}
}
	}
?>