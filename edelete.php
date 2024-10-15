<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include('dbconnection.php');

if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {
     if(isset($_GET['otherdel'])){
  $f = intval($_GET['otherdel']);
$query=mysqli_query($con,"delete from other where id='$f' ");
        echo '<script>alert("record  deleted")</script>';
        echo "<script>window.location.href='edelete.php'</script>";


    }
     if(isset($_GET['bdel'])){
  $f = intval($_GET['bdel']);
$query=mysqli_query($con,"delete from bus where id='$f' ");
        echo '<script>alert("record  deleted")</script>';
        echo "<script>window.location.href='edelete.php'</script>";


    }
    // Code for deletion
    if (isset($_GET['delid'])) {
        $rid = intval($_GET['delid']);
 //       $cname=$_POST['class'];
 // $payname=$_POST['area'];
    
 $result = $con->query("SELECT amount,term1,term2,term3,form FROM feepay where id='$rid' ");
            while($row = $result->fetch_assoc()) {
                  $classs = $row['form'];
                    $amount = $row['amount'];
 $term1 = $row['term1'];
                    $term2 = $row['term2'];
                     $term3 = $row['term3'];
                   

         $query=mysqli_query($con,"update  classes SET fee = fee - $amount,t1=t1-$term1, t2=t2-$term2,t3=t3-$term3 where class='$classs'");
        $query=mysqli_query($con,"delete from feepay where id='$rid' ");
        echo '<script>alert("record  deleted")</script>';
        echo "<script>window.location.href='edelete.php'</script>";


    }
    }


   if (isset($_GET['update'])) {


   }
?>

<!-- partial:partials/_navbar.html -->
<?php include_once('includes/header.php'); ?>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_sidebar.html -->
    <?php include_once('includes/sidebar.php'); ?>
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title">Update Payment</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Update Payment</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-sm-flex align-items-center mb-4">
                                <h4 class="card-title mb-sm-0">compulsory fee payents</h4>
                                <a href="#" class="text-dark ml-auto mb-3 mb-sm-0">compulsory payments</a>
                            </div>
                            <div class="table-responsive border rounded p-1">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            
                                            <th class="font-weight-bold">Paymentname</th>
                                            <th class="font-weight-bold">Form/Class/Grade</th>
                                            <th class="font-weight-bold">Term1</th>
                                            <th class="font-weight-bold">Term2</th>
                                            <th class="font-weight-bold">Term3</th>
                                            <th class="font-weight-bold">Total</th>
                                            <th class="font-weight-bold">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['pageno'])) {
                                            $pageno = $_GET['pageno'];
                                        } else {
                                            $pageno = 1;
                                        }
                                        // Formula for pagination
                                        $no_of_records_per_page = 7;
                                        $offset = ($pageno - 1) * $no_of_records_per_page;

                                        $ret = "SELECT id FROM feepay";
                                        $query1 = $dbh->prepare($ret);
                                        $query1->execute();
                                        $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                        $total_rows = $query1->rowCount();
                                        $total_pages = ceil($total_rows / $no_of_records_per_page);

                                        $sql = "SELECT id, paymentname, form, term1,term2,term3, amount FROM feepay LIMIT $offset, $no_of_records_per_page";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $row) {
                                        ?>   
                                        <tr>
                                           
                                            
                                            <td><?php echo htmlentities($row->paymentname); ?></td>
                                            <td><?php echo htmlentities($row->form); ?> </td>

                                            <td><?php echo htmlentities($row->term1); ?></td>
                                            <td><?php echo htmlentities($row->term2); ?></td>
                                            <td><?php echo htmlentities($row->term3); ?></td>
                                            <td><?php echo htmlentities($row->amount); ?></td>
                                            <td>
                                                <a href="editC.php?editid=<?php echo htmlentities($row->id); ?>" class="btn btn-primary btn-sm"><i class="icon-eye"></i></a>
                                                <a href="edelete.php?delid=<?php echo htmlentities($row->id); ?>" onclick="return confirm('Do you really want to delete?');" class="btn btn-danger btn-sm"><i class="icon-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php $cnt = $cnt + 1; } } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div align="left">
                                <ul class="pagination">
                                    <li><a href="?pageno=1"><strong>First</strong></a></li>
                                    <li class="<?php if ($pageno <= 1) { echo 'disabled'; } ?>">
                                        <a href="<?php if ($pageno <= 1) { echo '#'; } else { echo "?pageno=" . ($pageno - 1); } ?>"><strong style="padding-left: 10px">Prev</strong></a>
                                    </li>
                                    <li class="<?php if ($pageno >= $total_pages) { echo 'disabled'; } ?>">
                                        <a href="<?php if ($pageno >= $total_pages) { echo '#'; } else { echo "?pageno=" . ($pageno + 1); } ?>"><strong style="padding-left: 10px">Next</strong></a>
                                    </li>
                                    <li><a href="?pageno=<?php echo $total_pages; ?>"><strong style="padding-left: 10px">Last</strong></a></li>
                                </ul>
                            </div>
                            <br>
                            <br>
                        </div>
                         <div class="card-body">
                            <div class="d-sm-flex align-items-center mb-4">
                                  <h4 class="card-title mb-sm-0">Optional fee payents</h4>
                                                            <a href="#" class="text-dark ml-auto mb-3 mb-sm-0">Optional payments</a>
                            </div>
                            <div class="table-responsive border rounded p-1">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            
                                            <th class="font-weight-bold">Paymentname</th>
                                           
                                            <th class="font-weight-bold">Term1</th>
                                            <th class="font-weight-bold">Term2</th>
                                            <th class="font-weight-bold">Term3</th>
                                            <th class="font-weight-bold">Total</th>
                                            <th class="font-weight-bold">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['pageno'])) {
                                            $pageno = $_GET['pageno'];
                                        } else {
                                            $pageno = 1;
                                        }
                                        // Formula for pagination
                                        $no_of_records_per_page = 7;
                                        $offset = ($pageno - 1) * $no_of_records_per_page;

                                        $ret = "SELECT id FROM other";
                                        $query1 = $dbh->prepare($ret);
                                        $query1->execute();
                                        $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                        $total_rows = $query1->rowCount();
                                        $total_pages = ceil($total_rows / $no_of_records_per_page);

                                        $sql = "SELECT id, type, t1, t2,t3,amount FROM other LIMIT $offset, $no_of_records_per_page";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $row) {
                                        ?>   
                                        <tr>
                                           
                                            
                                            <td><?php echo htmlentities($row->type); ?></td>
                                            <td><?php echo htmlentities($row->t1); ?> </td>

                                            <td><?php echo htmlentities($row->t2); ?></td>
                                            <td><?php echo htmlentities($row->t3); ?></td>
                                         
                                            <td><?php echo htmlentities($row->amount); ?></td>
                                            <td>
                                                <a href="editO.php?editid=<?php echo htmlentities($row->id); ?>" class="btn btn-primary btn-sm"><i class="icon-eye"></i></a>
                                                <a href="edelete.php?otherdel=<?php echo htmlentities($row->id); ?>" onclick="return confirm('Do you really want to delete?');" class="btn btn-danger btn-sm"><i class="icon-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php $cnt = $cnt + 1; } } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div align="left">
                                <ul class="pagination">
                                    <li><a href="?pageno=1"><strong>First</strong></a></li>
                                    <li class="<?php if ($pageno <= 1) { echo 'disabled'; } ?>">
                                        <a href="<?php if ($pageno <= 1) { echo '#'; } else { echo "?pageno=" . ($pageno - 1); } ?>"><strong style="padding-left: 10px">Prev</strong></a>
                                    </li>
                                    <li class="<?php if ($pageno >= $total_pages) { echo 'disabled'; } ?>">
                                        <a href="<?php if ($pageno >= $total_pages) { echo '#'; } else { echo "?pageno=" . ($pageno + 1); } ?>"><strong style="padding-left: 10px">Next</strong></a>
                                    </li>
                                    <li><a href="?pageno=<?php echo $total_pages; ?>"><strong style="padding-left: 10px">Last</strong></a></li>
                                </ul>
                            </div>
                             <div class="card-body">
                            <div class="d-sm-flex align-items-center mb-4">
                               <h4 class="card-title mb-sm-0">Bus  payements</h4>
                                <a href="#" class="text-dark ml-auto mb-3 mb-sm-0">Transport/bus payments</a>
                            </div>
                            <div class="table-responsive border rounded p-1">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            
                                            <th class="font-weight-bold">Area</th>
                                           
                                            <th class="font-weight-bold">Term1</th>
                                            <th class="font-weight-bold">Term2</th>
                                            <th class="font-weight-bold">Term3</th>
                                            <th class="font-weight-bold">Total</th>
                                            <th class="font-weight-bold">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['pageno'])) {
                                            $pageno = $_GET['pageno'];
                                        } else {
                                            $pageno = 1;
                                        }
                                        // Formula for pagination
                                        $no_of_records_per_page = 7;
                                        $offset = ($pageno - 1) * $no_of_records_per_page;

                                        $ret = "SELECT id FROM bus";
                                        $query1 = $dbh->prepare($ret);
                                        $query1->execute();
                                        $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                        $total_rows = $query1->rowCount();
                                        $total_pages = ceil($total_rows / $no_of_records_per_page);

                                        $sql = "SELECT id, area,t1,t2,t3, amount FROM bus LIMIT $offset, $no_of_records_per_page";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $row) {
                                        ?>   
                                        <tr>
                                           
                                            
                                            <td><?php echo htmlentities($row->area); ?></td>

                                            <td><?php echo htmlentities($row->t1); ?></td>
                                            <td><?php echo htmlentities($row->t2); ?></td>
                                            <td><?php echo htmlentities($row->t3); ?></td>
                                            <td><?php echo htmlentities($row->amount); ?></td>
                                            <td>
                                                <a href="editB.php?editid=<?php echo htmlentities($row->id); ?>" class="btn btn-primary btn-sm"><i class="icon-eye"></i></a>
                                                <a href="edelete.php?bdel=<?php echo htmlentities($row->id); ?>" onclick="return confirm('Do you really want to delete?');" class="btn btn-danger btn-sm"><i class="icon-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php $cnt = $cnt + 1; } } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div align="left">
                                <ul class="pagination">
                                    <li><a href="?pageno=1"><strong>First</strong></a></li>
                                    <li class="<?php if ($pageno <= 1) { echo 'disabled'; } ?>">
                                        <a href="<?php if ($pageno <= 1) { echo '#'; } else { echo "?pageno=" . ($pageno - 1); } ?>"><strong style="padding-left: 10px">Prev</strong></a>
                                    </li>
                                    <li class="<?php if ($pageno >= $total_pages) { echo 'disabled'; } ?>">
                                        <a href="<?php if ($pageno >= $total_pages) { echo '#'; } else { echo "?pageno=" . ($pageno + 1); } ?>"><strong style="padding-left: 10px">Next</strong></a>
                                    </li>
                                    <li><a href="?pageno=<?php echo $total_pages; ?>"><strong style="padding-left: 10px">Last</strong></a></li>
                                </ul>
                            </div>
                    </div>
                </div>
            </div>
           

        </div>
<br>
<br><br>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <?php include_once('includes/footer.php'); ?>
        <!-- partial -->
    </div>
    <!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<?php } ?>
