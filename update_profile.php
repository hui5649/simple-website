<?php
include 'config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit; // Make sure to exit to stop further execution
}

// Retrieve the user's email from the session
$email = $_SESSION['email'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form inputs (you can add more fields as needed)
    $newFirstName = mysqli_real_escape_string($conn, $_POST['first_name']);
    $newLastName = mysqli_real_escape_string($conn, $_POST['last_name']);
    $newPhoneNumber = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $newGender = mysqli_real_escape_string($conn, $_POST['gender']);
    $newICNumber = mysqli_real_escape_string($conn, $_POST['ic_number']);

    $errors = array();

    if (!preg_match("/^[a-zA-Z\s]+$/", $newFirstName)) {
        $errors['fname'] = "First name must contain only alphabets";
    }
    if (!preg_match("/^[a-zA-Z]+$/", $newLastName)) {
        $errors['lname'] = "Last name must contain only alphabets";
    }
    if (!preg_match('/^\+60[0-9]{2}-[0-9]{7,8}$/', $newPhoneNumber)) {
        $errors['phone'] = "Invalid phone number format. It should be like +60xx-xxxxxxxx";
    }
    if (!preg_match('/^[0-9]{6}-[0-9]{2}-[0-9]{4}$/', $newICNumber)) {
        $errors['ic_number'] = "Invalid IC number format. It should be like 111111-11-1111";
    }
    if (empty($newGender)) {
        $errors['gender'] = "Select your gender";
    }

    if (empty($errors)) {
        $updateQuery = "UPDATE customer SET first_name = '$newFirstName', last_name = '$newLastName', phone_number = '$newPhoneNumber', gender='$newGender', ic_number='$newICNumber' WHERE email = '$email'";
        $result = mysqli_query($conn, $updateQuery);

        if ($result) {
            // Profile update was successful
            header("Location: update_profile.php?info=Profile updated successfully.");
        } else {
            // Profile update failed
            echo "Profile update failed. Please try again.";
        }
    }
}

// Retrieve the current user's profile information
$profileQuery = "SELECT * FROM customer WHERE email = '$email'";
$profileResult = mysqli_query($conn, $profileQuery);

if ($profileResult && mysqli_num_rows($profileResult) > 0) {
    $profileData = mysqli_fetch_assoc($profileResult);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="css/style1.css">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
    /* Add a background image */
    body {
        background-image: url('your-background-image.jpg');
        background-size: cover;
        background-repeat: no-repeat;
    }

    /* Adjust the font styles */
    body, input, select {
        font-family: Arial, sans-serif;
    }

    /* Style the header */
    .header {
        background-color: #3498db;
        color: white;
        padding: 15px;
        font-size: 24px;
    }

    /* Style the update_profile container */
    .update_profile {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        margin:20px;
        
    }

    /* Style the input fields */
    input[type="text"],
    input[type="radio"] {
        width: 95%;
        padding: 10px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }
    input[type="radio"]{
        width:2%;
    }
    /* Style the error messages */
    .error {
        color: red;
        font-size: 14px;
        margin-left: 10px;
        display: inline-block;
    }

    /* Style the submit button */
    .submit-update-profile {
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

    .submit-update-profile:hover {
        background: linear-gradient(135deg, #bf4a45, #3498db);
        transform: scale(1.05);
    }

    /* Style the success message */
    .succeed {
        font-size: 16px;
        margin-top: 10px;
    }

   

    .sidebar a:hover {
        color: #3498db;
    }



    /* Style the form labels */
    label {
        font-weight: bold;
    }

    /* Style the navigation links */
    ul {
        list-style-type: none;
        padding: 0;
    }


    

    /* Adjust the link styles */
    a {
        text-decoration: none;
        color: #3498db;
    }

    a:hover {
        text-decoration: underline;
    }
    
</style>

</head>
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
                <li class="active"><a href="profile.php"><i class="fa fa-user-circle-o"></i>Profile</a></li>
                <li><a href="about_us.php"><i class="fa fa-info-circle"></i>About Us</a></li>
                <li><a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a></li>
            </ul>
        </div>
        <div class="main_content">
            <div class="header">
                <h1>Update your profile</h1>
            </div>
            <div class="breadcrum"> 
            <a href="home.php">Home</a> >
            <a href="profile.php">Profile</a> >
            <span class="disable-links"><a href="#">Update Profile</a></span>
            </div>
            <div class="info">
            <div class="update_profile">
                
            <h2>Edit Profile</h2>
                <?php if (isset($_GET['info'])){ ?>
                    <p class="succeed"><?php echo $_GET['info']; ?></p>
                <?php } ?>
                <br>
                <form method="post" action="update_profile.php">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo $profileData['first_name']; ?>" required><br>

                    <?php if (isset($errors['fname'])) echo "<span class='error'>" . $errors['fname'] . "</span>"; ?>

                    <br>

                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo $profileData['last_name']; ?>" required><br>

                    <?php if (isset($errors['lname'])) echo "<span class='error'>" . $errors['lname'] . "</span>"; ?>

                    <br>

                    <label for="phone_number">Phone Number: </label>
                    <input type="text" name="phone_number" value="<?php echo $profileData['phone_number']; ?>" placeholder="+6011-11112222 or +6011-1111222" required><br>

                    <?php if (isset($errors['phone'])) echo "<span class='error'>" . $errors['phone'] . "</span>"; ?>

                    <br>
                    <label for="gender">Gender:</label>
                    <input type="radio" name="gender" value="M" <?php echo ($profileData['gender'] === 'M') ? 'checked' : ''; ?>> Male
                    <input type="radio" name="gender" value="F" <?php echo ($profileData['gender'] === 'F') ? 'checked' : ''; ?>> Female<br>
                    <?php if (isset($errors['gender'])) echo "<span class='error'>" . $errors['gender'] . "</span>"; ?>

                    <br>

                    <label for="ic_number">IC number:</label>
                    <input type="text" id="ic_number" name="ic_number" value="<?php echo $profileData['ic_number']; ?>" placeholder="111111-11-1111" required><br>

                    <?php if (isset($errors['ic_number'])) echo "<span class='error'>" . $errors['ic_number'] . "</span>"; ?>
                    <br>
                    <input type="submit" name="update_profile" value="Update Profile" class="submit-update-profile"><br><br>
                    <a href="profile.php">Back to Profile</a>
                </form>
            </div>
            
        </div>
        </div>
    </div>
</body>
</html>
