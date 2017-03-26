<?php
 include 'header.php';
?>
<br>
<br>
<br>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <link href="css/sidebar.css" rel="stylesheet">
    </head>
    <body>

    <div class="container-fluid bg-3 text-center">    
  <h1 style="background-color: black; color: white; align: center">QuizoMania</h1><br>
  <div class="row">
    <div class="col-sm-6">
      <h3> Write once, run anywhere</h3>
      <img src="java.jpg" alt="Image" width="350" height="300"><br><br>
        <button type="button" class="btn btn-primary btn-lg" onclick="window.location.href='https://www.tutorialspoint.com/java/'">Learn Java</button>
        <button type="button" class="btn btn-primary btn-lg" onclick="window.location.href='javaQuiz.php'">Start Quiz</button>
    </div>
    
    <div class="col-sm-6"> 
      <h3>Basic language for All Programer</h3>
      <img src="c1.jpg" alt="Image" width="350" height="300"><br><br>
      <button type="button" class="btn btn-primary btn-lg" onclick="window.location.href='https://www.tutorialspoint.com/cprogramming/'">Learn C</button>
        <button type="button" class="btn btn-primary btn-lg" onclick="window.location.href='cQuiz.php'">Start Quiz</button>
      
    </div>
  </div>
</div>

<br>
<br>
<br>
<br>
    
    

</body>

</html>

<?php


include 'footer.php';

?>
