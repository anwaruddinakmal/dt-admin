<?php
require_once "../includes/config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Malaysian Association of Aesthetic Dentistry</title>
    <link rel="icon" type="image/png" href="../img/logo.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <style type="text/css">
        body {
            background: rgb(40, 49, 59);
            background: linear-gradient(90deg, rgba(40, 49, 59, 1) 0%, rgba(72, 84, 97, 1) 100%);
        }

        .content {
            margin-top: 80px;
            height: 200px;
            width: 400px;
            text-align: center;
        }

        .navbar {
            height: 70px;
        }

        a:hover {
            text-decoration: none;
        }

        .card {
            border-radius: 15px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="mr-auto">
            <a class="btn btn-dark" href="../index.php"><i class="fas fa-chevron-left"></i>&nbsp;&nbsp;Back to homepage</a>
        </div>
    </nav>
    <div class="content mx-auto">
        <img src="../img/logo.png" width="250px" height="auto" style="padding-bottom:20px;"><br>
        <h3 style="color: #ffffff;"><b>Malaysian Association of Aesthetic Dentistry</b></h3>
        <br>
        <center>
            <div class="card">
                <div class="card-body">
                    <h3>Forgot Password</h3>
                    <hr>
                    <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="control-label" for="email">Registered Email Address :</label>
                            <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                        </div>
                        <button type="submit" name="forgot" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </center>
    </div>
</body>

</html>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['forgot'])) {

    $email = $_POST['email'];
    $subject = "MAAD Account Password Reset";
    $body = "Dear Sir/Mdm,<br><br>Your MAAD account password has been reset.<br><br>Kindly use this temporary password for login :<br><br><b>g786dfjsah</b><br><br><br>
    <i>* don't forget to change your temporary password as soon as you login.</i>";

    $sql = "SELECT password FROM user where email='$email'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            require_once "../vendor/autoload.php";
            $mail = new PHPMailer(true);

            // $mail->SMTPDebug = 3;
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "maadmalaysia@gmail.com";
            $mail->Password = "oapskkgxgbinjfov";
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;

            $mail->From = "maadmalaysia@gmail.com";
            $mail->FromName = "MAAD MALAYSIA";

            $mail->addAddress($email);

            $mail->isHTML(true);

            $mail->Subject = $subject;
            $mail->Body = $body;

            try {
                $mail->send();
                $passhash = password_hash('g786dfjsah', PASSWORD_DEFAULT);
                $sql = "UPDATE user SET password='$passhash' WHERE email='$email'";
                if ($link->query($sql) === TRUE) {
                    echo '<script>window.alert("Temporary password has been sent to your email. Thanks!");</script>';
                } else {
                    echo '<script>window.alert("Sending email failed. Kindly contact administrator.");</script>';
                }
            } catch (Exception $e) {
                echo '<script>window.alert("Sending email failed. Kindly contact administrator.");</script>';
            }

            // exit(json_encode(array("status" => $status, "response" => $response)));
        }
    } else {
        echo '<script>window.alert("Your email is not registered yet!");</script>';
    }
}
?>