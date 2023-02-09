<?php
session_start();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>homepage</title>
    <link rel="stylesheet" href="../css/homestyle.css">
    <link rel="shortcut icon" href="../images/favicon.logo.png" type="image/x-icon">
</head>
<body>
    <div class="container">
        <div class="navbar">
            <img src="../images/logo.png" alt="logo">
            <nav>
                <ul>
                    <li><a href="">Home</a></li>
                    <li><a href="">about</a></li>
                    <li><a href="../forgot/forgot.php">change password</a></li>
                    <li><a href="../includes/logout.inc.php">logout</a></li>
                </ul>
            </nav>
            <img src="../images/cart.png" alt="">        
        </div>
        <div class="content">
            <h1>I'm a developer</h1>
            <p>my 2022 diary</p>
            <a href="" class="btn">king james collections</a>
        </div>
    </div>
</body>
</html>