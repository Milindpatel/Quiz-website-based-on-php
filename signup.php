<?php

include 'header.php';


?>
<br>
<br>
<br>

        <div class="container">
            

            <!--<?php
                // if(isset($_SESSION['id'])){
                //     echo $_SESSION['id'];
                // }else{
                //     echo "you are not logged in";
                // }
            ?>-->

            <?php
                if(isset($_SESSION['id'])){
                    echo "<div class='alert alert-danger'>
                            <strong>You are already logged In !</strong> 
                            </div>";
                }else{
                    echo "<h2 align = 'center'>Fill Out The Form:</h2>
                            <form  action='includes/signup.inc.php' method='post' id='taskForm'>
                                <div class='form-group'>
                                <label for='firstName'>First Name:</label>
                                <input type='text' class='form-control' name='first' id='firstName' placeholder='Enter first name' required>
                                
                                </div>
                                <div class='form-group'>
                                <label for='lastName'>Last Name:</label>
                                <input type='text' class='form-control' name='last' id='lastName' placeholder='Enter last name' required>
                                </div>
                                <div class='form-group'>
                                <label for='email'>Email:</label>
                                <input type='email' class='form-control' name='email' id='email' placeholder='Enter email' required>

                                </div>
                                <div class='form-group'>
                                <label for='pwd'>Password:</label>
                                <input type='password' class='form-control' name='pass' id='pwd' placeholder='Enter password' required>

                                </div>
                                <div class='form-group'>
                                <label for='phoneNumber'>Phone number:</label>
                                <input type='text' class='form-control' name='phone' id='phoneNumber' placeholder='Enter phone number' required>

                                </div>
                                <div class='form-group'>
                                <label for='Address'>Address:</label>
                                <input type='text' class='form-control' name='address' id='address' placeholder='Enter address:' required>

                                </div>
                                <div class='form-group'>
                                <div class='col-xs-9 col-xs-offset-3'>
                                    <div id='messages'></div>
                                </div>
                                </div>
                                <button type='submit' class='btn btn-primary'   >Save</button>
                            </form>";
                }
            ?>

            
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>

            
        </div>
    </body>
</html>

<?php


include 'footer.php';

?>