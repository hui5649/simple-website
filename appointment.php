<?php
    include 'config.php';
?>
<?php
    session_start();
    if(!isset($_SESSION['email'])){
    header("Location: login.php");
    }       
    
    
    $apptid = isset($_GET['cancel_id']) ? $_GET['cancel_id'] : '';
    if($apptid){
        $sql = "SELECT status FROM appointment WHERE appointment_id='".$apptid."'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
    
        $row = $result->fetch_assoc();
        $status = $row['status'];

        if ($status == "Cancelled") {
            header("Location: appointment.php?error=Appointment that have been cancelled cannot be changed!");
        }else if ($status == "Completed") {
            header("Location: appointment.php?error=Appointment already completed cannot be cancel!");
        }else if ($status == "InProgress") {
            header("Location: appointment.php?error=Appointment in progress cannot be cancel!");
        } else {
                        
        $sql ="UPDATE appointment SET status ='Cancelled' WHERE appointment_id='".$apptid."'";
        if($conn ->query($sql)===TRUE){
            echo "<br>";
            header("Location: appointment.php?info=Your appointment has been cancelled!");
    }}}}    
    $today = date('Y-m-d');
    // Calculate date after 3 months
    $afterThreeMonths = date('Y-m-d', strtotime('+3 months'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Appointment</title>
    <link rel="stylesheet" type="text/css" href="css/style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    /* Add this CSS code to your existing styles */

.cancelbtn {
  background-color: #c70e4e;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}

.cancelbtn::before {
  content: "Cancel Now"; /* Initial text */
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background-color: #FF0000; /* New background color */
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  transition: left 0.3s, background-color 0.3s;
}

.cancelbtn:hover::before {
    
  left: 0; /* Slide to the right */
  content: "Cancel Now"; /* New text */
}
td{
}
    p.succeed, p.error  {
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
<body>
    <div class="wrapper">
        <div class="sidebar">        
            <ul>
                <li><a href="home.php"><img src="image/dog.png" alt="EzSalon" class="img-dog"><h2>Home</h2></a></li>
                <li><a href="pet_details.php"><i class="fa fa-paw"></i>Pet</a></li>
                <li><a href="service.php"><i class="fa fa-book"></i>Service</a></li>
                <li class="active"><a href="appointment.php"><i class="fa fa-calendar-check-o"></i>Check Appointment</a></li>
                <li><a href="history.php"><i class="fa fa-history"></i>History</a></li>
                <li><a href="profile.php"><i class="fa fa-user-circle-o"></i>Profile</a></li>
                <li><a href="about_us.php"><i class="fa fa-info-circle"></i>About Us</a></li>
                <li><a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a></li>
            </ul>
        </div>
        <div class="main_content">
            <div class="header">                
                <h1>View appointment.</h1>
            </div>
            <div class="breadcrum">
                <a href="home.php">Home</a> >
                <span class="disable-links"><a href="#">Appointment</a></span>
            </div>
            <div class="info appointment">    
               <div style="margin:20px;">            
                <div>
                    <?php if (isset($_GET['error'])){ ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
                    <?php } ?>
                    <?php if (isset($_GET['info'])){ ?>
                    <p class="succeed"><?php echo $_GET['info']; ?></p>
                    <?php } ?>
                    <form action="appointment.php" method="post">
                    <button type="submit"><i class="fa fa-search" style="border-radius=50px"></i></button>
                    <input type="date" name="lastDate" id="lastDate" class="searchbar" placeholder="Search.." value="" required>
                    <label for="">To Date:</label>
                    <input type="date" name="firstDate" id="firstDate" class="searchbar" placeholder="Search.." value="" required>
                    <label for="">From Date:</label>
                    <input type="hidden" value="" name="todayDate" id="todayDate">
                    <input type="hidden" value="" name="latestDate" id="latestDate">
                    </form>           
                </div>
                <table><br>      
                <p class="total">Total results: 
                    <?php if (isset($_POST["firstDate"]) && isset($_POST["lastDate"])) {
                        $firstdate = $_POST["firstDate"];
                        $lastdate = $_POST["lastDate"];
                        $email = $_SESSION['email'];
                        $sql = "SELECT * FROM appointment WHERE email = '$email' AND (status = 'Open' OR status = 'Cancelled' OR status = 'InProgress') AND appointment_date BETWEEN '$firstdate' AND '$lastdate' ORDER BY appointment_date, appointment_time";
                        $result = mysqli_query($conn, $sql);
                        if (!$result) {
                            die("0");
                        }
                        if (mysqli_num_rows($result)>0){
                            echo "<b>".mysqli_num_rows($result)."</b>";} 
                        else {
                            echo "0";
                        }                           
                    }else{
                        $email = $_SESSION['email']; 
                        $sql = "SELECT * FROM appointment WHERE email='$email' AND (status = 'Open' OR status = 'Cancelled' OR status = 'InProgress') AND appointment_date BETWEEN '$today' AND '$afterThreeMonths' ";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result)>0){
                            echo mysqli_num_rows($result);} 
                        else {
                            echo "0";
                        }   }  ?></p>
                    <tr>
                        <th>Appointment ID</th>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Service</th>
                        <th>Pet Name</th>
                        <th>Status</th>
                        <th colspan="2">Button</th>                        
                    </tr>
                    <?php
                    if (isset($_POST["firstDate"]) && isset($_POST["lastDate"])) {
                        $firstdate = $_POST["firstDate"];
                        $lastdate = $_POST["lastDate"];
                        $email = $_SESSION['email'];
                        $sql = "SELECT  a.*, p.pet_name FROM appointment a INNER JOIN pet p ON a.pet_id = p.pet_id WHERE a.email = '$email' AND (a.status = 'Open' OR a.status = 'Cancelled' OR a.status = 'InProgress') AND a.appointment_date BETWEEN '$firstdate' AND '$lastdate' ORDER BY a.appointment_date, a.appointment_time";
                        $result = mysqli_query($conn, $sql);
                        if (!$result) {
                            die("Please select a date!");
                        }
                        if (mysqli_num_rows($result)>0){
                        while ($row= mysqli_fetch_array($result)) { ?>
                        <tr>
                            <td><?php echo $row['appointment_id']; ?></td>
                            <td><?php echo $row['appointment_date']; ?></td>
                            <td><?php echo $row['appointment_time']; ?></td>
                            <td><?php echo $row['service']; ?></td>
                            <td><?php echo $row['pet_name']; ?></td>
                            <?php $statusClass = strtolower('status-' . $row['status']); ?>
                            <td class="<?php echo $statusClass; ?>"><?php echo $row['status']; ?></td>
                            <?php if ($row['status'] == 'InProgress' OR $row['status'] == 'Completed'){?>
                            <td  class="tdbtn"><button class="cckstatus" onclick="checkStatus(<?php echo $row['appointment_id']; ?>)">Check Status</button></td>  
                            <?php }else{} ?>
                            <td  <?php if($row['status'] == 'Cancelled' OR $row['status'] == 'Open'){ echo "colspan=\"2\""; }?> class="tdbtn"><button class="cancelbtn" onclick="confirmCancellation(<?php echo $row['appointment_id']; ?>)">Cancel<br>Appointment</button></td>
                        </tr>
                        <?php
                        }                
                        }
                    }else{
                        $email = $_SESSION['email'];
                        $sql = "SELECT  a.*, p.pet_name FROM appointment a INNER JOIN pet p ON a.pet_id = p.pet_id WHERE a.email = '$email' AND (a.status = 'Open' OR a.status = 'Cancelled' OR a.status = 'InProgress') AND a.appointment_date BETWEEN '$today' AND '$afterThreeMonths' ORDER BY a.appointment_date, a.appointment_time";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                        if (mysqli_num_rows($result)>0){
                        while ($row= mysqli_fetch_array($result)) { ?>
                        <tr>
                            <td><?php echo $row['appointment_id']; ?></td>
                            <td><?php echo $row['appointment_date']; ?></td>
                            <td><?php echo $row['appointment_time']; ?></td>
                            <td><?php echo $row['service']; ?></td>
                            <td><?php echo $row['pet_name']; ?></td>
                            <?php $statusClass = strtolower('status-' . $row['status']); ?>
                            <td class="<?php echo $statusClass; ?>"><?php echo $row['status']; ?></td>
                            <?php if ($row['status'] == 'InProgress' OR $row['status'] == 'Completed'){?>                            
                            <td  class="tdbtn"><button class="cckstatus" onclick="checkStatus(<?php echo $row['appointment_id']; ?>)">Check Status</button></td>  
                            <?php }else{} ?>
                            <td <?php if($row['status'] == 'Cancelled' OR $row['status'] == 'Open'){ echo "colspan=\"2\""; }?> class="tdbtn"><button class="cancelbtn" onclick="confirmCancellation(<?php echo $row['appointment_id']; ?>)">Cancel<br>Appointment</button></td>
                        </tr>
                <?php
                        }} }}
                ?>
                </table>
                </div>
            </div>
        </div>
    </div>
<script>
function checkStatus(appointmentId) {
        window.location.href = 'checkstatus.php?appt_id=' + appointmentId;
    
}        
function confirmCancellation(appointmentId) {
    var confirmResult = confirm("Do you want to cancel this appointment?");

    if (confirmResult) {
        // Redirect to the URL with the cancel_id parameter
        window.location.href = 'appointment.php?cancel_id=' + appointmentId;
    }
}  
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
    document.getElementById("firstDate").setAttribute('min',minDate);    
    document.getElementById("lastDate").setAttribute('min',minDate);
    document.getElementById("todayDate").value = minDate;
    var month = date.getMonth() +4; 
    if (month>12){
        month -= 12;
        month = '0'+ month;        
         year +=1; 
    } 
    var maxDate = year + "-" +month + "-"+tdate;
    document.getElementById("firstDate").setAttribute('max',maxDate);
    document.getElementById("lastDate").setAttribute('max',maxDate);
    document.getElementById("latestDate").value = maxDate;
</script>
</body>
</html>