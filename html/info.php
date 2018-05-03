<html>
<body>
<?php
include '../database/database.php';
$foo = new DBConnection;
$conn = $foo->getInstance();
$conn->close();
?>
</body>
</html>
