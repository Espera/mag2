<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=<?php echo _CONTENT_CHARSET;?>" />
		<title><?php echo isset( $modules[ $uri['module'] ] ) ? $modules[ $uri['module'] ]['title'] : 'Демонстрация библиотеки History API 3.2.3';?></title>
		<link href="<?php echo _LINK_PATH;?>css/main.css" rel="stylesheet" type="text/css" />
		<!--
			* GET парметры history.js

			* basepath
				необязательный параметр если у вас сайт
				находиться в корне DOCUMENT_ROOT.
				корневой путь сайта, в которой сайт
				должен работать по умолчанию корень "/"

			* redirect
				если параметр равен 1 или true, происходит
				автоматическая переадресация на правильный url,
				нужен для переадресации с сылки типа: http://sample.ru/#/path
				на ссылку http://sample.ru/path это если браузер поддерживает
				history.pushState в противном случае наоборот из
				http://sample.ru/path в http://sample.ru/#/path

			* type
				параметр указывает на то с чего будет начинатся якорь ссылки

			пример:
				<script type="text/javascript" src="history.js?basepath=/rootdir/&redirect=true&type=/"></script>
		-->
		<script type="text/javascript" src="<?php echo _LINK_PATH;?>js/history.js?redirect=true&basepath=<?php echo _LINK_PATH;?>"></script>

		<!-- простая библиотека для работы с DOM элементами -->
		<script type="text/javascript" src="<?php echo _LINK_PATH;?>js/dom.js"></script>

		<!--
			скрипт ядра, выполняет всю подготовку к новым данным,
			удаляя все события повешанные на старый модуль.
			подгружвет новые данные и вешает события для новых ссылок.
		-->
		<script type="text/javascript" src="<?php echo _LINK_PATH;?>js/main.php"></script>

		<!--
			подключаем скрипт модулей передавая имя модуля параметром GET,
			нужно что бы браузер прокешировал данные для каждого модуля.
			В случае если мы вернемся на предыдущий раздел, браузер возьмет скрипт из кеша.
		-->
		<script type="text/javascript" src="<?php echo _LINK_PATH;?>js/jscore.php?module=<?php echo $uri['module'];?>"></script>
	</head>
	<body>
		<!-- Тело сайта -->
		<div id="main">
			<div id="main_content">
<?php
	include _TEPMLATE_PATH.'menu_top.php';
?>
				<div id="dynamic_content">
<?php
	if ( isset( $modules[ $uri['module'] ] ) ) {
		foreach( $modules[ $uri['module'] ]['templates'] as $file ) {
			include _TEPMLATE_PATH.$file;
		}
	}
?>
				</div>
			</div>
		</div>
		<!-- Конец тела сайта -->

		<!-- Фоновая музыка что бы было видно что страница не обновляется -->
		<script type="text/javascript" src="<?php echo _LINK_PATH;?>js/audiojs/audio.min.js"></script>
		<script type="text/javascript">
<?php
	// сканируем папку с музыкой, что бы составить плейлист
	$music_files = array();
	$getcontent_dir_type = dir( _INC_PATH.'mp3' );
	while ( false !== ( $entry = $getcontent_dir_type->read() ) ) {
        if ( ( $entry !== '.' ) && ( $entry !== '..' ) ) {
			if ( filetype( _INC_PATH.'mp3'."/".$entry ) != 'dir' ) {
				$music_files[] = _LINK_PATH.'mp3/'.$entry;
			}
		}
	}
	$getcontent_dir_type->close();
?>
			// Плейлист файлов для восспроизведения
			var playlist = [<?php echo count( $music_files ) > 0 ? "\n\t\t\t\t'".implode( "',\n\t\t\t\t'", $music_files )."'\n\t\t\t" : "" ;?>],
			// номер текущего трека, выбираем рандомно
			currentTrack = Math.floor( Math.random() * playlist.length );

			audiojs.events.ready( function(){

				// назначаем первый трек
				document.getElementById('default_preload').src = playlist[ currentTrack ];

				// инициализируем плеер
				var player = audiojs.createAll({
					trackEnded: function(){
						currentTrack++;
						if ( currentTrack >= playlist.length ) {
							currentTrack = 0;
						}
						player[ 0 ].load( playlist[ currentTrack ] );
						player[ 0 ].play();
					}
				});
			});

		</script>
		<div class="player_box">
			<audio preload="auto" aautoplay="autoplay">
				<source id="default_preload" src="<?php echo _LINK_PATH;?>" type="audio/mpeg" />
			</audio>
		</div>
		<!-- ============================================================ -->
	</body>
</html>