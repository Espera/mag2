<? session_start();


$action = stripslashes(htmlspecialchars($_POST['action']));

	switch ($action){
		case "open":	
			email_open();
		break;
		case "send":
			email_send();
		break;
		case "read":
			email_read();
		break;
		case "delete":
			email_delete();
		break;
		case "delete_query":
			email_delete_query();
		break;		
		default:
			die;
		break;
	}

function email_read(){
	$id = stripslashes(htmlspecialchars($_POST['id']));
		include 'db.php';
		$query="UPDATE `message` SET `read`=NOW() WHERE `id`='$id'";
		$result = $mysqli->query($query);
}//end email_read

function email_delete(){
	$id = stripslashes(htmlspecialchars($_POST['id']));
	echo '<div class="">';	
		echo '<div class="sure">Vi uvereni chto xotite udalitj pisjmo s id="'.$id.'"?</div>';
		echo '<div>Esli da, to nazhmite na udalitj</div>';
		echo '<div class="delete" onClick="email_delete_query('.$id.')">udalitj</div>';
	echo '</div>';
}//end email_delete

function email_delete_query(){
	$id = stripslashes(htmlspecialchars($_POST['id']));
		include 'db.php';
		$query="DELETE FROM `message` WHERE `id`='$id'";
		$result = $mysqli->query($query);
	echo 'pismo udaleno';
}//end email_delete_query

function email_send(){
	$id = stripslashes(htmlspecialchars($_POST['id']));
	$lang = stripslashes(htmlspecialchars($_POST['lang']));
	$text = stripslashes(htmlspecialchars($_POST['text']));
	$subject =stripslashes(htmlspecialchars($_POST['subject']));
		include 'db.php';
		$query="INSERT INTO `message_send`(`id`, `subject`, `text`, `lang`) VALUES ('$id','$subject','$text','$lang')";
		$result = $mysqli->query($query);
			$query="UPDATE `message` SET `answer`=NOW() WHERE `id`='$id'";
			$result = $mysqli->query($query);
}//end email_send

function email_open(){
	$id = stripslashes(htmlspecialchars($_POST['id']));
	$lang = stripslashes(htmlspecialchars($_POST['lang']));
	
	include 'db.php';
	$query="SELECT * FROM `message` WHERE `id`='$id'";
	if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
	while ($row = $result->fetch_object()){	
		$name=$row->name;
		$email=$row->email;
		$text=$row->text;
		$date=$row->date;
	}}
	
	echo '<div class="up">';
		echo '<div class="btn" onClick="email_send()">send</div>';
		echo '<div class="to">To: <input type="text" value="'.$email.'"></div>';
		echo '<div class="subject">Subject: <input type="text" value="Vets.lv" id="email_subject"></div>';
		echo '<div class="lang">Lang: <input type="text" value="'.$lang.'" id="email_lang"></div>';
		echo '<div class="id"><input type="text" value="'.$id.'" id="email_id"></div>';

	echo '</div>';


	echo '<div class="down">';
		echo '<div class="hello">privetstvie</div>';
		echo '<div class="text">';
			echo '<textarea id="email_text" placeholder="otvet na pisjmo"></textarea>';
		echo '</div>';

		echo '<div class="original">';
			echo '<div><input type="text" value ="'.$date.'"></div>';
			echo '<div><textarea id="email_original_text">'.$email.'</textarea></div>';
		echo '</div>';


		echo '<div class="thanks">spasibo</div>';

	echo '</div>';
}//end email_open





?>