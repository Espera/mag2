<head>
        <style>#galleria{height:320px;}</style>
        
<? /*
           <!-- load jQuery -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
*/ ?>

    
        <!-- load Galleria -->
        <script src="js/galleria-1.2.3.min.js"></script>

    </head>
    
<? 
require_once 'lang_'.$_SESSION['vets']['lang'].'.php';
echo '<a class="ajax" href="'._LINK_PATH.'news">'.$_LANG['Back_to_news'].'</a>'; ?>




    <div class="title big">Title glavnoj novosti</div>
<div class="galery">

      <div class="content">
        
        <div id="galleria">
            	<img title="Locomotives Roundhouse" alt="Steam locomotives of the Chicago &amp; North Western Railway." src="http://news.bbcimg.co.uk/media/images/74113000/jpg/_74113834_74113833.jpg">
                <img title="Icebergs in the High Arctic" alt="The debris loading isn't particularly extensive, but the color is usual." src="http://apod.nasa.gov/apod/image/1403/heic1404b1920.jpg">
                <img title="Arana" alt="Xysticus cristatus, A Estrada, Galicia, Spain" src="http://upload.wikimedia.org/wikipedia/commons/thumb/f/fe/Ara%C3%B1a._A_Estrada%2C_Galiza._02.jpg/100px-Ara%C3%B1a._A_Estrada%2C_Galiza._02.jpg">
                <img title="Museo storia naturale" src="http://upload.wikimedia.org/wikipedia/commons/thumb/2/2d/9104_-_Milano_-_Museo_storia_naturale_-_Fluorite_-_Foto_Giovanni_Dall%27Orto_22-Apr-2007.jpg/100px-9104_-_Milano_-_Museo_storia_naturale_-_Fluorite_-_Foto_Giovanni_Dall%27Orto_22-Apr-2007.jpg">
                <img title="Grjótagjá caves in summer 2009" src="http://upload.wikimedia.org/wikipedia/commons/thumb/1/15/Grj%C3%B3tagj%C3%A1_caves_in_summer_2009_%282%29.jpg/100px-Grj%C3%B3tagj%C3%A1_caves_in_summer_2009_%282%29.jpg">
                <img title="Thermes" alt="Xanthi hot-spa springs, Xanthi Prefecture, Greece" src="http://upload.wikimedia.org/wikipedia/commons/thumb/9/90/20091128_Loutra_Thermes_Xanthi_Thrace_Greece_2.jpg/100px-20091128_Loutra_Thermes_Xanthi_Thrace_Greece_2.jpg">
                <img title="Polish Army Ko³obrzeg" alt="A display of the Polish Army. Both the soldier, and the vehicle belong to the 7th Pomeranian Coastal Defence Brigade, a part of the Szczecin-based 12th Mechanized Division Boles³aw Krzywousty" src="http://upload.wikimedia.org/wikipedia/commons/thumb/5/58/Polish_Army_Ko%C5%82obrzeg_077.JPG/100px-Polish_Army_Ko%C5%82obrzeg_077.JPG">
                <img title="Zlatograd Bulgaria" src="http://upload.wikimedia.org/wikipedia/commons/thumb/2/2d/20100213_Zlatograd_Bulgaria_3.jpg/100px-20100213_Zlatograd_Bulgaria_3.jpg">

        </div>
        
    </div>        

</div>
<div class="text big">tewtkwejtkwet ewt wet wet jwekt wekt wet wetkasdjfkj astkew jekwtk jwetewt e</div>


<br />odna novostj pod nomerom <? echo $uri['list'][0]; ?>

    <script>

    // Load the classic theme
    Galleria.loadTheme('js/galleria.classic.js');
    
    // Initialize Galleria
    $('#galleria').galleria();

    </script>