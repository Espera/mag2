<? session_start(); 

include 'lang_'.$_SESSION['mag']['lang'].'.php';
//include_once 'product_price.php';
include_once 'functions.php';

global $_LANG;

class filter{
var $uri;
var $animal; 
var $category; 
var $page; //nomer stranici
var $options = array('size', 'color','manufactor','section','firm', 'subsubcategory', 'subcategory');
var $filters = array('price_up','price_down','popular_up','popular_down','volume_up','volume_down');
var $space; //kolichestvo kazhdogo options (category - cat, dog, fish...)
var $counts; //obshee kolichestvo options


// opredelitj skoljko znakov v url zanimaet etot $options

// zapolnitj select ciframi

// prochitatj znachenie select, znaja znachenie
	function Constructor_filter($uri, $animal, $category, $page){
		$this->uri = $uri;
		$this->animal = $animal;
		$this->category = $category;
		$this->page = $page;
		$this->counts = count($this->options)-1;
		$this->Div_start();
		$this->Space();
		$this->Shop_filter();
		$this->Shop_filter_orderby();
		$this->Shop_filter_clear();
		$this->Shop_filter_search();
		$this->Div_end();
	}
	
	function Space(){
		$options = $this->options;
		$counts = $this->counts;
			include 'db.php';
			while ($counts>=0){
				$query="SELECT COUNT(*) as `cnt` FROM `$options[$counts]`";	
				if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
				while ($row = $result->fetch_object()){
					$count=$row->cnt;
					$this->space[$counts]=$count;
				}}
				$counts--;	
			}	
	}
 

	function Div_start(){echo '<div class="filter">Sort by: ';}
	function Div_end(){echo '</div>';}

	function Shop_filter(){
		$uri=$this->uri;
		$count=$this->counts;
		$space = $this->space;
		$options= $this->options;
		$animal=$this->animal;
		if (!empty($animal)){$animal=' data-animal="'.$animal.'"';}
				
			include 'db.php';
			while ($count>=0){
				$table = $options[$count];
					echo '<div class="select">'.$table.'<select id="select_'.$count.'" data-option="'.$count.'"'.$animal.'>';
					
					$query="SELECT * FROM `$table`";					
					if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
					while ($row = $result->fetch_object()){
						$id=$row->id;
						$option = $row->$table;
						echo '<option value="'.$id.'"';
							if ($_SESSION['mag']['filter'][$count]==$id){echo ' selected="selected"';}
						echo' >'.$option.'</option>';
					}}
				echo '</select></div>';

				$count--;	
			}	
	}//end function shop_filter
	
	function Shop_filter_orderby(){
		$filters=$this->filters;
		$count = count($filters)-1;
		echo '<div class="order">';
			while ($count>=0){
				echo '<div class="by" data-id="'.$count.'" >'.$filters[$count].'</div>';			
			$count--;				
			}
		echo '</div>';
	}// end function Shop_filter_additional()

	function Shop_filter_clear(){
		echo '<div class="clear">Clear search</div>';
	}
	function Shop_filter_search(){
		$animal=$this->animal;
		if (!empty($animal)){$animal=$animal.'/';}
		echo '<div class="search" href="'._LINK_PATH.'shop/'.$animal.'filter">Search</div>';	
	}
}// end class shop_filter

function shop_id_to_category($category, $value){
	include 'db.php';	
	$query="SELECT `$category` FROM `$category` WHERE `id`='$value'";
		if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
		while ($row = $result->fetch_object()){
			$category=$row->$category;			
		}}
return $category; 
}

function shop_category_to_id($category, $value){
	include 'db.php';	
	$query="SELECT `id` FROM `$category` WHERE `$category`='$value'";
		if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
		while ($row = $result->fetch_object()){
			$category=$row->id;			
		}}

return $category; 
} // end function shop_category_to_id



/*function shop_table_search($content,$options,$content_new){
	$field = substr($options,0,-3);
	include 'db.php';	
	$query="SELECT `$field` FROM `$field` WHERE `id`='$content'";
		if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
		while ($row = $result->fetch_object()){
			$content_new=$row->$field;
		}}
return $content_new; 
}*/
//end function shop_table_search




function shop_id($_LANG, $id){
	include 'db.php';
	$lang=$_SESSION['mag']['lang'];

	echo '<div class="shop">';
	

		$i=0;	
		$query="SELECT * FROM `shop` WHERE `id`='$id' LIMIT 1";	
			if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
			while ($row = $result->fetch_object()){
				$id=$row->id;
				$name=$row->name;
				$price=$row->price;
				$ean=$row->ean; 
				$info=$row->info; 	
				$offer_count = product_status($id);
						
					global $regular;
					global $price_real;
					global $percent;

					//product_price($id);
					$offer = user_offer($id);					
					$price2=$offer['price'];
					
//					echo '<br>price: '.$offer['price'];		
	//				echo '<br>count: '.$offer['count'];							
					echo '<div class="pictures">';
						$dir = 'img/shop/'.$id.'';
						$file_list_pb = glob("$dir/?pb*.jpg");
						
						
						echo '<div class="big">';
						$file_count= (count($file_list_pb)>0)?(count($file_list_pb)-1):0;
						$i=0;	
							if ($file_count>=0){
								while ($file_count>=0){
									echo '<div class="picture';
										if ($i==0){echo ' show';}
									echo '" id="picture_big_'.$i.'"><img src="'.$file_list_pb[$file_count].'"></div>';
								$i++;
								$file_count--;
								}
							}else{
								echo '<div class="picture show">';
									echo '<img src="'._LINK_PATH.'img/shop/no_img_shop_id.jpg">';
								echo '</div>';
							}
						echo '</div>';//end div big
									
						echo '<div class="small">';	
							$file_list_ps = glob("$dir/?ps*.jpg");
							$file_count= (count($file_list_ps)>0)?(count($file_list_ps)-1):0;
							$i=0;	
								if ($file_count>0){
									while ($file_count>=0){
										echo '<div class="picture';
											if ($i==0){echo ' show';}
										echo'" data-id="'.$i.'"><img src="'.$file_list_ps[$file_count].'"></div>';

									$i++;
									$file_count--;
									}
								}
						echo '</div>';//end div small
					echo '</div>';// end div pictures

			echo '<div class="description">';
		
				
				echo '<div class="title">';
					echo '<div class="name">'.$name.'</div>';
				echo '</div>';

				echo '<div class="card">';
					echo '<div class="prices">';
						if ($price2==''){
							echo '<div class="one">cena: '.$price.' eur</div>';	
						}else{
							echo '<div class="old">cena: '.$price.' eur</div>';
							echo '<div class="new">Cena ar atlaidi: '.$price2.' eur</div>';	
						}
						if ($offer_count=='1'){
							echo '<div class="status">Jusu piedavajums tiek apstradats</div>';	
						}
					echo '</div>';
					
					echo '<div class="card">';
						
						$place = array_search($id, $_SESSION['mag']['card']['id']);
						$count = $place>0 ? $_SESSION['mag']['card']['count'][$place] : 0;
						echo '<div class="count" data-id="'.$id.'" data-price="'.$price_real.'">';
							echo '<div class="product_count plus">+</div>';							
							echo '<div class="product_count"><div class="product_count_value" data-id="product_count_'.$id.'" id="product_count_'.$id.'" >'.$count.'</div></div>';
							echo '<div class="product_count minus">-</div>';
						echo '</div>';				

			
					echo '</div>';
					
										
					echo '<div class="add" onClick="shop_id_add_card()">';
						echo '<div class="icon"></div>';
					echo '</div></div>';	
					
				if ($_SESSION['id']>0){echo '<div class="left" onClick="shop_offer_show('.$id.')" ><div id="offer_button_'.$id.'" class="button" style="margin:0.5em 0">Piedavat cenu</div></div>';}
					echo '<div class="offer" id="offer_'.$id.'" style="display:none">';
						echo '<div id="offer_msg_'.$id.'"></div>';
						echo '<div><input id="offer_count_'.$id.'" placeholder="Vēlamais daudzums"></div>';
						echo '<div><input id="offer_price_'.$id.'" placeholder="Cena par 1 gab"></div>';
						echo '<div class="button" onclick="shop_offer('.$id.')" style="margin-top: 1em;" id="offer_button_'.$id.'">Piedavat cenu</div>';						
					echo '</div>';

				
				echo '<div class="info">Produkta apraksts: '.$info.'</div>';	
				echo '</div>';//end div description
				
			}}
	echo '</div>';//div class shop
	
} //end function shop_id()


function shop_constructor($_LANG, $uri, $params, $animal, $category, $page, $filter){
$filter_url='';
	echo '<div class="shop">';
		if (preg_match("/filter/", $params)){$filter_url='filter_url';}		
		
		echo '<div id="shop">';
	//	shop_map();
		shop_products($_LANG, $uri, $animal, $category, $page, $filter, $filter_url,'');
	//	shop_pages($_LANG, $uri, $animal, $category, $page, $filter,$filter_url);
		echo '</div>';
		
		echo '</div>';	
	echo '</div>';
	
} //end function shop_constructor



/*function shop_map(){
echo '<a href="">uri map<br><a href="">animal ></a href=""> <a href="">fish ></a><a href="">category</a>';
}//function shop_map()
*/

/*function query_animal($animal){
	if (!empty($animal) && $animal!='all'){
		$query_animal=" AND (`animal_checkbox` LIKE '%$animal%' OR `animal_checkbox` LIKE 'all')";
	}
return $query_animal;
}//function query_animal
*/
/*function query_category($category){
	if (!empty($category)){
		//perevesti $category v category_id;
		$query_category =	shop_category_to_id('category',$category);
		$query_category= " AND `category_id`='$query_category'";}
return $query_category;
}//function query_category
*/

/*function query_filter(){	
$filter_object = new filter; 	
$options = $filter_object->options;
$count = count($options)-1;

	include 'db.php';
	while ($count>=0){
		$table = $options[$count];

			$query="SELECT * FROM `$table`";
			if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
			while ($row = $result->fetch_object()){
				$id=$row->id;
				$option = $row->$table;					
					if ($_SESSION['vets']['filter'][$count]==$id && $_SESSION['vets']['filter'][$count]!=0){
						$table=$table.'_id';
						$query_filter=$query_filter." AND `$table`='$id'";
					}
			}}
		$count--;	
	}	
return $query_filter;			
}//function query_filter
*/
/*function query_orderby(){
	$filters = array('price_up','price_down','popular_up','popular_down','volume_up','volume_down');
	$count = count($filters);
		while ($count>=0){
			if ($_SESSION['vets']['filter']['orderby']==$count){
				list($sort, $by) = explode("_", $filters[$count]);
				break;
			}	
		$count--;				
		}
	
	if ($by=='up'){$by=' DESC';}else{$by=' ASC';}
	$query_orderby	= "ORDER BY `$sort` $by ";	
				//echo 'sort: '.$sort.' by: '.$by;
return $query_orderby;
}//function query_orderby
*/
/*function limit($page){
	if (empty($page)){$page=1;}
		if (!empty($page)){$offset=($page*15)-15;} 
		$limit = "LIMIT $offset,15";
	return $limit;	
}//end function limit
*/	
	
function shop_products($_LANG, $uri, $animal, $category, $page, $filter, $filter_url, $query){
//	$animal_url = $animal;
//	$query_animal = query_animal($animal);
//	$query_category = query_category($category);			
//	if (!empty($filter) || !empty($filter_url)){$query_filter = query_filter();}
//	if (!empty($filter) || !empty($filter_url)){$query_orderby = query_orderby();}else {$query_orderby = "ORDER BY `date_buy` ASC";}
//	$limit = limit($page);
		include 'db.php';
		if (empty($query)){$query="SELECT * FROM `shop` Order by `id` DESC";}
		$line = 0;
			if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
			while ($row = $result->fetch_object()){
				$id=$row->id;
				$name=$row->name;
				$price=$row->price;
				$info=$row->info;
				$regular=true;
				
					global $regular;
					global $price_real;
					global $percent;
				//	product_price($id);
					$offer = user_offer($id);
				
				if ($offer['price']!=''){
					$regular=false;	
					$price2 = $offer['price'];	
				}

				if ($line==0){echo '<div class="line">';}	
						
					echo '<div class="product" id="product_'.$id.'">';
				
								
					echo'<div class="value">';
							echo '<div class="left">';
								echo '<div class="triangle bottom"></div>';
							echo '</div>';							
						
							
						echo '<div class="percent">';
							if ($regular){
								echo '<div class="regular">Cena</div>';								
							}
							else if (empty($price2)){							
								echo '<div class="regular">Cena</div>';
							}
							else{
								echo '<div class="option">samazinata cena</div>';
							}
							
						echo '</div>';						
						echo '<div class="direction"><div class="r"></div></div>';
						echo '<div class="opposite"><div class="l"></div></div>';
							
						echo '<div class="price">';		
							if ($regular || empty($price2)){
								echo '<div class="regular">'.$price.'€</div>';								
							}else{
								
								if (!empty($price2)){	
									echo'<div class="old">'.$price.'€</div>'; 
									echo'<div class="new">'.$price2.'€</div>';}
								else {echo $price.'€';}
							}
						echo '</div>';
						
						echo '<div class="right">';
							echo '<div class="triangle bottom"></div>';
						echo'</div>';
					echo'</div>';
					
					echo '<a class="ajax" href="'._LINK_PATH.'shop/'.$id.'">';		
						echo'<div class="pictures_list" id="pictures_list_'.$id.'" data-id="'.$id.'">';
							$dir = 'img/shop/'.$id.'/';
							$file_list_pb = glob("$dir/?ps*.jpg");
			
							$file_count= (count($file_list_pb)>0)?(count($file_list_pb)-1):0;
							
							$i=0;	
								if ($file_count>=0){
									
									echo'<div class="shop_no_image">';
										if (!empty($file_list_pb[1])){
											echo '<div class="first"><img src="'.$file_list_pb[0].'"></div>';
											echo '<div class="second"><img src="'.$file_list_pb[1].'"></div>';
										}else{
											echo '<div class="second"><img src="'.$file_list_pb[0].'"></div>';											
										}
									echo '</div>';

								}
								else{
									echo'<div class="shop_no_image">';
										echo '<div class="first"><img src="img/shop/no_img_shop_list.jpg"></div>';
										echo '<div class="second"><img src="img/shop/no_img_shop_list2.jpg"></div>';
									echo '</div>';
								}
							
						echo'</div>';
					echo '</a>';
					
					echo'<div class="name">'.$name.'</div>
						<div class="feature">';
						
							echo $info;					 
						echo'</div>';
						
					if (array_search($id, $_SESSION['mag']['card']['id'])) {
						$show=' show';
						$card=true;
					}else{
						$card=false;
						$show='';
					}
							
							
	echo '<div class="card'.$show.'" id="card_'.$id.'">';	
		echo '<div class="block">';
			echo '<div class="top">Daudzums</div>';
			echo '<div class="bottom">';
								echo '<div class="count" data-id="'.$id.'">';
										$place = array_search($id, $_SESSION['mag']['card']['id']);
										if (empty($price2)){$price_one = $price;}else{$price_one = $price2;}
										$price_one = number_format($price_one, 2, '.', '');
										if ($card) {
											$value=$_SESSION['mag']['card']['count'][$place];
											$sum=$price_one*$value;
											}else{$sum=$price_one;$value=1;}
											$sum = number_format($sum, 2, '.', '');
										
									echo '<div class="product_count plus">+</div>';
									echo '<div class="product_count"><div class="product_count_value" id="product_count_'.$id.'" data-id="product_count_'.$id.'">'.$value.'</div></div>';
									echo '<div class="product_count minus">-</div>';
								echo '</div>';	
									echo'</div>';
								echo '</div>';
								echo '<div class="block">';
									echo '<div class="top"><div class="save" data-id="'.$id.'">Saglabat</div></div>';
									echo '<div class="bottom"><div class="delete" data-id="'.$id.'">Izdzest</div></div>';
								echo '</div>';
								echo '<div class="block">';
									echo '<div class="top">price</div>';
									echo '<div data-price="'.$price_one.'" id="price_'.$id.'"></div>';
									echo '<div class="bottom">'.$price_one.'</div>';
								echo '</div>';
								echo '<div class="block">';
									echo '<div class="top">Total</div>';
									echo '<div class="bottom"><div id="summ_'.$id.'">'.$sum.'</div></div>';
								echo '</div>';
							echo '</div>';
	
				
						echo '<div class="buttons">';
							
								if ($card) {
								echo '<div class="right one" data-id="'.$id.'" id="card_btn_add_'.$id.'">'.$_LANG['update'].'</div>';
								}else{
								echo '<div class="right" data-id="'.$id.'" id="card_btn_add_'.$id.'">'.$_LANG['add_to_card'].'</div>';
								}							
							if ($_SESSION['id']>0){echo '<div class="left" onClick="shop_offer_show('.$id.')" id="offer_button_'.$id.'">Piedavat cenu</div>';}

							echo '<a class="ajax" href="'._LINK_PATH.'card"><div class="card" id="card_btn_'.$id.'">'.$_LANG['go_to_card'].'</div></a>';
							
							
						echo '</div>';
						
						
						echo '<div class="offer" id="offer_'.$id.'">';
							echo '<div id="offer_msg_'.$id.'"></div>';
							echo '<input id="offer_count_'.$id.'" placeholder="Vēlamais daudzums">';
							echo '<input id="offer_price_'.$id.'" placeholder="Cena par 1 gab">';
							echo '<div class="button" onclick="shop_offer('.$id.')" style="margin-top: 1em;" id="offer_button_'.$id.'">Piedavat cenu</div>';						
						echo '</div>';
						
						
					echo'</div>';	
					
					

						
						
				if ($line==3){echo '</div>';}
				$line++;
				if ($line==4){$line=0;}
				}}
	//echo '</div>';//div id=shop

}//end function shop_product()



	$filter = stripslashes(htmlspecialchars($_POST['filter']));
	$params = $uri['params'];
	
		if (is_numeric($params)){shop_id($_LANG, $params);}
		else {shop_constructor($_LANG, $uri, $params, $animal, $category, $page, $filter);}




?>