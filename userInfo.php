<?php

include 'header.php';


?>

<br>
<br>
<br>
<?php

include 'dbh.php';
if(isset($_SESSION['id'])){
$sql = "SELECT firstname,lastname,email,pwd,phone,Address FROM userinfo where id='$_SESSION[id]'";
$result1 = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result1);
}
?>


<p>
<div class="container">

<?php


                if(isset($_SESSION['id'])){

                    echo "<h2 align = 'center'>User Information:</h2>
                            <form action='includes/edit.inc.php' method='post'>
                                <div class='form-group'>
                                <label for='firstName'>First Name:</label>
                                <input type='text' class='form-control' name='first' id='firstName'  value='" . $row['firstname'] . "' required>
                                </div>
                                <div class='form-group'>
                                <label for='lastName'>Last Name:</label>
                                <input type='text' class='form-control' name='last' id='lastName' value='" . $row['lastname'] . "'required>
                                </div>
                                <div class='form-group'>
                                <label for='email'>Email:</label>
                                <input type='email' class='form-control' name='email' id='email' value='" . $row['email'] . "'required>
                                </div>
                                <div class='form-group'>
                                <label for='pwd'>Password:</label>
                                <input type='text' class='form-control' name='pass' id='pwd' value='" . $row['pwd'] . "'required>
                                </div>
                                <div class='form-group'>
                                <label for='phoneNumber'>Phone number:</label>
                                <input type='text' class='form-control' name='phone' id='phoneNumber' value='" . $row['phone'] . "'required>
                                </div>
                                <div class='form-group'>
                                <label for='Address'>Address:</label>
                                <input type='text' class='form-control' name='address' id='address' value='" . $row['Address'] . "'required>
                                </div>
                                <div class='form-group'>
                                
                                <button  type='button' id= 'restartButton' class='btn btn-primary' onclick='scorePage();'>Show Score</button>
                                </div>
                                <button type='submit' class='btn btn-primary' >Save</button>
                            </form>
                            ";
                    
                }else{
                    echo "<div class='alert alert-danger'>
                            <strong>You are not logged In !</strong> 
                            </div>";
                }
            ?>

</div>
<p>
<br>
<br>
<br>
<br>

<script type='text/javascript'>
    
function scorePage(){
    window.location.href ='score.php';
}

</script>


<?php
include 'footer.php';
?>
