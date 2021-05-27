<?php
// Initialize the session
session_start();

// Include config file
require_once "includes/config.php";

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: auth/login.php");
    exit;
} 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dentreat - Staff Administration</title>
    <link rel="icon" type="image/png" href="img/dentreat-logo2.png" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="img/dentreat-logo.png" alt="" width="140px" height="auto">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <?php
                    $curPageName = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
                    ?>
                    <li class="nav-item <?php if ($curPageName == 'attendance.php') echo 'active';
                                        else echo ''; ?>">
                        <a class="nav-link" href="attendance.php">Attendance</a>
                    </li>

                    <li class="nav-item <?php if ($curPageName == 'leaves.php') echo 'active';
                                        else echo ''; ?>">
                        <a class="nav-link" href="leaves.php">Leaves</a>
                    </li>
                </ul>
                <div class="ml-auto">
                    <div class="dropdown">
                        <a class="btn btn-dark dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $_SESSION['email']; ?>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="admin/index.php">My Profile</a>
                            <a class="dropdown-item" href="admin/changepass.php">Change Password</a>
                            <a class="dropdown-item" href="auth/logout.php" style="color: red;">Log-Out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>