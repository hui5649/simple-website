<?php
    include 'config.php';
?>
<?php
    if(isset($_POST['email']) && isset($_POST['password'])){

        function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $email = validate($_POST['email']);
        $pw = validate($_POST['password']);

        if (empty($email)){
            header("Location: login.php?error=Email is required!");
            exit();
        }else if(empty($pw)){
            header("Location: login.php?error=Password is required!");
            exit();
        }else{
            $sql = "SELECT * FROM customer WHERE email='$email' AND password='$pw'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                if($row['email']===$email && $row['password']===$pw && $row['verification']==='Activated'){
                    session_start();                    
                    $_SESSION['email'] = $_POST['email'];
                    header( "Location: home.php" );                    
                }else if($row['email']===$email && $row['password']===$pw){
                header("Location: login.php?error=Please verify your email!");
                exit();
                }else{
                    header("Location: login.php?error=Incorrect email or password!");
                    exit();
                }
            }else{
                header("Location: login.php?error=Incorrect email or password!");
                exit();
            }
        }  
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
    <link rel="stylesheet" type="text/css" href="css/style1.css">
</head>
<body class="pagebg">
    <div class="img-dog">
    <img src="image/dog.png" alt="EzSalon" width=150>
    </div>    
    <div class="card1">
    <h1>Welcome to <br>Pet Grooming Salon</h1>
    <h2>Login Your Account</h2><br>
    <div class="login">
        <form action="login.php" method="post">
            <?php if (isset($_GET['error'])){ ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <label>Email:</label>
            <input type="email" id="email" name="email" size="40"><br>
            <label>Password:</label>
            <input type="password" id="password" name="password" size="40"><br> 
            <input type="checkbox" id="show-password"><p>Show Password</p>
            <br>
            <input type="submit" value="Login" name='login' class='button_login'>
            <br>
            <p><a href="forgot_pw.php">Forgot Password</a></p>
            <br>
            <p><a href="user_register.php">Register New User</a></p>
        </form>
    </div>
</div>
<script>
document.getElementById('show-password').addEventListener('change', function () {
        var passwordInput = document.getElementById('password');
        if (this.checked) {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    });
</script>
</body>
</html>