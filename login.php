<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>login form</title>
    <link rel="shortcut icon" href="./images/favicon.logo.png" type="image/x-icon">
</head>
<body>
   <div class="container">
    <form action="includes/login-inc.php" method="post">
        <h1>login here</h1>
        <input type="text" class = "form-control" name ="uid" placeholder ="username"><br>
        <input type="password" class = "form-control" name="pwd" placeholder="password"><br>
        <br>
        <button type="submit" name ="submit" class ="btn">login</button>
        <p class = "forgot-password"><a href="index.php"> signup</a>
        <a class ="a" href="./forgot/forgot.php">forgot password?</a>
        </p>
    </form>
   </div>
</body>
</html>