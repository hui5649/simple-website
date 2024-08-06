<?php

include 'config.php';

session_start();
if(!isset($_SESSION['email'])){
header("Location: login.php");
}

    if(isset($_POST['addpet'])){
        $pet_name = mysqli_real_escape_string($conn, $_POST['pet_name']);
        $category = mysqli_real_escape_string($conn, $_POST['category']);        
        $breed = mysqli_real_escape_string($conn, $_POST['breed']);
        $remark = mysqli_real_escape_string($conn, $_POST['remark']);
        $email = $_SESSION['email'];        
        $errors = array();
        
        if(!preg_match("/^[a-zA-Z\s]+$/",$pet_name)){
            $errors['pet_name'] = "Pet name must contain only alphabets";
        }
        if(empty($category)){
            $errors['category'] = "Select your pet's category";
        }        
               
            $img_name = $_FILES['petImage']['name'];
            $img_size = $_FILES['petImage']['size'];
            $tmp_name = $_FILES['petImage']['tmp_name'];
            $error = $_FILES['petImage']['error'];

            if($error === 0 ){
                if($img_size > 1000000){
                    $em = "Sorry , your file is too large.";
                    header("Location:pet_register.php?error=$em");
                }else{
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_lc = strtolower($img_ex);

                    $allowed_exs = array("jpg","jpeg","png");
                    if(in_array($img_ex_lc, $allowed_exs)){
                        $new_img_name = uniqid("IMG-",true).'.'.$img_ex_lc;
                        $img_upload_path = 'uploads/'.$new_img_name;
                        move_uploaded_file($tmp_name, $img_upload_path);
                        if(mysqli_query($conn,"INSERT INTO pet(pet_photo, pet_name, category, breed, remarks,email) VALUES ('".$new_img_name."','".$pet_name."','".$category."','".$breed."','".$remark."','".$email."')")){
                            header("Location:pet_register.php?info=Your pet has added successfully!");                            
                            exit();
                        }
                    }else{
                        $em = "You cannot upload files of this type";
                        header("Location:pet_register.php?error=$em");

                    }
                }
            }else{
                $em = "Unknow error occured";
                header("Location:pet_register.php?error=$em");
             
            }}
        
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Registration Form</title>
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
</head>
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
                <h1>Register your pets</h1>
            </div>
            <div class="breadcrum"> 
            <a href="home.php">Home</a> >
                <a href="pet_details.php">Pet Details</a> >
                <span class="disable-links"><a href="#">Pet Register</a></span> 
                </div>          
            <div class="info registerpet">
                <div class="profile">
                <?php if (isset($_GET['error'])){ ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
                <?php } ?>
                <?php if (isset($_GET['info'])){ ?>
                <p class="succeed"><?php echo $_GET['info']; ?></p>
                <?php } ?>
                <h2>Fill in all details.</h2><br>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <label>Pet's Name:</label>
                    <input type="text" id="pet_name" name="pet_name" size="20" required>
                    <br><br>
                    <label for="Category">Select category's pet: </label>
                    <select name="category" id="category">
                        <option value="Dog">Dog</option>
                        <option value="Cat">Cat</option>
                        <option value="Hamster">Hamster</option>
                        <option value="Rabbit">Rabbit</option>                        
                        <option value="Others">Others</option>
                    </select>
                    <br><br>
                    <label for="petImage">Choose a pet's picture:</label>
                    <input type="file" id="petImage" name="petImage" accept=".png, .jpeg, .jpg" required>

                    <!-- Add this code to display the uploaded image -->
                    <img id="previewImage" src="" alt="Uploaded Image" style="max-width: 300px; display: none;" class="image-frame">
                   
                    <script>
                    // Function to preview the selected image
                    function previewImage(input) {
                    var preview = document.getElementById('previewImage');
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        };
                        reader.readAsDataURL(input.files[0]);
                        } else {
                            preview.src = '';
                            preview.style.display = 'none';
                        }
                    }

                    // Attach an event listener to the file input
                    document.getElementById('petImage').addEventListener('change', function () {
                        previewImage(this);
                    });
                    </script>   

                    <br><br>
                    <label>Breed:</label>
                    <input type="text" id="breed" name="breed" size="35" required>
                    <br><br>
                
                    <label>Remark (Optional):</label>
                    <textarea id="remark" name="remark" cols="35" rows="2"></textarea>
                    <br><br>
                    <div class="btn">
                    <input type="submit" name="addpet" value="Add Pet" class="add-petdetail-btn">
                    <br><br>
                    <a href="pet_details.php">Back to Pet Details</a>
                    </div>
                    
                </div>
                </form>
                </div>
        </div>
    </form>

</body>
</html>

</body>
</html>