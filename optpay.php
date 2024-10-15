<?php session_start();
//error_reporting(0);
include('dbconnection.php');
 if (strlen($_SESSION['sturecmsaid']==0)) {
  header('location:logout.php');
  } else{

  	if(isset($_POST['oder'])){

 $adm = $_POST['adm'];
  
      //  $bus = $_POST['bus'];
        $type = $_POST['other'];
         $term = $_POST['oderterm'];

$result = $con->query("SELECT amount,t1,t2,t3 ,type FROM other where id='$type'");
            while($row = $result->fetch_assoc()) {
            	 $amount = $row['amount'];
            	    $t1 = $row['t1'];
            	     $t2 = $row['t2'];
            	    $t3 = $row['t3'];
            	      $paymenttype = $row['type'];

$amounthalf = $amount;
            	    $t1half =  $t1;
            	     $t2half =  $t2;
            	    $t3half =   $t3;


if($term=="ot1"){
	$query=mysqli_query($con,"INSERT INTO otherpayment( payname  ,term,amount,adm ) value('$paymenttype','term1','$t1','$adm')");


   $query=mysqli_query($con,"update  registration SET fee = fee + $t1 where adm='$adm'");
        

        echo '<script>alert("record  Updated")</script>';
      echo "<script>window.location.href='optionalpay.php'</script>";




  }

if($term=="ot2"){
		//$query=mysqli_query($con,"INSERT INTO otherpayment( payname,t1, t2, t3, amount ) value('$paymenttype','$t1','0','0','$t1')");
	$query=mysqli_query($con,"INSERT INTO otherpayment( payname  ,term,amount,adm ) value('$paymenttype','term2','$t2','$adm')");

   $query=mysqli_query($con,"update  registration SET fee = fee + $t2 where adm='$adm'");
        echo '<script>alert("record  Updated")</script>';
      echo "<script>window.location.href='optionalpay.php'</script>";




  }
  if($term=="ot3"){
  		$query=mysqli_query($con,"INSERT INTO otherpayment( payname  ,term,amount,adm ) value('$paymenttype','term3','$t3','$adm')");

   $query=mysqli_query($con,"update  registration SET fee = fee + $t3 where adm='$adm'");
        echo '<script>alert("record  Updated")</script>';
       echo "<script>window.location.href='optionalpay.php'</script>";




  }
$am=$t1+$t2;
 if($term=="ot1t2"){
 		$query=mysqli_query($con,"INSERT INTO otherpayment( payname  ,term,amount,adm ) value('$paymenttype','term1 & term2','$am','$adm')");

   $query=mysqli_query($con,"update  registration SET fee = fee + $t1 + $t2 where adm='$adm'");
        echo '<script>alert("record  Updated")</script>';
        echo "<script>window.location.href='optionalpay.php'</script>";




  }

 if($term=="owhole"){
 	 		$query=mysqli_query($con,"INSERT INTO otherpayment( payname  ,term,amount,adm ) value('$paymenttype','whole year','$amount','$adm')");

   $query=mysqli_query($con,"update  registration SET fee = fee + $amount where adm='$adm'");
        echo '<script>alert("record  Updated")</script>';
       echo "<script>window.location.href='optionalpay.php'</script>";




  }





            	}



  	}
	if(isset($_POST['submit'])){
	
    $adm = $_POST['adm'];
  
        $bus = $_POST['bus'];
        $term = $_POST['busp'];
         $area = $_POST['area'];
      if($bus=="Morning" || $bus=="Evening"){

 $result = $con->query("SELECT amount,t1,t2,t3 FROM bus where id='$area'");
            while($row = $result->fetch_assoc()) {
            	 $amount = $row['amount'];
            	    $t1 = $row['t1'];
            	     $t2 = $row['t2'];
            	    $t3 = $row['t3'];


  $term = $_POST['busp'];
   $adm = $_POST['adm'];
    $amounthalf = $amount/2;
            	    $t1half =   $t1 /2;
            	     $t2half = $t2/2;
            	    $t3half =   $t3 /2;

  if($term=="bt1"){
  	 	 		$query=mysqli_query($con,"INSERT INTO otherpayment( payname  ,term,amount,adm ) value('TRANSPORTATION','term 1 .$bus','$t1half','$adm')");

   $query=mysqli_query($con,"update  registration SET fee = fee + $t1half where adm='$adm'");
        echo '<script>alert("record  Updated")</script>';
        echo "<script>window.location.href='optionalpay.php'</script>";




  }
   if($term=="bt2"){
   	  	 	 		$query=mysqli_query($con,"INSERT INTO otherpayment( payname  ,term,amount,adm ) value('TRANSPORTATION','term 2 .$bus','$t2half','$adm')");

   $query=mysqli_query($con,"update  registration SET fee = fee + $t2half where adm='$adm'");
        echo '<script>alert("record  Updated")</script>';
        echo "<script>window.location.href='optionalpay.php'</script>";




  }
           
            if($term=="bt3"){
            	  	 	 		$query=mysqli_query($con,"INSERT INTO otherpayment( payname  ,term,amount,adm ) value('TRANSPORTATION','term 3 .$bus','$t3half','$adm')");

   $query=mysqli_query($con,"update  registration SET fee = fee + $t3half where adm='$adm'");
        echo '<script>alert("record  Updated")</script>';
        echo "<script>window.location.href='optionalpay.php'</script>";

  }
  $am=$t1half+$t2half;
    if($term=="bt1t2"){
    	  	 	 		$query=mysqli_query($con,"INSERT INTO otherpayment( payname  ,term,amount,adm ) value('TRANSPORTATION','term 1 & 2 .$bus',' $am','$adm')");

   $query=mysqli_query($con,"update  registration SET fee = fee + $t1half+$t2half where adm='$adm'");
        echo '<script>alert("record  Updated")</script>';
        echo "<script>window.location.href='optionalpay.php'</script>";

  }
  if($term=="bwhole"){
  	    	  	 	 		$query=mysqli_query($con,"INSERT INTO otherpayment( payname  ,term,amount,adm ) value('TRANSPORTATION','whole year .$bus',' $amounthalf','$adm')");

   $query=mysqli_query($con,"update  registration SET fee = fee + $amounthalf where adm='$adm'");
        echo '<script>alert("record  Updated")</script>';
        echo "<script>window.location.href='optionalpay.php'</script>";

  }
               



            }


      }
      if($bus=="Morning and evening" ){

 $result = $con->query("SELECT amount,t1,t2,t3 FROM bus where id='$area'");
            while($row = $result->fetch_assoc()) {
            	 $amount = $row['amount'];
            	    $t1 = $row['t1'];
            	     $t2 = $row['t2'];
            	    $t3 = $row['t3'];


  $term = $_POST['busp'];
   $adm = $_POST['adm'];
   

  if($term=="bt1"){
  	  	    	  	 	 		$query=mysqli_query($con,"INSERT INTO otherpayment( payname  ,term,amount,adm ) value('TRANSPORTATION','term1 morning &evening',' $t1','$adm')");

   $query=mysqli_query($con,"update  registration SET fee = fee + $t1 where adm='$adm'");
        echo '<script>alert("record  Updated")</script>';
        echo "<script>window.location.href='optionalpay.php'</script>";




  }
   if($term=="bt2"){
   	  	  	    	  	 	 		$query=mysqli_query($con,"INSERT INTO otherpayment( payname  ,term,amount,adm ) value('TRANSPORTATION','term2 morning &evening',' $t2','$adm')");

   $query=mysqli_query($con,"update  registration SET fee = fee + $t2 where adm='$adm'");
        echo '<script>alert("record  Updated")</script>';
        echo "<script>window.location.href='optionalpay.php'</script>";




  }
           
            if($term=="bt3"){
            	  	  	    	  	 	 		$query=mysqli_query($con,"INSERT INTO otherpayment( payname  ,term,amount,adm ) value('TRANSPORTATION','term3 morning &evening',' $t3','$adm')");

   $query=mysqli_query($con,"update  registration SET fee = fee + $t3 where adm='$adm'");
        echo '<script>alert("record  Updated")</script>';
        echo "<script>window.location.href='optionalpay.php'</script>";

  }
  $as=$t1+$t2;
    if($term=="bt1t2"){
    	  	  	    	  	 	 		$query=mysqli_query($con,"INSERT INTO otherpayment( payname  ,term,amount,adm ) value('TRANSPORTATION','term 1 & term2 morning &evening',' $as','$adm')");

   $query=mysqli_query($con,"update  registration SET fee = fee + $t1+$t2 where adm='$adm'");
        echo '<script>alert("record  Updated")</script>';
        echo "<script>window.location.href='optionalpay.php'</script>";

  }
  if($term=="bwhole"){
  	    	  	  	    	  	 	 		$query=mysqli_query($con,"INSERT INTO otherpayment( payname  ,term,amount,adm ) value('TRANSPORTATION','whole year morning &evening',' $amount','$adm')");

   $query=mysqli_query($con,"update  registration SET fee = fee + $amount where adm='$adm'");
        echo '<script>alert("record  Updated")</script>';
        echo "<script>window.location.href='optionalpay.php'</script>";

  }
               



            }


      }





          
}
	}

?>
