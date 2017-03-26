


<?php

    session_start();
    include '../dbh.php';

    
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    

    $sql = "SELECT * FROM userinfo WHERE email= '$email' AND pwd= '$pass'";

   $result = mysqli_query($conn, $sql);
   
   if(!$row = mysqli_fetch_assoc($result)){
       header("Location: ../invalid.php");

   }else{
       $_SESSION['id'] = $row['id'];
       header("Location: ../index.php");
       
   }






?>



