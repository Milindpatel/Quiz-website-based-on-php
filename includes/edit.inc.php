<?php

    session_start();
    
    include '../dbh.php';

    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "UPDATE userinfo SET firstname='$first', lastname='$last',email='$email',pwd='$pass',phone='$phone',Address='$address' where id='$_SESSION[id]'";

   $result = mysqli_query($conn, $sql);

   header("Location: ../index.php");



?>