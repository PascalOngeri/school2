<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
             <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="profile-image">
                  
                     <?php
                $aid = $_SESSION['sturecmsaid'];
                $sql = "SELECT * from tbladmin where ID=:aid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':aid', $aid, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $cnt = 1;
                if ($query->rowCount() > 0) {
                    foreach ($results as $row) {
            ?>
               
                  <div class="dot-indicator bg-success"></div>
                   <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header d-flex">
                  <img class="img-md rounded-circle" src="assets/images/faces/face8.jpg" width="60px" alt="Profile image">
                  <div><p class="mb-1 mt-3"><?php  echo htmlentities($row->AdminName);?></p>
                  <p class="font-weight-light text-muted mb-0"><?php  echo htmlentities($row->Email);?></p> </div>
                  
                </div><?php $cnt=$cnt+1;}} ?>
                <a class="dropdown-item" href="profile.php"><i class="dropdown-item-icon icon-user text-primary"></i> My Profile</a>
                <a class="dropdown-item" href="change-password.php"><i class="dropdown-item-icon icon-energy text-primary"></i> Change Password</a>
                <a class="dropdown-item" href="logout.php"><i class="dropdown-item-icon icon-power text-primary"></i>Sign Out</a>
              </div>
                </div>
                <div class="text-wrapper"> 
                  <?php
        // $aid= $_SESSION['sturecmsaid'];
// $sql="SELECT * from tbladmin where ID=:aid";

// $query = $dbh -> prepare($sql);
// $query->bindParam(':aid',$aid,PDO::PARAM_STR);
// $query->execute();
// $results=$query->fetchAll(PDO::FETCH_OBJ);

// $cnt=1;
// if($query->rowCount() > 0)
// {
// foreach($results as $row)
// {               ?>
                 <!--  <p class="profile-name"><?php // echo htmlentities($row->AdminName);?></p>
                  <p class="designation"><?php  //echo htmlentities($row->Email);?></p> --><?php ///$cnt=$cnt+1;}} ?>
            <!--     </div>
               
              </a>
            </li> -->
            
            <li class="nav-item">
              <a class="nav-link" href="dashboard.php">
              <i class="icon-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>

              </a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-layers menu-icon"></i>
                <span class="menu-title">Class</span>
              </a>
              <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="add-class.php">Add Class</a></li>
                  <li class="nav-item"> <a class="nav-link" href="manage-class.php">Manage Class</a></li>

                </ul>
              </div>
            </li>

             <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-layers menu-icon"></i>
                <span class="menu-title">Manage Fee</span>
              </a>
              <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="payfee.php">Pay Fee</a></li>
                  <li class="nav-item"> <a class="nav-link" href="regfee.php">Set Fee</a></li>
                   <li class="nav-item"> <a class="nav-link" href="edelete.php">Update Fee</a></li>
                    <li class="nav-item"> <a class="nav-link" href="optionalpay.php">Optional payments</a></li>
                   
                   
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-basic1" aria-expanded="false" aria-controls="ui-basic1">
                <i class="icon-people menu-icon"></i>
                <span class="menu-title">Students</span>
              </a>
              <div class="collapse" id="ui-basic1">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="add-students.php">Add Students</a></li>
                  <li class="nav-item"> <a class="nav-link" href="manage-students.php">Manage Students</a></li>
                </ul>
              </div>
            </li>
            <!--  Orginal Author Name: Mayuri K. 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website : www.mayurik.com -->  
          
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#auth1" aria-expanded="false" aria-controls="auth">
                <i class="icon-doc menu-icon"></i>
                <span class="menu-title">Public Notice</span>
              </a>
              <div class="collapse" id="auth1">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="add-public-notice.php"> Add Public Notice </a></li>
                  <li class="nav-item"> <a class="nav-link" href="manage-public-notice.php"> Manage Public Notice </a></li>
                </ul>
              </div>
            <!--   <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#auth2" aria-expanded="false" aria-controls="auth">
               <i class="icon-docs menu-icon"></i>
                <span class="menu-title">Pages</span>
                
              </a>
              <div class="collapse" id="auth2">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="about-us.php"> About Us </a></li>
                  <li class="nav-item"> <a class="nav-link" href="contact-us.php"> Contact Us </a></li>
                </ul>
              </div>
            </li> -->
              <li class="nav-item">
              <a class="nav-link" href="between-dates-reports.php">
              <i class="icon-flag menu-icon"></i>
              <span class="menu-title">Reports</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="search.php">
                <i class="icon-magnifier menu-icon"></i>
                <span class="menu-title">Search</span>
              </a>
            </li>
             <li class="nav-item">
              <a class="nav-link" href="send.php">
                <i class="icon-magnifier menu-icon"></i>
                <span class="menu-title">Messages</span>
              </a>
            </li>
             <li class="nav-item">
              <a class="nav-link" href="setting.php">
                <i class="icon-magnifier menu-icon"></i>
                <span class="menu-title">Message Settings</span>
              </a>
            </li>
             <li class="nav-item">
              <a class="nav-link" href="adduser.php">
                <i class="icon-magnifier menu-icon"></i>
                <span class="menu-title">Manage Users</span>
              </a>
            </li>
          

             <li class="nav-item">
              <a class="nav-link" target="a_blank" href="logs.php">
                <i class="icon-info menu-icon"></i>
                <span class="menu-title">User logs</span>
              </a>
            </li>

             
            </li>
          </ul>
        </nav>