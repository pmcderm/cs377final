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
	$sql = "SELECT * from Student where Sid = ?";
	$stmt = self::$connection->prepare($sql);
	$bool = $stmt->bind_param("s", $userName);
	if(!$bool) {
		return false;
	}
	$result = $stmt->execute();
	$stmt->close();
	if($result['num_rows'] > 0){
		echo "It is true";
		return true;
	} else {
		echo "It is false";
		return false;
	}
}

//TODO select statement that verifies user can provide class evaluation
// User can only provide one class evaluation
function isUserEvaluationValid($userName, $evalId) {

}

//TODO select statement that loads the evaluation questions for each course
function getEvaluationQuestion($course) {

}

//TODO insert evaluation answer
function insertEvaluationAnswer() {

}


}
?> 
