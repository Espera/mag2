<? session_start();

include_once 'functions.php';

include_once 'product_price.php';
	if (empty($action)){$action = stripslashes(htmlspecialchars( $_POST['action']));}


		switch($action){
			case "add":
				card_add();
			break;
			case "check":
				card_check();
			break;			
			case "delete":
				card_delete();
			break;
			case "total":
				card_total(false);
			break;
			case "header":
				card_header($_LANG);
			break;
			case "last":
				card_header_last($_LANG,'');
			break;
			default:	
				card_view($_LANG);
			break;		
		}

function card_check(){
	$id = stripslashes(htmlspecialchars( $_POST['id']));
	$place = array_search($id, $_SESSION['mag']['card']['id']);	
	$place = $place>0 ? $place : 0;
echo $place;
}//end card_check

function card_total($hide){
global $_LANG;
	$count = count ($_SESSION['mag']['card']['id']);
	$summ = 0;
					
	for ($i=1;$i<$count;$i++){
		$id = $_SESSION['mag']['card']['id'][$i];
		$product_status = product_status($id);

		
		global $percent_option;
		global $regular;
		global $price_real;
		global $percent;
		product_price($id);
	
		$counts = ($_SESSION['mag']['card']['count'][$i]>0)? $_SESSION['mag']['card']['count'][$i] : 1;		
		$info = card_view_one($id);	
			$price = $info['price'];
			$price2 = $info['price2'];		
			
			if ($price2>0 && $price2!=''){
				$summ_one=$price2*$counts;}
			else{$summ_one=$price*$counts;}

				
		$summ = $summ+$summ_one;
	}
	$summ = number_format($summ, 2, '.', '');
	
	if (!$hide){echo $summ;}
	else{return $summ;}
	
}//end function card_total

function card_add(){
$id = stripslashes(htmlspecialchars( $_POST['id']));
$count = stripslashes(htmlspecialchars( $_POST['count']));
	$counts = count($_SESSION['mag']['card']['id']);
	$place = array_search($id, $_SESSION['mag']['card']['id']);

	if ($count>0){
		if (array_search($id, $_SESSION['mag']['card']['id'])) {
			$_SESSION['mag']['card']['count'][$place] =$count;
		}else{
			array_push($_SESSION['mag']['card']['id'],"$id");
			array_push($_SESSION['mag']['card']['count'],"$count"); 	 	
		}
	}else{
		if (array_search($id, $_SESSION['mag']['card']['id'])) {
			unset($_SESSION['mag']['card']['id'][$place]);
			unset($_SESSION['mag']['card']['count'][$place]);		
			$_SESSION['mag']['card']['id'] =array_values($_SESSION['mag']['card']['id']);
			$_SESSION['mag']['card']['count'] =array_values($_SESSION['mag']['card']['count']);		
		}
	}	
}//end function card_add

function card_delete(){
	$id = stripslashes(htmlspecialchars( $_POST['id']));	
		$place = array_search($id, $_SESSION['mag']['card']['id']);

			unset($_SESSION['mag']['card']['id'][$place]);
			unset($_SESSION['mag']['card']['count'][$place]);
			
			$_SESSION['mag']['card']['id'] =array_values($_SESSION['mag']['card']['id']);
			$_SESSION['mag']['card']['count'] =array_values($_SESSION['mag']['card']['count']);						
}//end function delete

function card_view_one($id){
global $_LANG;	
$user = $_SESSION['id'];
include 'db.php';
		
	$query = "SELECT * FROM `offer` WHERE `product_id`='$id' AND `user`='$user' AND `status`='1' AND `receive`='admin'";		
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		$admin_price = $row->price;	
		$count = $row->count;
	}}

//proverjaem estj li offer i podtverzhden li

//esli net, to berem cenu s magazina

	if (!empty($id) && $id>0){
	
		$query="SELECT * FROM `shop` WHERE `id`='$id'";
		if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
		while ($row = $result->fetch_object()){
			$name = $row->name;
			$dir = $row->shop_pic;
			$price = $row->price;
		}}
			if (!empty($dir)){
				$preview = glob("img/shop/$dir/$ps*.jpg");
			}else{$img='img/shop/no_img_shop_list.jpg';}
			
			if (file_exists($preview[0])) {
				$img = $preview[0];
			}
		$return = array(
			'name'=>$name,
			'img'=>$img,
			'price'=>$price,
			'price2'=>$admin_price,
			'count'=>$count
		);
		
	return $return;
	}
}//end function card_view_one

function card_view($_LANG){
global $_LANG;	
	echo '<div class="cards">';	
		$summ_total = card_total(true);
		$card_count = count ($_SESSION['mag']['card']['id']);
		$card_total_count = $card_count-1;
		echo '<div class="card_title">';
			echo '<div class="name">Produkti groza: '.$card_total_count.'</div>';		
		echo '</div>';
				
			for ($i=1;$i<$card_count;$i++){
				$id = $_SESSION['mag']['card']['id'][$i];
				$count = $_SESSION['mag']['card']['count'][$i];
				$info = card_view_one($id);
				
					$price = $info['price'];
					$price2 = $info['price2'];
					$price = number_format($price, 2, '.', '');
					$price2 = number_format($price2, 2, '.', '');
					$img = $info['img'];
					$name = $info['name'];
					
					
					global $percent_option;
					global $regular;
					global $price_real;
					global $percent;
					product_price($id);
						$offer = user_offer($id);
						$price2=$offer['price'];
					$product_status = product_status($id);
					

					if ($price2>0){
						$sum=$price2*$count;	
					}else{
						$sum=$price*$count;							
					}

					
						$sum = number_format($sum, 2, '.', '');
				

				echo '<div id="card_product_'.$id.'">';
					echo '<div class="product">';
						echo '<a class="ajax" href="shop/'.$id.'">';
							echo '<div class="img">';
								echo '<img src="'.$img.'">';
							echo '</div>';
						echo '</a>';
											
						echo '<div class="name">';
							echo $name;
						echo '</div>';
										
						echo '<div class="card" id="card_'.$id.'">';
							echo '<div data-price="'.$price_one.'" id="price_'.$id.'"></div>';
															
							echo '<div class="count" data-id="'.$id.'" data-price="'.$price_one.'">';
								echo '<div class="title">Daudzums:</div>';
								echo '<div class="product_count plus">+</div>';							
								echo '<div class="product_count"><div class="product_count_value" data-id="product_count_'.$id.'" id="product_count_'.$id.'">'.$count.'</div></div>';
								echo '<div class="product_count minus">-</div>';
							echo '</div>';
						echo '</div>';	
						
						echo '<div class="action">';
							echo '<div class="save" data-id="'.$id.'">Saglabat</div>';
							echo '<div class="delete" data-id="'.$id.'">Izdzest</div>';
						echo '</div>';	
						
						

						echo '<div class="price">';
							echo 'Cena:';
							
							echo 'price1: '.$price;
							echo ' price2: '.$price2;
							if ($price2>0){
								echo '<div class="old">'.$price.' EUR</div>';	
								echo '<div class="new">'.$price2.' EUR</div>';								
							}else {
								echo '<div class="one">'.$price.' EUR</div>';	
							}
							if ($product_status>0){echo '<div class="offer_status">Jusu cenas piedavajums tiek apstradats</div>';}
						echo '</div>';
						echo '<div class="summ">';
							echo '<div class="title">Summa :</div>';
							echo '<div class="amount" id="summ_'.$id.'">'.$sum.'</div>';
							echo '<div class="eur">EUR</div>';
						echo '</div>';
					echo '</div>';

				echo '</div>';
			}
			
	echo '<div class="total">Kopeja summa :';
		echo'<div id="summ_total" class="summ">'.$summ_total.'</div>';
		echo'<div class="eur">euro</div>';
	echo '</div>';		
	
	echo '<a class="ajax" href="'._LINK_PATH.'order"><div class="next">Pasutit</div></a>';



	echo '</div>';	
}//end function card_view
function card_number(){
	
	
	
}//end card_number

function card_header_last($_LANG,$i){
	
	if (empty($i)){
		$i=count($_SESSION['mag']['card']['id'])-1;
		$id = stripslashes(htmlspecialchars($_POST['id']));
	}
	else {
		$id = $_SESSION['mag']['card']['id'][$i];	
	}

			$count = $_SESSION['mag']['card']['count'][$i];
			$info = card_view_one($id);
				$img = $info['img'];
				$name = $info['name'];
				$price = $info['price'];
				$price2 = $info['price2'];
	
			echo '<div class="line" id="header_card_line_'.$id.'">';
				echo '<a class="ajax" href="'._LINK_PATH.'shop/'.$id.'">';
					echo '<div class="img">';
						echo '<img src="'.$img.'">';
					echo '</div>';
				echo '</a>';
				echo '<div class="name">'.$name.'</div>';
				echo '<div class="count" id="header_card_count_'.$i.'">'.$count.'</div>';
				echo '<div class="count">gab</div>';
				echo '<div class="remove" data-id="'.$id.'">';
					echo 'X';
				echo '</div>';
			echo '</div>';

			echo '<div class="delete" id="header_card_delete_'.$id.'">';
				echo '<div class="name">Jus esat parliecinati, ka gribat izdzest ¹o produktu no groza?</div>';
				
				echo '<div class="no" data-id="'.$id.'">Ne</div>';
		
				echo '<div class="yes" data-id="'.$id.'">Ja</div>';				
			echo '</div>';
	
	
	
} //end function card_header_last

function card_header($_LANG){
global $_LANG;	

	$card_count = count ($_SESSION['mag']['card']['id'])-1;
	
	echo '<div class="title">';
		if ($card_count==0){$count='Nav produktu';}else{$count=$card_count;}
		echo 'Produktu skaits: ';
	echo '</div>';
	$summ_total = card_total(true);
	
	echo '<div class="block" id="header_shop_card">';
		for ($i=1;$i<$card_count+1;$i++){
				card_header_last($_LANG,$i);
		}
	echo '</div>';//div block
	
	echo '<div class="total">';
		echo '<div class="name">Summa: </div>';
			echo '<div id="header_summ_total">'.$summ_total.'</div>';
		echo '<div class="eur"> eur</div>';
	echo '</div>';
	echo '<a class="ajax" href="'._LINK_PATH.'card">';
		echo '<div class="button">Pasutit</div>';
	echo '</a>';
}//end function card_header



?>