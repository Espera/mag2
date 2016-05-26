<?php  

echo 'nachalo';

function jsOnResponse($obj){echo '<script type="text/javascript">window.parent.onResponse("'.$obj.'");</script>';}  

$max_pic = 4; //maksimaljnoe kolichestvo fotok - 1
	$id = $_POST['id']; //id kartinki (polnij adres category_rownumber_i)
	$url=$_POST['url']; //adress kartinki gde naxoditsja 
	$old_dir = $_POST['dir']; //papka, v kotoroj naxodjatsja fotki
	$object_id = $_POST['object_id']; //id objekta s kotorim rabotaem, shop id = 123
	$delete = $_POST['delete'];


echo "<br>id: $id";
echo "<br>url: $url";
echo "<br>old_dir: $old_dir";
echo "<br>object_id: $object_id";
echo "<br>delete: $delete";

	if ($delete){delete_picture($category,$object_id, $id);}
	else{upload_picture($id, $url, $old_dir, $object_id);}




function sizes(){
	$sizes = array(
		"news" => array(
			 "0" => array(
			 	"name" => "o",
//				"resize" => "resizeByWidth",
//				"value" => 240,
			 ),         
			 "1" => array(
			 	"name" => "sf",
				"resize" => "resizeByWidth",
				"value" => 900,
			 ),
			 "2" => array(
				 "name" => "sb",
				 "resize" => array(
					 "0" => "resizeByWidth",
					 "1" => "thumbnail"),
				 
				 "value" => array(
					 "0" => 445,
					 "1" => '445,265'),	
			 ),
			 "3" => array(
				"name" => "ss",
				"resize" => array( 
					"0" => "resizeByWidth",
					"1" => "thumbnail"),				
				 "value" => array( 
					"0" => 150,
					"1" => '150, 85'),	
			 ),    
			 "4" => array(
				 "name" => "pb",
				 "resize" => array( 
				 	"0" => "resizeByWidth",
					"1" => "thumbnail"),
					
				 "value" => array(
				 	"0" => 600,		 
				 	"1" => '600, 150'),		 
			 ), 
			 "5" => array(
				"name" => "ps",
				"resize" => array(
					"0" => "resizeByWidth",
					"1" => "thumbnail"),
				"value" => array( 
					"0" => 180,
					"1" => '180,140'	),
			 ), 		 
		),
			
		"shop" => "bar",
		"user" => "bar",
	);
return $sizes;
}// end function sizes
	

function delete_picture($category,$object_id, $id){
	include 'db.php';
	
		$dir =  base_convert($object_id, 10, 35);
		list($pic, $category, $row_number, $pic_number) = explode("_", $id);

		$url = 'img/'.$category.'/'.$dir;
		$url_delete = 'img/'.$category.'/'.$dir.'/'.$pic_number.'*.jpg';
		$url_other = 'img/'.$category.'/'.$dir.'/*.jpg';
		

			$pic_list_delete = glob($url_delete);
			$pic_count_delete= (count($pic_list_delete)>0)?(count($pic_list_delete)-1):0;			
			if ($pic_count_delete>0){
				while ($pic_count_delete>=0){
				unlink($pic_list_delete[$pic_count_delete]);
				$pic_count_delete--;
				}
			}
		
			$pic_list = glob($url_other);
			$pic_count= (count($pic_list)>0)?(count($pic_list)):0;
					
				if($pic_count==0 || empty($pic_count)){
					$set = $category.'_pic';
					$query="UPDATE `$category` SET `$set`='' WHERE `id`='$object_id'";		
					$mysqli->query($query);			
				}
}//end function delete_picture

function upload_picture($id, $url, $old_dir, $object_id){
	include 'db.php';


	list($category, $row_number, $pic_number) = explode("_", $id);
	
		// esli eto vremennaja fotka, to zapisivaem v temp, inache v papku
		if ($row_number==0){$dir = 'img/temp/';}
		else if (empty($old_dir)){
			//sozdaem emu papku s nuzhnim id i zapisivaem etot id v bazu dannix
			
			
			echo '<br>empty old_dir';
			$dir =  base_convert($object_id, 10, 35);
			if (!is_dir("img/$category/$dir")){mkdir("img/$category/$dir", 0755);}
				
				$set = $category.'_pic';
				$query="UPDATE `$category` SET `$set`='$dir' WHERE `id`='$object_id'";
				echo "<br>$query";
				$mysqli->query($query);				
					$dir='img/'.$category.'/'.$dir.'/';
		}
		else {list($a, $b, $dir) = explode("/", $url);
			$dir='img/'.$category.'/'.$old_dir.'/';
		}
				
		echo "<br>!!!!!!DIR : $dir";	
					
			$pic_list = glob($dir.$pic_number."*.jpg");
			$pic_count= (count($pic_list)>0)?(count($pic_list)-1):0;
			if ($pic_count>0){
				while ($pic_count>=0){
				unlink($pic_list[$pic_count]);
				$pic_count--;
				}
			}
	
		$image = $_FILES['loadfile']['tmp_name'];
		
echo "<br>Image: $image";
		
		include'crop/AcImage.php';
			if(AcImage::isFileExists($image)){
			if(AcImage::isFileImage($image)){	
				$size = getimagesize($_FILES['loadfile']['tmp_name']);
				$sy = round($size[1]);
				$sx = round($size[0]);
				$mask = md5(microtime($_FILES['loadfile']['tmp_name'])).'.jpg';	
			
				if($category=='news'){
				
				
						$letters = 'o';
						$filename = $pic_number.$letters.$mask;
							$images = AcImage::createImage($image);	   
							$images
								->save($dir.$filename);	
								   
								   
						echo "<br>adress: $dir$filename";		   
						$letters = 'sf';
						$filename = $pic_number.$letters.$mask;
							$images = AcImage::createImage($image);	   
							$images
								->resizeByWidth(900)
								->save($dir.$filename);	
	
						$letters = 'sb';
						$filename = $pic_number.$letters.$mask;
							$images = AcImage::createImage($image);	   
							$images
								->resizeByWidth(668)
								->cropCenter('4pr','3pr')
								->save($dir.$filename);	
								
						$letters = 'ss';
						$filename = $pic_number.$letters.$mask;
							$images = AcImage::createImage($image);	   
							$images
								->resizeByWidth(225)
								->cropCenter('45pr', '17pr')
								->save($dir.$filename);	
	
						$letters = 'pb';
						$filename = $pic_number.$letters.$mask;
							$images = AcImage::createImage($image);	   
							$images
								->resizeByWidth(800)
								->cropCenter('2pr', '1pr')
								->save($dir.$filename);	
	
						$letters = 'ps';
						$filename = $pic_number.$letters.$mask;
						$preview = $dir.$pic_number.$letters.$mask;
							$images = AcImage::createImage($image);	   
							$images
								->resizeByWidth(180)
								->cropCenter('4pr', '3pr')
								->save($dir.$filename);	
				
				}

			
			

			 
		/*
				$image_small = $image;	
				$image_middle = $image;
				$image_big = $image;
				$image_news = $image;
				
					$letters = 'ps';//preview small 
					$filename = $pic_number.$letters.$mask;
					$preview = $dir.$filename;
					//echo '<br>filename: '.$dir.$filename;
						$image_small = AcImage::createImage($image);
						AcImage::setRewrite(true);
							$image_small
							   ->thumbnail (60, 70,3)
							   ->save($dir.$filename);
							
					$letters = 'pb';//preview big
					$filename = $pic_number.$letters.$mask;
					//echo '<br>filename: '.$dir.$filename;
						$image_middle = AcImage::createImage($image);	   
						$image_middle
							   ->thumbnail (120, 140,3)
							   ->save($dir.$filename);	
							
					$letters = 'og';//original
					$filename = $pic_number.$letters.$mask;
					//echo '<br>filename: '.$dir.$filename;
						$image_big = AcImage::createImage($image);	   
							$image_big							
							   ->save($dir.$filename);
							   
					$letters = 'pn';//preview big
					$filename = $pic_number.$letters.$mask;
					//echo '<br>filename: '.$dir.$filename;
						$image_news = AcImage::createImage($image);	   
						$image_news
							   ->cropCenter(600, 240)
							   ->save($dir.$filename);	
							   
				*/		   
							   							   
			}}
	
	// jsOnResponse("$file"); 
	 //esli estj url, to udaljaem fail i na ego mesto zapisivaem novij (udaljaem vse faili s etim nomerom)
	 //$success = move_uploaded_file($_FILES['loadfile']['tmp_name'], $file);  
	 // peredaem objekt s id i adresom i nomerom (chtobi ego najti i vstavitj kartinku);
	  jsOnResponse("{'url':'".$preview."','id':'" . $id . "','file count':'" . $file_count . "', 'success':'" . $success . "'}"); 
}
  
?> 