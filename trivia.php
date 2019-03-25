<? 
session_start();
require_once("functions.php");
if ($_SESSION['authenticated'] != true) {
  die("Access denied");	
}
print_html_header2("Play Trivia");
// Start State
if (!$_SESSION['question_num'] || !$_POST || $_POST['action']=="Play Again") {
	$_SESSION['question_num'] = 1;
	$_SESSION['points'] = 0;
	
	$mysqli = db_connect();
	$result = $mysqli->query("SELECT question, choice1, choice2, choice3, choice4, answer FROM QuestionsLilD ORDER BY RAND() LIMIT 10");
	echo $mysqli->error;
	$questions_array = array();
	while ($row = $result->fetch_row()) {
	  array_push($questions_array, $row);
	}
	$result->close();
	$mysqli->close();
	//var_dump($questions_array);
	$_SESSION['question'] = $questions_array;	
		
	echo '
		<p>Get 10 question from database</p>
		<form method="post" action="trivia.php">
			<input class="btn btn-primary" type="submit" name="action" value="Start">
		</form>';
}
// Display State
else if ($_POST['action']=="Start" || $_POST['action']=="Next Question") {
	$question_index = $_SESSION['question_num'] - 1;
	$current_question =  $_SESSION['question'][ $question_index ];
		$q = $current_question[0];
		$c1 = $current_question[1];
		$c2 = $current_question[2];
		$c3 = $current_question[3];
		$c4 = $current_question[4];
		$_SESSION['answer'] =  $current_question[5];
	echo '
		<fieldset class="form-group">
		<div class="form-check">
		
		<h3>Question '.$_SESSION['question_num'].'</h3>
		<p>'.$q.'</p>
		<form method="post" action="trivia.php">		
		  <label class="form-check-label">
			<input type="radio" class="form-check-input" name="answer" value="1">
			'.$c1.'
		  </label><br>
		  <label class="form-check-label">
			<input type="radio" class="form-check-input" name="answer" value="2">
			'.$c2.'
		  </label><br>
		  <label class="form-check-label">
			<input type="radio" class="form-check-input" name="answer" value="3">
			'.$c3.'
		  </label><br>
		  <label class="form-check-label">
			<input type="radio" class="form-check-input" name="answer" value="4">
			'.$c4.'
		  </label><br>
			
		  <input class="btn btn-secondary" type="submit" name="action" value="Submit">
			
		</form>
		
		</div>
		</fieldset>';	
}
// Add Feedback State
else if ($_POST['action']=="Submit") {
	
	if($_POST['answer'] == $_SESSION['answer']) {
		 
		 $_SESSION['points'] += 10;
		echo'
		<div class="alert alert-success" role="alert">
			<strong>Well done!</strong> You answered correctly.
		</div>
		';
	}
	else{ echo'
	<div class="alert alert-danger" role="alert">
		<strong>WRONG</strong>
	</div>
	';
	}
	echo '<p>Process submission</p>';
	
	if ($_SESSION['question_num'] < 5) {
		$_SESSION['question_num']++;
		echo '
			<form method="post" action="trivia.php">
				<input class="btn btn-success" type="submit" name="action" value="Next Question">
			</form>';		
	}
	else {
	
		// Stop State
		$mysqli = db_connect();
		$username = $_SESSION['username'];
		$sql = "SELECT games, points FROM userTableLilD WHERE username='$username'";
		echo 'Debugging';
		$result = $mysqli->query($sql);
		$row = $result->fetch_row();
		$games = $row[0];
		$points = $row[1];
		$games++;
		$points += $_SESSION['points'];
		$sql = "UPDATE userTableLilD SET games=$games, points=$points WHERE username='$username'";
		$result = $mysqli->query($sql);
		echo '<p>Recored score: </p>'.$_SESSION['points'].'';
		
		echo '<p>Total Points</p>'.$points.'';	
		echo '<p>Total Games</p>'.$games.'';			
		echo '<div class="alert alert-success" role="alert">
			  <strong>Well done!</strong> You successfully completed the game!
		  </div>';
		echo '
			<form method="post" action="trivia.php">
				<input class="btn btn-primary" type="submit" name="action" value="Play Again">
			</form>
			<p><a href="home.php">Back to Home</a></p>';
			
		$mysqli->close();
	}
	
}
print_html_footer2();
?>