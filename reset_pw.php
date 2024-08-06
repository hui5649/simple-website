<?php
    include 'config.php';
?>
<?php     
    if(isset($_POST['pw']) && isset($_POST['cpw'])){
        $email = $_POST['email'];
        $pw = $_POST['pw'];
        $cpw = $_POST['cpw'];         
        
       
        if (empty($pw)){
            header("Location: reset_pw.php?email=".$email."&&error=New Password is required!");
            exit();
        }else if(empty($cpw)){
            header("Location: reset_pw.php?email=".$email."&&error=Confirm New Password is required!");
            exit();
        }else if(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/",$pw)){
            header("Location: reset_pw.php?email=".$email."&&error=Password must be minimum 8 characters and includes both letters and numbers!");
            exit();            
        }else if($pw != $cpw){
            header("Location: reset_pw.php?email=".$email."&&error=Password and Confirm Password Does' not Match");
            exit();  
        }else{
            $sql = "SELECT password FROM customer WHERE email='$email'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $oldPassword = $row["password"];

                if ($pw === $oldPassword) {
                    header("Location: reset_pw.php?email=".$email."&&error=New Password cannot SAME as Old Password");
                } else {
                    $updateSql = "UPDATE customer SET password = '$pw' WHERE email='$email'";
                    if($conn ->query($updateSql)===TRUE){                                    
                    header("Location: reset_pw.php?email=".$email."&&info= Password reset successfully");
                    exit(); }
                }   
        }}
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" type="text/css" href="css/style1.css">
</head>
<body class="pagebg">
<div class="forgot">
        <p class="lock-icon"><span class="fas fa-lock"></span></p>
        <h2>Reset Password</h2>
        <br>        
        <p>Password must be minimum 8 characters and includes both letters and numbers!</p>
        <br>
        <div class="login">
        <form action="reset_pw.php" method="post">
            <?php if (isset($_GET['error'])){ ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <?php if (isset($_GET['info'])){ ?>
                <p class="succeed"><?php echo $_GET['info']; ?></p>
            <?php } ?>
            <input type="hidden" name='email' value="<?php if(isset($_GET['email'])){echo $_GET['email'];}?>">   
            <label>New Password:</label><br>
            <input type="password" name='pw' value="" placeholder=""><br>
            <label>Confirm New Password:</label><br>
            <input type="password" name='cpw' value="" placeholder=""><br>
            <input type="submit" value="Submit" name='resetpw' class='button_login'><br>
            <p><a href="login.php">Back To Login Page</a></p>
        </form>
        </div>
    </div>     
</body>
</html>