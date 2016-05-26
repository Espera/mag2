<? session_start(); 
include 'content_left.php';?>



<div class="contacts">

    <h3><? echo $_LANG['Our_contacts'].':';?></h3>
        <h4><? echo $_LANG['general_information'];?></h4>
        <p>SIA Vets</p>
        <p style="display:none;">SIA "Vets" sia 'vets'</p>
        <p><? echo $_LANG['Veterinar'].' '.$_LANG['Kristina_Mazure']?></p>
        <p>Tel. +371 27406479</p>
        <p>Email kristina.mazure@gmail.com</p>
        <p><? echo $_LANG['working_hours'].':'; ?> <? echo $_LANG['reception_by_previous_appointment']; ?></p>	
        <p><? echo $_LANG['for_reception_use_contact_form_or_phone']; ?> <b>+371 27406479</b></p>
    	<p><a class="ajax" href="<? echo _LINK_PATH.'contact_form';?>"><? echo $_LANG['want_to_ask_us']; ?></a></p>




	<div class="">
        <div class="map_field">
    		<div class="top">
               <h4><? echo $_LANG['our_contacts_on_map']; ?></h4>
                <p>Valdeku iela, Ziepniekkalns, Zemgales priekšpilseta, Rīga</p>
        	</div>
        	<div id="map-canvas" data-x="56.903" data-y="24.0975"></div>
        	<div class="find">Kak nas najti, kak dobratjsja na avtobuse, trolejbuse, mashine </div>
        
        </div>
		        
        <div class="map_field">
			<div class="top">
       	        <p>Garciems, Carnikavas novads</p>
            </div>
        	<div id="map-canvas2" data-x="57.113" data-y="24.2378"></div>
        	<div class="find">Kak nas najti, kak dobratjsja na avtobuse, trolejbuse, mashine </div>
        </div>


	</div>
    
	<? include 'contact_form.php'; ?>   
</div>

<script>initialize();</script>
