<?php
    session_start();

    session_destroy();   // function that Destroys Session 
    header("Refresh:3; Url=login.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout page</title>
    <link rel="stylesheet" type="text/css" href="css/style1.css">
</head>
<body>
   
    <div class="logout">
        <img src="image/dog.png" alt="EzSalon" class="img-dog">
        <h1>Logout Successfully</h1>
        <h2>See you next time !</h2>

    </div>
</body>
</html>