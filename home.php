<?php
    include 'config.php';
?>
<?php
    session_start();
    if(!isset($_SESSION['email'])){
    header("Location: login.php");
    }
    $email = $_SESSION['email'];
    $sql ="SELECT * FROM customer WHERE email ='$email' ";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
    }
    $row= mysqli_fetch_array($result);
    $gender = $row['gender']; // Replace with the actual gender value you have

    if ($gender == "M") {
        $gender = "Mr. ";
    } elseif ($gender == "F") {
        $gender = "Ms. ";
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" type="text/css" href="css/style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
     .info {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
  </style>
</head>
<body>
    <div class="wrapper">
        <div class="sidebar">
            <ul>
                <li class="active"><a href="home.php"><img src="image/dog.png" alt="EzSalon" class="img-dog"> 
                <h2>Home</h2></a></li>
                <li><a href="pet_details.php"><i class="fa fa-paw"></i>Pet</a></li>
                <li><a href="service.php"><i class="fa fa-book"></i>Service</a></li>
                <li><a href="appointment.php"><i class="fa fa-calendar-check-o"></i>Check Appointment</a></li>
                <li><a href="history.php"><i class="fa fa-history"></i>History</a></li>
                <li><a href="profile.php"><i class="fa fa-user-circle-o"></i>Profile</a></li>
                <li><a href="about_us.php"><i class="fa fa-info-circle"></i>About Us</a></li>
                <li><a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a></li>
            </ul>
        </div>
        <div class="main_content">
            <div class="header">
                <h1>Welcome! <?php echo $gender." ".$row['first_name']." ".$row['last_name'];?>. </h1>
            </div>
            <div class="breadcrum"> 
            </div>
            <div class="info">
                <div style="width:100%;">
                <div class="today">
                    <h2>Today Appointment</h2>
                    <?php
                        $email = $_SESSION['email']; 
                        $today = date('Y-m-d');
                        $sql = "SELECT a.*,p.pet_name FROM appointment a INNER JOIN pet p ON a.pet_id=p.pet_id WHERE a.email='$email' AND a.appointment_date = '$today' AND (a.status = 'Open' OR a.status = 'Completed' OR a.status = 'InProgress')ORDER BY a.appointment_time";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result)>0){                            
                            while ($row= mysqli_fetch_array($result)) { 
                                echo "<table class=\"today_appt\">";
                                echo "<tr><th>Appointment ID: </th><td>".$row['appointment_id']."</td></tr>";
                                echo "<tr><th>Appointment Date: </th><td>".$row['appointment_date']."</td></tr>";
                                echo "<tr><th>Appointment Time: </th><td>".$row['appointment_time']."</td></tr>";
                                echo "<tr><th>Service: </th><td>".$row['service']."</td></tr>";
                                echo "<tr><th>Pet: </th><td>".$row['pet_name']."</td></tr>";
                                $statusClass = strtolower('status-' . $row['status']); 
                                echo "<tr><th>Status: </th><td class=\"".$statusClass."\">".$row['status']."</td></tr>";
                                if($row['status'] == 'Completed' OR $row['status'] == 'InProgress'){ ?>
                                <tr><td colspan=2 style="text-align:center; margin:0; padding:0;"><button class="cckstatus" onclick="checkStatus(<?php echo $row['appointment_id']; ?>)">Check Status</button></td></tr>
                                <?php }else{} echo "</table>";
                            }                            
                        }else {
                            echo " <br>No appointment for today.<br> ";} 
                    ?>
                    </div>
                </div>
                <div class="next">                    
                    <h2>Next Appointment</h2>
                    <?php                        
                        $currentDate = new DateTime();
                        $nextDay = $currentDate->modify("+1 day")->format("Y-m-d");
                        $lastDay = $currentDate->modify("+3 month")->format("Y-m-d");                        
                        $sql = "SELECT a.*,p.pet_name FROM appointment a INNER JOIN pet p ON a.pet_id=p.pet_id WHERE a.email='$email' AND a.status = 'Open' AND a.appointment_date BETWEEN '$nextDay' AND '$lastDay' ORDER BY a.appointment_date,a.appointment_time";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result)>0){                            
                            $row= mysqli_fetch_array($result);
                                echo "<table>";
                                echo "<tr><th>Appointment ID: </th><td>".$row['appointment_id']."</td></tr>";
                                echo "<tr><th>Appointment Date: </th><td>".$row['appointment_date']."</td></tr>";
                                echo "<tr><th>Appointment Time: </th><td>".$row['appointment_time']."</td></tr>";
                                echo "<tr><th>Service: </th><td>".$row['service']."</td></tr>";
                                echo "<tr><th>Pet: </th><td>".$row['pet_name']."</td></tr>";
                                echo "</table>";                                                        
                        }else {
                            echo " <br> No next appointment.<br>  ";} 
                    ?>                  

                </div>
                <p class="home" style="padding-left:20px; text-align:center;"><a href=make_appointment.php>Make An Appointment Now?</a></p>
            </div>
        </div>
    </div>
<script>
    function checkStatus(appointmentId) {

        window.location.href = 'checkstatus.php?appt_id=' + appointmentId;
    
    }  
</script>
</body>
</html>