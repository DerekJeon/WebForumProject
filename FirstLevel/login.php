<html> <head> <title>Please write Login Information</title> </head> <body>


<?php 

function print_form($id, $passwd){ 
	?>

<form action="login.php" method="get">
	ID: <input type="text" name="id" value="<?php echo $id?>" /> <br/> 
	Password: <input type="text" name="passwd" value="<?php echo $passwd?>" /> <br/>
	<input type="submit" name="submit" value="LOGIN" />
	<input type="submit" name="ad_submit" value="INSERT OR UPDATE USER" />
</form> 

<?php } 


function check_form($id, $passwd) {
if(isset($_GET["ad_submit"])) {
         check_administrator($id, $passwd); }

	else if (!$passwd||!$id){ 
         echo "<h3>You are missing some required fields!</h3>"; 
         print_form($id, $passwd); } 
     else if(isset($_GET["submit"])){
         	confirm_db($id, $passwd); }
         } 

function check_administrator($id, $passwd){
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

if (!isset($_GET["ad_submit"]) && !isset($_GET["submit"])) { ?>
<h3>Please enter your information</h3>
<?php 
print_form("",""); }
else{
check_form($_GET["id"],$_GET["passwd"]);}
?>

</body> 
</html>