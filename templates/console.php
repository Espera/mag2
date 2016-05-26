<br />Status 0 - tiek apstradat
<br />Status 1 - tiek pienemts lemums

<div class="console">
	<div class="button" data-up="user">Lietotaji</div>
	<div class="button" data-up="supplier">Piegadataji</div>
	<div class="button" data-up="admin">Administratori</div>

	<div class="down" id="user" data-up="user"><? console_show(''); ?></div>
	<div class="down" id="supplier" data-up="supplier" ><? console_show('supplier'); ?></div>
	<div class="down" id="admin" data-up="admin"><? console_show('admin'); ?></div>

</div>
<?php

function console_show($user){
	if (empty($user)){$query="SELECT * FROM `offer` WHERE `user_id` REGEXP '^[0-9]+$' AND `receive`='' ORDER BY `date` DESC LIMIT 20";}
	else {$query="SELECT * FROM `offer` WHERE `receive` LIKE '%$user%' ORDER BY `date` DESC LIMIT 20";}

include 'db.php';
	

	echo '<div class="table">';
		echo '<div class="line">';
			echo '<div>ID</div>';
			echo '<div>Product ID</div>';		
			echo '<div>Count</div>';	
			echo '<div>Price</div>';		
			echo '<div>Date</div>';	
			echo '<div>User</div>';		
			echo '<div>Status</div>';		
			echo '<div>Supplier</div>';																	
		echo '</div>';
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		$id=$row->id;
		$product_id=$row->product_id;
		$count=$row->count;
		$price=$row->price;
		$date=$row->date;
		$user=$row->user_id;
		$status=$row->status;
		$supplier=$row->receive;
		
		echo '<div class="line" style="background:';
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
?>

