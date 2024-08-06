<?php
    include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Page</title>
    <link rel="stylesheet" type="text/css" href="css/style1.css">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
.about-content {
        background-color: #f5f5f5;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        font-family: Arial, sans-serif;
        overflow: hidden;
        margin:20px;
    }

    .about-content h2 {
        font-size: 28px;
        color: #333;
        padding-bottom: 5px;
        animation: slideIn 0.5s forwards;
    }

    p {
        font-size: 18px;
        color: #666;
        line-height: 1.5;
        animation: fadeIn 0.5s forwards;
    }

    strong {
        font-weight: bold;
        color: #222;
    }

    a {
        text-decoration: none;
        color: #007BFF;
        transition: color 0.3s;
    }

    a:hover {
        color: #0056b3;
    }

    iframe {
        width: 100%;
        height: 400px;
        border: none;
        animation: fadeIn 1s forwards;
    }

    .social-icons {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }

    .social-icons a {
        display: inline-block;
        margin: 0 10px;
        transition: transform 0.2s;
    }

    .social-icons a i {
        font-size: 25px;
        color: inherit;
        transition: transform 0.2s;
    }

    .social-icons a i:hover {
        transform: scale(1.2);
    }

    @keyframes slideIn {
        0% {
            transform: translateX(-100%);
            opacity: 0;
        }
        100% {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }
    /* Your existing CSS styles here */

    .floating-comment-box {
        position: fixed;
        bottom: 90px; /* Adjust the distance from the WhatsApp button as needed */
        right: 20px;
        background-color: #25d366; /* WhatsApp green color */
        color: #fff;
        border-radius: 10px;
        width: 200px;
        padding: 10px;
        text-align: center;
        font-size: 14px;
        line-height: 1.4;
        text-decoration: none;
        z-index: 999;
        display: none; /* Hide the comment box by default */
    }

    .whatsapp-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #25d366; /* WhatsApp green color */
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 75px;
        height: 75px;
        font-size: 50px;
        text-align: center;
        line-height: 60px;
        text-decoration: none;
        transition: background-color 0.3s;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 999;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            background-color: #25d366; /* Start with WhatsApp green */
        }
        50% {
            transform: scale(1.05); /* Scale up at 50% of the animation */
            background-color: #1fe130; /* Lighter green color */
        }
        100% {
            transform: scale(1);
            background-color: #25d366; /* Back to WhatsApp green */
        }
    }

    .whatsapp-button:hover {
        background-color: #128C7E; /* Darker WhatsApp green on hover */
    }

    .show-comment-box {
        display: block; /* Show the comment box when hovering over the WhatsApp button */
    }
    /* Footer CSS */
footer {
    background-color: #333;
    color: #fff;
    padding: 20px;
}

.footer-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.footer-logo img {
    width: 100px; /* Adjust the width as needed */
    margin-top: 50px;
}
.footer-logo2 img {
    width: 80px; /* Adjust the width as needed */
    margin-top: 50px;
    margin-right:550px;
}
.footer-logo3 img {
    width: 80px; /* Adjust the width as needed */
    margin-top: 50px;
    margin-left: -550px;
    margin-right: 600px;
}

.footer-info {
    max-width: 400px; /* Adjust the max-width as needed */
}

.copywright {
    text-align: center;
    margin-top: 20px;
}

/* Media query for responsiveness (adjust as needed) */
@media (max-width: 768px) {
    .footer-content {
        flex-direction: column;
        text-align: center;
    }

    .footer-info {
        margin-top: 10px;
    }
}
/* Existing styles for .footer-logo */
.footer-logo, .footer-logo2, .footer-logo3 {
    display: flex;
    justify-content: space-around;
    align-items: center;
}

.footer-logo img, .footer-logo2 img, .footer-logo3 img {
    /* Your existing styles */
    animation: jumpAnimation 0.7s infinite alternate;
}

@keyframes jumpAnimation {
    to {
        transform: translateY(-20px);
    }
}

/* Additional styles for .footer-logo2 and .footer-logo3 */
.footer-logo2 img {
    animation-delay: 0.5s; /* Delay the animation by 0.5 seconds */
}

.footer-logo3 img {
    animation-delay: 1s; /* Delay the animation by 1 second */
}


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
                <li><a href="history.php"><i class="fa fa-history"></i>History</a></li>
                <li><a href="profile.php"><i class="fa fa-user-circle-o"></i>Profile</a></li>
                <li  class="active"><a href="about_us.php"><i class="fa fa-info-circle"></i>About Us</a></li>
                <li><a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a></li>
            </ul>
        </div>
    
        <div class="main_content">
            <div class="header">
                <h1>About Us</h1>
            </div>
            <div class="breadcrum"> 
            <a href="home.php">Home</a> >
                <span class="disable-links"><a href="#">About Us</a></span>
                </div>
            <div class="info">
                
            <div class="about-content">
                
                <h2>Contact Information</h2>
                <hr>
                <p>
                    We are dedicated to providing the best pet grooming services in town. Our experienced and caring staff will ensure that your pets receive the love and attention they deserve.
                </p><br>
                
                <p>
                <i class="fa fa-phone"style="color: green;"></i><strong> Phone:</strong> <a href="tel:+011-1111222">+011-1111222</a><br>
                <i class="fa fa-envelope" style="color: blue;"></i><strong>Email:</strong> <a href="mailto:info@petgroomingsalon.com">info@petgroomingsalon.com</a><br>
                <i class="fa fa-map-marker" style="color: red;"></i><strong> Address:</strong> Jalan Api-Api 88, Taman Mount Austin, 81100 Johor Bahru, Johor.<br>
                <i class="fa fa-map-pin" style="color: black;"></i><strong> Waze:</strong>
                <a href="https://ul.waze.com/ul?preview_venue_id=68026384.680132764.2527304&navigate=yes&utm_campaign=default&utm_source=waze_website&utm_medium=lm_share_location" target="_blank">Click here to <strong>Waze</strong> Ez Pet Salon</a>
                <br><br>
                <iframe src="https://embed.waze.com/iframe?zoom=17&lat=1.559469&lon=103.779955&ct=livemap" width="600" height="450" allowfullscreen></iframe>
                    
                </p>
                <div class="social-icons">
                    <a href="https://www.facebook.com/PetLoversCentreMalaysia/"  target="_blank"><i class="fa fa-facebook-square">Ez Salon Facebook</i></a>

                    <a href="https://www.instagram.com/plc_malaysia/"  target="_blank"><i class="fa fa-instagram" style="color: #E4405F;">Ez Salon Instagram</i></a>

                </div>
                <h2><u>Suggestions</u></h2>
                <p>
                    We value your feedback and suggestions. If you have any ideas or recommendations to improve our services, please feel free to contact us.
                </p>
                <div class="floating-comment-box">
                    👋Hi! Need help With Grooming Appointment? Click Here to chat with customer service!
                </div>

                <a href="https://api.whatsapp.com/send?phone=60186685101" class="whatsapp-button" target="_blank">
                    <i class="fa fa-whatsapp"></i>
                </a>

                <script>
                    document.querySelector('.whatsapp-button').addEventListener('mouseover', function () {
                        document.querySelector('.floating-comment-box').classList.add('show-comment-box');
                    });

                    document.querySelector('.whatsapp-button').addEventListener('mouseout', function () {
                        document.querySelector('.floating-comment-box').classList.remove('show-comment-box');
                    });
                </script>
                </div>
            </div>
            <!-- Add this code before the closing </body> tag -->
    <footer>
        <div class="footer-content">
            <div class="footer-logo">
                <img src="image/dog.png" alt="Ez Salon Logo">
            </div>
            <div class="footer-logo2">
                <img src="image/dog.png" alt="Ez Salon Logo">
            </div>
            <div class="footer-logo3">
                <img src="image/dog.png" alt="Ez Salon Logo">
            </div>
            <div class="footer-info">
                <h4>Ez Salon Pet Grooming</h4>
                <p>Jalan Api-Api 88, Taman Mount Austin, 81100 Johor Bahru, Johor</p>
                <p>Phone: +011-1111222</p>
                <p>Email: info@petgroomingsalon.com</p>
            </div>
        </div>
        <div class="copywright">
            <p>&copy; 2023 Ez Salon Pet Grooming. All rights reserved.</p>
        </div>
    </footer>
        </div>
        
    </div>
    

</body>
</html>