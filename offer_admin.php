<?

$id = $_POST['id'];
$count = $_POST['count'];
$user = $_POST['user'];
$price = $_POST['price'];
$user = $_POST['user'];
$offer_user = $_POST['offer_user'];

echo '<br>id '.$id;
echo '<br>count '.$count;
echo '<br>user '.$user;
echo '<br>price '.$price;

function user_price($id){
include 'db.php';	
	$query="SELECT `price` FROM `offer` WHERE `status`=0 AND `user`='$user' AND `product_id`='$id'";	
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		$price = $row->price;
	}}
return $price;	

}



function email_send($name, $surname, $phone, $email, $id, $count, $price){
include 'db.php';
	$query="SELECT * FROM `shop` WHERE `id`='$id'";	
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		$product_name = $row->name;
		$ean = $row->ean;
		$info = $row->info;
		$product_price = $row->price;
	}}

	$user_price = user_price($id);

$email_text = "
<html>
<div><br>Labdien, <b>$name $surname</b>
	<br>Jus intereseja <b>$count</b> prece(s) <b>$product_name</b>
	<br>Produkta EAN <b>$ean</b>
	<br>Produkta apraksts <b>$info</b>
	<br>Produkta veikala cena ir <b>$product_price</b>
	<br>Jusu piedavata cena ir <b>$user_price</b>
	<br>Veikala pretpiedavajums ir <b>$price</b>
	<br>Preci var apskatit http://rel.lv/shop/$id
	</div>
</html>";


mail("stx.vi@inbox.lv", "Veikala www.rel.lv piedavajums", "$email_text"); 

}

include 'db.php';
	$query="SELECT * FROM `user` WHERE `user`='$offer_user' LIMIT 1";	
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		$name = $row->name;
		$surname = $row->surname;
		$phone = $row->phone;
		$email = $row->email;		
		email_send($name, $surname, $phone, $email, $id, $count, $price);
		
	}}
	
	$query="UPDATE `offer` SET `status`='1' WHERE `user_id`='$offer_user' AND `status`='0' AND `product_id`='$id'";
		$mysqli->query($query, MYSQLI_USE_RESULT);


	$query = "INSERT INTO `offer`(`product_id`, `count`, `price`, `user_id`, `status`, `supplier`,`receive`) VALUES ('$id','$count','$price','$offer_user','1','$user','admin')";

		$mysqli->query($query, MYSQLI_USE_RESULT);

	$mysqli->close;


?>