<?  session_start(); 

function date_to_month($month){
	include 'lang_'.$_SESSION['vets']['lang'].'.php';

	switch ($month) {
		case 1:
			$month=$_LANG['January'];	
			break;
		case 2:
			$month=$_LANG['February'];
			break;
			
		case 3:
			$month=$_LANG['March'];	
			break;
			
			case 4:
			$month=$_LANG['April'];
			break;
	
			case 5:
			$month=$_LANG['May'];	
			break;
	
			case 6:
			$month=$_LANG['June'];
			break;
	
			case 7:
			$month=$_LANG['July'];	
			break;
	
			case 8:
			$month=$_LANG['August'];
			break;
	
			case 9:
			$month=$_LANG['September'];	
			break;
	
			case 10:
			$month=$_LANG['October'];
			break;
	
			case 11:
			$month=$_LANG['November'];
			break;
	
			case 12:
			$month=$_LANG['December'];
			break;
	}
	if ($_SESSION['vets']['lang']=='ru'){$month=substr($month,0,6);}else {$month=substr($month,0,3);
}
	
	$GLOBALS['month']=$month;
	return;

}
	

	

	

	

		

?>