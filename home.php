<? 
require_once("functions.php");
session_start();
if ($_SESSION['authenticated'] != true) {
  die("Access denied");	
}
	
print_html_header2("Home");
echo' <h2>Home</h2>';
echo'
	<div class="alert alert-info" role="alert">
		<p> Welcome to Trivia <Strong>'.$_SESSION['username'].'</Strong>! <a href="trivia.php">Play trivia</a> to earn points which you can redeem for nothing!</p>
	</div>
	';
	
print_html_footer2();
?>