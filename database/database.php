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
	$sql = "SELECT Cname, Class.Cnumber from Student_Class,Class where Sid = ? and Class.Cnumber = Student_Class.Cnumber";

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

//TODO select statement that verifies user can provide class evaluation; have they already answered
// User can only provide one class evaluation
function isUserEvaluationValid($userName, $evaluationAnswers) {
	$sql = "SELECT Answer from Question where Sid = ? and Cnumber = ?";

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

	if($res_size == 0){
		return true;
	} else {
		return false;
	}

}

//if no one from the class has answered the question, you can assume it is not on the eval
function isQuestionInCourseEval($fname,$lname, $cName) {
	$sql = "SELECT distinct Answer from Class,Question where Class.Cnumber = Question.Cnumber and Fname = $fname and Lname = $lname and Cname = ?";

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

	if($res_size == 1 and $res[0] == ''){
		return false;
	} else {
		return true;
	}

}

//TODO converts course name to number
// returns a 1 by 1 array with an integer, but I want to return just the integer
function courseNameToNumber($course) {
	$sql = "SELECT distinct Cnumber from Class where Cname = ?";

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


//TODO select statement that loads the evaluation questions for each course
// returns a 1 by 1 array with the text of the question, but I wan't just the text of the question
function getEvaluationQuestion($courseNumber) {
	$sql = "SELECT Qcontent from Question_Evaluation,Question where Question_Evaluation.Qnumber = Question.Qnumber and Cnumber = ?";

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

//TODO insert evaluation answer
function insertEvaluationAnswer($studentId,$classId,$questionNum,$ans) {
$sql = "INSERT INTO Question
VALUES ($studentId, $classId,$questionNum,$ans) ";

$stmt = self::$connection->prepare($sql);

if ($stmt->execute()) {
   	echo "Submitted!";
} else {
    echo "Error with Submission.";
}
}

//Student View

//Find type of question given Question number
//Return 1 by 1 array with question type
function questionType($qNumber) {
	$sql = "SELECT Qtype from Question_Evaluation where Qnumber = ?";

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

//finds numerator of Agree Disagree task in student view
function agreeDisagreeNumerator($Qnumber) {

}

// finds median of unordered varchar array
function medianVarChar($array){
$length = count($array);
if ($length == 1) {
	return $array(0);
}
$iterator = 0;
$newarray = array($length);
while ($iterator <= $length) {
	$newarray[$iterator] = (float) $array[$iterator];
}
sort($newarray);
if ($length % 2 == 0){
	return ($newarray[($length/2)-1] + $newarray[($length/2)+1])/2;
}
else {
	return $newarray[$length-1];
}

}



}
?> 
