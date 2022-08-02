<?php
session_start();
require_once "dbConfig.php";
if (isset($error_message)) {
    echo $error_message;
    unset($error_message);
}
if (isset($_SESSION['user_id']) != "") {
    header("Location: dashboard.php");
}
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Please Enter Valid Email ID";
    }
    if (strlen($password) < 6) {
        $password_error = "Password must be minimum of 6 characters";
    }
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '" . $email . "' and password = '" . $password . "'");
    if (!empty($result)) {
        if ($row = mysqli_fetch_array($result)) {
            $_SESSION['user_id'] = $row['uid'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_mobile'] = $row['mobile'];
            header("Location: dashboard.php");
        }
    } else {
        $error_message = "Incorrect Email or Password!!!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Simple Login Form in PHP with Validation | Tutsmake.com</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <div class="page-header">
                    <h2>Login Form in PHP with Validation</h2>
                </div>
                <p>Please fill all fields in the form</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group ">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="" maxlength="30" required="">
                        <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" id="password" name="password" class="form-control" value="" maxlength="8" required="">
                        <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
                    </div>
                    <input type="checkbox" id="showPass"> Show Password<br>
                    <input type="submit" class="btn btn-primary my-3" name="login" value="submit">
                    <br>
                    You don't have account?<a href="registration.php" class="m-3 btn btn-outline-warning">Click Here</a>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#showPass').on('click', function() {
                var passInput = $("#password");
                if (passInput.attr('type') === 'password') {
                    passInput.attr('type', 'text');
                } else {
                    passInput.attr('type', 'password');
                }
            })
        })
    </script>
</body>

</html>