<html>
<body>
<?php
include '../components/header.php';
include '../database/database.php';
	$foo = new DBConnection;
	$conn = $foo->getInstance();
	$isUserValid = false;
	$checkedUserNameOnce = false;
	if (!empty($_GET['userName'])) {
		$userName =  $_GET['userName'];
		$isUserValid = $foo->isUserValid($userName);
		$checkedUserNameOnce = true;
	}
?>
<?php if (empty($_GET['userName']) || !$isUserValid) : ?>
	<form action="student_input.php" method="get">
		<label for="userName">Enter Username</label>
		<input type="text" name="userName"/>
		<button>Submit</button>
	</form>
	<?php if(!empty($_GET['userName'])){
		echo "User is not valid";
	}?>
<?php else : 
	echo $userName . " is a valid user name";
	$students_class_rows = $foo->getUsersClasses($userName);	
	echo $students_class_rows;
	foreach ($row as $students_class_rows) {
		echo $row;
	}
?>
<?php endif; ?>
</body>
</html>
