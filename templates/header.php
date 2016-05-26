<? session_start(); ?>
<div class="header">
	<div class="lang"> <? global $_LANG;include_once 'lang_'.$_SESSION['mag']['lang'].'.php';?></div>
    
    <div class="header_left">
		<a class="ajax" href="<? echo _LINK_PATH;?>"><div class="logo_pic"></div></a>
    </div>
        
	<div class="header_right">    
        
            
        <div class="right">
        	
                <div class="header_basket">
                    <div class="basket">
                        
                            <div class="basket_icon">
                                <a class="ajax" href="<? echo _LINK_PATH;?>card"><div class="icon"></div></a>
                            </div>
                        <div class="basket_middle">
                            <div class="middle">	
                                <div class="name"><? echo $_LANG['card_count'];?>:</div>
                                <? $count = count($_SESSION['mag']['card']['id'])-1; 
								if ($count<0){$count=0;}?>
                                <div class="value" id="header_card_total_count"><? echo $count;?></div>
                                <div class="count"><? echo $_LANG['products'];?></div>
                                
                                
                            </div>
                        </div>
                        <div class="arrow"><div class="icon"></div></div>                        
                     </div>
                     
                     
                     <div class="products">
						<? $action='header';
						include 'card.php';	?>
                     </div>
                 </div>
             
        
        
        </div>
        
        
        <div class="header_menu">
			<div class="top_panel">
            <?
			    
				$list=array('veikals','grozs','konsole','administrators','kabinets');
				$url=array('shop','card','console','admin','cabinet');
				
				$i=0;
					while($i<count($list)){
						echo '<a class="ajax" href="'._LINK_PATH.$url[$i].'">'.$list[$i].'</a>';					
						$i++;	
					}

			?>

			</div>                
        </div>
	</div>     
</div>

<div class="card_window"></div>