<? 
require_once("functions.php");
session_start();
if ($_SESSION['usertype'] != 'admin') {
  die("Access denied");	
}
if ($_SESSION['authenticated'] != true) {
	die("Access denied");	
}
print_html_header2("Delete User");
//  Only process if $_GET is not empty and an id is present in the URL
if (empty($_GET) == false && $_GET['username'] != "") {
	$id = $_GET['username'];
	$mysqli = db_connect();				
	$mysqli->query("DELETE FROM userTableLilD WHERE username='$id'");
	$mysqli->close();
}
// Always print the list table of questions
$mysqli = db_connect();				
//$result = $mysqli->query("SELECT id, question FROM Questions");
$result = $mysqli->query("SELECT username, password, usertype, games, points FROM userTableLilD");
while ($row = $result->fetch_array()) {
	echo '	
	<div class="card">
		<div class="card-block">
			<h4 class="card-title">'.$row[0].'</h4>
		</div>
		<ul class="list-group list-group-flush">';	
	echo '
		</ul>
		<div class="card-block">
			<a class="btn btn-danger" href="delete_user.php?username='.$row[0].'">Delete</a>
		</div>
	</div>';
	
	
}	
$result->close();
$mysqli->close();
print_html_footer();
?>