<?php

	/*
	*  Загружаем базовый файл конфигураций
	*/
	include_once dirname( __FILE__ )."/bootstrap.php";

	/*
	*  Идет ли запрос посредством AJAX
	*/
	define( "_IS_AJAX", isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) );

	/*
	*  Данный скрипт требуется для безопасности, так как все запросы проходят через индексный файл
	*  если запрос просит файл с рассширением .php
	*  обрабатываем это правило
	*/

	/*
	*  Загружаем общие функции
	*/
	include_once _INC_PATH."includes/common.php";
	include_once _INC_PATH."includes/modules.php";

	if ( isset( $_GET['httpd_include_file'] ) ) {
		/*
		*  Разрешения на доступ к файлам
		*  ключ: содержит ссылку на файл требующий обращения, начиная от _DOCUMENT_ROOT
		*  значение: это цифра указывающая на метод доступа
		*
		*  0 - это значение разрешает обращатся к файлу только через AJAX
		*  1 - это значение разрешает обращатся любым доступным методом
		*/
		$allow_include = array(
			"/ajax/core.php" => 0,
			"/js/main.php" => 1,
			"/js/jscore.php" => 1,
		);

		foreach( $allow_include as $allow_file => $access_method ) {

			if (
				( _DOCUMENT_ROOT.$allow_file == $_GET['httpd_include_file'] ) &&
				( ( ( $access_method == 0 ) && ( _IS_AJAX ) ) ||
				( $access_method == 1 ) )
			) {
				$include_file = $_GET['httpd_include_file'];

				unset( $_GET['httpd_include_file'] );

				// Если разрешения позволяют, переходим на данный скрипт и выходим
				include_once $include_file;
				exit;
			}
		}
	}

	$uri = parse_uri( preg_replace( "#^"._LINK_PATH."#iu", "/", $_SERVER['REQUEST_URI'] ) );

	/*
	*  Загружаем страницу по умолчанию
	*/
	include_once _TEPMLATE_PATH."main.php";

?>