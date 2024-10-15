<?php
session_start();
error_reporting(0);
include('dbconnection.php');
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid'])==0) {
    header('location:logout.php');
} else {
    // Code for deletion
    if(isset($_GET['delid'])) {
        $rid = intval($_GET['delid']);
        $sql = "DELETE FROM registration WHERE id = :rid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':rid', $rid, PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Data deleted');</script>";
        echo "<script>window.location.href = 'manage-students.php'</script>";
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
                <h3 class="page-title">Between Dates Reports</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Between Dates Reports</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-sm-flex align-items-center mb-4">
                                <?php
                                // Retrieve dates from form submission
                                $fdate = $_POST['fromdate'];
                                $tdate = $_POST['todate'];
                                ?>
                                <h5 align="center" style="color:blue">Report from <?php echo htmlspecialchars($fdate);?> to <?php echo htmlspecialchars($tdate);?></h5>
                            </div>
                            <div class="table-responsive border rounded p-1">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="font-weight-bold">Receipt no</th>
                                            <th class="font-weight-bold">ADM</th>
                                            <th class="font-weight-bold">Amount</th>
                                            <th class="font-weight-bold">Balance</th>
                                            <th class="font-weight-bold">Payment type</th>
                                            <th class="font-weight-bold">Reference</th>
                                            <th class="font-weight-bold">Date</th>
                                            <th class="font-weight-bold">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Pagination setup
                                        if (isset($_GET['pageno'])) {
                                            $pageno = $_GET['pageno'];
                                        } else {
                                            $pageno = 1;
                                        }
                                        $no_of_records_per_page = 100;
                                        $offset = ($pageno - 1) * $no_of_records_per_page;

                                        // SQL query to select records between the dates with pagination
                                        $sql = "SELECT * FROM payment 
                                                WHERE date BETWEEN :fdate AND :tdate
                                                ORDER BY id DESC 
                                                LIMIT :offset, :no_of_records_per_page";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':fdate', $fdate, PDO::PARAM_STR);
                                        $query->bindParam(':tdate', $tdate, PDO::PARAM_STR);
                                        $query->bindParam(':offset', $offset, PDO::PARAM_INT);
                                        $query->bindParam(':no_of_records_per_page', $no_of_records_per_page, PDO::PARAM_INT);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                                        // Count total rows for pagination
                                        $count_sql = "SELECT COUNT(*) FROM payment WHERE date BETWEEN :fdate AND :tdate";
                                        $count_query = $dbh->prepare($count_sql);
                                        $count_query->bindParam(':fdate', $fdate, PDO::PARAM_STR);
                                        $count_query->bindParam(':tdate', $tdate, PDO::PARAM_STR);
                                        $count_query->execute();
                                        $total_rows = $count_query->fetchColumn();
                                        $total_pages = ceil($total_rows / $no_of_records_per_page);
 
                                        $cnt = 1;
                                        if($query->rowCount() > 0) {
                                            foreach($results as $row) { ?>
                                                <tr>
                                                    <td><?php echo htmlentities($row->id);?></td>
                                                    <td><?php echo htmlentities($row->adm);?></td>
                                                    <td><?php echo htmlentities($row->amount);?> </td>
                                                    <td><?php echo htmlentities($row->bal); ?></td>
                                                    <td><?php echo htmlentities($row->paytype);?></td>
                                                    <td><?php echo htmlentities($row->reference);?></td>
                                                    <td><?php echo htmlentities($row->date);?></td>
                                                    <td>
                                                        <div><a href="edit-student-detail.php?editid=<?php echo htmlentities($row->sid);?>"><i class="icon-eye"></i></a>
                                                        || <a href="manage-students.php?delid=<?php echo htmlentities($row->sid);?>" onclick="return confirm('Do you really want to Delete ?');"><i class="icon-trash"></i></a></div>
                                                    </td>
                                                </tr>
                                                <?php $cnt++; 
                                            }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div align="left">
                                <ul class="pagination">
                                    <li><a href="?pageno=1"><strong>First</strong></a></li>
                                    <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                                        <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>"><strong>Prev</strong></a>
                                    </li>
                                    <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                                        <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>"><strong>Next</strong></a>
                                    </li>
                                    <li><a href="?pageno=<?php echo $total_pages; ?>"><strong>Last</strong></a></li>
                                </ul>
                            </div>
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
<?php } ?>
