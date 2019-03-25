<?
require_once("functions.php");
session_start();
if ($_SESSION['authenticated'] != true) {
  die("Access denied");	
}
print_html_header2("Rank Questions");
$file = 'rankQuestion.txt';
$current = file_get_contents($file);
echo $current;
    echo ' 
        <h3>Select which question is better</h3><br>';
	$_SESSION['question_num'] = 1;
	$_SESSION['points'] = 0;
	
	$mysqli = db_connect();
	$result = $mysqli->query("SELECT question, choice1, choice2, choice3, choice4, answer, id FROM QuestionsLilD ORDER BY RAND() LIMIT 2");
	echo $mysqli->error;
	$row = $result->fetch_row();
	$_SESSION['answer1'] =  $row[6];
	$q = $row[0];
	print_only_question($q);
	
	
	$row = $result->fetch_row();
	$_SESSION['answer2'] =  $row[6];
	$q = $row[0];
	print_only_question($q);
if($_SESSION['answer1'] != null && $_POST['action'] == "Insert"){
    $current .= $_SESSION['answer1'].'>'.$_SESSION['answer2'].',';
    file_put_contents($file, $current);
}
echo '
<form method="post" action="rank_question.php">
<input type="submit" name="action" size="50" value="Insert">
</form>';
    
print_html_footer2("Rank Questions");
$result->close();
$mysqli->close();
?>