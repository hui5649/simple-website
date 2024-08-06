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
    <title>Services</title>
    <link rel="stylesheet" type="text/css" href="css/style1.css">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    /* Style the container for the service options */
.info.servicepg {
  display: flex;
  justify-content: space-around;
  padding: 20px;
}

/* Style each service box */
.icon-box {
  width: 300px; /* Set a fixed width for all service boxes */
  background-color: #f4f4f4;
  border: 2px solid #e0e0e0;
  border-radius: 10px;
  padding: 20px;
  text-align: center;
  transition: transform 0.2s;
  margin: 7px;
}

.icon-box:hover {
  transform: scale(1.05);
}

/* Style the service icons */
.icon-box h2 {
  font-size: 24px;
  margin: 10px 0;
}

/* Style the service descriptions */
.icon-box p {
  font-size: 16px;
  margin: 10px 0;
}

/* Style the service features list */
.icon-box ul {
  list-style: none;
  padding: 0;
}

/* Style the service features */
.icon-box li {
  margin: 5px 0;
}

/* Style the "Make Appointment" button */
.make {
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.make:hover {
  background-color: #45a049;
}

/* Center the button in the box */
.icon-box button {
  display: block;
  margin: 0 auto;
}
.icon-box h1 {
    font-size: 60px; /* Set the font size for h1 */
    margin-bottom: 10px; /* Adjust the spacing as needed */
}

</style>
<body>
    <div class="wrapper">
        <div class="sidebar">


            <ul>
                <li><a href="home.php"><img src="image/dog.png" alt="EzSalon" class="img-dog"> 
                <h2>Home</h2></a></li>
                <li><a href="pet_details.php"><i class="fa fa-paw"></i>Pet</a></li>
                <li  class="active"><a href="service.php"><i class="fa fa-book"></i>Service</a></li>
                <li><a href="appointment.php"><i class="fa fa-calendar-check-o"></i>Check Appointment</a></li>
                <li><a href="history.php"><i class="fa fa-history"></i>History</a></li>
                <li><a href="profile.php"><i class="fa fa-user-circle-o"></i>Profile</a></li>
                <li><a href="about_us.php"><i class="fa fa-info-circle"></i>About Us</a></li>
                <li><a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a></li>                
            </ul>
        </div>
        <div class="main_content">
            <div class="header">
                <h1>Service page</h1>
            </div>
            <div class="breadcrum"> 
            <a href="home.php">Home</a> >
                <span class="disable-links"><a href="#">Service</a></span>
                </div>
            <div class="info servicepg">
                <div class="box-container">
                <div class="icon-box">
                  <h1>🛁</h1>
                    <h2> Basic Grooming</h2>
                    <p>The simplest and best way to improve your dogs skin and fur condition. 
                      <ul>
                        <li>Includes <b>nail clipping, cleaning of ears, shaving of paw pads and hygiene areas</b></li>
                        <li><b>Bath</b></li>
                    </ul>
                    <button class="make" onclick="window.location.href='/FYP/Final%20Project%20Wd/user/make_appointment.php?package=basicgrooming';">
                    Make Appointment
                    </button>
                </div>
                <div class="icon-box">
                  <h1>🐶</h1>
                    <h2> Full Grooming</h2>
                    <p>Catered to every dog's aesthetic and owner's preference</p>
                    <ul>
                        <li>Includes <b>all of Basic Grooming services</b></li>
                        <li><b>Fur cut and styling</b></li>
                    </ul>
                    <button class="make" onclick="window.location.href='/FYP/Final%20Project%20Wd/user/make_appointment.php?package=fullgrooming';">
                    Make Appointment
                    </button>
                </div>
                <div class="icon-box">
                <h1>😌</h1>
                    <h2> Spa and Massage</h2>
                    <p>Includes Basic Grooming</p>
                    <ul>
                        <li>Choose from 3 types of Spa - <b>Collagen</b>,<b>Ayurveda</b> or <b> Co2</b></li>
                        <li>Helps concentrate on <b>improving problematic skin or fur issues </b></li>
                    </ul>
                    <button class="make" onclick="window.location.href='/FYP/Final%20Project%20Wd/user/make_appointment.php?package=spaandmassage';">
                    Make Appointment
                    </button>
                    
                </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>