<div id="errors"></div>
<?php

function product_original_price($id){
include 'db.php';
	$query="SELECT `price` FROM `shop` WHERE `id`='$id'";	
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		$price = $row->price;
	}}
return $price;	
}
function picture($id){
	$dir = 'img/shop/'.$id.'';
	$file_list_pb = glob("$dir/?pb*.jpg");
	$url = $file_list_pb[0];
	if ($url==''){$url = 'img/shop/no_img_shop_id.jpg';};
return $url;
}						
						
function offer_supplier_count($id){
	include 'db.php';
	$query="SELECT COUNT(*) as `cnt` FROM `offer` WHERE `status`='1' AND `receive` LIKE '%supplier%' AND `product_id`='$id'";	
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		$count = $row->cnt;
	}}
	return $count;
}
function offer_header($id, $user_price,$count, $offer_user){

	$supplier_count = offer_supplier_count($id);
	echo '<div class="product">';
		echo '<div class="errors" id="errors_'.$id.'"></div>';
		echo '<div class="headers">';	
			echo '<div class="pic">';
				$url = picture($id);
				echo '<a href="shop/'.$id.'"><img src="'.$url.'"></a>';
			echo '</div>';
				$original_price = product_original_price($id);
			echo '<div class="">Produkta ID: '.$id.'</div>';
			echo '<div class="">Veikala cena '.$original_price.'</div>';
			echo '<div class=""><input type="text" class="price_input" oninput="admin_price('.$id.','.$count.','.$supplier_count.')" id="offer_'.$id.'"></div>';
			echo '<div class="">Klienta cena '.$user_price.'</div>';

			echo '<div class="button" onclick="offer_suppliers('.$id.')">Pieprasijums piegadatajiem</div>';
		echo '</div>';	


			offer_supplier($id, $supplier_count,$count, $offer_user);
			offer_user_history($id, $offer_user, 'a');
			offer_user_history($id, 'admin', 'b');			
	echo '</div>';
}

function offer_user_history($id, $offer_user, $option){
	echo '<div class="offer_table_header" id="show_table" data-id="'.$id.'_'.$option.'">';
		if ($option=='a'){echo 'Radit lietotaja vesturi';}
		else {echo 'Radit produkta cenu vesturi';}
	echo '</div>';
	echo '<div class="offer_table hide" id="table_'.$id.'_'.$option.'">';
		echo '<div class="line" style="display: table-row;">';
			echo '<div>ID</div>';
			echo '<div>Product ID</div>';		
			echo '<div>Count</div>';	
			echo '<div>Price</div>';		
			echo '<div>Date</div>';	
			echo '<div>User</div>';		
			echo '<div>Status</div>';		
			echo '<div>Supplier</div>';																	
		echo '</div>';
		
	include 'db.php';
	$query="SELECT * FROM `offer` WHERE `user_id`='$offer_user' AND `product_id`='$id'";
	
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		$count = $row->cnt;
		$product_id=$row->product_id;
		$count=$row->count;
		$price=$row->price;
		$date=$row->date;
		$user=$row->user;
		$status=$row->status;
		$supplier=$row->supplier;
		echo '<div class="line" style="display: table-row;background:';
			if ($status==0 ){echo '#FF9E9E;';}
			else {echo '#BBEA98;';}
		
		echo '">';
			echo '<div>'.$id.'</div>';
			echo '<div>'.$product_id.'</div>';			
			echo '<div>';
				if ($count>0){echo $count;}
			echo '</div>';				
			echo '<div>';
				if ($price>0){echo $price;}
			echo '</div>';	
			echo '<div>'.$date.'</div>';				
			echo '<div>'.$user.'</div>';	
			echo '<div>'.$status.'</div>';	
			echo '<div>'.$supplier.'</div>';										
		echo '</div>';	
	}}
	echo '</div>';
}

function offer_supplier($id, $supplier_count, $user_count, $offer_user){
$i=1;
echo '<br><div>Tika sanemti rezultati no '.$supplier_count.' piegadatajiem</div>';	
		
echo '<div class="line">';
	echo '<div class="supplier">';
			echo '<div>Piegadatajs</div>';
			echo '<div>Pieejami</div>';
			echo '<div>Pardodam</div>';		
			echo '<div>Perkam</div>';	
			echo '<div>Pelna</div>';	
			echo '<div>Pelna, %</div>';	
						
	echo '</div>';

	include 'db.php';
	$query="SELECT `count`,`price`,`date`,`receive`  FROM `offer` WHERE `status`='1' AND `receive` LIKE '%supplier%' AND `product_id`='$id'";	
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		$count_supplier = $row->count;
		$price = $row->price;
		$date = $row->date;
		$user = $row->receive;
		
		echo '<div class="supplier">';
		
				echo '<div>';
					echo $user;
				echo '</div>';		
				echo '<div id="count_'.$i.'_'.$id.'">';
					echo $count_supplier;
				echo '</div>';		
				echo '<div class="sell_'.$id.'" >';
					echo '';
				echo '</div>';			
				echo '<div id="buy_'.$i.'_'.$id.'">';
					echo $price;
				echo '</div>';
				echo '<div class="difference_'.$i.'_'.$id.'">';
					echo '';
				echo '</div>';
				echo '<div class="procent_'.$i.'_'.$id.'">';
					echo '%';
				echo '</div>';
				echo '<div></div>';
		
			echo '</div>';
			echo '<div class="supplier" id="supplier_'.$id.'_'.$i.'">';	
				echo '<div></div>';
				echo '<div>';
					echo $count_supplier;
				echo '</div>';			
				echo '<div class="few_sell_'.$id.'" >';
					echo '';
				echo '</div>';	
				echo '<div id="few_buy_'.$i.'_'.$id.'">';
					echo $price*$count_supplier;
				echo '</div>';
				echo '<div id="few_difference_'.$i.'_'.$id.'">';
					echo '';
				echo '</div>';
				echo '<div class="procent_'.$i.'_'.$id.'">';
					echo '%';
				echo '</div>';
				echo '<div class="button" data-id="'.$id.'" data-count="'.$user_count.'" data-user="'.$user.'" data-offeruser="'.$offer_user.'">Pasutit</div>';
			echo '</div>';			
			
		$i++;
		
	}}
echo '</div>';
}



echo '<div class="admin">';			
include 'db.php';
	$query="SELECT `product_id`,`price`,`count`,`user_id` FROM `offer` WHERE `status`='0' AND `user_id`>'0'";	
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		$id = $row->product_id;
		$price = $row->price;
		$count = $row->count;
		$offer_user = $row->user_id;
		offer_header($id, $price,$count,$offer_user);
	}}
	$mysqli->close;
echo '</div>';
?>