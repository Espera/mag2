<?php session_start();

$id =$_POST['id'];
$count = $_POST['count'];
$price = $_POST['price'];
$status = $_POST['status'];

function id_to_ean($id){
include 'db.php';
	$query="SELECT `ean` FROM `shop` WHERE `id`='$id'";	
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		$ean = $row->ean;
	}}
	
return $ean;	
}
function offer_supplier_update($id, $price, $count, $user){
	
include 'db.php';
//zapisivaem v bazu id i price
switch ($user) {
case 'xml':
    $user = 'supplierXML';
    break;
case 'xml2':
    $user = 'supplierXML2';
    break;	
case 'db':
    $user = 'supplierDB';
    break;
case 'db2':
    $user = 'supplierDB2';
    break;
}

// proverjaem skoljko zapisej ot postavshikov
	$query="SELECT COUNT(*) as `cnt` FROM `offer` WHERE `receive`='$user' AND `product_id`='$id'";	
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		$counts = $row->cnt;
	}}

//esli net, to sozdaem zapisj ob postavshike	
	if ($counts==0){
		$query = "INSERT INTO `offer`(`product_id`, `count`, `price`, `receive`,`status`) VALUES ('$id','$count','$price','$user','1')";
		$mysqli->query($query, MYSQLI_USE_RESULT);
	}else {
// esli estj, to obnovljaem kolichestvo i cenu
		$query = "UPDATE `offer` SET `count`='$count',`price`='$price' WHERE `receive`='$user' AND `product_id`='$id'";
		$mysqli->query($query, MYSQLI_USE_RESULT);		
	}
	
	//obnovljaem zakupochnuju cenu i count v magazine, esli cena nizhe imejushejsja

	$query="SELECT COUNT(*) as `cnt` FROM `shop` WHERE `id`='$id' AND `price`>'$price' OR `count`<'$count'";	
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		$count = $row->cnt;
	}}
	
	if ($count>0){	
		$query = "UPDATE `shop` SET `count`='$count', buy`='$price', 'supplier'='$user' WHERE `id`='$id'";
		$mysqli->query($query, MYSQLI_USE_RESULT);
	}
				
$mysqli->close;
}

function offer_supplier_send_xml($id){	
	// v baze dannix ishem ean produkta po id 
	$ean = id_to_ean($id);
	$file = '';
	$i=0;
	while ($i<2){
		if ($file==''){$file='supplier.xml'; $xml='xml';}else {$file='supplier2.xml';$xml='xml2';}
		$nXML= file_get_contents($file);
		$rxml = new XMLReader();
		$rxml->xml($nXML);
		
		
			while($rxml->read() && $rxml->name !== 'product');
			while($rxml->name === 'product'){   
				$node = new SimpleXMLElement($rxml->readOuterXML());
				if($node->ean == $ean ){
					$price = $node->price;
					$count = $node->count;
					break;
				}else{
					$rxml->next('product'); 
				}
			}
						
		offer_supplier_update($id, $price, $count, "$xml");
		$i++;
	}
}
function offer_supplier_send_db($id){
$ean = id_to_ean($id);
$i=0;
	while ($i<2){
		if ($i==0){$db='db';$table='supplier';}else {$db='db2';$table='supplier2';}
			include 'db.php';
			$query="SELECT `price`,`count` FROM `$table` WHERE `ean`='$ean'";	
			if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
			while ($row = $result->fetch_object()){
				$count = $row->count;
				$price = $row->price;
			}}
		offer_supplier_update($id, $price, $count, "$db");		
	$i++;
	}	
}



function offer_status_zero($id){
$user = $_SESSION['id'];
	include 'db.php';
	$query="SELECT COUNT(*) as `cnt` FROM `offer` WHERE `status`='0' AND `user_id`='$user' AND `product_id`='$id'";	
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		$count = $row->cnt;
	}}
return $count;	
}

function offer_price_lower_today($price, $id) {
	include 'db.php';	
$user = $_SESSION['id'];
	$query="SELECT COUNT(*) as `cnt` FROM `offer` WHERE `price`>='$price' AND `product_id`='$id' AND `user_id`='$user' AND `date`>= DATE_SUB(CURRENT_DATE, INTERVAL 1 DAY)";	
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		$count = $row->cnt;	
	}}
return $count;
}

/*function offer_request_today($id){
	include 'db.php';	
	$query="SELECT COUNT(*) as `cnt` FROM `offer` WHERE `product_id`='$id' AND `status`='0' AND `user` LIKE '%supplier%' AND `date`>=CURDATE()";	
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		$count = $row->cnt;	
	}}
return $count;	
		
}*/
function offer_user_add($id,$count,$price){
	$user = $_SESSION['id'];
	if ($count>0 && $price>0){
		include 'db.php';
		$query="INSERT INTO `offer`(`product_id`, `user_id`,`price`,`count`) VALUES ('$id','$user','$price','$count')";	
		$mysqli->query($query, MYSQLI_USE_RESULT);
		$mysqli->close;
	}
}


// estj li zapisj ot poljzovatelja so statusom 0
	$counts = offer_status_zero($id);


//esli net, to 	
	if ($counts==0 || $status=='admin'){

    // ishem net li segodnja zapisi s cenoj, kotoraja nizhe
		$offer_today = offer_price_lower_today($price, $id);
		
		if ($offer_today==0 || $status=='admin'){
		//esli net, to sozdaem zapisj i otpravljaem postavshiku zapros
	
			//$offer_request_today = offer_request_today($id);
			
			// otpravljaem postavshiku v sluchae, esli segodnja ne otpravljali uzhe zapros								
				//if ($offer_request_today==0){
				if ($status!='admin'){
					offer_user_add($id,$count,$price);
					echo 'Jusu piedavajums ir pienemts un bus apstradats';
				}
				//} 
				//if ($offer_request_today==0 || $status=='admin'){

// OTPRAVITJ KONKRETNIM POSTAVSHIKAM KONKRETNIJ ZAPROS		
					offer_supplier_send_xml($id);
					offer_supplier_send_db($id);					
					

			//	}else {
				//	echo 'Gaidam atbildi no piegādātāja';					
			//	}
	// proverjaem net li zaprosa k postavshiku naschet ceni 			
		}else{
		//esli estjj, to preduprezhdaem, chto slishkom nizkaja cena
			echo 'Piedāvāta cena ir zemāka par Jūsu iepriekš piedāvātu';		
		}
	}else{
//esli estj, to preduprezhaem, chobi zhdali otveta
			echo 'Jūsu piedāvājums tiek apstrādāts';		
	}
		
	
	
				











?>