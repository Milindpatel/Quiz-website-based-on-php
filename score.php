<?php
include 'header.php';
?>
<br>
<br>
<br>
<?php

include 'dbh.php';

$sql = "SELECT attempt,score,c_id FROM score where id='$_SESSION[id]' AND c_id=1";
$result = mysqli_query($conn, $sql);
$score = 0;
//array for count
$java = array();
$attempt = 1;
?>


<?php
echo "<div class='container'>
            <h2>Java Score</h2>            
            <table class='table'>
                <thead>
                <tr>
                    <th>Attempt NO</th>
                    <th>Score</th>
                </tr>
                </thead>
            ";
while ($row = mysqli_fetch_array($result)){
    $score += $row['score'];
    array_push($java,$row['attempt']);
    
    echo"<div class='container'>
            <table class='table'>
                <tbody>
                <tr>
                    <td>{$attempt}</td>
                    <td></td>
                    
                    <td>{$row['score']}</td>
                </tr>
                </tbody>
            
            ";
    $attempt += 1;
    
}

//count total attempt
$totaljava = count($java);


$sql1 = "SELECT  attempt FROM score where c_id=2 AND id=$_SESSION[id] ORDER BY score.s_id DESC LIMIT 1 ";
 $result1 = mysqli_query($conn, $sql1);
 $row1 = mysqli_fetch_array($result1);
echo "<div class='container'>            
            <table class='table'>
                <thead>
                    <th>Total Attempt: {$totaljava}</th>
                    <th></th>
                    <th>Total Score: {$score}</th>
                
                </thead>
                </table>
            </div>
            ";




//for css

$sql = "SELECT attempt,score,c_id FROM score where id='$_SESSION[id]' AND c_id=2";
$result = mysqli_query($conn, $sql);
$score2 = 0;
//array for count
$css = array();
$attempt2 = 1;

echo "<div class='container'>
            <h2>C Language Score</h2>            
            <table class='table'>
                <thead>
                <tr>
                    <th>Attempt NO</th>
                    <th>Score</th>
                </tr>
                </thead>
            ";
while ($row = mysqli_fetch_array($result)){
    $score2 += $row['score'];
    array_push($css,$row['attempt']);
    echo"<div class='container'>
            <table class='table'>
                <tbody>
                <tr>
                    <td>{$attempt2}</td>
                    <td></td>
                    <td>{$row['score']}</td>
                </tr>
                </tbody>
            
            ";
    $attempt2 += 1;
    
}


//count total css attempt
$totalcss = count($css);

$sql3 = "SELECT  attempt FROM score where c_id=2 AND id=$_SESSION[id] ORDER BY score.s_id DESC LIMIT 1 ";
 $result3 = mysqli_query($conn, $sql3);
 $row3 = mysqli_fetch_array($result3);
echo "<div class='container'>            
            <table class='table'>
                <thead>
                    <th>Total Attempt: {$totalcss}</th>
                    <th></th>
                    <th>Total Score: {$score2}</th>
                
                </thead>
                </table>
            </div>
            ";


?>
<br>
            <br>
            <br>
            <br>
