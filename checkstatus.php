<?php
    include 'config.php';
?>
<?php
    session_start();
    if(!isset($_SESSION['email'])){
    header("Location: login.php");
    }
    $email = $_SESSION['email'];
    $apptid = isset($_GET['appt_id']) ? $_GET['appt_id'] : ''; 
                
               
    

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Appointment Status</title>
    <link rel="stylesheet" type="text/css" href="css/style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        input[type="text"]{
            font-weight:bold;
            text-align:center;
            color:black;
        }
        h5, p.state {
            display: inline;
            padding-left: 10px;
            font-weight:normal;
        }
        p.state{
            font-weight:bold;
            font-size:23px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="sidebar">
            <ul>
                <li><a href="home.php"><img src="image/dog.png" alt="EzSalon" class="img-dog"><h2>Home</h2></a></li>
                <li><a href="pet_details.php"><i class="fa fa-paw"></i>Pet</a></li>
                <li><a href="service.php"><i class="fa fa-book"></i>Service</a></li>
                <li  class="active"><a href="appointment.php"><i class="fa fa-calendar-check-o"></i>Check Appointment</a></li>
                <li><a href="history.php"><i class="fa fa-history"></i>History</a></li>
                <li><a href="profile.php"><i class="fa fa-user-circle-o"></i>Profile</a></li>
                <li><a href="about_us.php"><i class="fa fa-info-circle"></i>About Us</a></li>
                <li><a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a></li>
            </ul>
        </div>
        <div class="main_content">
            <div class="header">
                <h1>Check Status</h1>
            </div>
            <div class="breadcrum">
                <a href="home.php">Home</a> >
                <a href="appointment.php">Appointment</a> >
                <span class="disable-links"><a href="#">Check Status</a></span>
            </div>
            <div class="breadcrum"> 
            </div>
            <div class="info status">
            <?php 
            if($apptid){
                $sql = mysqli_query($conn, "SELECT s.*,a.* FROM appointment_status s INNER JOIN appointment a ON s.appointment_id = a.appointment_id  WHERE s.appointment_id='$apptid'");
                if ($sql) {
                    if(mysqli_num_rows($sql)>0){
                    $fetch = mysqli_fetch_assoc($sql);      
                    $service = $fetch['service'];             
                    $petid = $fetch['pet_id'];
                    $sql2 = mysqli_query($conn, "SELECT * FROM pet WHERE pet_id = '$petid'");
                    if(mysqli_num_rows($sql2)>0){
                        $pet = mysqli_fetch_assoc($sql2);}       
                        if($fetch['picture1'] == ""){
                            $stage = "stage1";
                        }else if($fetch['picture2'] == ""){
                            $stage = "stage2";
                        }else if($fetch['picture3'] == ""){
                            $stage = "stage3";
                        }else if($fetch['picture4'] == ""){
                            $stage = "stage4";
                        }else if($fetch['picture5'] == ""){
                            $stage = "stage5";
                        }else{
                            $stage= "";
                        }   ?>
                            <section class="step-wizard">
                                <ul class="step-wizard-list">
                                    <li class="step-wizard-item <?php if($stage == "stage1"){ echo "current-item"; }?>">
                                        <span class="progress-count">1</span>
                                        <span class="progress-label">Nail Clipping</span>
                                    </li>
                                    <li class="step-wizard-item <?php if($stage == "stage2"){ echo "current-item"; }?>">
                                        <span class="progress-count">2</span>
                                        <span class="progress-label">Cleaning of Ears</span>
                                    </li>
                                    <li class="step-wizard-item <?php if($stage == "stage3"){ echo "current-item"; }?>">
                                        <span class="progress-count">3</span>
                                        <span class="progress-label">Shaving Part</span>
                                    </li>
                                    <li class="step-wizard-item <?php if($stage == "stage4"){ echo "current-item"; }?>">
                                        <span class="progress-count">4</span>
                                        <span class="progress-label">Bathing</span>
                                    </li>
                                    <?php if ($service == "Full Grooming"){?>
                                        <li class="step-wizard-item <?php if($stage == "stage5"){ echo "current-item"; }?>">
                                            <span class="progress-count">5</span>
                                            <span class="progress-label">Fur cut and styling</span>
                                        </li>
                                    <?php }else if ($service == "Spa and Massage"){?>
                                        <li class="step-wizard-item <?php if($stage == "stage5"){ echo "current-item"; }?>">
                                            <span class="progress-count">5</span>
                                            <span class="progress-label">Spa and Massage</span>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </section><br>
                            <div class="form-row">
                                <label>Appointment ID:</label>
                                <input type="text" name='appointmentid' value="<?php echo $fetch['appointment_id']; ?>" placeholder="" disabled>

                                <label>Appointment Date:</label>
                                <input type="text" name='appointmentdate' value="<?php echo $fetch['appointment_date']; ?>" placeholder="" disabled>

                                <label>Appointment Time:</label>
                                <input type="text" name='appointmenttime' value="<?php echo $fetch['appointment_time']; ?>" placeholder="" disabled>
                            </div>
                            <div class="form-row">
                                <label>Pet Name:</label><br>
                                <input type="text" name='petid' value="<?php echo $pet['pet_name']; ?>" placeholder="" disabled><br>
                                <label>Service:</label><br>
                                <input type="text" name='service' value="<?php echo $fetch['service']; ?>" placeholder="" disabled><br>
                            </div>
                            <?php if($fetch['picture1'] <> ""){ ?>                                    
                                <div class="step-wizard-lists"><br>
                                    <h2><u>Stage 1 - Nail Clipping</u></h2><br>
                                    <h5>Photo:</h5><br>
                                    <img src="../admin/uploads/<?php echo $fetch['picture1']; ?>" alt="Photo" width=300 height=250><br>
                                    <h5>Done By Staff : </h5><p class="state"><?php echo $fetch['staff1']; ?></p><br>
                                    
                                    <h5>Completion Time : </h5><p class="state"><?php echo $fetch['appointment_time']; ?> - <?php echo $fetch['time1']; ?></p><br>
                                </div>   
                                    <?php }else{ ?>
                                        <p class="succeed">Stage 1 service In Progress..</p>
                                    <?php } ?>                            
                            <?php if($fetch['picture2'] <> ""){ ?>                                                           
                                <div class="step-wizard-lists"><br>                                                               
                                    <h2><u>Stage 2 - Cleaning of Ears</u></h2><br> 
                                    <h5>Photo:</h5><br>
                                    <img src="../admin/uploads/<?php echo $fetch['picture2']; ?>" alt="Photo" width=300 height=250><br>
                                    <h5>Done By Staff : </h5><p class="state"><?php echo $fetch['staff2']; ?></p><br>
                                    
                                    <h5>Completion Time : </h5><p class="state"><?php echo $fetch['time1']; ?> - <?php echo $fetch['time2']; ?></p><br>
                                </div> 
                                    <?php }else{ ?>
                                        <p class="succeed">Stage 2 service In Progress..</p>
                                    <?php } ?> 
                                
                            <?php if($fetch['picture3'] <> ""){ ?> 
                                <div class="step-wizard-lists"><br>                                                              
                                    <h2><u>Stage 3 - Shaving Part</u></h2><br> 
                                    <h5>Photo:</h5><br>
                                    <img src="../admin/uploads/<?php echo $fetch['picture3']; ?>" alt="Photo" width=300 height=250><br>
                                    <h5>Done By Staff : </h5><p class="state"><?php echo $fetch['staff3']; ?></p><br>
                                    
                                    <h5>Completion Time : </h5><p class="state"><?php echo $fetch['time2']; ?> - <?php echo $fetch['time3']; ?></p><br>
                                </div>      
                                    <?php }else{ ?>
                                        <p class="succeed">Stage 3 service In Progress..</p>
                                    <?php } ?> 
                              
                            <?php if($fetch['picture4'] <> ""){ ?>                                    
                                <div class="step-wizard-lists"><br>                                                              
                                    <h2><u>Stage 4 - Bathing</u></h2><br> 
                                    <h5>Photo:</h5><br>
                                    <img src="../admin/uploads/<?php echo $fetch['picture4']; ?>" alt="Photo" width=300 height=250><br>
                                    <h5>Done By Staff : </h5><p class="state"><?php echo $fetch['staff4']; ?></p><br>
                                    
                                    <h5>Completion Time : </h5><p class="state"><?php echo $fetch['time3']; ?> - <?php echo $fetch['time4']; ?></p><br>
                                </div>
                                    <?php }else{ ?>
                                        <p class="succeed">Stage 4 service In Progress..</p>
                                    <?php } ?> 
                                  
                            <?php if ($service == "Full Grooming"){?>
                                    <?php if($fetch['picture5'] <> ""){ ?>  
                                <div class="step-wizard-lists"><br>                                                            
                                    <h2><u>Stage 5 - Fur cut and styling</u></h2><br> 
                                    <h5>Photo:</h5><br>
                                    <img src="../admin/uploads/<?php echo $fetch['picture5']; ?>" alt="Photo" width=300 height=250><br>
                                    <h5>Done By Staff : </h5><p class="state"><?php echo $fetch['staff5']; ?></p><br>
                                    
                                    <h5>Completion Time : </h5><p class="state"><?php echo $fetch['time4']; ?> - <?php echo $fetch['time5']; ?></p><br>
                                </div>   
                                    <?php }else{ ?>
                                        <p class="succeed">Stage 5 service In Progress..</p>
                                    <?php } ?>
                                           
                            <?php }else if ($service == "Spa and Massage"){?>
                                    <?php if($fetch['picture5'] <> ""){ ?> 
                                <div class="step-wizard-lists"><br>                                                             
                                    <h2><u>Stage 5 - Spa and Massage</u></h2><br> 
                                    <h5>Photo:</h5><br>
                                    <img src="../admin/uploads/<?php echo $fetch['picture5']; ?>" alt="Photo" width=300 height=250><br>
                                    <h5>Done By Staff : </h5><p class="state"><?php echo $fetch['staff5']; ?></p><br>
                                    
                                    <h5>Completion Time : </h5><p class="state"><?php echo $fetch['time4']; ?> - <?php echo $fetch['time5']; ?></p><br>
                                </div> 
                                    <?php }else{ ?>
                                        <p class="succeed">Stage 5 service In Progress..</p>
                                    <?php } ?>
                                <?php } ?>
                                    
                  <?php }else{ ?>
                     <p class="error">Service haven't start!</p>
                     <?php } }   }  else {   ?>
                           <p class="error">Service haven't start!</p>
             <?php    }    ?>
            
                
            </div>
        </div>
    </div>
</body>
</html>