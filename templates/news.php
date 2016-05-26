<? session_start(); 
include 'content_left.php';?>

<div class="news">
    <div id="fb-root"></div>


<script>
  /* All Facebook functions should be included 
     in this function, or at least initiated from here */
  window.fbAsyncInit = function() {
    FB.init({appId: '326781480851964', 
             status: true, 
             cookie: true,
         xfbml: true});

    FB.api('/me', function(response) {
      console.log(response.name);
    });
  };
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/en_US/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());
</script>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&appId=326781480851964&version=v2.0";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    

<?

$param = $uri['list'][0]; //parametr
$lang = $_SESSION['vets']['lang']; //jazik novostej
$news_count=10; //kolichestvo novostej na stranice
$pos=''; //pozicija znachenija PAGE (esli 0, to page, inache param=id novosti)
$exist=0; // sushestvuet li zapros

function slider($uri){

include 'slider.php';	
	
}

if(empty($param)){
		news_all($lang,'1', $news_count);
		}
	else{
//razbivaem parametr na sostavljajushie	
	$pos = strripos($param, 'page');
	
	if ($pos===0){			
		$page = preg_replace("/[^0-9]/", '', $param);
		news_check('page',$lang,$page,$news_count, $exist);	
			if ($exist==1){news_all($lang,$page, $news_count);}
			else {news_not('page');}

	}else{
		$id = preg_replace("/[^0-9]/", '', $param);
		news_check('id',$lang,$id,$news_count, $exist);			
			if ($exist==1){news_one($lang,$id,$uri);}
			else {news_not('id');}		
		}
}

function news_check($check,$lang,$value, $news_count,$exist){
global $exist;
	switch ($check) {
		case 'page':
			$value=$value*$news_count-$news_count;	
			$query_news="SELECT `id` FROM `news` WHERE `lang`='$lang' ORDER BY `date` DESC LIMIT $value, $news_count";
		break;
		case 'id':
			$query_news="SELECT `id` FROM `news` WHERE `id`='$value'";
		break;
	}//swith

	include 'db.php';
	if ($result = $mysqli->query($query_news, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		if (!empty($row->id)){$exist=1;}
	}}
}//end function news_check

function news_not($content){
	switch ($content) {
		case 'page':
			echo 'net takoj stranici';
		break;
		case 'id':
			echo 'net takogo id';
		break;
	}//swith
}//end function news_not

function news_all($lang, $page, $news_count){
global $_LANG;	
$value=$page*$news_count-$news_count;	
$i=0;	
	echo '<h3>'.$_LANG['news_page'].'</h3>';
	include 'db.php';
	$query_news="SELECT * FROM `news` WHERE `lang`='$lang' ORDER BY `date` DESC LIMIT $value, $news_count";
		if ($result = $mysqli->query($query_news, MYSQLI_USE_RESULT) ) {
		while ($row = $result->fetch_object()){
			
			$id=$row->id;
			$user_id=$row->user_id;
			$title=$row->title;
			$title = htmlspecialchars_decode($row->title);			
			$date=$row->date;
			$dir =$row->news_pic;
			
			if ($i==0){$class='first';$pr='pb';}else{$class='second';$pr='ps';}
	
			echo '<div class="news '.$class.'">';
				echo '<a class="ajax" href="'._LINK_PATH.'news/'.$id.'"><div class="picture '.$class.'">';
				
					if (!empty($dir)){
						$preview = glob("img/news/$dir/?$pr*.jpg");
					}else{$preview='';}
					
					if (file_exists($preview[0])) {
						echo '<img src="'.$preview[0].'">';
					}else{echo '<img src="'._LINK_PATH.'img/news/no_pic.jpg" width="100%" height="161px">';}
				echo '</div></a>';

				echo '<a class="ajax" href="'._LINK_PATH.'news/'.$id.'"><div class="title '.$class.'">'.$title.'</div></a>';
	//			echo '<div>skachatj kartinku, otpravitj drugu, kolichestvo prosmotrov, kolichestvo laikov </div>';
				echo '<a class="ajax" href="'._LINK_PATH.'news/'.$id.'"><div class="text '.$class.'">';
					echo $_LANG['Read_more'];
				echo '</div></a>';
			echo '</div>';
			
			$i++;
		}}
		
	news_page($lang, $page);	
}//end function news_all

function news_one($lang,$id,$uri){
global $_LANG;	

		echo '<div class="news_one">';	
			echo '<div class="left">';
				echo '<div class="news_block">';
					echo '<a class="ajax" href="'._LINK_PATH.'news">'.$_LANG['Back_to_news'].'</a>'; 	
					slider($uri);			
	
					include 'db.php';
					$query_news="SELECT `id`, `user_id`, `title`, `text`, `date` FROM `news` WHERE `id`='$id'";
						if ($result = $mysqli->query($query_news, MYSQLI_USE_RESULT) ) {
						while ($row = $result->fetch_object()){
							
							$id=$row-> id;
							$user_id=$row->user_id;
							$title=htmlspecialchars_decode($row->title); 
							$text=htmlspecialchars_decode($row->text);
							$date=$row->date;
							$pic=$row->news_pic;
								echo '<div class="title">'.$title.'(<fb:comments-count href=http://vets.lv/news/'.$id.'></fb:comments-count>)</div>';
								if (!empty($text)){echo '<div class="text">'.$text.'</div>';}
						}}
						
						
						echo '<div class="share">';
							echo '<div class="share_title">'.$_LANG['share_news_social'].': </div>';
							echo '<a class="social_btn" id="fb_btn" data-id='.$id.' data-title='.$title.'><div class="fb_btn"></div></a> ';
							echo '<a class="social_btn" id="tw_btn" data-id='.$id.' data-title='.$title.'><div class="tw_btn"></div></a>';
							echo '<a class="social_btn" id="vk_btn" data-id='.$id.'><div class="vk_btn"></div></a>';
							echo '<a class="social_btn" id="pi_btn" data-id='.$id.'><div class="pi_btn"></div></a>';
							//http://www.pinterest.com/pin/create/button/?url=facebook.com/dsgsdgsdg
							//https://plus.google.com/share?url=
							echo '<a class="social_btn" id="gl_btn" data-id='.$id.'><div class="gl_btn"></div></a>';
							echo '<a class="social_btn" target="_blank" href="mailto:?subject=Link&body=Your%20friend%20has%20sent%20You%20this%20funny%20page%20http://vets.lv/news/'.$id.'"><div class="em_btn"></div></a>';			
						echo '</div>';
						
	
						include 'comments.php';
	
						
					
					echo '</div>';
				echo '</div>';
			echo'</div>';		
		echo '</div>';
		echo '<div class="right">';
			echo '<div class="news_title">'.$_LANG['similar_news'].': </div>';
			news_one_slider($lang,$id);
		echo '</div>';
	echo '</div>';
}//end function news_one

function news_one_slider($lang,$news_id){
	include 'db.php';
	$query="(SELECT * FROM `news` WHERE `lang`='$lang' AND `id`>'$news_id' ORDER BY `id` ASC LIMIT 5 ) UNION ALL (SELECT * FROM `news` WHERE `lang`='$lang' AND `id`<='$news_id' ORDER BY `id` DESC LIMIT 5 )";
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		$id=$row->id;
		$news[$id]['text']=htmlspecialchars_decode($row->text);
		$news[$id]['title']=htmlspecialchars_decode($row->title);
		$news[$id]['news_pic']=$row->news_pic;
		$news[$id]['id']=$id;
		
		

	}}
	
	
	$news = array_orderby($news, 'id', SORT_DESC);	
		
		foreach ($news as $arr) {
			if ($arr['id']==$news_id){$selected=' selected';}else{$selected='';}
			
			$dir = $arr['news_pic'];

					if (!empty($dir)){
						$preview = glob("img/news/$dir/?ss*.jpg");
					}else{$preview='';}
					if (file_exists($preview[0])) {
						$img ="$preview[0]"; 
					}else{
						$img ="img/news/$dir/no_pic.jpg";
					}


			echo '<a class="ajax" href="'._LINK_PATH.'news/'.$arr['id'].'">';			
				echo '<div class="line'.$selected.'">';
					echo '<div class="img"><img class="img" src="'.$img.'" ></div>';
					echo '<div class="title">'.$arr['title'].'</div>';
				echo '</div>';	
			echo '</a>';
		}
}//end function news_one_slider()


	function array_orderby(){
    $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row)
                $tmp[$key] = $row[$field];
            $args[$n] = $tmp;
            }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
}//end function array_orderby()


function news_page($lang, $page){
// funkcija dlja stranic s
	
	
}//end function news_page

?>

</div>

<script>
window.fbAsyncInit = function() { 
FB.init({ appId : '326781480851964', status : true, cookie : true, xfbml : true, oauth: true }); };
</script>