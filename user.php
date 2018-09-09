<html> 
<head>
</head> 

<body>
	<button onclick="gologin()"> GO LOGIN </button>
<script>
	function gologin(){
		window.location.replace("login.php")
	}
</script>

<?php
session_start();

?>
<h2> Hello, It is user page. </h2><br>

<?php

if (!isset($_GET["insert"]) && !isset($_GET["delete"]) && !isset($_GET["update"]) && !isset($_GET["logout"])) {
insert_user("", "", "", "", "");
delete_user("", "");
update_user("", "", "", "", "", "", "");
click_make_table("", "");

if(isset($_GET["check"])){
make_user_table($_GET["check_id"], $_GET["check_passwd"]); 
}
}

else{
if (isset($_GET["insert"])){
	inse_user($_GET["iuid"], $_GET["u_name"], $_GET["passwd"], $_GET["e_mail"], $_GET["phone_num"]); }

else if(isset($_GET["delete"])) {
	dele_user($_GET["duid"], $_GET["d_passwd"]); }

else if(isset($_GET["update"])) {
	upda_user($_GET["uid"], $_GET["upasswd"], $_GET["uuid"], $_GET["uu_name"], $_GET["upasswd"], $_GET["ue_mail"], $_GET["uphone_num"]); }
}

function click_make_table($check_id, $check_passwd){
	?>
	<h3> Do You Want to see information of user? </h3>
	<form action="user.php" method="get">
	USER ID: <input type="text" name="check_id" value="<?php echo $check_id?>" /> <br/>
	PASSWORD: <input type="text" name="check_passwd" value="<?php echo $check_passwd?>" /> <br/><br/>
	<input type="submit" name="check" value=" Confirm user " />
	</form><br>

	<?php
}


function make_user_table($check_id, $check_passwd){

    $result = new mysqli('localhost', 'root', '', 'proj');
	if($result->connect_error){
		die("Connection failed:" . $result->connect_error);
	}
	$conn = $result;
	$que_result = $conn->query("select * from user where userID = '".$check_id."' and password = '".$check_passwd."' ");

	echo "<table border=1 color=black align=left>";
	echo "<tr>" . "<th>USER ID</th>" ."<th>USER NAME</th>" . "<th> PASSWORD </th>" . "<th>E-MAIL</th>" . "<th>PHONE NUMBER</th>" . "</tr>";

    while($row = $que_result -> fetch_assoc()){
        echo "<tr>";
        echo "<td>" . $row["userID"] . "</td>";
    	echo "<td>" . $row["userName"] . "</td>";
    	echo "<td>" . $row["password"] . "</td>";
    	echo "<td>" . $row["email"] . "</td>";
    	echo "<td>" . $row["phoneNum"] . "</td>";
		echo "</tr>";
	}
	echo "</table>";
	echo "<br>";
	echo "<br>";
	echo "<br>";
}

function delete_user($duid, $d_passwd){
	?>
	<h3> Do You Want to Delete your account? </h3>
	<form action="user.php" method="get">
	USER ID: <input type="text" name="duid" value="<?php echo $duid?>" /> <br/>
	PASSWORD: <input type="text" name="d_passwd" value="<?php echo $d_passwd?>" /> <br/>
	<input type="submit" name="delete" value=" Delete It " />
	</form><br>

	<?php
}

function insert_user($iuid, $u_name, $passwd, $e_mail, $phone_num){
	?>
	<h3> Do You Want to insert? </h3>
	<form action="user.php" method="get">
	USER ID: <input type="text" name="iuid" value="<?php echo $iuid?>" /> <br/>
	USER NAME: <input type="text" name="u_name" value="<?php echo $u_name?>" /> <br/>
	PASSWORD: <input type="text" name="passwd" value="<?php echo $passwd?>" /> <br/>
	E-MAIL: <input type="text" name="e_mail" value="<?php echo $e_mail?>" /> <br/>
	PHONE NUMBER: <input type="text" name="phone_num" value="<?php echo $phone_num?>" />
	<input type="submit" name="insert" value=" Insert It " />
	</form><br>

	<?php
}

function update_user($uid, $upasswd, $uuid, $uu_name, $upasswd, $ue_mail, $uphone_num){
	?>
	<h3> How do you want to change your account? </h3>
	<form action="user.php" method="get">
	USER ID: <input type="text" name="uid" value="<?php echo $uid?>" /> <br/>
	USER PASSWORD: <input type="text" name="upasswd" value="<?php echo $upasswd?>" /> <br/>
	<h4> How do you want to change? </h4>
	USER ID: <input type="text" name="uuid" value="<?php echo $uuid?>" /> <br/>
	USER NAME: <input type="text" name="uu_name" value="<?php echo $uu_name?>" /> <br/>
	PASSWORD: <input type="text" name="upasswd" value="<?php echo $upasswd?>" /> <br/>
	E-MAIL: <input type="text" name="ue_mail" value="<?php echo $ue_mail?>" /> <br/>
	PHONE NUMBER: <input type="text" name="uphone_num" value="<?php echo $uphone_num?>" />
	<input type="submit" name="update" value=" Update It " />
	</form>

	<?php
}

function dele_user($duid, $d_passwd){
	$result = new mysqli('localhost', 'root', '', 'proj');

	if($result->connect_error){
		die("Connection failed:" . $result->connect_error);
	}

	$conn = $result;
	$sql = "delete from user where userID = '".$duid."' and password = '".$d_passwd."' ";

	if($conn->query($sql) === TRUE) {
	header("location: login.php");
	}
	else{
	?>
	<script> 
	alert("There is error");
	window.location.replace("user.php");
	</script>
	<?php  }
}

function inse_user($iuid, $u_name, $passwd, $e_mail, $phone_num){
	$result = new mysqli('localhost', 'root', '', 'proj');

	if($result->connect_error){
		die("Connection failed:" . $result->connect_error);
	}

	$conn = $result;
	$sql = "insert into user values('".$iuid."', '".$u_name."', '".$passwd."', '".$e_mail."', '".$phone_num."')";

	if($conn->query($sql) === TRUE) {
	header("location: user.php");
	}
	else{
	?>
	<script> 
	alert("There is error");
	window.location.replace("user.php");
	</script>
	<?php  }
}

function upda_user($uid, $upasswd, $uuid, $uu_name, $upasswd, $ue_mail, $uphone_num){
	$result = new mysqli('localhost', 'root', '', 'proj');

	if($result->connect_error){
		die("Connection failed:" . $result->connect_error);
	}

	$conn = $result;
	$sql = "update user set userID = '".$uuid."', userName = '".$uu_name."', password = '".$upasswd."', email = '".$ue_mail."', phoneNum = '".$uphone_num."' where userID = '".$uid."' and password = '".$upasswd."'";

	if($conn->query($sql) === TRUE) {
	header("location: user.php");
	}
	else{
	?>
	<script> 
	alert("There is error");
	window.location.replace("user.php");
	</script>
	<?php  }
}


?>

</body> 
</html>