// JavaScript Document
function onResponse(d) {  
 eval('var obj = ' + d + ';');  
	$('#pic_'+obj.id).empty();
		
	setTimeout(function () {$('#pic_'+obj.id).append('<img src='+obj.url+'>');}, 1000);

alert(obj.url);
	
	$('#url_'+obj.id).empty().append(obj.url);	
	$('#del_'+obj.id).addClass('show');	
 }
 
function table_search(val){
	$('#admin_table').empty().append('<div class="load_bar"></div>');
	if (val==undefined){val = $('#table_search').val();}
	var radio = $('input[name=table_search_by]:checked').val();
		$.ajax({type: "post", url: "admin_db.php", data: {search: val, sort_by:radio},
		success: function(msg){$('#admin_table').empty().append(msg);}
		});		
}

function submit_handler(form) {
 table_search(form.table_search.value);
 return false;
}


$(".admin .category").live('click',function(){
	var id =$(this).data('id');

		$(".admin .category").removeClass('active');
		$(this).addClass('active');
				
			$(".table_field").removeClass('active');
			$("#field_"+id).addClass('active');
		
			$(".ability").removeClass('active');
			$("#ability_"+id).addClass('active');
			
				$(".field").removeClass('active');		
				$(".action").removeClass('active');			
});

$(".action").live('click',function(){
	var id =$(this).data('id');
	var action =$(this).data('action');	
		$(".action").removeClass('active');
		$(this).addClass('active');
			$(".field").removeClass('active');
			$("#field_"+action+'_'+id).addClass('active');
});

/*----------------- add ------------------ */
$(".button").live('click',function(){	
	var count =  $('#form_picture_'+category+'_0 > .form_picture').length-1,
	category = $(this).data('category'),	
	action = $(this).data('action'),
	count = $(this).data('count'),	
	row = $(this).data('row'),
	id= $(this).data('id'),
	types = [],
	vals = [],
	pic = [],
	i=0;	

	if (action=='save' || action=='add'){	
		while (i<=count){
			val = '';
			type = $('#td_'+category+'_'+row+'_'+i).data('type');
				if (type=='text' || type=='textarea'){val = $('#'+category+'_'+row+'_'+i).val();}
				if (type=='checkbox'){
					var ch = document.getElementsByName(category+'_'+row+'_'+i);
					for(var j=0; j<ch.length; j++){if (ch[j].checked){val = val+' '+$('[checkbox_id = "'+category+'_'+row+'_'+i+'_'+j+'"]').attr('option');}}
				}
				if (type=='select'){val = $('select[id='+category+'_'+row+'_'+i+']').attr('value');}
			vals[i]=val;
			types[i]=type;
			i++;
		}
		if (action=='add'){
			k=0;
			while (k<=count){
				pic[count]=$('#url_user_0_'+count).text();			
				k++;	
			}
		}
		
			$.ajax({type: "post", url: "admin_query.php", data: {action:action, val:vals, type:types, category:category,pic:pic},
				success: function(msg){
					$('#errors').show().addClass('active').empty().append(msg);
					$('#errors').delay(5000).hide(1000);

					if (action=='add'){

						for(var i=0; i<=count; i++){
						//	alert('#td_'+category+'_0_'+i);
							type = $('#td_'+category+'_0_'+i).data('type');
	//						alert(i+' tip: '+type);
								
								if (type=='text'){$('#'+category+'_0_'+i).val('');}
								else if (type=='checkbox'){
									var ch = document.getElementsByName(category+'_0_'+i);
									for(var j=0; j<ch.length; j++){$('[checkbox_id = "'+category+'_0_'+i+'_'+j+'"]').attr('checked', false);}
								}
								else if (type=='select'){$("#"+category+"_0_"+i+"  option[option='"+option+"']").prop("selected", false);}
								else{$('#'+category+'_0_'+i).empty();}
						}
					}
					//alert(msg);
				}
			});
	}
});


/*----------------- put ------------------ */
btn_put='';

$(".button.put").live('click',function(){
	var category = $(this).data('category'),	
	count = $(this).data('count'),	
	id = $(this).data('id'),
	row = $(this).data('row'),
	i=0;	

	if (btn_put==row){$('#tr_'+category+'_'+row).toggleClass('selected');}
	else {$('.tr_all').removeClass('selected');$('#tr_'+category+'_'+row).toggleClass('selected');}
	btn_put=row;

	if ($('#tr_'+category+'_'+row).hasClass('selected')){	
		while (i<=count){				
			type = $('#td_'+category+'_'+row+'_'+i).data('type');
			if (type=='checkbox'){
				var ch = document.getElementsByName(category+'_'+row+'_'+i);
				  for(var j=0; j<ch.length; j++)
					if (ch[j].checked){$('[checkbox_id = "'+category+'_0_'+i+'_'+j+'"]').attr('checked', true);} 
					else {$('[checkbox_id = "'+category+'_0_'+i+'_'+j+'"]').attr('checked', false);}
			}
			if (type=='select'){option = $('select[select_id='+category+'_'+row+'_'+i+']').attr('value');$("#"+category+"_0_"+i+"  option[option='"+option+"']").prop("selected", true);}
			else{value = $('#'+category+'_'+row+'_'+i).val();$('#'+category+'_0_'+i).val(value);}
			
			i++;	
		}//while end
	}//if end
});


/*----------------EMAIL-DOWN-------------*/
$( document ).on('click','table .email .reply', function(){
	lang = $(this).data('lang');
	id = $(this).data('id');
	$('#test-modal').modal().open();
		$.ajax({type: "post", url: "admin_email.php", data: {lang:lang, id:id, action:'open'},
		success: function(msg){$('#email_reply').empty().append(msg);}
		});		
});

$( document ).on('click','.row.blue .email .reply', function(){
 id = $(this).data('id');
	$.ajax({type: "post", url: "admin_email.php", data: {id:id, action:'read'},
	success: function(){
		$('table tr[data-row="'+id+'"]').removeClass('blue').addClass('white');
		}
	});	
});
 
function email_delete(id){
	$('#test-modal').modal().open();
		$.ajax({type: "post", url: "admin_email.php", data: {id:id, action:'delete'},
		success: function(msg){$('#email_reply').empty().append(msg);}
		});	
}

function email_delete_query(id){
		$.ajax({type: "post", url: "admin_email.php", data: {id:id, action:'delete_query'},
		success: function(msg){
			$('#email_reply').empty().append(msg);
			$('table tr[data-row="'+id+'"]').hide('fast');
		}
		});	
}
 
function email_send(){
	lang = $('#email_lang').val();
	id = $('#email_id').val();
	text = $('#email_text').val();
	subject = $('#email_subject').val();	
		$.ajax({type: "post", url: "admin_email.php", data: {lang:lang, id:id, text:text, subject:subject, action:'send'},
		success: function(msg){
			if (msg==''){
				$('table tr[data-row="'+id+'"]').removeClass('white').addClass('green');	
				$('#email_reply').empty().append('Message sent');
			}else{alert('pisjmo ne otpravlenno');}
			
		}
		});		
}
 
 
 /*----------------EMAIL-UP-------------*/

 