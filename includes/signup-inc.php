<?php

if (isset($_POST['submit'])) {
    $uid = $_POST['uid'];
    $pwd = $_POST['pwd'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    include "../class/dbh.class.php";
    include "../class/signup/signup.class.php";
    include "../class/signup/signup-contr.class.php";
    

    $signup = new SignupContr($uid, $pwd, $password, $email);
    $signup->setUser();
    header("location: ../login.php?message=registrationsuccesful");


}