<?php

include 'header.php';


?>
<br>
<br>
<br>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href = "css/quiz.css" rel="stylesheet" />
  
</head>
<body>





<?php
                if(isset($_SESSION['id'])){
                    echo "'<div id='page-content-wrapper'>
                                    <div class='container-fluid'>
                                        <div class='row'>
                                            <div class='col-lg-12'>
                                
                                                <div class='container' id ='quizContainer' >
                                                    <div> <h3 id= 'question'></h3></div>
                                                    
                                                    <div class='funkyradio'>
                                                        <div class='funkyradio-default'>
                                                            <input type='radio' name='radio' id='option1' value='1' />
                                                            <label for='option1' id='opt1'></label>
                                                        </div>
                                                        <div class='funkyradio-default'>
                                                            <input type='radio' name='radio' id='option2' value='2'/>
                                                            <label for='option2' id='opt2'></label>
                                                        </div>
                                                        <div class='funkyradio-default'>
                                                            <input type='radio' name='radio' id='option3' value='3' />
                                                            <label for='option3' id='opt3'></label>
                                                        </div>
                                                        <div class='funkyradio-default'>
                                                            <input type='radio' name='radio' id='option4' value='4' />
                                                            <label for='option4' id='opt4'></label>
                                                        </div>
                                                        
                                                    </div>
                                                
                                                    
                                                    <br>
                                                    <div>
                                                    <button type='button' class='btn btn-primary pull-right btn-lg' id='nextButton' onclick='loadNextQuestion();'>Next</button>
                                                    </div>
                                                </div>
                                                        
                                                        
                                                <div data-role='main' id= 'result' style='display:none;'>
                                                    <div  class='alert alert-info' id='result1'> </div>
                                                    <button  type='button' id= 'restartButton' class='btn btn-primary pull-right btn-lg' onclick='mainPage();'>Restart</button>
                                                </div>
                                
                                     </div>
                                </div>
                            </div>
                        </div>

                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>";
                }else{
                    echo " <div class='container'>
                            <div class='alert alert-danger'>
                            <strong>You have to First log In !</strong> 
                            </div>
                            </div>";
                }
            ?>
    </div>

</body>
</html>






<script type='text/javascript'>
    <?php
                 include 'dbh.php';

                $sql = "SELECT * FROM javaQuestion where c_id=1";
            $result = mysqli_query($conn, $sql);
            $array = array();
            while ($row = mysqli_fetch_array($result)){
            // add each row returned into an array
            $array[] = $row;
            }
            // show all array data
            // for($i=0;$i<count($array);$i++){
            // echo $array[$i]['question'];
            // }
   


    ?>
    
    //convert php array into json array
    var css_array =<?php echo json_encode($array );?>;
    
   

var currentQuestion = 0;
var score = 0;
 var container = $("#quizContainer");
var questionEl = $("#question");
var opt1 = $("#opt1");
var opt2 = $("#opt2");
var opt3 = $("#opt3");
var opt4 = $("#opt4");
var nextButton = $("#nextButton");
var resultCont = $("#result1");
var startCont = $("#startQuiz");



		var index;
        
        for (var i = css_array.length - 1; i > 0; i--) {
            
            index = Math.floor((Math.random() * i));
          
            temp = css_array[index];
            css_array[index] = css_array[i];
            css_array[i] = temp;
        }








function loadQuestion (questionIndex) {

	
	var q = css_array[questionIndex];
	questionEl.text((questionIndex + 1) + ". " + q.question);
	opt1.text(q.option1);
	opt2.text(q.option2);
	opt3.text(q.option3);
	opt4.text(q.option4);
};

function loadNextQuestion () {
	var selectedOption = $("input[type*=radio]:checked").each(function (){});
	if(!selectedOption.val()){
		alert("Please select your answer!");
		return;
	}
	var answer = selectedOption.val();
   
	
	if(css_array[currentQuestion].answer == selectedOption.val()){
		score += 1;
	}
    // alert(score);
	

    $('.funkyradio').find('label').removeClass('active')
  .end().find('[type="radio"]').prop('checked', false);

	currentQuestion++;
	
	if(currentQuestion == 9){
		nextButton.text("Finish");
	}
	if(currentQuestion == 10){
		$("#quizContainer").hide();
		$("#result").show();
		if(score >= 8){
			resultCont.show();	
			resultCont.text("You have successfully passed the test. You are now certified in Java Trainning, your score is: " + score);
		}else{
			resultCont.text("Unfortunately you did not pass the test. Please try again later!");
		}

                    $.ajax({ 
            type: "POST", 
            url: "saveResultJava.php", 
            data: {p:score} , 
            success: function(data) { } 
            });

        
		return;
	}
	loadQuestion(currentQuestion);
    
}


loadQuestion(currentQuestion);



function mainPage(){
    window.location.href ='index.php';
}







</script>



<?php


include 'footer.php';

?>

