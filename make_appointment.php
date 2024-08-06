<?php
    include 'config.php';
?>
<?php
    session_start();
    if(!isset($_SESSION['email'])){
    header("Location: login.php");
    }
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    function isAppointmentTaken($conn, $time,$date,$service) {
        $sql = "SELECT * FROM appointment WHERE appointment_time = '$time' AND appointment_date = '$date'  AND service ='$service' AND (status = 'Open' OR status = 'Completed' OR status = 'InProgress')";
        $result = $conn->query($sql);
        return $result->num_rows > 0;
    }
    function isPetHaveAppointment($conn,$date,$pet_id){
        $sql = "SELECT * FROM appointment WHERE appointment_date = '$date' AND pet_id = '$pet_id' AND (status = 'Open' OR status = 'Completed' OR status = 'InProgress')";
        $result = $conn->query($sql);
        return $result->num_rows > 0;
    }
   
    if(isset($_POST['makeappointment'])){    
    $appointment_date = $_POST['appointmentdate'];
    $appointment_time = $_POST['appointmenttime'];
    $service = $_POST['service'];
    $pet_id = $_POST['petid'];
    $email = $_SESSION['email'];
    $sql ="SELECT * FROM customer WHERE email ='$email' ";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
    }
    $row= mysqli_fetch_array($result);
    $name = $row['first_name']; 
    $gender = $row['gender']; 

    if ($gender == "M") {
        $gender = "Mr. ";
    } elseif ($gender == "F") {
        $gender = "Ms. ";
    } 
    
    if(isPetHaveAppointment($conn,$appointment_date,$pet_id)) {
        header("Location: make_appointment.php?error=Your pet have others appointment today!");
        exit();
    }else if (isAppointmentTaken($conn, $appointment_time,$appointment_date,$service)) {
        header("Location: make_appointment.php?error=This time slot is booked by others!");
        exit();
    }else {
        $sql = "INSERT INTO appointment(appointment_date, appointment_time, service, pet_id, email, status) VALUES ('".$appointment_date."','".$appointment_time."','".$service."','".$pet_id."','".$email."','Open')";    
        if ($conn->query($sql)===TRUE){
            $sql = "SELECT  a.*, p.pet_name FROM appointment a INNER JOIN pet p ON a.pet_id = p.pet_id WHERE a.email = '$email' AND a.appointment_date = '$appointment_date' AND a.appointment_time = '$appointment_time' ";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result)>0){
            $row= mysqli_fetch_array($result);}
            $pet_name=$row['pet_name'];
            $appointment_id = $row['appointment_id'];
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'petgroomingsalon71@gmail.com';
            $mail->Password = 'olhpkemwqewrwpvp';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
        
            $mail->setFrom('petgroomingsalon71@gmail.com');
        
            $mail->addAddress($email);
        
            $mail->isHTML(true);
            $mail->Subject = "Confirmation of Appointment";
            $mail->Body = "Dear ".$gender."".$name.",<br><br>Thank you for making apoointment in PET GROOMING SALON.<br><br>This is your appointment information:<br><br>Appointment ID : <b>".$appointment_id."</b><br>Appointment Date : <b>".$appointment_date."</b><br>Appointment Time : <b>".$appointment_time."</b><br>Service : <b>".$service."</b><br>Your pet's name : <b>".$pet_name."</b><br><br>We're looking forward to meeting you. If you have questions before the appointment or need to change or cancel, please contact us at 07-2345345.<br><br>Thank you.";
        
            $mail->send();           
            
            header("Refresh:1; Url=make_appointment.php?info=Appointment successfully! Please check your email.");
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
    <title>Make Appointment</title>
    <link rel="stylesheet" type="text/css" href="css/style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        p {
            text-align: center;
            font-size: 20px;
            color: #333;
            font-weight: bold;
            animation: fadeIn 1s forwards, zoomInOut 0.7s infinite alternate;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes zoomInOut {
            0% {
                transform: scale(0.98);
            }
            100% {
                transform: scale(1);
            }
        }
    </style>
    <script>
        function validateForm() {
            var now = new Date();
            var currentYear = now.getFullYear();
            var currentMonth = now.getMonth() + 1; // Months are zero-based
            var currentDate = now.getDate();

            // Formatting the current date with leading zeros if needed
            var formattedCurrentDate = currentYear + '-' + (currentMonth < 10 ? '0' : '') + currentMonth + '-' + (currentDate < 10 ? '0' : '') + currentDate;

            // Get the selected appointment date from the form
            var appointmentDate = document.getElementById('appointmentdate').value;

            // If the selected appointment date is not today, no need to check the time
            if (appointmentDate !== formattedCurrentDate) {
                return true;
            }
            var hours = now.getHours();
            var minutes = now.getMinutes();
            hours = (hours < 10) ? '0' + hours : hours;
            minutes = (minutes < 10) ? '0' + minutes : minutes;
            var currentTime = hours + ':' + minutes;
            var appointmenttime = document.getElementById('appointmenttime').value;
            
            if (currentTime >= appointmenttime) {
                alert('This appointment time has passed for today!');
                return false; // Prevent form submission
            }            
            return true;
        }
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="sidebar">
            <ul>
                <li><a href="home.php"><img src="image/dog.png" alt="EzSalon" class="img-dog"> 
                <h2>Home</h2></a></li>
                <li><a href="pet_details.php"><i class="fa fa-paw"></i>Pet</a></li>
                <li class="active"><a href="service.php"><i class="fa fa-book"></i>Service</a></li>
                <li><a href="appointment.php"><i class="fa fa-calendar-check-o"></i>Check Appointment</a></li>
                <li><a href="history.php"><i class="fa fa-history"></i>History</a></li>
                <li><a href="profile.php"><i class="fa fa-user-circle-o"></i>Profile</a></li>
                <li><a href="about_us.php"><i class="fa fa-info-circle"></i>About Us</a></li>
                <li><a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a></li>
            </ul>
        </div>
        <div class="main_content">
            <div class="header">
                <h1>Make Appointment.</h1>
            </div>            
            <div class="breadcrum"> 
            <a href="home.php">Home</a> >
            <a href="service.php">Service</a> >
            <span class="disable-links"><a href="#">Make Appointment</a></span>
            </div> 
            <div class="info servicepg">                
            <div class="col-lg-10 col-offset-2 apptform">
                <div><h2><u><b>Make Appointment</b></u></h2></div>
                <?php if (isset($_GET['error'])){ ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
                <?php } ?>
                <?php if (isset($_GET['info'])){ ?>
                <p class="succeed"><?php echo $_GET['info']; ?></p>
                <?php } ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
                <div class="form-group">
                <label>Service</label> <br>
                <select name="service" id="service">
                <?php
                    if(isset($_GET['package'])){
                        $service = $_GET['package'];
                        if($service=='basicgrooming'){?>                            
                            <option value="Basic Grooming" selected>Basic Grooming</option>
                            <option value="Full Grooming">Full Grooming</option>
                            <option value="Spa and Massage">Spa and Massage</option><?php
                        }
                        elseif($service=='fullgrooming'){?>                            
                            <option value="Basic Grooming">Basic Grooming</option>
                            <option value="Full Grooming"  selected>Full Grooming</option>
                            <option value="Spa and Massage">Spa and Massage</option><?php
                        }
                        elseif($service=='spaandmassage'){?>                            
                            <option value="Basic Grooming">Basic Grooming</option>
                            <option value="Full Grooming">Full Grooming</option>
                            <option value="Spa and Massage"  selected>Spa and Massage</option><?php
                        }
                        
                    }else{?>                                                    
                        <option value="Basic Grooming">Basic Grooming</option>
                        <option value="Full Grooming">Full Grooming</option>
                        <option value="Spa and Massage">Spa and Massage</option><?php
                    }
                ?>                
                </select>
                </div>
                <div class="form-group">
                <label>Appointment Date </label><br>
                <input type="date" id="appointmentdate" name="appointmentdate" class="form-control" value="" maxlength="50" required > 
                </div>
                <div class="form-group">
                <label>Appointment Time  (Working hours: 10AM-9PM)</label><br>
                <select id="appointmenttime" name="appointmenttime" required>
                <?php
                    for ($hour = 10; $hour <= 20; $hour++) {
                        $formattedHour = sprintf('%02d', $hour); // Add leading zero if needed
                        $currentTimeSlot = "$formattedHour:00";
        
                        echo "<option value=\"$currentTimeSlot\">$currentTimeSlot</option>";
                        
                        
                    }
                ?>
                </select>

                 </div> 
                <div class="form-group">
                <label>Pet Name </label><br>
                <select id="petid" name="petid" required>
                <?php
                    $email = $_SESSION['email'];
                    $sql = "SELECT * FROM pet WHERE email = '$email'";
                    $result = mysqli_query($conn, $sql);
                    while ($row= mysqli_fetch_array($result)) { ?>
                        <option value="<?php echo $row['pet_id']; ?>"><?php echo $row['pet_name']; ?></option>
                <?php
                    }
                ?>
                    </select> 
                    <label for="" style="font-size:15px; padding:10px;">Don't have your pet's name?<a href="pet_register.php">Add Pet</a> </label>   
                </div><br>
                <div style="text-align:center;">
                <input type="submit" class="btn btn-primary makebtn" name="makeappointment" value="Submit">             
                </div>   
                </form><br> 
                </div>
            </div>
        </div>
    </div>
    
    <script>
    var date = new Date();    
    var tdate = date.getDate();
    var month = date.getMonth() +1;    
    if (tdate < 10){
        tdate = '0' + tdate;
    }
    if (month<10){
        month = '0'+ month;
    }
    var year = date.getUTCFullYear();
    
    var minDate = year + "-" +month + "-"+tdate;
    document.getElementById("appointmentdate").setAttribute('value',minDate);
    document.getElementById("appointmentdate").setAttribute('min',minDate);
    var month1 = date.getMonth() +4;  
    if (month1>12){
        month1 -= 12;
        month1 = '0'+ month1;        
         year +=1; 
    }
    var maxDate = year + "-" +month1 + "-"+tdate;
    document.getElementById("appointmentdate").setAttribute('max',maxDate);
</script>
</body>
</html>