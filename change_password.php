<?php
include 'config.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the user's email from the session
    $email = $_SESSION['email'];

    // Retrieve the old and new passwords from the form
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['pw'];
    $newConfirmPassword = $_POST['cpw'];

    if(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/",$newPassword)){
        header("Location: change_password.php?&&error=New password must be minimum 8 characters and includes both letters and numbers!");
        exit();            
    }else if($newPassword != $newConfirmPassword){
        header("Location: change_password.php?&&error=New password and Confirm Password Does' not Match");
        exit();  
    }else{
        $sql = "SELECT password FROM customer WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $oldPasswordFromdb = $row["password"];

            if ($oldPassword != $oldPasswordFromdb) {
                header("Location: change_password.php?error=Wrong old password");
            }else if($newPassword === $oldPasswordFromdb){
                header("Location: change_password.php?error=New password and Old password cannot be the SAME!");
            } else {
                $updateSql = "UPDATE customer SET password = '$newPassword' WHERE email='$email'";
                if($conn ->query($updateSql)===TRUE){                                    
                header("Location: change_password.php?info=New password changed successfully!");
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
    <title>Change Password</title>
    <link rel="stylesheet" type="text/css" href="css/style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    /* Add these styles to your existing CSS or adjust as needed */

.info {
    margin: 20px;
}

.change_pw {
    width: 60%;
    margin: 0 auto;
}

.change_pw form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.change_pw label {
    margin-top: 10px;
}

.change_pw input {
    margin: auto 0;
    padding: 10px;
    width: 50%;
    box-sizing: border-box;
}

.change_pw input[type="submit"] {
    background: linear-gradient(135deg, #3498db, #bf4a45);
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 18px;
    letter-spacing: 1px;
    transition: background 0.3s, transform 0.2s;
}

.change_pw input[type="submit"]:hover {
    background: linear-gradient(135deg, #bf4a45, #3498db);
    transform: scale(1.05);
}
</style>
<body>
    <div class="wrapper">
        <div class="sidebar">            
            <ul>
            <li><a href="home.php"><img src="image/dog.png" alt="EzSalon" class="img-dog"><h2>Home</h2></a></li>
                <li><a href="pet_details.php"><i class="fa fa-paw"></i>Pet</a></li>
                <li><a href="service.php"><i class="fa fa-book"></i>Service</a></li>
                <li><a href="appointment.php"><i class="fa fa-calendar-check-o"></i>Check Appointment</a></li>
                <li><a href="history.php"><i class="fa fa-history"></i>History</a></li>
                <li class="active"><a href="profile.php"><i class="fa fa-user-circle-o"></i>Profile</a></li>
                <li><a href="about_us.php"><i class="fa fa-info-circle"></i>About Us</a></li>
                <li><a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a></li>
            </ul>
        </div>
        <div class="main_content">
            <div class="header">
                <h1>Change Password</h1>
            </div>  
            <div class="breadcrum">          
                <a href="home.php">Home</a> >
                <a href="profile.php">Profile</a> >
                <span class="disable-links"><a href="#">Change Password</a></span>
            </div>
            <div class="info">
                <div class="change_pw">
                <form action="change_password.php" method="post">
                    <?php if (isset($_GET['error'])){ ?>
                        <p class="error"><?php echo $_GET['error']; ?></p>
                    <?php } ?>
                    <?php if (isset($_GET['info'])){ ?>
                        <p class="succeed"><?php echo $_GET['info']; ?></p>
                    <?php } ?>
                    <div class="profile">
                    <p>Password must be minimum 8 characters and includes both letters and numbers!</p><br>
                    <label for="old_password">Old Password:</label><br>
                    <input type="password" name="old_password" id="old_password" required><br>
                    <label>New Password:</label><br>
                    <input type="password" name='pw' value="" placeholder=""><br>
                    <label>Confirm New Password:</label><br>
                    <input type="password" name='cpw' value="" placeholder=""><br>
                    <input type="submit" value="Change Password" name='resetpw' class="update-profile-btn"><br>
                </form>                   
                </div>
                </div>
            </div>
        </div>
    </div>    
</body>
</html>
