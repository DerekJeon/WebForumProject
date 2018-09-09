<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<button onclick="move()"> GO INDEX PAGE </button>
<script>
	function move(){
		window.location.replace("index.html")
	}
</script>

<?php

session_start();

if(isset($_POST["submit"])){

if(isset($_POST["captcha"]) && $_POST["captcha"] != "" && $_SESSION["num"] == $_POST["captcha"]){
echo "Your code is correct!"; }
else{
die("Your code is not correct"); }
}
else{
	make_form();

}


function make_form(){
	?>
<form action="captcha.php" method="post">
Enter what number you see
<input name="captcha" type="text">
<img src="captcha_image.php"/> <br>
<input type="submit" name="submit" value="WRITE">
</form>
<?php
}
?>

</body>
</html>
