<html> 
<head>

</head> 

<body>
<H1> This is Talking Square</H1>

<?php
session_start();

if(!isset($_SESSION['login_user'])) {
	echo "Please login" ?>

<button onclick="no_login()">  go to first </button>
<br><script>
	function no_login(){
		window.location.replace("login.php")}
</script>


<?php
}
else{
$userid = $_SESSION['login_user'];
if(!isset($_GET["logout"])){
echo("User: " . $userid);
make_logout();
?>
<button onclick="go_docu()">  Insert or Change your Document </button>
<br><br>
<script>
	function go_docu(){
		window.location.replace("document.php");}
</script>
<?php
make_doc_table();
}
else{
	logout_user();
}
}


function make_doc_table(){

    $result = new mysqli('localhost', 'root', '', 'proj');
	if($result->connect_error){
		die("Connection failed:" . $result->connect_error);
	}
	$conn = $result;
	$que_result = $conn->query("select * from documents order by num");

	echo "<table color=black border=1 align=left>";
	echo "<tr>" . "<th>NUMBER</th>" ."<th>CONTENT</th>" . "<th> ID </th>" . "<th> FINAL UPDATE DATE </th>" . "<th> EMAIL </th>" ."</tr>";

    while($row = $que_result -> fetch_assoc()){
        echo "<tr>";
        echo "<td>" . $row["num"] . "</td>";
    	echo "<td>" . $row["documnet"] . "</td>";
    	echo "<td>" . $row["userID"] . "</td>";
    	echo "<td>" . $row["date"] . "</td>";
    	echo "<td>" . $row["email"] . "</td>";
		echo "</tr>";
	}
	echo "</table>";
}

function make_logout(){
?>	<br><br>
	<form action="success.php" method="get">
	<input type="submit" name="logout" value="logout your account " />
	</form><br>
<?php
}

function logout_user(){
	session_unset($_SESSION['login_user']);
	header("location: login.php");
}

?>

</body> 
</html>