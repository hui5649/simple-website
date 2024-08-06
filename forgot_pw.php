<?php
    include 'config.php';
?>
<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    if(isset($_POST['email']) && isset($_POST['ic'])){

        function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $email = $_POST['email'];
        $ic = $_POST['ic'];    

        if (empty($email)){
            header("Location: forgot_pw.php?error=Email is required!");
            exit();
        }else if(empty($ic)){
            header("Location: forgot_pw.php?error=IC No is required!");
            exit();
        }else{
            $sql = "SELECT * FROM customer WHERE email='$email' AND ic_number='$ic'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                $gender = $row['gender']; // Replace with the actual gender value you have

                if ($gender == "M") {
                    $gender = "Mr. ";
                } elseif ($gender == "F") {
                    $gender = "Ms. ";
                } 
                if($row['email']===$email && $row['ic_number']===$ic){
                    $mail = new PHPMailer(true);

                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'petgroomingsalon71@gmail.com';
                    $mail->Password = 'olhpkemwqewrwpvp';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;
            
                    $mail->setFrom = 'petgroomingsalon71@gmail.com';
            
                    $mail->addAddress($email);
            
                    $mail->isHTML(true);
                    $pw = $row['password'];
                    $link = 'http://localhost/FYP/Final%20Project%20Wd/user/reset_pw.php?email='.$email;
                    $mail->Subject = "Reset Password";
                    $mail->Body = "Dear ".$gender."".$row['first_name'].",<br><br>   Please click the link below to reset your password:<br><a href=".$link.">Click Here</a><br><br>Thank you.";
                    $mail->send();

                echo"
                <script>
                alert('Please check your email!');
                </script>
                ";                                         
                }}else{
                header("Location: forgot_pw.php?error=Incorrect Email or IC No!");
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
    <link rel="stylesheet" type="text/css" href="css/style1.css">
    <title>Forgot Password</title>
</head>
<body class="pagebg_forgot">
    <div class="forgot">
        <p class="lock-icon"><span class="fas fa-lock"></span></p>
        <h2>Forgot Password?</h2><br>
        <p>Fill in the details<br></p><br>
        <div class="login">
        <form action="forgot_pw.php" method="post">
            <?php if (isset($_GET['error'])){ ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <label>Email:</label><br>
            <input type="email" name='email' value="" placeholder="Email address"><br>
            <label>IC No:</label><br>
            <input type="text" name='ic' value="" placeholder="xxxxxx-xx-xxxx"><br>
            <input type="submit" value="Reset Password" name='forgotpw' class='button_login'><br>
            <p><a href="login.php">Back To Login Page</a></p>
        </form>
        </div>
    </div>     
</body>
</html>