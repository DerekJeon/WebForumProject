<html> 
<head>
<h1>It is picture page!</h1>
</head> 

<body>

<?php

session_start();
echo "<br>". "<br>";

if(!isset($_SESSION['login_user'])) {
	echo "Please login";
	?>
<button onclick="no_login()">  IF YOU WANT TO ENTER, PLEASE LOGIN </button><br><br>
<script>
	function no_login(){
		window.location.replace("login.php")}
</script>
	<?php
}

else{
$userid = $_SESSION['login_user'];
echo ("USER ID : " . $userid . "<br>"); ?>
<br><button onclick="go_success()"> GO SUCCESS PAGE </button>
<script>
	function go_success(){
		window.location.replace("success.php") }
</script>
<?php


if (!isset($_POST["submit"]) && !isset($_GET["delete"]) && !isset($_GET["update"])) { ?>
<h3> Upload or change your pictures </h3>
<?php
formpictures("");
make_del(""); 
make_update("", ""); }
else{ 
	if(isset($_POST["submit"])){
	check_pic($userid, $_POST["text"]);}
	else if(isset($_GET["delete"])){
	delete_pic($userid, $_GET["number"]);}
	else if(isset($_GET["update"])){
	update_pic($userid, $_GET["ch_number"], $_GET["ch_text"]);}    

}
}



function formpictures($text){
?>
<form action="picture.php" method="post" enctype = "multipart/form-data">
	FILE: <input type="file" name="pict" /> <br><br>
	<textarea rows="7" cols="60" name="text" value="<?php echo $text ?>">
</textarea>
	<input type="submit" name="submit" value="submit" />
</form>
<?php
}

function make_del($number){
	?>
	<h3> Do You Want to Delete? </h3>
	<form action="picture.php" method="get">
	NUMBER: <input type="text" name="number" value="<?php echo $number?>" />
	<input type="submit" name="delete" value=" DELETE " />
	</form>

	<?php
}

function make_update($ch_number, $ch_text){
	?>
	<h3> Do You Want to Change your information of picture? </h3>
	<form action="picture.php" method="get">
	NUMBER: <input type="text" name="ch_number" value="<?php echo $ch_number?>" /><br>
	<br>
	<textarea rows="7" cols="60" name="ch_text" value="<?php echo $ch_text ?>">
	</textarea>
	<input type="submit" name="update" value=" UPDATE " />
	</form>

	<?php
}


function update_pic($userid , $ch_number, $ch_text){
	$result = new mysqli('localhost', 'root', '', 'proj');

	if($result->connect_error){
		die("Connection failed:" . $result->connect_error);
	}

	$conn = $result;
	$sql = "update pictures set description = '".$ch_text."' , date = now() where num = '".$ch_number."' ";
	$sqll = "select userID from pictures where num = '".$ch_number."' ";
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


function delete_pic($userid , $number){
	$result = new mysqli('localhost', 'root', '', 'proj');

	if($result->connect_error){
		die("Connection failed:" . $result->connect_error);
	}

	$conn = $result;
	$sql = "delete from pictures where num = '".$number."' ";
	$sqll = "select userID from pictures where num = '".$number."' ";
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


function check_pic($userid, $text){
if($_FILES["pict"]){
$file = $_FILES["pict"];
$tmpname = $file['tmp_name'];
$filename = $file['name'];

$namearr = explode(".",$filename);
$file_name = $namearr[0];
$prop = end($namearr);
$prop = strtolower($prop);

if($prop == "jpg" || $prop == "png" || $prop = "jpeg" || $prop == "gif"){
	$date_name = date("Y-m-d-h-i-s");

move_uploaded_file($tmpname, "./upload/" . $date_name.".".$prop);
echo move_uploaded_file($tmpname, "./upload/" . $date_name. "." . $prop);

$way = $date_name. "." .$prop;


$result = new mysqli('localhost', 'root', '', 'proj');
	if($result->connect_error){
		die("Connection failed:" . $result->connect_error);
	}

	$conn = $result;

	$sqll = "select email from user where userID = '".$userid."' ";
	$que_result = $conn->query($sqll);
	$row = $que_result -> fetch_row();
	$selec_email = $row[0];

	$sql = "insert into pictures values(null, '".$file_name."', '".$text."', now(), '".$userid."', '".$way."')";

	if($conn->query($sql) === TRUE) {
	header("location: success.php");
	}
	else{
	echo "Error creating database: " . $conn->error;
	} }

}else{

}}

?>

</body>
</html>
