<?php

	define( "_SPECIAL_PATH", "" );

	/*
	*  Базовая директория сайта, вместо $_SERVER['DOCUMENT_ROOT']
	*/
	define( "_DOCUMENT_ROOT", str_replace( "\\", "/", dirname( __FILE__ ) ) );

	/*
	*  Если запускать скрипт через командную строку, дефолтный DOCUMENT_ROOT пуст, нам это не нужно.
	*/
	$_SERVER['DOCUMENT_ROOT'] = empty( $_SERVER['DOCUMENT_ROOT'] ) ? _DOCUMENT_ROOT : $_SERVER['DOCUMENT_ROOT'];

	/*
	*  Путь для подключаемых файлов
	*/
	define( "_INC_PATH", _DOCUMENT_ROOT."/" );

	/*
	*  Путь для ссылок
	*/
	define( "_LINK_PATH", preg_replace( '*^'.$_SERVER[ 'DOCUMENT_ROOT' ].'*', '', _INC_PATH, 1 ) );

	/*
	*  Кодировка символов по умолчанию
	*/
	define( "_CONTENT_CHARSET", "utf-8" );

	/*
	*  Информируем браузер с какой кодировкой работать
	*/
	header( "Content-type: text/html; charset="._CONTENT_CHARSET );

	/*
	*  Ставим кодировку по умолчанию для рассширения mb_string
	*/
	mb_internal_encoding( _CONTENT_CHARSET );

	/*
	* Путь к шаблонам
	*/
	define( "_TEPMLATE_PATH", _DOCUMENT_ROOT."/templates/" );

?>