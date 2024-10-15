<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "vpbgvvdz_simon";
$password = "40702314Simon?";
$dbname = "vpbgvvdz_pay";

// Create Connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute query
    $stmt = $con->prepare("SELECT id, subscription, very, password FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $subscription, $very, $hashed_password);
    $stmt->fetch();

    // Verify the password
    if ($hashed_password && password_verify($password, $hashed_password)) {
        // Password is correct
        $_SESSION['id'] = $user_id;
        $_SESSION['username'] = $username;

        // Check subscription and verification status
        if ($subscription == 0) {
            header("Location: pay.php");
        } elseif ($very == 0) {
            header("Location: veri.php");
        } else {
            header("Location: home.php");
        }
        exit();
    } else {
        $error = "Invalid username or password.";
    }

    $stmt->close();
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
 <meta name="google-site-verification" content="K5ut6o5JoxSdoNvRB16OybrrrFYQQtNwBivJTNEyZGk" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
   
 <title>Shabanet Hub</title> 

           <link rel="icon" href="favicon.png">

    <link href="css/all.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <!-- <a class="navbar-brand" href="#">Shabanet PROTECH HUB payment System</a> -->

        <a class="navbar-brand" href="#">Shabanet PROTECH HUB payment System</a>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">USER LOGIN</h1>
                    </div>
                    <form method="POST" class="user" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="username" placeholder="Enter Username here..." required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" name="password" placeholder="Enter Password here..." required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block" name="login">Login</button>
                        <br>
                        <input type="checkbox" id="remember" class="form-check-input" name="remember">
                        <label for="remember">Keep me signed in</label>
                        <br>
                        <a href="#"><i>Forgot Password?</i></a>
                    </form>
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger mt-3"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    <br>
                    <center><a href="reg.php" style="color: red">Create Account?</a></center>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar fixed-bottom navbar-dark bg-dark">
        <span style="color:#ffffff;">&copy; Copyright Shabanet Technologies     Contact 0757563475, 0740385892, 0722943271</span>
        <!-- <span style="color:#ffffff;">&copy; Copyright Shabanet Technologies     Contact 0757563475, 0740385892, 0722943271</span> -->

        <span style="color:#ffffff;">All Rights Reserved <?php echo date("Y"); ?></span>
    </nav>
</body>
</html>
