<?
function uri_animal_category($uri,$animal, $category){

global $animal;
global $category;
	
$i='0';
include 'db.php';
	$where=$uri['list'][$i];	
	$query="SELECT count(*) as `cnt` FROM `animal_checkbox` WHERE `animal_checkbox`='$where'";
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
			if ($row->cnt==1){
				$animal=$uri['list'][$i];
			$i++;	
			}
	}}


	$where=$uri['list'][$i];	
	$query="SELECT count(*) as `cnt` FROM `category` WHERE `category`='$where'";
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		if ($row->cnt==1){
			$category=$uri['list'][$i];
		$i++;	
		}
	}}	
} //end function uri_shop()

function uri_page($uri, $page){
global $page;
		for ($i=0;$i<=10;$i++){
			if (preg_match("/page/", $uri['list'][$i])) {
				$page = preg_replace("/[^0-9]/", '', $uri['list'][$i]);
				$i=10;
			}
		}
}
function uri_id($uri,$id){
global $id;
		for ($i=0;$i<=10;$i++){
			if (is_numeric($uri['list'][$i])) {
			$id=$uri['list'][$i]; $i=10;}
		}	
	
}
?>