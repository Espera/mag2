<? session_start();

	$id = stripslashes(htmlspecialchars($_POST['id']));
	$option = stripslashes(htmlspecialchars($_POST['option']));	
	$orderby = stripslashes(htmlspecialchars($_POST['orderby']));
	$_SESSION['vets']['filter'][$option]=$id;
	$_SESSION['vets']['filter']['orderby']=$orderby;

?>