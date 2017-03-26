<?php

    session_start();
    
    include '../dbh.php';

    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "INSERT INTO userinfo(firstname,lastname,email,pwd,phone,Address) 
            VALUES('$first', '$last', '$email', '$pass', '$phone', '$address')";

   $result = mysqli_query($conn, $sql);

   header("Location: ../index.php");



?>