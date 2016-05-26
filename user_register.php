<?php session_start();

$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$phone = $_POST['phone'];

include 'db.php';
$query = "INSERT INTO `user`(`name`, `surname`, `phone`, `email`) VALUES ('$name', '$surname', '$phone', '$email')";
$mysqli->query($query, MYSQLI_USE_RESULT);
$query="SELECT `id` FROM `user` WHERE `name`='$name' AND `surname`='$surname' AND `email`='$email' AND `phone`='$phone'";	
if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
while ($row = $result->fetch_object()){
	$id=$row->id;
	$_SESSION['id']=$id;
}}


echo 'Lietotajs veiksmigi registrets';
$mysqli->close;

?>