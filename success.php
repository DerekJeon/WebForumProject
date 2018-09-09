<html> 
<head>

</head> 

<body>
<H1> This is Talking Square</H1>

<?php
session_start();

if(!isset($_SESSION['login_user'])) {
	echo "Please login" ?>

<button onclick="no_login()">  IF YOU WANT TO ENTER, PLEASE LOGIN </button>
<br><script>
	function no_login(){
		window.location.replace("login.php")}
</script>


<?php
}
else{
$userid = $_SESSION['login_user'];
if(!isset($_GET["logout"])){
echo("USER ID: " . $userid);
make_logout();
?>
<button onclick="go_docu()">  Insert or Change your Document </button>
<br><br>
<script>
	function go_docu(){
		window.location.replace("document.php");}
</script>
<button onclick="movepic()">  Insert or Change your Picture </button>
<br><br>
<script>
	function movepic(){
		window.location.replace("picture.php");}
</script>

<?php
make_doc_table();
make_pic_table();
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

	echo "<table color=black border=1 align=center>";
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

function make_pic_table(){

    $result = new mysqli('localhost', 'root', '', 'proj');
	if($result->connect_error){
		die("Connection failed:" . $result->connect_error);
	}
	$conn = $result;
	$que_result = $conn->query("select num, storename, picname, description, date, userID from pictures order by date");

	echo "<table border=1 color=black align=center>";
	echo "<tr>" . "<th> NUMBER </th>" . "<th>PICTURE NAME</th>" ."<th>DESCRIPTION</th>" . "<th> FIANL UPDATE DATE </th>" . "<th> USER ID </th>" ."</tr>";

    while($row = $que_result -> fetch_assoc()){
        echo "<tr>";
        echo "<td>" . $row["num"] . "</td>";
        ?> <td> <a href = <?php echo "upload/" . $row["storename"] ?>><p><?php echo $row["picname"] ?></p></a></td>
        <?php
    	echo "<td>" . $row["description"] . "</td>";
    	echo "<td>" . $row["date"] . "</td>";
    	echo "<td>" . $row["userID"] . "</td>";
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