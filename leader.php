<?
require_once("functions.php");
session_start();
if ($_SESSION['authenticated'] != true) {
  die("Access denied");	
}
print_html_header2("Leaderboard");
$mysqli = db_connect();	
$result = $mysqli->query("SELECT username, points FROM userTableLilD ORDER BY points DESC LIMIT 10");
	echo '	
<table class="table table-striped">
  <thead>
    <tr>
      <th>World Rankings</th>
      <th>username</th>
      <th>points</th>
    </tr>
  </thead>
  <tbody>';
  
  $x = 1;
  while ($row = $result->fetch_array()) {
    echo '
     <tr>
      <td>'.$x++.'</td>
      <td>'.$row[0].'</td>
      <td>'.$row[1].'</td>
      </tr>';
    }  
echo'  
  </tbody>
</table>';	
	
	
	
$result->close();
$mysqli->close();
print_html_footer2();
?>