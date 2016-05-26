<? session_start();  
global $_LANG;
	if (function_exists ('card_view')){card_view($_LANG);
	}else{include 'card.php';}
?>