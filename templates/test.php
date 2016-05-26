<head>
<script src='http://code.jquery.com/jquery-2.1.1.min.js'></script>

	<script>
	
	alert('start');
    var outer = document.getElementById('outer')
    var info = document.getElementById('info');
	alert(outer);
	alert(info);
	
    outer.onmouseout = handleMouseLeave(function(e) {
		alert('nuka');
      e = e || event;
      var target = e.target || e.srcElement;
      info.innerHTML = e.type+', target:'+target.tagName;
    });
    outer.onmouseover = handleMouseEnter(function(e) {
      e = e || event;
      var target = e.target || e.srcElement;
      info.innerHTML = e.type+', target:'+target.tagName;
    });
    </script>
</head>


<div style="padding:10px; margin:10px; border: 2px solid blue" id="outer" name="outer">
 <p style="border: 1px solid green">На синем родителе эмулируются обработчики mouseenter/mouseleave.</p>
 <div style="border: 1px solid red">Без лишних событий.</div>
</div>
<div id="info" name="info">Тут будет информация о событиях.</div>
