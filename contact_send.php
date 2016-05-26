<? session_start();
 require 'db.php';


/// proverka dannix 
		$name = mysql_escape_string(htmlspecialchars(strip_tags($_POST['name'])));
		$text = mysql_escape_string(htmlspecialchars(strip_tags($_POST['text'])));
		$email = mysql_escape_string(htmlspecialchars(strip_tags($_POST['email'])));
		$user_id = $_SESSION['vets']['user_id'];


/// zapisivaem v bazu
			$query="INSERT INTO `message`(`user_id`, `name`, `email`, `text`) VALUES ('$user_id','$name','$email','$text')";
			$mysqli->query($query);
			$mysqli->close();


?>