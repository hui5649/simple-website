<?php
    include 'config.php';
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['email'])) {
        header("Location: login.php");
        exit; // Make sure to exit to stop further execution
    }

    if(isset($_GET['id'])){
        $pet_id = $_GET['id'];}
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve and sanitize form inputs (you can add more fields as needed)
        $newPetName = mysqli_real_escape_string($conn, $_POST['pet_name']);
        $newCategory = mysqli_real_escape_string($conn, $_POST['category']);
        $newBreed = mysqli_real_escape_string($conn, $_POST['breed']);
        $newRemarks = mysqli_real_escape_string($conn, $_POST['remarks']);
        $pet_id = mysqli_real_escape_string($conn, $_POST['pet_id']);
        // Update the user's profile information in the database
        $img_name = $_FILES['petImage']['name'];
        $img_size = $_FILES['petImage']['size'];
        $tmp_name = $_FILES['petImage']['tmp_name'];
        $error = $_FILES['petImage']['error'];

            if($error === 0 ){
                if($img_size > 1000000){
                    $em = "Sorry , your file is too large.";
                    header("Location:edit_pet.php?error=$em&&id=$pet_id");
                }else{
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_lc = strtolower($img_ex);

                    $allowed_exs = array("jpg","jpeg","png");
                    if(in_array($img_ex_lc, $allowed_exs)){
                        $new_img_name = uniqid("IMG-",true).'.'.$img_ex_lc;
                        $img_upload_path = 'uploads/'.$new_img_name;
                        move_uploaded_file($tmp_name, $img_upload_path);
                        $updateQuery = "UPDATE pet SET pet_photo = '$new_img_name', pet_name = '$newPetName', category = '$newCategory', breed = '$newBreed', remarks = '$newRemarks' WHERE pet_id = '$pet_id'";
                        $result = mysqli_query($conn, $updateQuery);
                        if ($result) {
                            header("Location:edit_pet.php?id=$pet_id&&info=Your pet has updated successfully!");
                            
                            exit();
                        }
                    }else{
                        $em = "You cannot upload files of this type";
                        header("Location:edit_pet.php?error=$em&&id=$pet_id");
                    }
                }
            }else{
                $updateQuery = "UPDATE pet SET pet_name = '$newPetName', category = '$newCategory', breed = '$newBreed', remarks = '$newRemarks' WHERE pet_id = '$pet_id'";
                $result = mysqli_query($conn, $updateQuery);
                if ($result) {
                    header("Location:edit_pet.php?id=$pet_id&&info=Your pet has updated successfully!");                    
                    exit();
                }             
            }}        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pet Details</title>
    <link rel="stylesheet" type="text/css" href="css/style1.css">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style> 
        #previewImage {
            display: block;
            margin-top: 20px; /* Adjust the margin as needed */
        }
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
</head>
<body>
    <div class="wrapper">
        <div class="sidebar">
            <ul>
                <li><a href="home.php"><img src="image/dog.png" alt="EzSalon" class="img-dog"><h2>Home</h2></a></li>
                <li class="active"><a href="pet_details.php"><i class="fa fa-paw"></i>Pet</a></li>
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
                <h1>Edit Pet Details</h1>
            </div>
            <div class="breadcrum"> 
                <a href="home.php">Home</a> >
                <a href="pet_details.php">Pet Details</a> >
                <span class="disable-links"><a href="#">Update Pet Details</a></span>
            </div>
            <div class="edit_pet">
                <div class="apptform">
                <form method="post" action="edit_pet.php" enctype="multipart/form-data">
                    <?php
                    if(isset($_GET['id'])){
                        // Retrieve the current user's profile information
                        $profileQuery = "SELECT * FROM pet WHERE pet_id = '$pet_id'";
                        $profileResult = mysqli_query($conn, $profileQuery);

                        if ($profileResult && mysqli_num_rows($profileResult) > 0) {
                            $profileData = mysqli_fetch_assoc($profileResult);
                        }}?>
                    <?php if (isset($_GET['error'])){ ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
                    <?php } ?>
                    <?php if (isset($_GET['info'])){ ?>
                    <p class="succeed"><?php echo $_GET['info']; ?></p>
                    <?php } ?>
                    <input type="hidden" id="pet_id" name="pet_id" value="<?php echo $profileData['pet_id']; ?>">
                    <label>Pet's Photo:</label>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div style="padding-left:20px;">                        
                    <br> <img src="uploads/<?php echo $profileData['pet_photo']; ?>" alt="Pets Photo" width=300 height=300>                        
                    </div>
                    <div style=" text-align: center;">
                    <span id="arrowLine" style='font-size:100px; display: none;'><br>&#8680;</span>
                    </div>
                    <div style="flex: 1; text-align: center;">
                    <img id="previewImage" src="" alt="Uploaded Image" style="max-width: 300px; display: none; "  width=300 height=300><br>
                    </div>
                    </div>
                    <label for="petImage">Choose a pet's picture:</label>
                    <input type="file" id="petImage" name="petImage" accept=".png, .jpeg, .jpg" >                    
                    <script>
                    // Function to preview the selected image
                    function previewImage(input) {
                    var preview = document.getElementById('previewImage');
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                            arrowLine.style.display = 'block'; 
                        };
                        reader.readAsDataURL(input.files[0]);
                        } else {
                            preview.src = '';
                            preview.style.display = 'none';
                            arrowLine.style.display = 'none'; 
                        }
                    }
                    // Attach an event listener to the file input
                    document.getElementById('petImage').addEventListener('change', function () {
                        previewImage(this);
                    });
                    </script>   
                    <br><label for="pet_name">Pet's Name:</label><br>
                    <input type="text" id="pet_name" name="pet_name" value="<?php echo $profileData['pet_name']; ?>" required><br><br>
                    <label>Category:</label>       <br>                 
                    <select name="category" id="category">
                        <option value="Dog" <?php echo ($profileData['category'] === 'Dog') ? 'selected' : ''; ?>>Dog</option>
                        <option value="Cat" <?php echo ($profileData['category'] === 'Cat') ? 'selected' : ''; ?>>Cat</option>
                        <option value="Hamster" <?php echo ($profileData['category'] === 'Hamster') ? 'selected' : ''; ?>>Hamster</option>
                        <option value="Rabbit" <?php echo ($profileData['category'] === 'Rabbit') ? 'selected' : ''; ?>>Rabbit</option>                        
                        <option value="Others" <?php echo ($profileData['category'] === 'Others') ? 'selected' : ''; ?>>Others</option>
                    </select>
                    <br><br>
                    <label>Breed:</label><br>
                    <input type="text" id="breed" name="breed" size="35" value="<?php echo $profileData['breed']; ?>"  required> <br>  <br>                     
                    <label>Remark (Optional): </label><br>
                    <textarea id="remarks" name="remarks" cols="35" rows="2" ><?php echo $profileData['remarks']; ?></textarea>
                    <br><br>
                    <!-- Add more fields as needed -->
                    <div style="text-align:center;">
                    <button type="submit"><i class="fa fa-save"></i>Save</button>
                    <button type="button" onclick="cancelForm()">Cancel</button> 
                    <br>
                    </div>
                </form>
            </div>
            </div>
    </div>
</div>
<script>
    function cancelForm() { 
        window.location.href = 'pet_details.php';
    }
</script>
</body>
</html>
