<?php
require_once "dbConfig.php";
$error = false;
if (isset($_SESSION['user_id']) != "") {
    header("Location: dashboard.php");
}
if (isset($_POST['signup'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // echo $password;

    if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        $name_error = "Name must contain only alphabets and space";
        $error = true;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Please Enter Valid Email ID";
        $error = true;
    }

    if(!preg_match('/^(?=.*[!@#$%&])[0-9A-Za-z!@#$%&]{6,12}$/', $password)) {
        $password_error = "Password must be minimum of 6 characters and atleast one special character";
        $error = true;
    }

    if (strlen($mobile) < 10) {
        $mobile_error = "Mobile number must be minimum of 10 characters";
        $error = true;
    }

    if ($password != $cpassword) {
        $cpassword_error = "Password and Confirm Password doesn't match";
        $error = true;
    }

    if (!$error) {
        if (mysqli_query($conn, "INSERT INTO users(`name`, `email`, `mobile`, `password`) VALUES('" . $name . "', '" . $email . "', '" . $mobile . "', '" . $password . "')")) {
            header("location: login.php");
            exit();
        } 
        else {
            echo "Error: " . $sql . "" . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Simple Registration Form in PHP with Validation</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-offset-2">
                <div class="page-header">
                    <h2>Registration Form in PHP with Validation</h2>
                </div>
                <p>Please fill all fields in the form</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="" maxlength="50" required="">
                        <span class="text-danger"><?php if (isset($name_error)) echo $name_error; ?></span>
                    </div>
                    <div class="form-group ">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="" maxlength="30" required="">
                        <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Mobile</label>
                        <input type="text" name="mobile" class="form-control" value="" maxlength="12" required="">
                        <span class="text-danger"><?php if (isset($mobile_error)) echo $mobile_error; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" value="" maxlength="8" required="">
                        <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="cpassword" class="form-control" value="" maxlength="8" required="">
                        <span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
                    </div>
                    <input type="submit" class="btn btn-primary my-3" name="signup" value="submit">
                      Already have a account?<a href="login.php" class="btn btn-default btn-outline-warning mx-3">Login</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>