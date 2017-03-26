<?php

$conn = mysqli_connect("localhost","root","","quiz");

if(!$conn){
    die("Connection failed:" .mysqli_connect_error());
}
?>