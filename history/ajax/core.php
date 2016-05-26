<?php

	$out = array(
		"status" => 0,
		"page" => array(
			"title" => "Page not found!",
			"template" => "",
			"module" => "notfound",
		)
	);

	if ( isset( $_POST['action'] ) && !empty( $_POST['action'] ) && isset( $_POST['url'] ) && !empty( $_POST['url'] ) ) {

		$uri = parse_uri( $_POST['url'] );

		switch( $_POST['action'] ) {
			case "page":
				if ( isset( $modules[ $uri['module'] ] ) ) {

					$out['page']['title'] = $modules[ $uri['module'] ]['title'];
					$out['page']['module'] = $uri['module'];

					if ( !empty( $modules[ $uri['module'] ]['templates'] ) ) {

						ob_start();

						foreach( $modules[ $uri['module'] ]['templates'] as $file ) {
							include _TEPMLATE_PATH.$file;
						}

						$out['page']['template'] = ob_get_contents();
						ob_end_clean();
					}

					$out['status'] = 1;
				}
				break;
			default:
		}
	}

	exit( json_encode( $out ) );
?>