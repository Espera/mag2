<? session_start();

$action = mysql_real_escape_string(htmlspecialchars (addslashes($action)));
if (empty($action)){$action = mysql_real_escape_string(htmlspecialchars (addslashes($_POST['action'])));}

	switch($action){
		case 'add':
			comment_add();
		break;
		case 'show':
			comment_show();
		
		break;
		case 'status':
			comment_status();
		break;
		default:
			comment_all($uri);		
		break;

	}//switch


function comment_all($uri){
	include 'db.php';
	include 'lang_'.$_SESSION['vets']['lang'].'.php';
	$id = $uri['list'][0];
	
			echo '<div class="comments">';
				echo '<div class="comment_title">'.$_LANG['news_comments'].':</div>';
					
					
			echo '<div class="comment_box">';
					echo '<div class="top">';
					echo '<div class="comment_status" id="comment_status"></div>';
					echo '<div class="first">';
						echo '<div class="name">'.$_LANG['name'].':</div>';
						echo '<div class="input"><input type="text" name="name" id="comment_name" placeholder="'.$_LANG['your_name'].'"></div>';
						echo '<div class="errors" id="error_name">';
							echo '<div >Vvedite imja</div>';
						echo '</div>';
						
					echo '</div>';
					echo '<div class="first">';
						echo '<div class="name">'.$_LANG['email'].':</div>';
						echo '<div class="input"><input type="text" name="email" id="comment_email" placeholder="'.$_LANG['your_email'].'"></div>';
						echo '<div class="errors" id="error_email">';
							echo '<div>Vvedite email</div>';
						echo '</div>';

					echo '</div>';
					echo '<div class="second">';
						echo '<div class="name">'.$_LANG['comment_text'].'</div>';
						echo '<div class="input"><textarea name="text" id="comment_text" placeholder="'.$_LANG['enter_comment_text'].'"></textarea></div>';
						echo '<div class="errors" id="error_text">';
							echo '<div >Vvedite tekst kommentarija</div>';
						echo '</div>';
					echo '</div>';
					echo '<div class="third">';
						echo '<div class="button" id="comment_add" onclick="comment_add()" data-content="'.$uri['module'].'" data-id="'.$uri['list'][0].'">'.$_LANG['send_comment'].'</div>';
					echo '</div>';
					echo '<div class="">';
						echo '<div class="">* '.$_LANG['Fields_required'].'</div>';
						echo '<div class="">* '.$_LANG['email_not_public'].'</div>';
						echo '<div style="display:none;" id="comment_content" data-content=""></div>';
					echo '</div>';
				echo '</div>';
							
				echo '<div class="bottom">';
						$content = $uri['module'];

						$query="SELECT count(*)as `cnt` FROM `comments` WHERE `content`='$content' AND`content_id`='$id' ORDER BY `date` DESC LIMIT 0,20";
						if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
						while ($row = $result->fetch_object()){
							$count=$row->cnt;
						}}
						
					echo '<div class="comments_all">'.$_LANG['comments_all'].' ('.$count.')</div>';					
					echo '<div id="comments_all">';

						if ($count>0){
							$query="SELECT * FROM `comments` WHERE `content`='$content' AND`content_id`='$id' ORDER BY `date` DESC LIMIT 0,20";
							if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
							while ($row = $result->fetch_object()){
								$id=$row->id;
								$name=$row->name;
								$text=$row->text;
								$date = date('D, d M Y h:i:s', strtotime ($row->date));
								comment_one($name, $text, $date, $id);
							}}
						}else {
							echo '<div class="comments_empty">';	
								echo $_LANG['comments_empty'];
							echo '</div>';
							
						}
					echo '</div>';
				echo '</div>';	

	
	
	
}//end comment_all

function comment_add(){
	$content=mysql_real_escape_string(htmlspecialchars (addslashes($_POST['content']), ENT_QUOTES));
	$content_id=mysql_real_escape_string(htmlspecialchars (addslashes($_POST['content_id']), ENT_QUOTES));
	$name=mysql_real_escape_string(htmlspecialchars (addslashes($_POST['name']), ENT_QUOTES));
	$email=mysql_real_escape_string(htmlspecialchars (addslashes($_POST['email']), ENT_QUOTES));
	$text=mysql_real_escape_string(htmlspecialchars (addslashes($_POST['text']), ENT_QUOTES));
	$errors=0;
	
		if (empty($content) || empty($name) || empty($email) || empty($text) || !ctype_digit($content_id)){$errors=1;}	
		if ($errors==0){
			$user_id=empty($_SESSION['vets']['user_id'])?'0':$_SESSION['vets']['user_id'];
			$news_id=$uri['list']['module'];
			
			include 'db.php';
			$query= "INSERT INTO `comments`(`user_id`, `content`,`content_id`, `name`, `email`, `text`) VALUES ('$user_id','$content','$content_id','$name','$email','$text')";
			$mysqli->query($query, MYSQLI_USE_RESULT);
				$query="SELECT `id` FROM `comments` WHERE `user_id`='$user_id' AND `content`='$content' AND `content_id`='$content_id' AND `name`='$name' AND `email`='$email' AND `text`='$text'";
				if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
				while ($row = $result->fetch_object()){
					$id=$row->id;
				}}
			echo $id;
		}	
}//end cimment_add

function comment_one($name, $text, $date, $id){
	 echo '<div class="block">';
		echo '<div class="head">';
			echo '<div class="name">';
				echo $name;
			echo '</div>';
			echo '<div class="date">';
				echo $date;
			echo '</div>';
		echo '</div>';
		
		echo '<div class="comment">'; 				
			echo $text;
		echo '</div>';
	echo '</div>';	
}//end comment_one

function comment_show(){	
$id = mysql_real_escape_string(htmlspecialchars (addslashes($_POST['id'])));
include 'db.php';
	$query="SELECT * FROM `comments` WHERE `id`='$id'";
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){
		$name=$row->name;
		$text=$row->text;
		$date=$row->date;
	}}
	comment_one($name, $text, $date, $id);	
}//end comment_show

function comment_status(){
	$id = mysql_real_escape_string(htmlspecialchars (addslashes($_POST['id'])));	
	include 'lang_'.$_SESSION['vets']['lang'].'.php';	
		if (empty($id)){echo '<div class="not_send"><div class="logo"></div>'.$_LANG['comment_not_added'].'</div>';}
		else{echo '<div class="send"><div class="logo"></div>'.$_LANG['comment_is_added'].'</div>';}
}//end comment_status





?>