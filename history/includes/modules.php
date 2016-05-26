<?php

	$modules = array(
		"home" => array(
			"title" => "Home",
			"templates" => array(
				"home.php",
			),
		),
		"demo" => array(
			"title" => "Demo",
			"templates" => array(
				"demo.php",
			),
		),
		"sources" => array(
			"title" => "Sources",
			"templates" => array(
				"sources.php",
			),
		),
		"about" => array(
			"title" => "About",
			"templates" => array(
				"about.php",
			),
		),
		"help" => array(
			"title" => "Help",
			"templates" => array(
				"help.php",
			),
		),
	);

	$modules[""] = $modules["home"];

?>