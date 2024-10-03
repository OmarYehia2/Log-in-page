<?php
    include('config.php');
    session_start();

    if (isset($_POST['okk'])) {
        $name = mysqli_real_escape_string($conn, $_POST['user']);
        $email = mysqli_real_escape_string($conn, $_POST['Email']);
        $pass = $_POST['Password'];
    
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
        $user_type = $_POST['usertype'];
    
        $select = "SELECT * FROM data WHERE Email = '$email'";
        $result = mysqli_query($conn, $select);
    
        if (mysqli_num_rows($result) > 0) {
            echo 'User already exists!';
        } else {
            try{
                $insert = "INSERT INTO data (user, Email, pass, user_type) VALUES ('$name', '$email', '$hashed_pass', '$user_type')";
                if (!mysqli_query($conn, $insert)) {
                    echo 'Database error: ' . mysqli_error($conn);
                } else {
                    header('location:login.php');
                    exit();
                }
            }
            catch(mysqli_sql_exception)
            {
                echo "<script>alert('Username Is Taken!');</script>";
            };
        }
    }
    

    if (isset($_POST['ok'])) {
        $email = mysqli_real_escape_string($conn, $_POST['Email']);
        $pass = $_POST['Password'];
    
        $select = "SELECT * FROM data WHERE Email = '$email'";
        $result = mysqli_query($conn, $select);
    
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $hashed_pass = $row['pass'];
    
            if (password_verify($pass, $hashed_pass)) {
                if ($row['user_type'] == 'admin') {
                    $_SESSION['admin_name'] = $row['user'];
                    header('location:admin.php');
                    exit();
                } elseif ($row['user_type'] == 'user') {
                    $_SESSION['user_name'] = $row['user'];
                    header('location:user.php');
                    exit();
                }
            } else {
                echo 'Incorrect email or password!';
            }
        } else {
            echo 'Incorrect email or password!';
        }
    }
    
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Login Page</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="" method="post">
                <h1>Create Account</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>or use your email for registration</span>
                <input type="text" name="user" placeholder="Name" required>
                <input type="email" name="Email" placeholder="Email" required>
                <input type="password" name="Password" placeholder="Password" required>
                <select name="usertype">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit" name="okk">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="" method="post">
                <h1>Sign In</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>or use your email password</span>
                <input type="email" name="Email" placeholder="Email" required>
                <input type="password" name="Password" placeholder="Password" required>
                <a href="#">Forget Your Password?</a>
                <button type="submit" name="ok">Sign In</button>
            </form>
        </div>
        
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>
