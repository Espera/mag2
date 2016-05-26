<?php

	$modules = array(

		"cabinet" => array("title" => "Profile page",
			"templates" => array("cabinet.php",),),
			
		"console" => array("title" => "Konsole",
			"templates" => array("console.php",),),
		"admin" => array("title" => "Konsole",
			"templates" => array("admin.php",),),
						
			

		"help" => array("title" => "Upload page",
			"templates" => array("help.php",),),
		"shop" => array("title" => "shop page",
			"templates" => array("shop.php",),),
		"card" => array("title" => "Shopping  card",
			"templates" => array("card.php",),),


	);

	$modules[""] = $modules["shop"];

?>