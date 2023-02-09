
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signup</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="./images/favicon.logo.png" type="image/x-icon">
</head>
<body>
    <div class="form-centre">
    <form action="includes/signup-inc.php" method="post">
        <h1>create a new account</h1>
       <input type="text" class = "form-control" name="uid" placeholder="Username" ><br>
       <input type="password" class = "form-control" name="pwd" placeholder="password" ><br>
       <input type="password" class = "form-control" name="password" placeholder="passwordRepeat" ><br>
       <input type="email" class = "form-control" name="email" placeholder="E-mail" ><br>
       <br>
       <button type="submit" class = "btn" name="submit">signup</button>
       <br>
       <p><a href="login.php">login here</a></p>
       
    </form>
    </div>
</body>
</html>