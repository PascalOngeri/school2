<?php
session_start();
// Validate admin credentials (you should validate against a database)
if ($_POST['username'] === 'admin' && $_POST['password'] === 'adminpassword') {
    $_SESSION['admin_logged_in'] = true;
} else {
    header("Location: admin_login.php");
    exit();
}

// Database connection
require_once 'config.php'; // Replace with your database connection details

// Fetch all clients from database
$sql = "SELECT * FROM user";
$result = $con->query($sql);

// Check if any clients exist
if ($result->num_rows > 0) {
    $user = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $user = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        
        .dashboard-container {
            width: 100%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        h2 {
            text-align: center;
            color: #333;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        table th, table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        
        table td {
            vertical-align: middle;
        }
        
        table td a {
            text-decoration: none;
            color: #007bff;
            margin-right: 5px;
        }
        
        table td a:hover {
            text-decoration: underline;
        }
        
        .actions-column {
            white-space: nowrap;
        }
        
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 10px;
            }
            table th, table td {
                padding: 6px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Admin Dashboard</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Phone</th>
                    <th>Business Name</th>
                    <th>Payment Type</th>
                    <th>Payment No</th>
                    <th>Developer Api</th>
                    <th>Subscription</th>
                    <th>Verified</th>
                    <th class="actions-column">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($user as $r): ?>
                    <tr>
                        <td><?php echo $r['id']; ?></td>
                        <td><?php echo $r['fullname']; ?></td>
                        <td><?php echo $r['email']; ?></td>
                        <td><?php echo $r['username']; ?></td>
                        <td><?php echo $r['phone']; ?></td>
                        <td><?php echo $r['bname']; ?></td>
                        <td><?php echo $r['payname']; ?></td>
                        <td><?php echo $r['paymentno']; ?></td>
                        <td><?php echo $r['devapi']; ?></td>
                        <td><?php echo $r['subscription']; ?></td>
                        <td><?php echo $r['very']; ?></td>
                        <td class="actions-column">
                            <a href="approve_client.php?id=<?php echo $r['id']; ?>">Approve</a>
                            <a href="suspend_client.php?id=<?php echo $r['id']; ?>">Suspend</a>
                            <a href="reject_client.php?id=<?php echo $r['id']; ?>">Reject</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <a href="admin_logout.php">Logout</a>
    </div>
</body>
</html>
