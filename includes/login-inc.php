<?php


if (isset($_POST['submit'])) {
    $uid = $_POST['uid'];
    $pwd = $_POST['pwd'];

    include "../class/dbh.class.php";
    include "../class/login/login.class.php";
    include "../class/login/login-contr.class.php";

    $login = new loginContr($uid,$pwd);
    $login->loginUser();
    header("location: ../homepages/home.php?message=loginsucessful");
    


    
}