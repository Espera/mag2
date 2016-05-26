<? session_start();


// chto, iz kakoj sistemi, v kakuju sistemu
//		$test =  base_convert($test, 10, 35);
// razdelitj stroku po znakam
//				list($sort, $by) = explode("_", $filters[$count]);
// 	tochka i 00				
// $price = number_format($price, 2, '.', '');
	include_once dirname( __FILE__ )."/bootstrap.php";
	define( "_IS_AJAX", isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) );

	include_once _INC_PATH."includes/common.php";
	include_once _INC_PATH."includes/modules.php";

	if ( isset( $_GET['httpd_include_file'] ) ) {
		$allow_include = array(


			"/shop.xml" => 1,
			"/supplier.php" => 1,
			"/offer_admin.php" => 1,
			"/user_register.php" => 1,
			"/admin_pic.php" => 1,
			"/user_leave.php" => 1,
			"/user_login.php" => 1,


			"/ajax/core.php" => 0,
			"/js/main.php" => 1,
			"/js/jscore.php" => 1,
			"/js/vets.js" => 1,
			

			"/db.php" => 0,
			"/login.php" => 1,

			"/offer.php" => 1,
			"/lang.php" => 1,
			"/lang_ru.php" => 1,
			"/lang_en.php" => 1,
			"/lang_lv.php" => 1,
			"/contact_send.php" => 1,
			"/shop_session.php" => 1,
			"/shop_session_clear.php" => 1,
			"/shop.php" => 1,
			"/card.php" => 1,
			"/header_search.php" => 1,
			"/comments.php" => 1,
						
/*--------------------------ADMIN--------------------------------*/
			"/admin_query.php" => 1,
			"/admin_db.php" => 1,
			"/admin_email.php" => 1,
						
		);

		foreach( $allow_include as $allow_file => $access_method ) {

			if (
				( _DOCUMENT_ROOT.$allow_file == $_GET['httpd_include_file'] ) &&
				( ( ( $access_method == 0 ) && ( _IS_AJAX ) ) ||
				( $access_method == 1 ) )
			) {
				$include_file = $_GET['httpd_include_file'];

				unset( $_GET['httpd_include_file'] );

				include_once $include_file;
				exit;
			}
		}
	}

	$uri = parse_uri( preg_replace( "#^"._LINK_PATH."#iu", "/", $_SERVER['REQUEST_URI'] ) );

	include_once _TEPMLATE_PATH."main.php";

?>