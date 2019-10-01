<?php
$servername = $_ENV["DB_HOST"]; //"localhost";
$username = $_ENV[""];
$password = $_ENV[""];
$dbname = $_ENV["DB_NAME"];

//probably ussless
$db_port = $_ENV["DB_PORT"];
$app_port = $_ENV["APP_PORT"];
$app_host = $_ENV["APP_HOST"];


if(isset($_POST['val'])){
	$num = $_POST['val'];
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$val = $conn->query('select 1 from reqests_numbers LIMIT 1');
	if($val == FALSE){
		$conn->query("CREATE TABLE reqests_numbers (digits int(38) NOT NULL, UNIQUE KEY digits (digits)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	}
	
	$sql = "SELECT * FROM reqests_numbers WHERE digits=".($num-1);
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			error_log("Someone entered number reduced by one val = $num \n", 3, "err_log.log");
			die ("Someone entered number reduced by one");
		}
	}	
	$sql = "INSERT INTO reqests_numbers (digits) VALUES (".$num.")";	
	$result = $conn->query($sql);
	if ($result == null){
		error_log("Number alredy exists = $num \n", 3, "err_log.log");
		die("Number alredy exists");
	}
	ECHO $num+1;
	$conn->close();
}
?>
