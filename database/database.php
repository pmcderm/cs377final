<?php
class DBConnection
{
STATIC $connection = NULL;

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
echo "Connected successfully";
return $conn;
}

function getInstance(){
if($connection == NULL) {
$connection = $this->connect();
}
return $connection;
}
}
?> 
