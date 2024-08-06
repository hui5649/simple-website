<?php
    include 'config.php';
?>
<?php
    session_start();
    if(!isset($_SESSION['email'])){
    header("Location: login.php");
    }    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Page</title>
    <link rel="stylesheet" type="text/css" href="css/style1.css">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
/* Style the submit button */
.wrapper .main_content .info .profile .update-profile-btn {
    background: linear-gradient(135deg, #3498db, #bf4a45);
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 18px;
    letter-spacing: 1px;
    transition: background 0.3s, transform 0.2s;
    margin-left:20px;
    margin-top:10px;
}
h3{
    margin-left:20px;
}
.wrapper .main_content .info .profile .update-profile-btn:hover {
    background: linear-gradient(135deg, #bf4a45, #3498db);
    transform: scale(1.3);
}
p{
    display:inline;
}

</style>
<body>
    <div class="wrapper">
        <div class="sidebar">
            <ul>
                <li><a href="home.php"><img src="image/dog.png" alt="EzSalon" class="img-dog"> 
                <h2>Home</h2></a></li>
                <li><a href="pet_details.php"><i class="fa fa-paw"></i>Pet</a></li>
                <li><a href="service.php"><i class="fa fa-book"></i>Service</a></li>
                <li><a href="appointment.php"><i class="fa fa-calendar-check-o"></i>Check Appointment</a></li>
                <li><a href="history.php"><i class="fa fa-history"></i>History</a></li>
                <li  class="active"><a href="profile.php"><i class="fa fa-user-circle-o"></i>Profile</a></li>
                <li><a href="about_us.php"><i class="fa fa-info-circle"></i>About Us</a></li>
                <li><a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a></li>
            </ul>
        </div>
    
        <div class="main_content">
            <div class="header">
                <h1>User Profile</h1>
            </div>
            <div class="breadcrum"> 
            <a href="home.php">Home</a> >
                <span class="disable-links"><a href="#">Profile</a></span>
                </div>
            <div class="info">
                
                <div class="profile">
                    
                    <form action="update_profile.php" method="post">

                        <?php
                            $email = $_SESSION['email'];
                            
                            $sql = mysqli_query($conn, "SELECT * FROM customer WHERE email = '$email'")
                            or die('query failed');
                            if(mysqli_num_rows($sql)>0){
                                $fetch = mysqli_fetch_assoc($sql);
                            }
                        ?>

                        <h3><?php echo $fetch['first_name']; ?> <?php echo $fetch['last_name']; ?></h3>
                        
                        <div class="profile">
                            <p style="padding-right:35px;">First Name </p>:<p> <strong><?php echo $fetch['first_name']; ?></strong></p><br>
                            <p style="padding-right:37px;">Last Name </p>:<p> <strong><?php echo $fetch['last_name']; ?></strong></p><br>
                            <p style="padding-right:0px;">Phone number </p>:<p> <strong><?php echo $fetch['phone_number']; ?></strong></p><br>
                            <p style="padding-right:65px;">Gender </p>:<p> <strong><?php echo ($fetch['gender'] === 'F') ? 'Female' : 'Male'; ?></strong></p><br>
                            <p style="padding-right:38px;">IC number </p>:<p> <strong><?php echo $fetch['ic_number']; ?></strong></p><br>

                            <!-- Display other profile information here -->
                           
                        </div>
                        <a href="update_profile.php" class="update-profile-btn">Update Profile</a> 
                        <a href="change_password.php" class="update-profile-btn">Change Password</a>
                    </form>
                
                </div>
            </div>
        </div>
    </div>
</body>
</html>