<?php
    include 'config.php';
?>
<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    if(isset($_POST['signup'])){
        $f_name = mysqli_real_escape_string($conn, $_POST['fname']);
        $l_name = mysqli_real_escape_string($conn, $_POST['lname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);        
        $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
        $phone_no = mysqli_real_escape_string($conn, $_POST['phone_number']);
        $ic_no = mysqli_real_escape_string($conn, $_POST['ic_number']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        
        $errors = array();
        
        if(!preg_match("/^[a-zA-Z\s]+$/",$f_name)){
            $errors['fname'] = "First name must contain only alphabets";
        }
        if(!preg_match("/^[a-zA-Z]+$/",$l_name)){
            $errors['lname'] = "Last name must contain only alphabets";
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = "Please enter valid Email ID";
        }
        if(strlen($phone_no)<10){
            $errors['phone'] = "Mobile Phone number must be minimum 10 characters";
        }
        if(strlen($ic_no)!=14){
            $errors['ic'] = "Please fill in valid IC number";
        }
        if(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/",$password)){
            $errors['pw'] = "Password must be minimum 8 characters and includes both letters and numbers!";
        }
        if($password != $cpassword){
            $errors['cpw'] = "Password and Confirm Password Does' not Match";
        }
        if(empty($gender)){
            $$errors['gender'] = "Select your gender";
        }
        $query = mysqli_query($conn, "SELECT * FROM customer WHERE email= '".$email."'");
            if(mysqli_num_rows($query)>0){
                $errors['email'] = "This Email ID has been registered";
            }else{
        if(count($errors)==0){
            if(mysqli_query($conn,"INSERT INTO customer(first_name, last_name, email, password, phone_number, ic_number, gender, verification) VALUES ('".$f_name."','".$l_name."','".$email."','".$password."','".$phone_no."','".$ic_no."','".$gender."', 'Non-activated')")){
               
            if ($gender == "M") {
                $gender = "Mr. ";
            } elseif ($gender == "F") {
                $gender = "Ms. ";
            } 
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
                $link = 'http://localhost/FYP/Final%20Project%20Wd/user/verification_account.php?email='.$email;
                $mail->Subject = "New Account Created";
                $mail->Body = "Dear ".$gender."".$f_name.",<br><br>Thank you for creating an account in PET GROOMING SALON.<br>Please click the link below to verify your account:<br><a href=".$link.">Click Here</a><br><br>Thank you.";
            
                $mail->send();
                echo '<script>alert("Account created successfully!\nPlease check your email!\nClick Okay will automatically redirect to login page.")</script>';
                header("Refresh:1; Url=login.php");
                
                exit();
            } else{
            }
        }
    }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>    
    <link rel="stylesheet" type="text/css" href="css/style1.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel = "stylesheet">
</head>
<body class="pagebg register">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-offset-2 form">
                <div class="page-header">
                <h2><u>Registration Form</u></h2>                 
                </div>
                <p>Please fill in all the fields in the form.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                <label>First Name</label>
                <input type="text" name="fname" class="form-control" value="" maxlength="50" placeholder="Name AS PER IC">
                <span class="text-danger"><?php if(isset($errors['fname'])) echo $errors['fname']; ?></span>
                </div>
                <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="lname" class="form-control" value="" maxlength="50"  placeholder="Name AS PER IC"> 
                <span class="text-danger"><?php if(isset($errors['lname'])) echo $errors['lname']; ?></span>
                </div>
                <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="" maxlength="50"  placeholder="Each email only register ONCE">
                <span class="text-danger"><?php if(isset($errors['email'])) echo $errors['email']; ?></span>
                </div> 
                <div class="form-group">
                <label>Mobile Phone No</label>
                <input type="text" name="phone_number" class="form-control" value="" maxlength="50"  placeholder="+601x-xxxxxxx">
                <span class="text-danger"><?php if(isset($errors['phone'])) echo $errors['phone']; ?></span>
                </div>
                <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="" maxlength="50" placeholder="Min. 8 Characters and includes both letters and numbers">
                <span class="text-danger"><?php if(isset($errors['pw'])) echo $errors['pw']; ?></span>
                </div>
                <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="cpassword" class="form-control" value="" maxlength="50" placeholder="Same as Password above">
                <span class="text-danger"><?php if(isset($errors['cpw'])) echo $errors['cpw']; ?></span>
                </div>
                <div class="form-group">
                <label>IC No</label>
                <input type="text" name="ic_number" class="form-control" value="" maxlength="50" placeholder="xxxxxx-xx-xxxx">
                <span class="text-danger"><?php if(isset($errors['ic'])) echo $errors['ic']; ?></span>
                </div>
                <div class="">
                <label>Gender</label> <br>
                <input type="radio" name="gender" value="M" checked> Male
                <input type="radio" name="gender" value="F" > Female <br>                
                <span class="text-danger"><?php if(isset($errors['gender'])) echo $errors['gender']; ?></span>
                </div><br> 
                <input type="submit" class="btn btn-primary" name="signup" value="Submit">                
                </form><br> 
                <p>Have an account? <a href="login.php">Login Now</a></p>
            </div>
        </div>
    </div>
    
</body>
</html>