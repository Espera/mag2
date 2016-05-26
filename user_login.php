<?php session_start();


$email = $_POST['email'];
$email = stripslashes($email);

include 'db.php';
 $query = "SELECT * FROM `user` WHERE `email`='$email'";
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){

    $_SESSION['id']= $row->id;
	echo 'Veiksmigi ienakat sistema';
	}}

?>