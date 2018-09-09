<html> <head> <title>Please write Login Information</title> </head> <body>
<button onclick="move()"> GO BACK </button>
<script>
	function move(){
		window.location.replace("index.html")
	}
</script>

<?php 

function print_form($id, $passwd){ 
	?>

<form action="login.php" method="get">
	ID: <input type="text" name="id" value="<?php echo $id?>" /> <br/> 
	Password: <input type="text" name="passwd" value="<?php echo $passwd?>" /> <br/>
	<input type="submit" name="submit" value="Login" />
	<input type="submit" name="user_submit" value="Redesign User" />
</form> 

<?php }  //**  end of "print_form" function


function check_form($id, $passwd) {
	if(isset($_GET["user_submit"])) {
         check_administrator(); }
    if (!$passwd||!$id){ 
         echo "<h3>You are missing some required fields!</h3>"; 
         print_form($id, $passwd); } 
    else{ 
         if(isset($_GET["submit"])){
         	confirm_db($id, $passwd);
         }
         } 
         }  //** end of "check_form" function

function check_administrator(){
		header("location: user.php");
}

function confirm_db($id, $passwd) { 

	$result = new mysqli('localhost', 'root', '', 'proj');
	if($result->connect_error){
		die("Connection failed:" . $result->connect_error);
	}
	$conn = $result;
	$que_result = $conn->query(" select * from user where userID = '".$id."' and password = '".$passwd."' ");
	$num_result = $que_result->num_rows;

	if(!$num_result){
		$pluscheck = $_SESSION['oppor'];
		$pluscheck++;
		$_SESSION['oppor'] = $pluscheck;
		?>
	<script> 
	alert("You are not user");
	window.location.replace("login.php");
	</script>
	<?php
	}
	if($num_result > 0){
		$_SESSION['login_user'] = $id;
		header("location: success.php");
	}else{
		?>
	<script> 
	alert("You are not user");
	window.location.replace("login.php");
	</script>
	<?php
	} }

/*Main Program*/

session_start();

if(!isset($_SESSION["oppor"])){
	$_SESSION["oppor"] = 0;
}

if($_SESSION['oppor'] == 3){

	$inactive = 30;
	if(isset($_SESSION["timeout"])){
		$sessionTTL = time() - $_SESSION["timeout"];
		if($sessionTTL > $inactive){

		session_unset($_SESSION["oppor"]);
		session_destroy(); 

	if (!isset($_GET["user_submit"]) && !isset($_GET["submit"])) { ?>
	<h3>Please enter your information</h3>
	<?php 
	print_form("",""); }
	else{
	check_form($_GET["id"],$_GET["passwd"]);} }

	else{
		$waittime = 30 - $sessionTTL;
		echo "You have to wait time to re-login : " . $waittime; }
	}
	else{
		$_SESSION["timeout"] = time();
		header("location: login.php");
	}
}

else{
$leftopportunity = 3 - $_SESSION["oppor"];
echo "LEFT OPPORTUNITY IS " . $leftopportunity . ".";
if (!isset($_GET["user_submit"]) && !isset($_GET["submit"])) { ?>
<h3>Please enter your information</h3>
<?php 
print_form("",""); }

else{
check_form($_GET["id"],$_GET["passwd"]); }
}

?>

</body> 
</html>