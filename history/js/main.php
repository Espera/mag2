<?php
	header( "Content-Type: application/javascript" );
?>
$(function(){

	// сохраняем ссылу на обработчик запросов, что бы можно было остановить запрос в случае необходимости
	var xhr;

	function loadContent( url, push ) {

		// прерываем предыдущую операцыю запроса
		if ( xhr ) xhr.abort();

		var
			fragmentsUrl = url.split("?"),
			reqUrl = fragmentsUrl.shift();

		// запрашиваем новые данные
		xhr = $.ajax({
			url: "<?php echo _LINK_PATH;?>ajax/core.php" + ( fragmentsUrl.length ? "?" + fragmentsUrl.join("?") : ""),
			data: { action: "page", "url": reqUrl },
			type: "post",
			dataType: "json",
			success: function( data, textStatus, xhr ) {
				if ( data.status == 1 ) {

					// снять все обработчики с элементов которые будут уничтожены
					$("#dynamic_content").find("*").unbind();

					// заменяем контент и ставим обработчик на все ссылки
					$("#dynamic_content").html( data.page.template ).find("a.ajax").bind( "click", actionAnchors );

					$("#dynamic_content a.external").click( externalAnchors );

					// перебираем все теги с именем script
					$("script").each(function(){

						// ищем модульный скрипт
						if ( /(.*)<?php echo str_replace( '/', '\\/', _LINK_PATH );?>js\/jscore.php\?module(.*)$/i.test( this.src ) ) {
							var parent = this.parentNode;

							// удаляем найденый скрипт тем самым высвобождая память
							parent.removeChild( this );
							// создаем новый скрипт
							var script = document.createElement('script');
							script.type = "text/javascript";
							script.async = "async";
							script.src = "<?php echo _LINK_PATH;?>js/jscore.php?module=" + data.page.module;

							// загружаем его для исполнения
							parent.appendChild( script );

							return false;
						}

					});

					if ( data.page.title ) {
						document.title = data.page.title;
					}

					if ( push ) {
						// заменяем ссылку в браузере
						history.pushState( null, null, url );
					}
				}
			},
			complete: function( xhr, textStatus ) {
				//alert( xhr.responseText );
			},
			error: function( xhr, textStatus ) {
			}
		});
	}

	function externalAnchors( e ) {
		// если ссылка имеет класс external значит нужно открыть ее в другой вкладке браузера
		window.open( this.href );
		return false;
	}

	function actionAnchors( e ) {
		// подгружаем нужный контент
		this.href && loadContent( this.href, true );
		return false;
	}

	$( window ).bind( 'popstate', function( e ){

		/*
		* заметьте, это единственная разница при работе с данной библиотекой,
		* так как объект document.location нельзя перезагрузить, поэтому
		* библиотека history возвращает сформированный "location" объект внутри
		* объекта window.history, поэтому получаем его из "history.location".
		* Для браузеров поддерживающих "history.pushState" получаем
		* сформированный объект "location" с обычного "document.location".
		*/
		var loc = history.location || document.location;

		// подгружаем нужный контент
		loadContent( loc.href );
	});

	$("#main_content a.ajax").click( actionAnchors );

	$("a.external").click( externalAnchors );

	if ( $.browser.msie && $.browser.version < 10 ) {
		$(".top_panel ul a").append('<div class="first"><div><div><div><div><div><div><div><div><div><div><div></div></div></div></div></div></div></div></div></div></div></div></div>');
	}
});
