<?

function product_price($id){
global $price_real;
global $regular;
global $_LANG;
global $percent_option;
global $percent;
	include 'db.php';
		$query_price="SELECT * FROM `shop` WHERE `id`='$id' LIMIT 1";	
			if ($result = $mysqli->query($query_price, MYSQLI_USE_RESULT) ) {
			while ($row = $result->fetch_object()){
				$price=$row->price;
				$date = strtotime(date('Y-n-j'));	
											
				if (isset($price2)){$percent = round(-(($price2-$price)/$price)*100);}
			}}
}

?>