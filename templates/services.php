<? session_start();
	include 'content_left.php'; 
?>
<div class="services">
	<h3><? echo $_LANG['prices_and_services']; ?></h3>
	<div class="services_block">
        <div class="form blue">
            <div class="logo"></div>
            <p><? echo $_LANG['Price_list'];?></p>
        
        
                <div class="line">
                    <div class="title">zagolovok </div>
                </div>
                <div class="line">
                    <div class="left services">Usluga</div>
                    <div class="right services">0,00€</div>
                </div>
                <div class="line">
                    <div class="left services">Usluga2</div>
                    <div class="right services">0,00€</div>
                </div>
                <div class="line">
                    <div class="left services">Usluga3</div>
                    <div class="right services">0,00€</div>
                </div>
                <div class="line">
                    <div class="left services">Usluga4</div>
                    <div class="right services">0,00€</div>
                </div>
                <div class="line">
                    <div class="left services">Usluga5</div>
                    <div class="right services">0,00€</div>
                </div>
        
                <div class="line">
                    <div class="title">zagolovok2 </div>
                </div>
                <div class="line">
                    <div class="left services">Usluga6</div>
                    <div class="right services">0,00€</div>
                </div>
                <div class="line">
                    <div class="left services">Usluga7</div>
                    <div class="right services">0,00€</div>
                </div>
                <div class="line">
                    <div class="left services">Usluga8</div>
                    <div class="right services">0,00€</div>
                </div>
                <div class="line">
                    <div class="left services">Usluga9</div>
                    <div class="right services">0,00€</div>
                </div>
                <div class="line">
                    <div class="left services">Usluga10</div>
                    <div class="right services">0,00€</div>
                </div>
        
            <div class="more">
				<? echo $_LANG['more_information_by_phone'];?> (+371) 27406479<br />
            	<? echo $_LANG['or_fill_form_bellow'];?>
            </div>
            <div class="star">* <? echo $_LANG['price_has_informative_character']; ?></div>
            <div class="star">** <? echo $_LANG['price_by_agreement']; ?></div>
		</div>
        
        <p>Forma kontaktov</p>
        <? include 'contact_form.php'; ?>
    </div>
</div>    