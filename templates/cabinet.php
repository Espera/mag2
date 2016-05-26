<? session_start(); 


		
function cabinet_offer_count($user){
include 'db.php';
	$user = $_SESSION['id'];
	$query="SELECT COUNT(*) as `cnt` FROM `offer` WHERE `user_id`='$user'";	
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		$count = $row->cnt;
	}}
return $count;		
}
function cabinet_product_info($id){
	include 'db.php';
	$query="SELECT * FROM `shop` WHERE `id`='$id'";	
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		$info['ean'] = $row->ean;
		$info['name']  = $row->name;
		$info['info']  = $row->info;
		$info['price'] = $row->price;
	}}
return $info;
}
function cabinet_offer_admin_price($id){
	include 'db.php';
	$query="SELECT `price` FROM `offer` WHERE `product_id`='$id' AND `receive`='admin'";	
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		$price = $row->price;
	}}
return $price;
}
function cabinet_offer($id,$status,$price2,$count,$date){	
	
	$price3 = cabinet_offer_admin_price($id);				
	$info = cabinet_product_info($id);
	$price = $info['price'];			

	$ean = $info['ean'];
	$infos = $info['info'];


	$price = number_format($price, 2, '.', '');
	$price2 = number_format($price2, 2, '.', '');
	$price3 = number_format($price3, 2, '.', '');
	
	$dir = 'img/shop/'.$id.'/';
 	$img = glob("$dir/?pb*.jpg");
	if ($img[0]==''){$img[0]='img/shop/no_img_shop_id.jpg';}
					$name = $info['name'];
					
					

					if ($price3>0){
						$sum=$price3*$count;	
					}else{
						$sum=$price*$count;	
					}
						$sum = number_format($sum, 2, '.', '');
				

				echo '<div id="card_product_'.$id.'">';
					echo '<div class="product">';
						echo '<a class="ajax" href="shop/'.$id.'">';
							echo '<div class="img">';
								echo '<img src="'.$img[0].'">';
							echo '</div>';
						echo '</a>';
											
						echo '<div class="name">';
							echo $name;
						echo '</div>';
										
						echo '<div class="card" id="card_'.$id.'">';
							echo '<div data-price="'.$price_one.'" id="price_'.$id.'"></div>';
															
							echo '<div class="count">';
								echo '<div class="title">Daudzums:'.$count.'</div>';
							echo '</div>';
						echo '</div>';	
						
						echo '<div class="action">';
							echo $infos;
						echo '</div>';	
						
						echo '<div class="action">';
							echo 'Status: ';
							if ($status == 0){echo 'Jusu piedavajums tiek apstradats';}
							else {echo 'Lemums pienemts';}
						echo '</div>';							

						echo '<div class="price">';
						
							if ($price3>0){
								echo '<div class="old">Standarta cena '.$price.' EUR</div>';									
								echo '<div class="new">Jusu piedavajums '.$price2.' EUR</div>';								
								echo '<div class="one">Veikala piedavajums <b>'.$price3.' EUR</b></div>';	
							
							}else {
								echo '<div class="one">Standarta cena '.$price.' EUR</div>';									
								echo '<div class="new">Jusu piedavajums '.$price2.' EUR</div>';								
							}							
						echo '</div>';
					
						echo '<div class="summ">';
							echo '<div class="title">Summa :</div>';
							echo '<div class="amount" id="summ_'.$id.'">'.$sum.'</div>';
							echo '<div class="eur">EUR</div>';
						echo '</div>';
					echo '</div>';

				echo '</div>';
				
			}
			

	
		
	


if (empty($_SESSION['id']) || $_SESSION['id']==''){
	include ('signin.php');
	
}else {
	echo '<div class="leave" title="iziet no sistemas" onclick="user_leave()"></div>';
	echo '<div class="cards">';	
		$user = $_SESSION['id'];
		
		echo '<div class="card_title">';
		$product_count = cabinet_offer_count($user);
			echo '<div class="name">Kobineta ir '.$product_count.' produkti: </div>';
			echo '<div class="count" id="card_total_count">'.$card_total_count.'</div>';		
		echo '</div>';
		
		include 'db.php';		
		$query="SELECT * FROM `offer` WHERE `user_id`='$user'";	
		if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
		while ($row = $result->fetch_object()){
			$id = $row->product_id;
			$status = $row->status;
			$price = $row->price;
			$count = $row->count;
			$date = $row->date;		
			cabinet_offer($id,$status,$price,$count,$date);		
		}}	
	echo '</div>';
}




?>
