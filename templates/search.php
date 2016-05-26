<? session_start(); 
 
 include 'db.php';
	$search = $uri['list'][0]; 
	$search_original = $uri['list'][0];
	$search = explode(" ", $search);
	$search_count = count($search);

	for ($i=0;$i<=$search_count;$i++){
		if (empty($search[$i]) || $search[$i]==' '){unset($search[$i]);}	
	}
	$search = array_values($search);
	$search_count = count($search)-1;

//shop 
		$shop_array = array('id','barcode','name', 'consist' ,'use_ru', 'use_lv', 'use_en', 'dose_ru', 'dose_lv', 'dose_en' );
		$shop_count = count($shop_array)-1;	
		
		for ($i=0;$i<=$search_count;$i++){
			for ($j=0;$j<=$shop_count;$j++){$query_shop .= " `$shop_array[$j]` LIKE '%$search[$i]%' OR";}
		}

	$query_shop_count = "SELECT count(*) as `cnt` FROM `shop` WHERE".substr($query_shop,0,-3);
	$query_shop = "SELECT * FROM `shop` WHERE".substr($query_shop,0,-3).' LIMIT 0,20';
		
		
		if ($result = $mysqli->query($query_shop_count, MYSQLI_USE_RESULT) ) {
		while ($row = $result->fetch_object()){
			$match_shop_count = $row->cnt;
		}}
// shop end

// web

		$news_array = array('title', 'text');
		$news_count = count($news_array)-1;	
		
		for ($i=0;$i<=$search_count;$i++){
			for ($j=0;$j<=$news_count;$j++){$query_news .= " `$news_array[$j]` LIKE '%$search[$i]%' OR";}		
		}
 
	$query_news_count = "SELECT count(*) as `cnt` FROM `news` WHERE".substr($query_news,0,-3);
	$query_news = "SELECT * FROM `news` WHERE".substr($query_news,0,-3).' LIMIT 0,20';
		
		echo "<br><br><br>query_news: $query_news";
		
		if ($result = $mysqli->query($query_news_count, MYSQLI_USE_RESULT) ) {
		while ($row = $result->fetch_object()){
			$match_news_count = $row->cnt;
		}}

//poisk po news 
//poisk po web


// web end


echo '<br>';
print_r($search);

echo '<br>'.$count;

?>

<br> v nachale poisk polnogo sovpadenija, zatem chastichnogo
<br> V nachale AND LIKE '%abc%'
<br> zatem OR LIKE '%abc%'
<br /><br />Ubratj vse zapjatie, kovichki i drugie znaki -> v mesto nix probel
esli slovo menjshe 3 znakov, tozhe ubratj
ubratj dvojnie probeli






<? include 'content_left.php'; ?>
<div class="search">
	
     
    <div class="search_error">
	  <? echo $_LANG['enter_at_least_2_chars']; ?>
    </div>
    
	<div class="searhing">
		<div class="search_result"><? echo $_LANG['search_result']; ?>:</div>
    	<div class="search_for"><? echo $search_original; ?></div>
    </div>
	<div class="found">
    	<div class="title"><? echo $_LANG['have_found']; ?>:</div>
    	<div class="count">
			<? $match_summ = ($match_shop_count+$match_news_count>20)? '20+' : $match_shop_count+$match_news_count; ?>
        
        </div>
    	<div class="match"><? echo $_LANG['search_match']; ?></div>
        
    </div>	


    <div class="top">
    	<div class="button first active" data-action="products"><? echo $_LANG['search_in_shop']; echo "($match_shop_count)";?> </div>
        <div class="button second" data-action="web"><? echo $_LANG['search_in_web']; echo "($match_news_count)"?></div>
    </div>
	<div class="bottom">
    	<div class="result active" id="search_products">
        	<div class="title"><? echo $_LANG['search_in_shop']; ?></div>
        </div>
        
        <div class="result" id="search_web">
           	<div class="title"><? echo $_LANG['search_in_web']; ?></div>
		</div>
    </div>


</div>