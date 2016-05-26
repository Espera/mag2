<? session_start();

function user_offer($id){
$offer='';
$user = $_SESSION['id'];
	include 'db.php';
	$query="SELECT `price`,`count` FROM `offer` WHERE `product_id`='$id' AND `receive`='admin' AND `user_id`='$user' AND `status`='1'";
		if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
		while ($row = $result->fetch_object()){
			$offer['price']=$row->price;
			$offer['count']=$row->count;			
		}}
return $offer; 
}


function product_status($id){
$user = $_SESSION['id'];
	include 'db.php';
	$query="SELECT COUNT(*) as `cnt `FROM `offer` WHERE `product_id`='$id' AND `user_id`='$user' AND `status`='0'";
		if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
		while ($row = $result->fetch_object()){
			$count =$row->cnt;

		}}
return $count; 	
}


?>