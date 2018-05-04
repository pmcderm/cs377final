<html>
<body>
<?php
include '../components/header.php';
include '../database/database.php';
	$foo = new DBConnection;
	$conn = $foo->getInstance();
	$isUserValid = false;
	$checkedUserNameOnce = false;
	if (!$isUserValid && !empty($_GET['userName'])) {
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
?>
<?php endif; ?>
<?php if(!isset($_GET['studentClass']) && isset($_GET['userName']) && sizeof($students_class_rows) > 0) : ?>
	<form action="student_input.php" method="get"> 
	<?php foreach ($students_class_rows as $i =>$row): ?> 
		<input type="hidden" name="userName" value="<?php echo $userName?>"/>
		<button name="studentClass" value="<?php echo $row[$i];?>"><?php echo $row[$i] ?></button>
	<?php endforeach;?>
<?php endif; ?>
</body>
</html>
