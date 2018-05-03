<?php
class DBConnection
{
private static $connection =  NULL;

private function connect() {
$servername = "localhost";
$username = "cs377";
$password = "cs377_s18";
$dbname = "Evaluations";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";
return $conn;
}

function getInstance() {
	if(self::$connection == NULL) {
		 self::$connection = $this->connect();
	}
	return self::$connection;
}

//TODO select statement that verifies user exists
function isUserValid($userName) {
	//? is more secure and better practice
	$sql = "SELECT * from Student where Sid = ?";

	//Create prepare statement using the sql command
	$stmt = self::$connection->prepare($sql);

	//Binds $username to the $stmt
	//Have to declare what the types are, so $userName is a string
	if( !$stmt->bind_param("s", $userName) ) {
		return false;
	}


	//runs the statement that you previously prepared
	if( !$stmt->execute() ) {
		return false;
	}

	//gets the result and stores it in $res
	if(!($res = $stmt -> get_result())) {
		return false;
	}

	//$res->fetch_all returns an array 
	//gets the size of that array
	$res_size = sizeof($res->fetch_all());

	//closes the statement after done using it
	$stmt->close();

	//checks to see if the query returns a result greater than 0
	//means that the username is valid
	if($res_size > 0){
		return true;
	} else {
		return false;
	}
}

//TODO get users classes
function getUsersClasses($userName) {
	$sql = "SELECT * from Student_Class where Sid = ?";

	$stmt = self::$connection->prepare($sql);

	if( !$stmt->bind_param("s", $userName) ) {
		return false;
	}

	if( !$stmt->execute() ) {
		return false;
	}

	if(!($res = $stmt -> get_result())) {
		return false;
	}

	$stmt->close();
	return $res->fetch_all();
}

// TODO verifies if user took class
function didUserTakeClass($userName, $cNumber) {
	$sql = "SELECT * from Student_Class where Sid = ? and Cnumber = ?";

	$stmt = self::$connection->prepare($sql);

	if( !$stmt->bind_param("ss", $userName, $cNumber) ) {
		return false;
	}

	if( !$stmt->execute() ) {
		return false;
	}

	if(!($res = $stmt -> get_result())) {
		return false;
	}

	$res_size = sizeof($res->fetch_all());

	$stmt->close();

	if($res_size > 0){
		return true;
	} else {
		return false;
	}
}

//TODO select statement that verifies user can provide class evaluation
// User can only provide one class evaluation
function isUserEvaluationValid($userName, $evaluationAnswers) {

}

//TODO select statement that loads the evaluation questions for each course
function getEvaluationQuestion($course) {

}

//TODO insert evaluation answer
function insertEvaluationAnswer() {

}

}
?> 
