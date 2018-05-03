<html>
<body>
<?php
include '../database/database.php';
	$foo = new DBConnection;
	$conn = $foo->getInstance();
	$isUserValid = false;
	if (!empty($_GET['userName'])) {
		$userName =  $_GET['userName'];
		$isUserValid = $foo->isUserValid($userName);
		echo $isUserValid;
	}
?>
<?php if (empty($_GET['userName']) || !$isUserValid) : ?>
	<form action="info.php" method="get">
		<label for="userName">Enter Username</label>
		<input type="text" name="userName"/>
		<button>Submit</button>
	</form>
	<?php if ($isUserValid) {
		echo "User is not valid";
	} ?>
<?php else : 
	echo $userName . " is a valid user name";
?>
<?php endif; ?>
</body>
</html>
