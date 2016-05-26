<? //skachatj v originaljnom razmere? ?>


<? /*<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
	<script src="js/slides.js"></script>
	
	<script>$(function(){$("#slides").slides({slide: {browserWindow: true}});});</script>
</head>
*/ 



// img/ $module / ($param - esli estj) / $db_pic

if (empty($param)){$param = $uri['list'][0];}
if (empty($module)){$module = $uri['module'];}
if (empty($lang)){$lang = $_SESSION['vets']['lang'];}
	
//echo "<br>uri: ".$uri['list'][0];
//echo "<br>param: $param";
//echo "<br>module: $module";
//echo "<br>";

//increase = uvelichivatj $i ili net (true, false
// folger = gde xranitja papka v baze dannix $row->$folger 

		if ($module=='shop'){
			if ($param>0){
				$increase = true;
				$query="SELECT `shop_pic`,`id` FROM `shop` WHERE `id`='$param'"; //ishem po id (vitaskivaem vse kartinki odnogo tovara
			}else {
				
				
				if ($param==''){
					$module='slider';
					$increase = false;
					$query="SELECT `slider_pic`,`action_id` FROM `slider` WHERE `lang`='$lang' ORDER BY `id` DESC LIMIT 5";
				}//ishem poslednie 5 akcij
				else{
					$module='slider';
					$increase = false;
					
					switch ($param) {
						case 'new':$action="1";break;
						case 'discount':$action="2";break;
						case 'special':$action="3";break;
						}// switch
				
					$query="SELECT `slider_pic`,`action_id` FROM `slider` WHERE `action_id`='$action' AND `lang`='$lang' ORDER BY `id` DESC LIMIT 5";
					
				}//inache ishem konkretnie akcii
			
			}
		}else{
			$module='news';
			$increase = true;
			$query="SELECT `news_pic`,`id` FROM `news` WHERE `id`='$param' AND `lang`='$lang'"; //ishem konkretnuju novostj			
		}

	
	$folger=$module.'_pic';	
	$i=1;

	include 'db.php';	
//	echo '<br>'.$query;
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		
	
	//	echo "<br>";
//		echo "<br>folger: $folger";
		
		if (!empty($row->$folger )){
			$url[$i]=$row->$folger;
			$action_id[$i]=$row->action_id;
				if ($action_id[$i]=='1'){$url[$i]='new/'.$url[$i];}
				else if ($action_id[$i]=='2'){$url[$i]='discount/'.$url[$i];}
				else if ($action_id[$i]=='3'){$url[$i]='special/'.$url[$i];}
		}
		$i++;
	}}
	
	
	
	
?>

<? //     Otpravitj drugu po e-mail? i - informacija kak poljzovatjsja; zagruzitj kartinku           ?>

<div class="slider">
	<div class="left">
    	<div class="trigger">
        	<div class="full"></div>
            <div class="download"></div>
            <div class="i"></div>
        </div>      
        <? 
			$show=' show';
			$i=1;
			$k=1;

			$pic_big = glob ('img/'.$module.'/'.$url[$k].'/?sb*.jpg'); //?sb*.jpg
			$count = count($pic_big)-1;
			
            for ($j=0; $j<=$count; $j++){
				echo '<div class="picture'.$show.'" id="slide_'.$j.'">';					
					echo '<img src="'.$pic_big[$j].'">';
				
					//echo '<img src="img/'.$module.'/'.$url[$k].'/'.$i.'.jpg" />';
				echo '</div>';
				if ($increase){$i++;}else{$k++;}
				$show='';
			}
		?>
    </div>
    
    

		<div class="modal" id="test-modal" style="display: none">
            <div class="close">&times;</div>    
			<div class="content">
                <div class="button left"></div><div class="button right"></div>                
				<? 
				$i=1;
				$k=1;
 				$pic_full = glob ('img/'.$module.'/'.$url[$k].'/?sf*.jpg');
                
				    for ($j=0; $j<=$count; $j++){
                        echo '<div class="picture" id="modal_'.$j.'">';
							echo '<img src="'.$pic_full[$j].'" />';
						echo'</div>';
						if ($increase){$i++;}else{$k++;}
                    }
                ?>
			</div>
        </div>
            


    <div class="right">
		<? 
			$show=' show';
			$i=1;
			$k=1;
			$pic_small = glob ('img/'.$module.'/'.$url[$k].'/?ss*.jpg');
            for ($j=0; $j<=$count; $j++){
                echo '<div id="button_'.$j.'" class="button'.$show.'" data-id="'.$j.'">';	
					echo '<img src="'.$pic_small[$j].'" />';
                echo '</div>';
			if ($increase){$i++;}else{$k++;}
			$show='';	
            } 
        ?>        
    </div>
</div>










<? /*
		<div class="modal" id="test-modal" style="display: none">
            <div class="close">&times;</div>    
			<div class="content">
                <div class="button left"></div><div class="button right"></div>                
				<? 
                    for ($i=1; $i<=5; $i++){
                        echo '<div class="picture" id="modal_'.$i.'"><img src="img/'.$i.'.jpg" /></div>';
                    }
                ?>
			</div>
        </div>
            
     Otpravitj drugu po e-mail?           
<div class="slider">
	<div class="left">
    	<div class="trigger"><div class="full"></div></div>
        
        <? 
			$show=' show';
            for ($i=1; $i<=5; $i++){
				echo '<div class="picture'.$show.'" id="slide_'.$i.'">';
					echo '<img src="img/'.$i.'.jpg" />';
				echo '</div>';
				$show='';
			}
		?>
    </div>

    <div class="right">
		<? 
			$show=' show';
            for ($i=1; $i<=5; $i++){
                echo '<div id="button_'.$i.'" class="button'.$show.'" data-id="'.$i.'">';	
                    echo '<img src="http://localhost/vets.lv/img/'.$i.'.jpg" />';
                echo '</div>';
			$show='';	
            } 
        ?>        
    </div>
</div>

*/ ?>

<script>slider_time();</script>

<? /*
	<div id="container">
		<div id="slides">
			<a class="ajax" href="<? echo _LINK_PATH."contacts"; ?>"><img src="img/1.jpg" width="560" height="240" alt="Slide 1"></a>
			
			<img src="img/2.jpg" width="560" height="240" alt="Slide 2">

			<img src="img/3.jpg" width="560" height="240" alt="Slide 3">

			<img src="img/4.jpg" width="560" height="240" alt="Slide 4">

		</div>
	</div>
*/ ?>