<? session_start();

if (empty($_SESSION['id']) || $_SESSION['id']==''){
	
echo 'Registreties	
	<div id="errors"></div>
	<div style="display:table">
		<div style="display:table-row"><div style="display:table-cell">Jusu vards</div><div style="display:table-cell"> <input type="text" placeholder="Vards" id="name"/></div></div>
		<div style="display:table-row"><div style="display:table-cell">Jusu uzvards</div><div style="display:table-cell"> <input type="text" placeholder="Uzvards" id="surname"/></div></div>
		<div style="display:table-row"><div style="display:table-cell">Kontakt telefons</div><div style="display:table-cell"> <input type="text" placeholder="Telefons" id="phone"/></div></div>
		<div style="display:table-row"><div style="display:table-cell">Epasts</div><div style="display:table-cell"> <input type="text" placeholder="Email" id="email"/></div></div>
	</div>
	
	<div class="button" onclick="user_register()">Registreties</div>';

echo 'Ienakt
	<div style="display:table">
		<div style="display:table-row"><div style="display:table-cell">Epasts</div><div style="display:table-cell"> <input type="text" placeholder="Email" id="email2"/></div></div>
	</div>
	
	<div class="button" onclick="user_login()">Ienakt</div>';



}else {
	echo 'session_id : '.$_SESSION['id'];	
	echo '<div class="leave" title="iziet no sistemas" onclick="user_leave()"></div>';
}


?>