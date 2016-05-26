<? session_start();

function table_name_to_id($field,$val){
	
	$field = substr($field,0,-3); 
	
	include 'db.php';
	$query="SELECT `id` FROM `$field` WHERE `$field`='$val'";
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){	
		$val =$row->id;
	}}
return $val;	
}//end function table_name_to_id()

	$val = $_POST['val'];
	$type=$_POST['type'];
	$i=0;
	$count=count($_POST['val'])-1;
	while ($i<=$count){
		
		$val[$i]= stripslashes(htmlspecialchars( $_POST['val'][$i], ENT_QUOTES));
		$type[$i] = stripslashes(htmlspecialchars( $_POST['type'][$i], ENT_QUOTES));	
		$i++;
	}
	
	$action = $_POST['action'];
	$counts = count($val)-1;
	$category = $_POST['category'];
	$i=0;
	
	
		include 'db.php';
		$query="SHOW FIELDS FROM `$category`";
		if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
		while ($row = $result->fetch_object()){	
			$field[$i]=$row->Field;
			$extra[$i]=$row->Extra;
			$type[$i]=$row->Type;
			$default[$i]=$row->Default;
			$key[$i]=$row->Key;
			$val[$i]=htmlspecialchars($val[$i]);
			$i++;
		}}
	
	
		switch($action){
			case 'add':
				$query_set;
				$query_value;
				$query_start="INSERT INTO `$category` ";
				$i=0;
					while ($i<=$counts){	
						if ($extra[$i]!='' || $defaut[$i]!='' || $type[$i]=='timestamp'){}
						else {
							if ($key[$i]=='MUL'){$val[$i]=table_name_to_id($field[$i],$val[$i]);}
							$query_where_value = $query_where_value." `$field[$i]`= '$val[$i]' AND";
							$query_value=$query_value." '$val[$i]',";
							$query_set=$query_set." `$field[$i]`,";

						}
						$i++;				
					}
						
						$query_set=' ('.substr($query_set, 0, -1).')';	
						$query_value=' VALUES ('.substr($query_value, 0, -1).')';
							$query=$query_start.$query_set.$query_value;
							$mysqli->query($query);
							
							echo '<br>'.$query;
				
				
				/////////////
						///esli estj zagruzhennie fotki, inache propuskaem
						$temp_pic = glob('img/temp/*.jpg');
						$temp_pic_count = count($temp_pic);
						print_r($temp_pic);
						echo '<br>pic count: '.$temp_pic_count;
						
						if ($temp_pic_count>0){
							$query_where_value=' WHERE '.substr($query_where_value, 0, -3);	
								
								$query_select = "SELECT `id` FROM `$category` ".$query_where_value.' LIMIT 1';
								echo '<br>select: '.$query_select;
									if ($result = $mysqli->query($query_select, MYSQLI_USE_RESULT) ) {
									while ($row = $result->fetch_object()){	
										$id = $row->id;
										$dir = base_convert($row->id, 10, 35);
									}}
									echo '<br>id: '.$id;
									echo '<br>dir: '.$dir;
									
										if (!is_dir("img/$category/$dir")){
											mkdir("img/$category/$dir", 0744);
											$set = $category.'_pic';
											$query_update = "UPDATE `$category` SET `$set`='$dir' WHERE `id`='$id'";
											$mysqli->query($query_update);
											//echo '<br>update: '.$query_update;										
										}
											//$pic = $_POST['pic'];
											$pic = glob('img/temp/*.jpg');
											$count = count($pic)-1;
											//$count = 5;
											while ($count>=0){
												//$pic[$count];
												$pic_list = $pic[$count];
												list($a, $a, $pic_url) = explode("/", $pic_list);
												
											//	echo '<br>';
											//	echo '<br>pic_list: '.$pic_list;
											//	echo '<br>pic url: '.$pic_url;
											//	echo '<br>kuda: '."img".DIRECTORY_SEPARATOR.$category.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$pic_url;
											//	echo '<br>otkuda: '."img".DIRECTORY_SEPARATOR."temp".DIRECTORY_SEPARATOR.$pic_url;
												
												copy("img".DIRECTORY_SEPARATOR."temp".DIRECTORY_SEPARATOR.$pic_url,"img".DIRECTORY_SEPARATOR.$category.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$pic_url);
												
												
											$count--;	
											}
									//udaljaem vse vremennie fotki
									
									
									$temp_pic_count--;
									while ($temp_pic_count>=0){
										unlink($temp_pic[$temp_pic_count]);
									
									$temp_pic_count--;	
									}
									
									
						}//if temp_pic_count>0
							echo 'zapisj dobavlena!';
						
							$mysqli->close();
				
			break;
			case 'save':
				$query_start="UPDATE `$category` SET";
					$i=0;
					while ($i<=$counts){	
						if ($extra[$i]!='' || $defaut[$i]!='' || $type[$i]=='timestamp'){}
						else {
							$val[$i]=htmlspecialchars_decode($val[$i]);
						//	$val[$i]=htmlspecialchars( $val[$i], ENT_QUOTES);
							
							if ($key[$i]=='MUL'){$val[$i]=table_name_to_id($field[$i],$val[$i]);}
							
							$query_set=$query_set." `$field[$i]`='$val[$i]',";
						}
						
						$i++;				
					}
											
						$query_where=" WHERE `id`='$val[0]'";
						$query_set=substr($query_set, 0, -1);
							$query=$query_start.$query_set.$query_where;
							$mysqli->query($query);
							echo 'zapisj ispravlenna';	
							
			break;		
			
		}//end switch
	
	
	/* sozdatj papku s nazvaniem id (mozhet bitj perevesti v hesh)
	
	skopirovatj vse fotki iz vremennoj papki v novuju papku
	
		/* udalitj vse fotki iz vremennoj papki 

		$dir = 'img/temp/';
		$file_list = glob("$dir*.jpg");
		$file_count= (count($file_list)>0)?(count($file_list)-1):0;
			while ($file_count>=0){
			unlink($file_list[$file_count]);
			$file_count--;
	*/
	
	
	
	
	

	
	
	//vipolnjaem zapros
//	$mysqli->query($query);

?>