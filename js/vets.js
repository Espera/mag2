$( document ).on('click','.order .delivery .type', function(){ 
 id = $(this).data('id');
	 $('.type').removeClass('active');
	 $(this).addClass('active');
	 $('.adress').removeClass('show');
	 $('#adress_'+id).addClass('show');
});
 
$( document ).on('click','.form_picture .preview .preview_delete ', function(){
id = $(this).data('id');
category = $(this).data('category');
object_id = $(this).data('object_id');

$(this).removeClass('show');
$('#'+id).empty();
		$.ajax({
		type: "post", url: "admin_pic.php", data: {id:id, category:category, object_id:object_id,'delete':true},
		success: function(msg){
			$('#errors').empty().append(msg);
		}
		});


});

/*==================================ADMIN=UP===========================================================°
==================================================================================================*/



function user_leave(){
	$.ajax({
	type: "post", url: "user_leave.php", data: {},
	success: function(msg){
		$('#errors').empty().append(msg);
		alert('Veiksmigi izgajat no sistemas');
	}});	
}

function user_login(){
	email = $('#email2').val();
	$.ajax({
	type: "post", url: "user_login.php", data: {email:email},
	success: function(msg){
		$('#errors').empty().append(msg);
		alert(msg);
	}});	
}


function user_register(){
name = $('#name').val();
surname = $('#surname').val();
phone = $('#phone').val();
email = $('#email').val();

	$.ajax({
	type: "post", url: "user_register.php", data: {name:name, surname:surname, email:email,phone:phone},
	success: function(msg){
		$('#errors').empty().append(msg);
	}
	});	
}

function offer_suppliers(id){
$('#errors_'+id).empty().append('Piprasijums izsutits');
	$.ajax({type: "post", url: "offer.php", data: {id:id,status:'admin'},});
}

$( document ).on('click','.supplier .button ', function(){
alert('a');
id = $(this).data('id');
count = $(this).data('count');
user = $(this).data('user');
price = $('#offer_'+id).val();
offer_user = $(this).data('offeruser');
alert(offer_user);

	$.ajax({
	type: "post", url: "offer_admin.php", data: {id:id, count:count, user:user,price:price, offer_user:offer_user},
	success: function(msg){
		$('#errors').empty().append(msg);
	}
	});
});


var map;
var map2;
function initialize() {
var map_x = $('#map-canvas').data('x');
var map_y = $('#map-canvas').data('y');
var map_x2 = $('#map-canvas2').data('x');
var map_y2 = $('#map-canvas2').data('y');


  var city = new google.maps.LatLng(map_x,map_y);
  var city2 = new google.maps.LatLng(map_x2,map_y2);


  var mapOptions = {
    zoom: 13,
    center: city,
  };
  var mapOptions2 = {
    zoom: 11,
    center: city2,
  };
    
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  map2 = new google.maps.Map(document.getElementById('map-canvas2'), mapOptions2);
	  
  var marker = new google.maps.Marker({
    position: new google.maps.LatLng(map_x,map_y),
    map: map
  });  
  
  var marker2 = new google.maps.Marker({
    position: new google.maps.LatLng(map_x2,map_y2),
    map: map2
  });  
  
  markers.push(marker); 
  markers.push(marker2); 
   
}

function admin_price(id,count,supplier_count){

var best_supplier = Number(0);
var best_price = Number(0);

$('.supplier').removeClass('best');


for (var i = 1; i < supplier_count+1; i++) {
		price_sell = $('#offer_'+id).val();
		price_buy = Number($('#buy_'+i+'_'+id).text());
		price_profit = price_sell-price_buy;
		few_sell = (price_sell*count).toFixed(2);
		difference = Number(price_profit.toFixed(2));
		few_difference = (difference * count).toFixed(2);
		procent = ((price_profit/price_buy)*100).toFixed(2); 

		if (best_price<difference && difference>0){
			best_price = difference; 
			best_supplier = i;	
		}
		
		$('.sell_'+id).empty().text(price_sell);
		$('.few_sell_'+id).empty().text(few_sell);
		$('#few_difference_'+i+'_'+id).empty().text(few_difference);
		$('.difference_'+i+'_'+id).empty().text(difference);
		$('.procent_'+i+'_'+id).empty().text(procent+' %');
		
	}
$('#supplier_'+id+'_'+best_supplier).addClass('best');

}

function shop_offer_show(id){
$('#offer_button_'+id).addClass('active');

	$('#offer_'+id).hide().addClass('show').show(300);
}

function shop_offer(id){
	price = $('#offer_price_'+id).val();
	count = $('#offer_count_'+id).val();
	if (price>0 && count>0){
		$.ajax({type: "post", url: "offer.php", data: {id:id, price:price, count:count},
		success: function(msg){$('#offer_msg_'+id).empty().text(msg);}});
	}
}

$(document).on('click','.offer_table_header', function(){
id = $(this).data('id');
$('#table_'+id).toggleClass('hide');
});




$(document).on('click','.console .button', function(){
up = $(this).data('up');
$('.button').removeClass('active');
$(this).addClass('active');
$('.down').removeClass('show');
$('#'+up).addClass('show');
});



$(document).on('click','.shop .product .buttons .right', function(){
	id = $(this).data('id');
	if ($(this).hasClass('one')){
		$('#card_btn_'+id).addClass('show');		
		$(this).removeClass('one').addClass('two');
			count = parseInt($('#product_count_'+id).text());

			shop_card_add(id,count);
		}	
	else{
		$('#card_'+id).hide().addClass('show').show(300);
		$(this).addClass('one');
	
	}	
});


$(document).on('click','.card_window', function(){
			$('.header_basket .basket .arrow').removeClass('open');
			$('.header_basket .products').removeClass('open')
			$('.card_window').removeClass('show');
});
		
$(document).on('click','.header_basket .basket .arrow', function(){
	$('.header_basket .basket .arrow').toggleClass('open');
	$('.header_basket .products').toggleClass('open');
	$('.card_window').toggleClass('show');
});



$( document ).on('click','.search .top .button', function(){
var action = $(this).data('action');
	$('.search .top .button').removeClass('active');
	$(this).addClass('active');
	$('.search .result').removeClass('active');
	$('#search_'+action).addClass('active');
});



$( document ).on('click','.shop .product .card .delete', function(){
var id = $(this).data('id');
$('#product_count_'+id).empty().append('0');
$('#summ_'+id).empty().empty().append('0.00');
shop_card_add(id,0);
});

$( document ).on('click','.shop .product .card .save', function(){
var id = $(this).data('id'),
count = $('#product_count_'+id).text();
alert('start');
	$.ajax({type: "post", url: "card.php", data: {action:'check',id:id},
	success: function(check){
		check = parseInt(check);
		$('#header_card_count_'+check).empty().append(count);
	}
	});
shop_card_add(id,count);			
});




$( document ).on('click','.card .count .product_count', function(){
var pressed=false;
var id = $(this).parent('.count').data('id');
	if ($(this).hasClass('plus')){pressed=true;val = (parseInt($('#product_count_'+id).text())+1);}
	else if ($(this).hasClass('minus')){pressed=true;val = (parseInt($('#product_count_'+id).text())-1)<=0? 0:parseInt($('#product_count_'+id).text())-1;}
	if (pressed){		
		$('div[data-id="product_count_'+id+'"]').empty().append(val);
		price = $('#price_'+id).data('price');
		price = (price * val).toFixed(2);
		$('.summ_'+id).empty().hide().text(price).show(300);
		shop_card_add(id,val);
	}
});

function header_search(){

var search = $('#header_search').val();
		$.ajax({type: "post", url: "header_search.php", data: {search:search},
		success: function(msg){
			href = $('#header_search_href').data('href');
			href = href+msg;
			$('#header_search_href').attr('href', href);
		}
		});

}

function card_note(id){
$('#notes_'+id).show('fast');	
}

function header_shop_card_add(id){
	$.ajax({type: "post", url: "card.php", data: {action:'last',id:id},
	success: function(msg){
		$('#header_shop_card').append(msg);
	}
	});
			$.ajax({type: "post", url: "card.php", data: {action:'check',id:id},
			success: function(check){
				check = parseInt(check);
				alert(check);
				if (check>0){
					$('#header_card_count_'+check).empty().append(count);
				}else{
					
					shop_card_count('plus');
					header_shop_card_add(id);			
				}
			}
			});
}

function shop_card_add(id,count){
		$.ajax({
		type: "post", url: "card.php", data: {action:'add',id:id, count:count},
		success: function(msg){
			alert('Pievienots grozam');
			shop_card_total();
		}
		});
}

/*function shop_card_add_note(id){
note = $('#note_'+id).val();
		$.ajax({type: "post", url: "card.php", data: {action:'note',id:id,note:note},
		success: function(){
		}
		});	
}*/

function shop_card_count(action){
	count = parseInt($('#header_card_total_count').text());	
	if (action=='minus'){
		count = count-1;
		if (count<0){count=0;}
	}
	else if (action=='plus'){
		count = count+1;		
	}
	
	$('#header_card_total_count').empty().append(count);
	$('#card_total_count').empty().append(count);
}

function shop_card_total(){
		$.ajax({type: "post", url: "card.php", data: {action:'total'},
		success: function(msg){
			$('#summ_total').empty().text(msg);
			$('#header_summ_total').empty().text(msg);
			
		}
		});	
}

function shop_product_delete(id){
		//krasnaja knopka
		$('#card_'+id).removeClass('show');
		$('#card_btn_'+id).removeClass('show');		
		// ubratj stilj two		
		$('#card_btn_add_'+id).removeClass('one').removeClass('two');
		$(this).removeClass('one').addClass('two');
}

function shop_card_delete(id){
		$.ajax({
		type: "post", url: "card.php", data: {action:'delete',id:id},
		success: function(msg){
			$('#header_card_delete_'+id).hide('slow');
			$('#header_card_line_'+id).hide('slow');
			$('#card_product_'+id).hide('slow');

			shop_card_total();
			shop_card_count('minus');	
			shop_product_delete(id);		
		}
		});
}


/*
var msg;
if (window.jQuery) {
    msg = 'You are running jQuery version: ' + jQuery.fn.jquery;
} else {
    msg = 'jQuery is not installed';
}
alert(msg);
*/



/*------------------------MODAL-DOWN----------------------------*/

;(function($, window, document, undefined) {
	"use strict";
	/*jshint smarttabs:true*/

	// :focusable expression, needed for tabindexes in modal
	$.extend($.expr[':'],{
		focusable: function(element){
			var map, mapName, img,
				nodeName = element.nodeName.toLowerCase(),
				isTabIndexNotNaN = !isNaN($.attr(element,'tabindex'));
			if ('area' === nodeName) {
				map = element.parentNode;
				mapName = map.name;
				if (!element.href || !mapName || map.nodeName.toLowerCase() !== 'map') {
					return false;
				}
				img = $('img[usemap=#' + mapName + ']')[0];
				return !!img && visible(img);
			}

			var result = isTabIndexNotNaN;
			if (/input|select|textarea|button|object/.test(nodeName)) {
				result = !element.disabled;
			} else if ('a' === nodeName) {
				result = element.href || isTabIndexNotNaN;
			}

			return result && visible(element);

			function visible(element) {
				return $.expr.filters.visible(element) &&
					!$(element).parents().addBack().filter(function() {
						return $.css(this,'visibility') === 'hidden';
					}).length;
			}
		}
	});

	var pluginNamespace = 'the-modal',
		// global defaults
		defaults = {
			lockClass: 'themodal-lock',
			overlayClass: 'themodal-overlay',

			closeOnEsc: true,
			closeOnOverlayClick: true,

			onBeforeClose: null,
			onClose: null,
			onOpen: null,

			cloning: true
		};
	var oMargin = {};
	var ieBodyTopMargin = 0;

	function isIE() {
		return ((navigator.appName == 'Microsoft Internet Explorer') ||
			(navigator.userAgent.match(/MSIE\s+\d+\.\d+/)) ||
			(navigator.userAgent.match(/Trident\/\d+\.\d+/)));
	}

	function lockContainer(options, overlay) {
		var body = $('body');
		var oWidth = body.outerWidth(true);
		body.addClass(options.lockClass);
		var sbWidth = body.outerWidth(true) - oWidth;
		if (isIE()) {
			ieBodyTopMargin = body.css('margin-top');
			body.css('margin-top', 0);
		}

		if (sbWidth != 0) {
			var tags = $('html, body');
			tags.each(function () {
				var $this = $(this);
				oMargin[$this.prop('tagName').toLowerCase()] = parseInt($this.css('margin-right'));
			});
			$('html').css('margin-right', oMargin['html'] + sbWidth);
			overlay.css('left', 0 - sbWidth);
		}
	}

	function unlockContainer(options) {
		if (isIE()) {
			$('body').css('margin-top', ieBodyTopMargin);
		}

		var body = $('body');
		var oWidth = body.outerWidth(true);
		body.removeClass(options.lockClass);
		var sbWidth = body.outerWidth(true) - oWidth;

		if (sbWidth != 0) {
			$('html, body').each(function () {
				var $this = $(this);
				$this.css('margin-right', oMargin[$this.prop('tagName').toLowerCase()])
			});
		}
	}

	function init(els, options) {
		var modalOptions = options;

		if(els.length) {
			els.each(function(){
				$(this).data(pluginNamespace+'.options', modalOptions);
			});
		} else {
			$.extend(defaults, modalOptions);
		}

		// on Ctrl+A click fire `onSelectAll` event
		$(window).bind('keydown',function(e){
			if (!(e.ctrlKey && e.keyCode == 65)) {
				return true;
			}

			var selectAllEvent = new $.Event('onSelectAll');
			selectAllEvent.parentEvent = e;
			$(window).trigger(selectAllEvent);
			return true;
		});

		els.bind('keydown',function(e){
			var modalFocusableElements = $(':focusable',$(this));
			if(modalFocusableElements.filter(':last').is(':focus') && (e.which || e.keyCode) == 9){
				e.preventDefault();
				modalFocusableElements.filter(':first').focus();
			}
		});

		return {
			open: function(options) {
				var el = els.get(0),
					localOptions = $.extend({}, defaults, $(el).data(pluginNamespace+'.options'), options);

				// close modal if opened
				if($('.'+localOptions.overlayClass).length) {
					$.modal().close();
				}

				var overlay = $('<div/>').addClass(localOptions.overlayClass).prependTo('body');
				overlay.data(pluginNamespace+'.options', localOptions);

				lockContainer(localOptions, overlay);

				if(el) {
					var openedModalElement = null;
					if (!localOptions.cloning) {
						overlay.data(pluginNamespace+'.el', el);
						$(el).data(pluginNamespace+'.parent', $(el).parent());
						openedModalElement = $(el).appendTo(overlay).show();
					} else {
						openedModalElement = $(el).clone(true).appendTo(overlay).show();
					}
				}

				if(localOptions.closeOnEsc) {
					$(document).bind('keyup.'+pluginNamespace, function(e){
						if(e.keyCode === 27) {
							$.modal().close();
						}
						if(e.keyCode === 32 || e.keyCode === 39  || e.keyCode === 13) {
							modal_next();
						}
						if(e.keyCode === 37 ) {
							modal_previous();
						}
					});
					
				}

				if(localOptions.closeOnOverlayClick) {
					overlay.children().on('click.' + pluginNamespace, function(e){
						e.stopPropagation();
					});
					$('.' + localOptions.overlayClass).on('click.' + pluginNamespace, function(e){
						$.modal().close();
					});
				}

				$(document).bind('touchmove.'+pluginNamespace,function(e){
					if(!$(e).parents('.' + localOptions.overlayClass)) {
						e.preventDefault();
					}
				});

				if(el) {
					$(window).bind('onSelectAll',function(e){
						e.parentEvent.preventDefault();

						var range = null,
							selection = null,
							selectionElement = openedModalElement.get(0);
						if (document.body.createTextRange) { //ms
							range = document.body.createTextRange();
							range.moveToElementText(selectionElement);
							range.select();
						} else if (window.getSelection) { //all others
							selection = window.getSelection();
							range = document.createRange();
							range.selectNodeContents(selectionElement);
							selection.removeAllRanges();
							selection.addRange(range);
						}
					});
				}

				if(localOptions.onOpen) {
					localOptions.onOpen(overlay, localOptions);
				}
			},
			close: function(options) {
				var el = els.get(0),
				  localOptions = $.extend({}, defaults, $(el).data(pluginNamespace+'.options'), options);
				var overlay = $('.' + localOptions.overlayClass);

				if ($.isFunction(localOptions.onBeforeClose)) {
					if (localOptions.onBeforeClose(overlay, localOptions) === false) {
						return;
					}
				}

				if (!localOptions.cloning) {
					if (!el) {
						el = overlay.data(pluginNamespace+'.el');
					}
					$(el).hide().appendTo($(el).data(pluginNamespace+'.parent'));
				}

				overlay.remove();
				unlockContainer(localOptions);

				if(localOptions.closeOnEsc) {
					$(document).unbind('keyup.'+pluginNamespace);
				}

				$(window).unbind('onSelectAll');

				if(localOptions.onClose) {
					localOptions.onClose(overlay, localOptions);
				}
			}
		};
	}

	$.modal = function(options){
		return init($(), options);
	};

	$.fn.modal = function(options) {
		return init(this, options);
	};

})(jQuery, window, document);

		jQuery(function($){
			// bind event handlers to modal triggers
			$('body').on('click', '.trigger .full', function(e){
				e.preventDefault();
				$('#test-modal').modal().open();
			});

			// attach modal close handler
			$('.modal .close').on('click', function(e){
				e.preventDefault();
				$.modal().close();
			});

			$('.modal .content .button.left').on('click', function(e){
				modal_previous();
			});

			$('.modal .content .button.right').on('click', function(e){
				modal_next();
			});
				
				
		});


function modal_next(){
slide_max = $('#test-modal .picture img').length/2-1;
	if(modal_id>=slide_max){modal_id=0;}
	else{modal_id++;}
	modal_show(modal_id)	
}

function modal_previous(){
slide_max = $('#test-modal .picture img').length/2-1;
	if(modal_id==1){
	modal_id=slide_max;}
	else{modal_id--;}
modal_show(modal_id)
}

function modal_show(modal_id){
	$(".modal .picture").hide();	
	$("#modal_"+modal_id).show();	
}

/*------------------------MODAL-UP----------------------------*/	


 
$( document ).on('click','.shop .pictures .small .picture ', function(){
id = $(this).data('id');
	$('.picture').removeClass('show');
	$('#picture_big_'+id).addClass('show');
	$(this).addClass('show');
});

/*
$( document ).on('mouseenter','.shop .product .pictures_list', function(){
alert('start');
	id = $(this).data('id');

	Shop_Ready = true;
	count =  $('#pictures_list_'+id+' > div').length-1;
	Shop_picture_slider_id=0;
	if (count>0){
		
		//shop_picture_slider();		
	shop_slider_timer(id);
	}
});


$( document ).on('mouseleave','.shop .product .pictures_list', function(){
alert('leave');
Shop_Ready=false;
id = $(this).data('id');
	$('#shop_pic_'+id+'_'+Shop_picture_slider_id).removeClass('show');
	$('#shop_pic_'+id+'_0').addClass('show');
	
});
*/


/*------------------------------------------------UDALITJ SHOP PICTURE TIMER I SLIDER????????????????????????????????????????????
--------------------------------------------------------------------------------------------
---------------------------------------------------------------------
--------------------------------------------------------------------- */

var Shop_picture_timer;
var Shop_picture_slider_id;
var Shop_Ready;
var Shop_slider;

function shop_slider_timer(id){
	if (Shop_Ready){
	clearTimeout(Shop_slider);
	Shop_slider=setTimeout("shop_picture_slider_next(id);",7000);
	}
}

function shop_picture_slider_next(id){
//alert(Shop_picture_slider_id);
	count =  $('#pictures_list_'+id+' > div').length-1;	
//	alert('count: '+count);
	$('#shop_pic_'+id+'_'+Shop_picture_slider_id).removeClass('show');
	Shop_picture_slider_id++;

//alert(Shop_picture_slider_id);	
//	alert(count)
	if (Shop_picture_slider_id>count){Shop_picture_slider_id=0;}
	$('#shop_pic_'+id+'_'+Shop_picture_slider_id).addClass('show');
	shop_slider_timer(id);


}

/*----------------------------------------------------------------------------------------------*/





var slide_id=0,
modal_id=0,
slide_max,
Slider,
Ready = true;

function slider_off(){
	Ready = false;	
	clearTimeout(Slider);
}

function slider_time(){
	slide_max = $('#test-modal .picture img').length-1;

	if(Ready && slide_max>0){	
		Ready = false; 
		slider_timer();
	} 
}

function slider_timer(){
	slide_max = $('#test-modal .picture img').length-1;
	clearTimeout(Slider);
	if (slide_max>0){
		Slider=setTimeout("slider_timer(); slider_next(); Ready = true",7000);
	}
}

banner_id=0;
$( document ).on('click','.banner .button', function(){
	banner_id = $(this).data('id');	
	banner_show(banner_id);
	banner_timer();
});

function banner_show(id){	
	count =  $(".banner .field > div").length-1;
	
	if (id==undefined){
		id=$('.button.show').data('id');
		if (id==count){id=0;}else{id++;}
		}
		
	$('.button').removeClass('show');
	$('#button_'+id).addClass('show');
	$('.picture').removeClass('show');
	$('#picture_'+id).addClass('show');	
}
var Banner;
function banner_timer(){
	clearTimeout(Banner);
	Banner=setTimeout("banner_timer(); banner_show();",30000);
}

$( document ).on('change','.shop .filter .select select', function(){
	option = $(this).data('option');
	id = this.value;
		$.ajax({
		type: "post", url: "shop_session.php", data: {option: option, id:id },
		success: function(){shop_show();}
		});
});
	
	
$( document ).on('click','.info h4', function(){
    $(".info p").hide('fast');
	$(this).next('p').show('slow');
 });

				
function shop_show(){
	$.ajax({
	type: "post", url: "shop.php", data: {filter:'filter'},
	success: function(msg){
		$('#shop').empty().append(msg);
	}	
	});
}
function shop_filter_clear(){
	count =  $(".shop .filter > .select").length-1;
	while (count>=0){
		$('#select_'+count).val('');
	count--;	
	}
}


$( document ).on('click','.shop .filter .search', function(){
	shop_show();
});

$( document ).on('click','.header_basket .products .line .remove', function(){
	id = $(this).data('id');
	$('#header_card_delete_'+id).addClass('show');
	$('#header_card_line_'+id).addClass('hide');
});
$( document ).on('click','.header_basket .products .delete .no', function(){
	id = $(this).data('id');
	$('#header_card_delete_'+id).removeClass('show');
	$('#header_card_line_'+id).removeClass('hide');
});
$( document ).on('click','.header_basket .products .delete .yes', function(){
	id = $(this).data('id');

// udaljaem iz korzini
//	alert('yes delete from card');
	shop_card_delete(id);

});
	
	

$( document ).on('click','.shop .filter .order .by', function(){
	id = $(this).data('id');
	$('.shop .filter .order .by').removeClass('selected');
	$(this).addClass('selected');
		$.ajax({
		type: "post", url: "shop_session.php", data: {orderby: id},
		success: function(){shop_show();}
		});
});

$( document ).on('click','.shop .filter .clear', function(){
		$.ajax({
		type: "post", url: "shop_session_clear.php", data: {},
		success: function(){
			shop_filter_clear();
			shop_show();
		}
		});
});

$( document ).on('click','.slider .right .button', function(){
//	change_content();	
	slide_id = $(this).data('id');	
	
	$('.slider .right .button').removeClass('show');
	$(this).addClass('show');
	
	slider_show();
	slider_timer();
});

$( document ).on('click','.slider .left .full', function(){
	modal_show(slide_id);
	modal_id=slide_id;
});
$( document ).on('click','.slider .left .download', function(){
	alert('download picture');
});
$( document ).on('click','.slider .left .i', function(){
alert('information');
});


function slider_previous(){
	if(slide_id==0){slide_id=slide_max;}
	else{slide_id--;}
	slider_show();
	
}

function slider_next(){
	if(slide_id==slide_max){slide_id=0;}
	else{slide_id++;}
	if (slide_max>0){slider_show();}
}

function slider_move(id){
var offset;
width = $('.slider .right .button').css('width');
width = parseInt(width.slice(0,-2));
offset = parseInt(((id-2)*width));
	if (id!=slide_max){offset=parseInt(offset+width);}
	offset = Math.ceil((offset/2)/10)*10;
	if (offset<0){offset=0;}
		$('.slider .right').css('margin-top','-'+offset+'px');
}


function slider_show(){
	$(".slider .picture").fadeOut('fast');	
	$("#slide_"+slide_id).fadeIn('fast');
	slider_move(slide_id);
	
	$('.slider .right .button').removeClass('show');
	$('#button_'+slide_id).addClass('show');
}

	$(".slider").on('click',function(){
//		     $(this).next("div").slideToggle("fast")
  //      .siblings("div:visible").slideUp("fast");
   //     $(this).toggleClass("selected");
    //    $(this).siblings("h6").removeClass("selected");
		
     });


function test() {
//$(this).css('background','grey');	
$('#test').css('background-color', '#FF6600');
}

function signin() {
$('#errors').empty();
var 
login = $("#login").val(),
password = $("#password").val();
if (login.length >2  && password.length >3) {
$.ajax({
type: "post", url: "login.php", data: {login: login, password:password },
success: function(msg){
	$('#errors').empty().append(msg);
	alert(msg);

if (msg =="") {
	document.location.reload(true);
/*		$$a({
	        url:'login_name.php',
	        response:'text', 
	        success:function (name) { 
	            $$('login_name',name);
	        	parent.window.document.getElementById("exit").style.display = "";
			}
	    });		
		$$a({
	        url:'signin.php',
	        response:'text', 
	        success:function (data) { 
	            $$('dynamic_content',data);
	        }
	    });*/				
}else{alert('error');}
}
});
}
else if (login == '' && password == '') {$('#errors').empty().append('Please enter Login and Password')}
else if (login == '') {$('#errors').empty().append('Please enter Login')}
else if (login.length <3 && !login =='') {$('#errors').empty().append('Please check Login')}
else if (password == '') {$('#errors').empty().append('Please enter Password')}
else if (password.length <4 && !password =='') {$('#errors').empty().append('Please check Password')}
}




function flag(val){
		$.ajax({
		type: "post",url: "lang.php",
		data: {data:val},
		success: function(){document.location.reload(true);}});
}	


				$(document).ready(function(){
				var content_right = document.getElementById('fixed');
				var content_offset = $("#fixed").offset().top;
				var offsets = "10";
				var content_right_width = content_right.clientWidth;
				
					$(document).scroll(function(){
						var main_offset = $(window).scrollTop();		
							if (main_offset > content_offset - offsets ) {
						$('#offset').empty().append(main_offset);
								  
								content_right.className = "content_right_field_fixed";
								content_right.style.width = content_right_width+'px';
							}else {
								content_right.className = "content_right_field";
								content_right.style.width = '100%';

								
								};});		
							
							});

function contact_form(){
	$('.error').removeClass('show');
	var text =$('#text').val(),
	name = $('#name').val(),
	email = $('#email').val();	
	
	if (email=='' || text==''){$('.error').addClass('show');}
	else{
		$.ajax({
			type: "post", url: "contact_send.php", data: {name:name, email:email, text:text},
			success: function(msg){
				alert(msg);
				$('.ok').addClass('show');
				$('#message').hide();
			}
		});
	}
}

function comment_add(){
var r = /^[\w\.\d-_]+@[\w\.\d-_]+\.\w{2,6}$/i,
content = $('#comment_add').data('content'),
content_id =$('#comment_add').data('id'),
name = $('#comment_name').val(),
email = $('#comment_email').val(),
text = $('#comment_text').val(),
errors = 0;

$('comment_status').removeClass('show').empty().hide();

	$('.errors').removeClass('show');
	if (content==''){errors=1;}
	if (name==''){$('#error_name').addClass('show');errors=1;}
	if (!email.match(r)){$('#error_email').addClass('show');errors=1;}
	if (text==''){$('#error_text').addClass('show');errors=1;}

	if (errors==0){
		$.ajax({type: "post", url: "comments.php", data: {action:'add',content:content, content_id:content_id, name:name, email:email, text:text},
		success: function(msg){			
			$('#comment_name').val('');
			$('#comment_email').val('');
			$('#comment_text').val('');
			if (msg!=''){
				$.ajax({type: "post", url: "comments.php", data: {id:msg, action:'show',},
				success: function(msg){
					$('#comments_all').prepend(msg);
					$.ajax({type: "post", url: "comments.php", data: {id:msg, action:'status',},
					success: function(msg){$('#comment_status').hide().addClass('show').empty().append(msg).show(500).delay(5000).hide(500);}
					});
				}
				});

			}
		}
		});
		
	}	
}

function order(){
/* 
proveritj vse polja, esli chto oshibka
*/


/*
otpravitj formu 
ochistitj sessiju 
$('.order').hide();
$('.confirmed').show();

*/
	
	
}
				
