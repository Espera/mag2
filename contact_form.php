<div class="form blue">
	<div class="logo"></div>
	<p><? echo $_LANG['Contact_form'];?></p>
	<div class="ok" id="ok"><? echo $_LANG['message_sent'];?></div>
	<div class="error" id="error"><? echo $_LANG['check_fields'];?></div>


	<div id="message" class="message">
    
        <div class="line">
            <div class="left"><? echo $_LANG['Name']; ?></div>
            <div class="right"><input type="text" class="text"  name="name" id="name" /></div>
        </div>
        
        <div class="line">
            <div class="left">* <? echo $_LANG['Email']; ?></div>
            <div class="right"><input type="text" class="text"  name="email" id="email" /></div>
        </div>
        
        <div class="line">
            <div class="left">* <? echo $_LANG['Message_text']; ?></div>
            <div class="right"><textarea class="textarea" name="text" id="text"></textarea></div>
        </div>
        
        <div class="line">       
			<div class="button" onClick="contact_form()"><? echo $_LANG['Send'];?></div>
        </div>
        
    <div class="star">* <? echo $_LANG['Fields_required']; ?></div>        
    <div class="more"><? echo $_LANG['contact_form_more']; ?> :<br />
		<? echo $_LANG['questions_products']; ?><br />
        <? echo $_LANG['questions_cure']; ?><br />
        <? echo $_LANG['questions_reception']; ?><br />
        <? echo $_LANG['questions_webpage']; ?><br />
        <? echo $_LANG['questions_other']; ?><br />   
    </div>
    
    


	</div>
</div>










