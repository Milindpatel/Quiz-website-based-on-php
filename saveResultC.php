<?php
    session_start();
    

    //ajax p
     $finalScore=$_POST['p'];
     $attempt1 = 1;
     $cid = 2;
    // database connection
     include 'dbh.php';
     
     
         $sql1 = "SELECT  attempt FROM score where c_id=2 ORDER BY score.s_id DESC LIMIT 1 ";
            $result1 = mysqli_query($conn, $sql1);
            $row = mysqli_fetch_array($result1);
            $row['attempt'] += 1;
            $attempt1 = $row['attempt'];
    
     
     
     $sql = "INSERT INTO score (score, attempt,id,c_id) VALUES('$finalScore','$attempt1','$_SESSION[id]','$cid')";
     
    
    $result = mysqli_query($conn, $sql);
    echo "Result Saved. Score = ". $_POST['p'];
    // save score
?>