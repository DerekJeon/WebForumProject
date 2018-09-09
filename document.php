<html> 
<head>
<h1>It is document page!</h1>
</head> 

<body>

<?php
session_start();
echo "<br>". "<br>";

if(!isset($_SESSION['login_user'])) {
	echo "Please login";
?>

<button onclick="no_login()">  go to first </button>
<script>
	function no_login(){
		window.location.replace("login.php")}
</script>
	<?php
}
else{
$userid = $_SESSION['login_user'];
?>
<button onclick="go_success()"> GO SUCCESS PAGE </button>
<script>
	function go_success(){
		window.location.replace("success.php")
	}
</script>
<?php


if (!isset($_GET["delete"]) && !isset($_GET["submit"]) && !isset($_GET["update"])) { ?>
<h3> Write down your thinking! </h3>
<?php
make_Text("");
make_Delete("");
make_Update("", ""); 
}

else{
if (isset($_GET["submit"])){
	confirm_db($userid, $_GET["text"]); }
else if(isset($_GET["delete"])) {
	delete_docu($_GET["number"], $userid); }
else if(isset($_GET["update"])) {
	update_docu($_GET["ch_number"], $_GET["ch_text"], $userid); }
}
}



function make_Text($text){
?>
<form action="document.php" method="get">
<textarea rows="7" cols="80" name="text" value="<?php echo $text ?>">
</textarea>
<input type="submit" name="submit" value=" UPLOAD " />
</form>
<?php
}


function make_Delete($number){
	?>
	<h3> DELETE YOUR DOCUMENT </h3>
	<form action="document.php" method="get">
	NUM: <input type="text" name="number" value="<?php echo $number?>" />
	<input type="submit" name="delete" value=" DELETE " />
	</form>

	<?php
}

function make_Update($ch_number, $ch_text){
	?>
	<h3> CHANGE YOUR DOCUMENT </h3>
	<form action="document.php" method="get">
	NUM: <input type="text" name="ch_number" value="<?php echo $ch_number?>" /><br>
	<br>
	<textarea rows="7" cols="80" name="ch_text" value="<?php echo $ch_text ?>">
	</textarea>
	<input type="submit" name="update" value=" UPDATE " />
	</form>

	<?php
}


function confirm_db($userid, $text) { 
	$result = new mysqli('localhost', 'root', '', 'proj');
	if($result->connect_error){
		die("Connection failed:" . $result->connect_error);
	}

	$conn = $result;

	$sqll = "select email from user where userID = '".$userid."' ";
	$que_result = $conn->query($sqll);
	$row = $que_result -> fetch_row();
	$selec_email = $row[0];

	$sql = "insert into documents values (null, '".$text."', '".$userid."', now(), '".$selec_email."')";

	if($conn->query($sql) === TRUE) {
	header("location: success.php");
	}
	else{
	echo "Error creating database: " . $conn->error;
	} }


function delete_docu($number, $userid){
	$result = new mysqli('localhost', 'root', '', 'proj');

	if($result->connect_error){
		die("Connection failed:" . $result->connect_error);
	}

	$conn = $result;
	$sql = "delete from documents where num = '".$number."' ";
	$sqll = "select userID from documents where num = '".$number."' ";
	$que_result = $conn->query($sqll);
	$row = $que_result -> fetch_row();
	$selec_uid = $row[0];

	if($userid == $selec_uid){
	
	if($conn->query($sql) === TRUE) {
	header("location: success.php");
	}
	else{
	echo "Error creating database: " . $conn->error;
	} }

	else{
	?>
	<script> 
	alert("It is not your document");
	window.location.replace("success.php");
	</script>
	<?php
}}

function update_docu($ch_number, $ch_text, $userid){
	$result = new mysqli('localhost', 'root', '', 'proj');

	if($result->connect_error){
		die("Connection failed:" . $result->connect_error);
	}

	$conn = $result;

	$sql = "update documents set documnet = '".$ch_text."' , date = now() where num = '".$ch_number."' ";
	$sqll = "select userID from documents where num = '".$ch_number."' ";
	$que_result = $conn->query($sqll);
	$row = $que_result -> fetch_row();
	$selec_uid = $row[0];

	if($userid == $selec_uid){
	
	if($conn->query($sql) === TRUE) {
	header("location: success.php");
	}
	else{
	echo "Error creating database: " . $conn->error;
	} }

	else{
	?>
	<script> 
	alert("It is not your document");
	window.location.replace("success.php");
	</script>
	<?php
}}


?>

</body> 
</html>