<?php session_start(); $_SESSION['mag']['lang'] = empty($_SESSION['mag']['lang']) ? "lv" : $_SESSION['mag']['lang']; 
$_SESSION['mag']['card']['id'][0]=0;
$_SESSION['mag']['card']['count'][0]=0;
?>
<!DOCTYPE html>
<html>
	<head>
    	<meta property="fb:admins" content="162068413843305"/>
		<meta property="fb:app_id" content="326781480851964"/>
        
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	    <base href="<?php echo _LINK_PATH;?>" />
		<meta http-equiv="content-type" content="text/html; charset=<?php echo _CONTENT_CHARSET;?>" />
		<link href="<?php echo _LINK_PATH;?>css/main.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="<?php echo _LINK_PATH;?>js/jquery.min.1.8.3.js"></script>        
		<script type="text/javascript" src="<?php echo _LINK_PATH;?>js/history.js?redirect=true&basepath=<?php echo _LINK_PATH;?>"></script>
<? /*	<script type="text/javascript" src="<?php echo _LINK_PATH;?>js/dom.js"></script> */ ?>
		<script type="text/javascript" src="<?php echo _LINK_PATH;?>js/main.php"></script>
		<script type="text/javascript" src="<?php echo _LINK_PATH;?>js/jscore.php?module=<?php echo $uri['module'];?>"></script>
		<script type="text/javascript" src="<?php echo _LINK_PATH;?>js/vets.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
	</head>
<body>




<?   	

    	echo '<div class="main">';
			include 'header.php';  

			echo'<div id="main_content">';
				echo'<div id="dynamic_content">';   
					 	
					
					
					if (isset($modules[$uri['module']])){
						foreach($modules[$uri['module']]['templates'] as $file) {
							include _TEPMLATE_PATH.$file;
						}
					}else {include _TEPMLATE_PATH.'404.php';}

				echo'</div>';
			echo'</div>';
		echo'</div>';
	 	include 'footer.php';

?>
	</body>
</html>