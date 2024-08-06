<?php
    include 'config.php';
?>
<?php
    session_start();
    if(!isset($_SESSION['email'])){
    header("Location: login.php");
    }    
    $email= $_SESSION['email'];
    $sql = "SELECT * FROM pet WHERE email= '$email'";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
    }
    $petid = isset($_GET['id']) ? $_GET['id'] : '';
    if($petid){
        $sql ="DELETE FROM pet WHERE pet_id='".$petid."'";
        if($conn ->query($sql)===TRUE){
            echo "<br>";
            header("Location: pet_details.php?info=The pet details has been DELETED!");
    }}
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Details</title>
    <link rel="stylesheet" type="text/css" href="css/style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    
    
</head>
<style>
.add_pet img {
    margin-top:30px;
    transition: transform 0.3s ease-in-out;
}

.add_pet img:hover {
    transform: scale(1.1);
}
p {
    text-align: center;
    font-size: 20px;
    color: #333;
    font-weight: bold;
    animation: fadeIn 1s forwards, zoomInOut 0.7s infinite alternate;
}
h5{
    font-weight:normal;
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
                <li><a href="home.php"><img src="image/dog.png" alt="EzSalon" class="img-dog"> 
                <h2>Home</h2></a></li>
                <li  class="active"><a href="pet_details.php"><i class="fa fa-paw"></i>Pet</a></li>
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
                <h1>Your lover pet details</h1>            
            </div>
            <div class="breadcrum"> 
            <a href="home.php">Home</a> >
                <span class="disable-links"><a href="#">Pet Details</a></span>
                </div>
            <div class="info">
            <?php if (isset($_GET['info'])){ ?>
                    <p class="succeed"><?php echo $_GET['info']; ?></p>
                    <?php } ?>
                  
            <?php if (mysqli_num_rows($result)>0){
            while ($row= mysqli_fetch_array($result)) {                
            echo '<div class="pet">';?>
               <h5>Pet's Photo:</h5><br><img src="uploads/<?php echo $row['pet_photo']; ?>" alt="Pets Photo" width=300 height=300>
            <?php
            echo "<h5>Pet's Name </h5>:<p>".$row['pet_name']."</p><br>";
            echo "<h5 style=\"padding-right:15px;\">Category </h5>:<p>".$row['category']."</p><br>";
            echo "<h5 style=\"padding-right:42px;\">Breed </h5>:<p>".$row['breed']."</p><br>";
            echo "<h5 style=\"padding-right:20px;\">Remarks </h5>:<p>".$row['remarks']."</p><br>";
            echo "<a href='edit_pet.php?id={$row['pet_id']}' class='edit-btn'>Edit</a>";?>
            <a href="#" onclick="confirmDelete(<?php echo $row['pet_id']; ?>)" class='delete-btn'>Delete</a><?php 
            echo '</div>';
            }}
            ?>
            <div class="add_pet">
            <p >Click here to add pet<br><a href="pet_register.php"><img src="image/add-btn.png" alt="Add Pet" width=60%  height=60% ></a>
            <!--should show the pet pic-->
            </p>  
            </div>
            
              
        </div>
    </div>
    
<script>
    function confirmDelete(petId) {
        var confirmResult = confirm("Do you want to delete this pet?");

        if (confirmResult) {
            window.location.href = 'pet_details.php?id=' + petId;
        }
    }  
</script>
</body>
</html>