<?

	$category = array("slider",  "galery", "email","news", "user", "shop" );
	$action = array("delete","edit","new");
	$picture = array("shop","galery","user","news","slider");




	if (empty($_POST['search']))
	{constructor_default($category, $action, $picture);}
	else{constructor_search($category, $action, $picture);}



function constructor_search($category, $action, $picture){
global $fields;	
$search = true;
$show=' active';
	table_buttons($category);
		$count = count($category);
		while ($count>0){
			$count--;
			echo '<div class="table_field'.$show.'" id="field_'.$category[$count].'">';
				echo '<table id="table_'.$category[$count].'" border="1">';
					$info[$count] = info($category[$count]);
					head($category[$count], $picture, $fields);
					add($category[$count], $fields, $picture, $info[$count]);
					row($category[$count],10, $fields, $picture, $info[$count],$search);				
				echo '</table>';
			echo '</div>';
			$fields = array(); 
			$show='';
		}
	echo '</div>';
}//end function constructor_search

function constructor_default($category, $action, $picture){
global $fields;	
$search = false;
$show=' active';
		table_buttons($category);
		$count = count($category);
		while ($count>0){
			$count--;
			echo '<div class="table_field'.$show.'" id="field_'.$category[$count].'">';
				echo '<table id="table_'.$category[$count].'" border="1">';
					$info[$count] = info($category[$count]);
					head($category[$count], $picture, $fields);
					add($category[$count], $fields, $picture, $info[$count]);
					row($category[$count],10, $fields, $picture, $info[$count],$search);				
				echo '</table>';
			echo '</div>';
			$fields = array(); //ochishaem massiv s nazvaniem kolonn
			$show='';
		}
	echo '</div>';
} //end function constructor_default

function table_buttons($category){
	$count = count($category);
	$show = ' active';
	echo '<div class="admin">';
		while ($count>0){
			$count--;
			echo '<div class="category'.$show.'" id="'.$category[$count].'" data-id="'.$category[$count].'">'.$category[$count].'</div>';
			$show='';
		}	
	
}//end function table_buttons

function rows($category){
	include 'db.php';
	$query="SHOW FIELDS FROM $category";
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){	
		$field=$row->Field;
		$extra=$row->Extra;
		$default=$row->Default;
		$key = $row->Key;
			if ($extra!=''){/*esli extra, to propuskaem (id auto increment, date_buy curent timestamp */}
			else if ($defaut!=''){/* esli default, to propuskaem, znachenija po default */}			
			else if (preg_match('/[checkbox\,\.]/ui', $field)){/*checkbox($field);*/}	
			else{			
				echo '<div><div style="width:150px;float:left">'.$field.': </div>';	
					if ($key!=''){
						$field = substr($field,0,-3); //obrezaem kategoriju (ubiraem poslednie 3 simbola 'category_id'->category
						//delaem select 
						select($field);
						// konec select
					}			
					else {echo '<input type="text" name="'.$field.'" id="'.$field.'">';}		
				echo '</div>';
			}
		
		// kolichestvo zapisej (skoljko dobavitj tovara)
					switch ($field) {
						case 1:
							$title=$_LANG['New'];
							break;
						case 2:
							$title=$_LANG['Discounts'];
							break;
						case 3:
							$title=$_LANG['News'];
							break;
					}//swith					
	}}
}//end function rows(

function checkbox($field, $id, $category, $row_number, $number){
	include 'db.php';
	if ($id!='' && $id!='0'){
		$query="SELECT `$field` FROM `$category` WHERE `id`='$id'";	
		if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
		while ($row = $result->fetch_object()){	
			$checked=$row->$field;
		}}
	}
	$i=0;
	$query="SELECT * FROM `$field`";
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){	
		$option = $row->$field;
		echo '<input type="checkbox" name="'.$category.'_'.$row_number.'_'.$number.'" checkbox_id="'.$category.'_'.$row_number.'_'.$number.'_'.$i.'" option="'.$option.'"';
			if ($id!=''){if (stristr($checked, $option)){echo 'checked';}}
		echo '>'.$option;
		$i++;
	}}
}//end function checkbox

function select($field, $id, $category, $row_number, $number){
include 'db.php';

	if ($id!='' && $id!='0'){
		$query="SELECT `$field` FROM `$category` WHERE `id`='$id'";
			if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
			while ($row = $result->fetch_object()){	
				$select=$row->$field;
			}}
	}

	$i=0;
	echo '<select select_id="'.$category.'_'.$row_number.'_'.$number.'" id="'.$category.'_'.$row_number.'_'.$number.'">';
		$field = substr($field,0,-3);
		$query="SELECT * FROM `$field`";
			if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
			while ($row = $result->fetch_object()){	
				$option = $row->$field;
				$id= $row->id;
				echo '<option id="'.$id.'" select_id="'.$category.'_'.$row_number.'_'.$number.'_'.$i.'"'; //
					if ($id!=''){if (stristr($id, $select)){echo ' selected';}}		
				echo ' option="'.$option.'">'.$option.'</option>';
				$i++;
			}}
	echo '</select>';		
} //end function select

function counts($category, $row_number, $number){
	$i=0;
	echo '<td id="td_'.$category.'_'.$row_number.'_'.$number.'">';
		echo '<select name="cost" id="count">';
			
			while($i<21){
				echo '<option value="'.$i.'">'.$i.'</option>';	
				$i++;
			}		
		echo '</select>';		
	echo '</td>';
}//end function counts

function button($type, $category, $fields, $id, $row_number){
	$count = count($fields)-1;		
	echo '<td><div class="button '.$type.'" data-category="'.$category.'" data-count="'.$count.'" data-id="'.$id.'" data-row="'.$row_number.'" data-action="'.$type.'">'.$type.'</div></td>';
}

function head($category, $picture, $fields){
global $fields;	
	echo '<tr>';	
		include 'db.php';
		$query="SHOW FIELDS FROM $category";
		if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
		while ($row = $result->fetch_object()){	
			$field=$row->Field;
			$fields[]=$field;
			echo '<td>'.$field.'</td>';	
		}}
		if (in_array($category, $picture)) {echo '<td>picture</td>';}
		echo '<td>Buttons</td>';
	echo '</tr>';
} //end head

function add($category, $fields, $picture, $ifno){
	$row_number=0;
	$number=0;
	$i=0;
	echo '<tr class="tr_all" id="tr_'.$category.'_'.$row_number.'">';

		include 'db.php';
		$query="SHOW FIELDS FROM `$category`";
		if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
		while ($row = $result->fetch_object()){	
			$field=$row->Field;
			$extra=$row->Extra;
			$type=$row->Type;
			$default=$row->Default;
			$key = $row->Key;

			echo '<td id="td_'.$category.'_'.$row_number.'_'.$number.'"'; //td nachinaetsja, no ne zakanchivaetsja
				if ($extra!=''){echo 'data-type="text">';/*esli extra, to propuskaem (id auto increment, date_buy curent timestamp */}
				else if ($defaut!=''){echo 'data-type="text">';/* esli default, to propuskaem, znachenija po default */}
				else if ($type=='timestamp'){echo 'data-type="text">';/* esli plnaja data so vremenem, to ne pokazivaem (vremja pokupki i vremja prodazhi) */}
				else if ($type=='date'){echo 'data-type="text"><input class="select_date" type="text" name="'.$field.'" id="'.$category.'_'.$row_number.'_'.$number.'" data-type="text">';}			
				else if (stristr($field, 'checkbox')){echo 'data-type="checkbox">'; checkbox($field,'0',$category, $row_number, $number);}	
				else if ($key!=''){echo 'data-type="select">';select($field, '0', $category, $row_number, $number);}
				else if ($type=='varchar(2500)'){echo 'data-type="text"><textarea id="'.$category.'_'.$row_number.'_'.$number.'" data-type="text"></textarea>';}
				else {echo 'data-type="text"><input type="text" name="'.$field.'" id="'.$category.'_'.$row_number.'_'.$number.'" data-type="text">';}						
			$number++;	
			echo '</td>';					
		}} //end query
		
	if (in_array($category, $picture)) {pictures($category,$row_number,'0');}
	button('add',$category, $fields ,'0', $row_number);
	echo '<br>fields: '.$fields;
echo '</tr>';
	
}//end function add

function search($category,$fields){
	$content = $_POST['search'];
	$count = count($fields)-1;
		for ($i=0;$i<=$count;$i++){
			$query=$query."`$fields[$i]` LIKE '%$content%' OR ";		
		}	
	switch ($_POST['sort_by']) {
		case '0':$query_sort = "ORDER BY `id` DESC";
		break;
		case '1':$query_sort = "ORDER BY `id` ASC";
		break;
	}		
	$query= "SELECT * FROM `$category` WHERE ".substr($query,0,-3).' '.$query_sort.' LIMIT 20';
return $query;	
}//end function

function row($category, $count, $fields, $picture, $info, $search){
	
	$row_number=1;
	$i=0;
	include 'db.php';	
	
	if ($search){$query = search($category,$fields);}
	else{$query="SELECT * FROM `$category` ORDER BY `id` DESC LIMIT 0, $count";}
	
	
	
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){	
		$count = count($fields);	
		$id=$row->id;
		$i=0;		
		$number=0;
		
		echo '<tr class="tr_all" id="tr_'.$category.'_'.$row_number.'">';
			while ($i<$count){	
				
				$id=$row->id;
				$value = $row->$fields[$i];
			
				echo '<td id="td_'.$category.'_'.$row_number.'_'.$number.'"'; //td nachinaetsja, no ne zakanchivaetsja
					switch ($info[$i]['type']) {
						case 'date':
							echo 'data-type="date"><input type="text" class="select_date" value="'.$value.'" id="'.$category.'_'.$row_number.'_'.$number.'">';
							break;
						case 'varchar(150)':
							echo 'data-type="checkbox">';
							checkbox($info[$i]['field'], $id, $category,$row_number, $number);	
							break;
						case 'varchar(2500)':
							echo 'data-type="textarea"><textarea id="'.$category.'_'.$row_number.'_'.$number.'">'.$value.'</textarea>';
							break;
						case 'int(11)':						
							if ($info[$i]['key']!='' && $info[$i]['extra']==''){echo 'data-type="select">';select($info[$i]['field'], $id, $category, $row_number, $number);}
							else {echo 'data-type="text"><input type="text" value="'.$value.'" id="'.$category.'_'.$row_number.'_'.$number.'">';}
							break;
						default:
							echo 'data-type="text"><input type="text" value="'.$value.'" id="'.$category.'_'.$row_number.'_'.$number.'">';						
							break;
					
					}//swith
				echo '</td>';				
				$number++;					
				$i++;	
										
			}
			
			if (in_array($category, $picture)) {pictures($category,$row_number,$id);}
			button('put',$category,$fields, $id, $row_number);
			button('save',$category,$fields, $id, $row_number);	
		echo '</tr>';	
		$row_number++;
							
	}}
	
}//end row


function pictures($category,$row_number,$id){
$max_pic=4;
include 'db.php';
	echo '<td>';
/*		echo '<br>show_pic???????????????';
		echo '<br>esli estj fotki, to pokazatj ix preview!';
		echo '<br>esli kliknutj po malenjkoj fotke, to otkroetsja boljshaja fotka!';
		echo '<br>esli vozmozhnostj udalitj fotki!';
*/


	if (!empty($id)){
		$query="SELECT `".$category."_pic` as `url` FROM `$category` WHERE `id`='$id'";
		if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
		while ($row = $result->fetch_object()){
			$url=$row->url;
		}}

		if (!empty($url)){	
			$dir='img/'.$category.'/'.$url;								
			for ($i = 0; $i <= $max_pic; $i++) {			
				$file_list[$i] = glob($dir.'/'.$i.'ps*.jpg');
			}
		}	
	}

		echo $id;
		echo '<div class="div_picture" id="form_picture_'.$category.'_'.$id.'">';
			for ($i = 0; $i <= $max_pic; $i++) {	
				echo '<div class="form_picture" >';
					echo '<form action="admin_pic.php" target="rFrame" method="post" enctype="multipart/form-data" class="picture">'; 
					echo '<input type="file" name="loadfile" onchange="this.form.submit()">';
					echo '<div class="preview">';
						echo '<div class="preview_url" id="url_'.$category.'_'.$row_number.'_'.$i.'">';
							if (!empty($file_list[$i][0])){echo '<img src="'.$file_list[$i][0].'">';}
						echo '</div>';
						echo '<div class="preview" id="pic_'.$category.'_'.$row_number.'_'.$i.'">';
							if (!empty($file_list[$i][0])){echo '<img src="'.$file_list[$i][0].'">';}
						echo '</div>';
						echo '<div class="preview_delete';
							if (!empty($file_list[$i][0])){echo ' show';}
						echo '" data-id="pic_'.$category.'_'.$row_number.'_'.$i.'" id="del_'.$category.'_'.$row_number.'_'.$i.'" data-category="'.$category.'" data-object_id="'.$id.'">X</div>';
					echo '</div>';	
					
					echo '<input type="hidden" name="object_id" value="'.$id.'">';
					echo '<input type="hidden" name="dir" value="'.$url.'">';	
					echo '<input type="hidden" name="url" value="';
						if (!empty($file_list[$i][0])){echo $file_list[$i][0];}
					echo '">';
						
					echo '<input type="hidden" name="id" value="'.$category.'_'.$row_number.'_'.$i.'">';
					
					echo '</form>';				
				echo '</div>';
			}
		echo '</div>';
	echo '</td>';	
}//end function pictures

function info($category){
//varchar(50) - obichnij input
//varchar(150) - perechislenie (skorej vsego checkbox)
//varchar(2500) - tekstovoe pole

//int(11)
//tinyint(1) - obichno 1 ili 0 (pokazivatj ili net)
//double - ceni s tochkoj


//timestamp - avtomaticheski sozdajutsja (vremja prodazhi i vremja pokupki)
//date - data (vibiraetsja iz spiska)

include 'db.php';
global $info;	
$i=0;	
	$query="SHOW FIELDS FROM $category";
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		$info[$i]['field']=$row->Field;		
		$info[$i]['type']=$row->Type;
		$info[$i]['key']=$row->Key;
		$info[$i]['default']=$row->Default;
		$info[$i]['extra']=$row->Extra;
		$i++;
	}}
return $info;
} //end funtion info 



?>