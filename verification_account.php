<?php
    include 'config.php';
?>
<?php 
    if(isset($_POST['email'])){
        $email = $_POST['email'];
        $query = mysqli_query($conn, "SELECT * FROM customer WHERE email= '$email'");
            if(mysqli_num_rows($query)>0){
                mysqli_query($conn, "UPDATE customer set verification = 'Activated' WHERE email= '".$email."'");
                $msg = "Your account is activated now! Now redirecting to Login Page...";
                header("Refresh:5; Url=login.php");
            }else{

            }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Account</title>
    <link rel="stylesheet" type="text/css" href="css/style1.css">
</head>
<body class="pagebg">
    <div class="verification">
    <?php if(isset($msg)){echo "<p class=\"succeed\" style=\"font-weight:bold;\">$msg</p>";}?>     
    <h2>Click the button to verify your email.</h2><br>
    <form action="verification_account.php" method="post">
    <input type="hidden" name='email' value="<?php if(isset($_GET['email'])){echo $_GET['email'];}?>"> 
    <input type="submit" value="Verify Email" name='verification' class='button_login'>
    </form>
    </div>
</body>
</html>