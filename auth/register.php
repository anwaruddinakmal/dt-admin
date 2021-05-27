<?php
// Include config file
require_once "../includes/config.php";

// Define variables and initialize with empty values
$email = $name = $password = $confirm_password = $type = "";
$email_err = $name_err = $password_err = $confirm_password_err = $type_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //validate type
    if(!empty(trim($_POST['type']))) {
        $type = trim($_POST['type']);
    } else {
        $type_err = 'Please select the membership type';
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter a email.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM user WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = "This email is already taken.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your full name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if (empty($email_err) && empty($name_err) && empty($password_err) && empty($confirm_password_err) && empty($type_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO user (email, name, password, type) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_email, $param_name, $param_password, $param_type);

            // Set parameters
            $param_email = $email;
            $param_name = $name;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_type = $type;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {

                echo '<script type="text/javascript">';
                echo 'alert("Registration successful!. Please Log-in");';
                echo 'window.location.href = "../admin/index.php";';
                echo '</script>';

                // Redirect user to index page
                // header("location: ../admin/index.php"); 
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
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
            background: linear-gradient(90deg, rgba(40, 49, 59, 1) 0%, rgba(72, 84, 97, 1) 100%)
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
        <div class="card shadow">
            <div class="card-body">
                <h2>Register</h2>
                <p>Please fill in your credentials to register.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($type_err)) ? 'has-error' : ''; ?>">
                        <select name="type" class="form-control" id="exampleFormControlSelect1">
                            <option value="" disabled selected>Choose Type of Membership</option>
                            <option value="student">Student Member</option>
                            <option value="ordinary">Ordinary Member</option>
                            <option value="associate">Associate Member</option>
                        </select>
                        <span class="help-block" style="color:red"><?php echo $type_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                        <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" placeholder="Email">
                        <span class="help-block" style="color:red"><?php echo $email_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                        <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" placeholder="Full Name">
                        <span class="help-block" style="color:red"><?php echo $name_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <span class="help-block" style="color:red"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                        <span class="help-block" style="color:red"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success btn-block" value="Register">
                    </div>
                </form>
            </div>
        </div>
        <br>
        <p style="color: #ffffff;">Already have an account? <a href="../auth/login.php">Log-in here</a></p>
    </div>
</body>

</html>