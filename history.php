<?php
    include 'config.php';
?>
<?php
    session_start();
    if(!isset($_SESSION['email'])){
    header("Location: login.php");
    }   
    
    $email = $_SESSION['email'];
    $yesterday = new DateTime();
    $yesterday = $yesterday->format('Y-m-d');
    
    $oneYearAgo = new DateTime();
    $oneYearAgo->sub(new DateInterval('P1Y'));
    $oneYearAgo =$oneYearAgo->format('Y-m-d') ;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Page</title>
    <link rel="stylesheet" type="text/css" href="css/style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>

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
                <li class="active"><a href="history.php"><i class="fa fa-history"></i>History</a></li>
                <li><a href="profile.php"><i class="fa fa-user-circle-o"></i>Profile</a></li>
                <li><a href="about_us.php"><i class="fa fa-info-circle"></i>About Us</a></li>
                <li><a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a></li>
            </ul>
        </div>
        <div class="main_content">
            <div class="header" style="display: flex; align-items: center; ">                
                <h1>View History </h1><p> (Only Available 12 Months Records)</p>
            </div>
            <div class="breadcrum"> 
            <a href="home.php">Home</a> >
                <span class="disable-links"><a href="#">History</a></span>
                </div>
            <div class="info appointment"> 
               <div style="margin:20px;">
                <div>                    
                    <?php if (isset($_GET['info'])){ ?>
                    <p class="succeed"><?php echo $_GET['info']; ?></p>
                    <?php } ?>
                    <form action="history.php" method="post">
                    <button type="submit"><search class="fa fa-search"></i></button>
                    <input type="date" name="lastDate" id="lastDate" class="searchbar" placeholder="Search.." value="" required min="<?php echo $oneYearAgo; ?>"  max="<?php echo $yesterday; ?>">
                    <label for="">To Date:</label>
                    <input type="date" name="firstDate" id="firstDate" class="searchbar" placeholder="Search.." value="" required  min="<?php echo $oneYearAgo; ?>" max="<?php echo $yesterday; ?>">
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
                        $sql = "SELECT * FROM appointment WHERE email = '$email' AND (status = 'Completed' OR status = 'Cancelled') AND appointment_date BETWEEN '$firstdate' AND '$lastdate' ORDER BY appointment_date, appointment_time";
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
                        $sql = "SELECT * FROM appointment WHERE email='$email' AND (status = 'Completed' OR status = 'Cancelled') AND appointment_date BETWEEN '$oneYearAgo' AND '$yesterday' ";
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
                        <th>Button</th>                   
                    </tr>
                    <?php
                    if (isset($_POST["firstDate"]) && isset($_POST["lastDate"])) {
                        $firstdate = $_POST["firstDate"];
                        $lastdate = $_POST["lastDate"];
                        $sql = "SELECT a.*, p.pet_name FROM appointment a INNER JOIN pet p ON a.pet_id = p.pet_id WHERE a.email = '$email' AND (a.status = 'Completed' OR a.status = 'Cancelled') AND a.appointment_date BETWEEN '$firstdate' AND '$lastdate' ORDER BY a.appointment_date, a.appointment_time";
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
                            <?php }else{ ?>
                            <td class="tdbtn"><button class="cckstatus2">-</button></td>  
                            <?php } ?> 
                            </tr>
                        <?php
                        }
                
                    }}else{
                        $sql = "SELECT a.*, p.pet_name FROM appointment a INNER JOIN pet p ON a.pet_id = p.pet_id WHERE a.email = '$email' AND (a.status = 'Completed' OR a.status = 'Cancelled') AND a.appointment_date BETWEEN '$oneYearAgo' AND '$yesterday' ORDER BY a.appointment_date, a.appointment_time";
                        $result = mysqli_query($conn, $sql);
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
                            <?php }else{ ?>
                            <td class="tdbtn"><button class="cckstatus2">-</button></td>  
                            <?php } ?>                            
                        </tr>                                           
                <?php
                        }} }
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
</script>      
</body>
</html>