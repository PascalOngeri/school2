  <h3>Public Notice</h3>
                    <table class="table table-striped">
                       <thead>
                          <tr>
                            <th class="font-weight-bold">S.No</th>
                            <th class="font-weight-bold">Notice Title</th>
                            <th class="font-weight-bold">Notice Date</th>
                            <th class="font-weight-bold">Description</th>
                            
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
        $no_of_records_per_page =15;
        $offset = ($pageno-1) * $no_of_records_per_page;
       $ret = "SELECT ID FROM tblpublicnotice";
$query1 = $dbh -> prepare($ret);
$query1->execute();
$results1=$query1->fetchAll(PDO::FETCH_OBJ);
$total_rows=$query1->rowCount();
$total_pages = ceil($total_rows / $no_of_records_per_page);
$sql="SELECT * from tblpublicnotice";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>   
                          <tr>
                           
                            <td><?php echo htmlentities($cnt);?></td>
                            <td><?php  echo htmlentities($row->NoticeTitle);?></td>
                            <td><?php  echo htmlentities($row->CreationDate);?></td>
                                                       <td><?php  echo htmlentities($row->NoticeMessage);?></td>
 
                          </tr><?php $cnt=$cnt+1;}} ?>
                        </tbody>
                    </table>
                    <br>
                    <br>