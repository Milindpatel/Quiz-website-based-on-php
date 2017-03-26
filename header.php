<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <!--<link rel="stylesheet" type="text/css" href="style.css">-->
    </head>
    <body>

    <header>
        <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                
            
            </div>
            <div class="navbar-header">
            <a class="navbar-brand" href="index.php">QuizoMania</a>
            
            
            
            </div>
            
                

            <?php
                if(isset($_SESSION['id'])){
                    
                    echo "<ul class='nav navbar-nav navbar-left'>
                            <li><a href='userInfo.php'><span class='glyphicon glyphicon-user'></span> UserInfo</a></li>
                            
                            </ul>
                            <form class='navbar-form navbar-right' action='includes/logout.inc.php' method='post'>
                        <button type='submit' class='btn btn-primary'>logout</button>
                         </form>";
                }else{
                    echo "<ul class='nav navbar-nav navbar-left'>
                            <li><a href='signup.php'><span class='glyphicon glyphicon-user'></span> New User</a></li>
                            
                            </ul>
                            <form class='navbar-form navbar-right' action='includes/login.inc.php' method='post' id='login'>
                            <div class='form-group'>
                                <input type='email' class='form-control' name='email' id='email' placeholder='email' required>
                            </div>
                            <div class='form-group'>
                                <input type='password' class='form-control' name='pass' id='pwd' placeholder='password'>
                            </div>

                            <button type='submit' class='btn btn-primary'>login</button>
                            
                            </form>";
                }
            ?>
            
            
        </div>
        </nav>

    </header>
    </body>
</html>