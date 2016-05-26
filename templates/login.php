<? session_start(); 

echo 'Esli estj poljzovatelj, to zapuskaetsja admin'; 
echo '<br>v drugom sluchaet zapuskaetsja login form'; 
	if (empty($_SESSION['vets']['login']) || empty($_SESSION['vets']['user_id'])){include 'login_form.php';}
	else{
		include 'admin_login.php';
		
	}
	
	?>

<br><br>
<? echo 'username '.$_SESSION['vets']['login']; ?>
<? echo '<br>id '.$_SESSION['vets']['user_id']; ?>
