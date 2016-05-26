<? session_start(); ?>
esli estj poljzovateljno, to propuskaem i perexodim k zakazu<br>
esli net poljzovatelja, to predlogaem na vibor 2 varianta<br>

zaloginitsja | zapolnitj zakaz

<?
include_once 'card_status.php';
include 'content_left.php';
//proverka na poljzovatelja
	order_constructor($_LANG);
	
	
	
function order_constructor($_LANG){
	echo '<div class="order">';
		card_status($_LANG, 'order');			
		order_name($_LANG);	
		order_email($_LANG);
		order_delivery($_LANG);
		order_next($_LANG);
	echo '</div>';
		order_confirmed($_LANG);
}//end function order_constructor

function order_name($_LANG){
	echo '<div class="contacts">';
		echo '<div class="title">';
			echo $_LANG['enter_contact_information'];
		echo '</div>';
		echo '<div class="half">';
			echo '<div class="field">';
				echo '<div class="top">';
					echo '<div class="required">*</div>';
					echo '<div class="title">'.$_LANG['name'].':</div>';
				echo '</div>';
	
	
				echo '<div class="bottom">';
					echo '<div class="input">';
						echo '<input type="text" name="name" id="name" placeholder="'.$_LANG['your_name'].'">';
					echo '</div>';
					
					echo '<div class="error" id="error_name">*objazateljno dlja zapolnenija</div>';		
				echo '</div>';
			echo '</div> ';	
			echo '<div class="field">';
				echo '<div class="top">';
					echo '<div class="required">*</div>';
					echo '<div class="title">'.$_LANG['email'].':</div>';
				echo '</div>';
								
				echo '<div class="bottom">';
					echo '<div class="input">';					
						echo '<input type="text" name="email" id="email" placeholder="'.$_LANG['your_email'].'">';
					echo '</div>';
					echo '<div class="error" id="error_email">*objazateljno dlja zapolnenija</div>';		
				echo '</div>';
			echo '</div> ';	

		echo '</div>';

		echo '<div class="half">';
			echo '<div class="field">';
				echo '<div class="top">';
					echo '<div class="required">*</div>';
					echo '<div class="title">'.$_LANG['surname'].':</div>';
				echo '</div>';
				
				echo '<div class="bottom">';	
					echo '<div class="input">';
						echo '<input type="text" name="surname" id="surname" placeholder="'.$_LANG['your_surname'].'">';
					echo '</div>';
					echo '<div class="error" id="error_surname">*objazateljno dlja zapolnenija</div>';		
				echo '</div>';
			echo '</div> ';	
			echo '<div class="field">';
				echo '<div class="top">';
					echo '<div class="required">*</div>';
					echo '<div class="title">'.$_LANG['phone'].':</div>';
				echo '</div>';
				echo '<div class="bottom">';
					echo '<div class="input">';				
						echo '<input type="text" name="phone" id="phone" placeholder="'.$_LANG['your_phone'].'">';
					echo '</div>';
					echo '<div class="error" id="error_phone">*objazateljno dlja zapolnenija</div>';		
				echo '</div>';
			echo '</div> ';	
		echo '</div>';
	echo '</div>';
}//order_name

function order_email($_LANG){
	echo '<div class="spam">';
		echo '<input type="checkbox" name="spam" id="spam" checked="checked">';
		echo $_LANG['send_spam'].'?';
	echo '</div>';
}//order_email


function order_delivery($_LANG){
	echo '<div class="delivery">';
		echo '<div class="title">';
			echo $_LANG['choose_delivery_way'];
		echo '</div>';
		

		echo '<div class="type" data-id="1" id="type=1">';	
			echo '<div class="img lv_pasts">';
			echo '</div>';
			echo '<div class="information">';
				echo 'dopolniteljnaja informacija';
			echo '</div>';
			
			echo '<div class="name">';
				echo '<div class="post">';
					echo ' obichnaja pochta';
				echo '</div>';
				echo '<div class="time">';
					echo ' vremja dostavki ';
				echo '</div>';
			echo '</div>';
			echo '<div class="price">';
				echo '<div class="plus">+</div>';
				echo '<div class="value">99.99</div>';
				echo '<div class="eur">eur</div>';
			echo '</div>';					
		echo '</div>';
		
		
		
		echo '<div class="type" data-id="2" id="type=2">';
			echo '<div class="img lv_express">';
			echo '</div>';
			echo '<div class="information">';
				echo 'dopolniteljnaja informacija';
			echo '</div>';
			
			echo '<div class="name">';
				echo '<div class="post">';
					echo ' obichnaja pochta';
				echo '</div>';
				echo '<div class="time">';
					echo ' vremja dostavki ';
				echo '</div>';
			echo '</div>';
			echo '<div class="price">';
				echo '<div class="plus">+</div>';
				echo '<div class="value">99.99</div>';
				echo '<div class="eur">eur</div>';
			echo '</div>';
		echo '</div>';	
		
		
		echo '<div class="type" data-id="3" id="type=3">';
			echo '<div class="img dpd">';
			echo '</div>';
			echo '<div class="information">';
				echo 'dopolniteljnaja informacija';
			echo '</div>';
			
			echo '<div class="name">';
				echo '<div class="post">';
					echo ' DPD pochta';
				echo '</div>';
				echo '<div class="time">';
					echo ' vremja dostavki ';
				echo '</div>';
			echo '</div>';
			echo '<div class="price">';
				echo '<div class="plus">+</div>';
				echo '<div class="value">99.99</div>';
				echo '<div class="eur">eur</div>';
			echo '</div>';			
		echo '</div>';



		echo '<div class="type" data-id="4" id="type=4">';
			echo '<div class="img omniva">';
			echo '</div>';
			echo '<div class="information">';
				echo 'dopolniteljnaja informacija';
			echo '</div>';
			
			echo '<div class="name">';
				echo '<div class="post">';
					echo ' Omniva pochta';
				echo '</div>';
				echo '<div class="time">';
					echo ' vremja dostavki ';
				echo '</div>';
			echo '</div>';
			echo '<div class="price">';
				echo '<div class="plus">+</div>';
				echo '<div class="value">99.99</div>';
				echo '<div class="eur">eur</div>';
			echo '</div>';			
		echo '</div>';
				
				
		echo '<div class="type" data-id="5" id="type=5">';
			echo '<div class="img courier">';
			echo '</div>';
			echo '<div class="information">';
				echo 'dopolniteljnaja informacija';
			echo '</div>';
			
			echo '<div class="name">';
				echo '<div class="post">';
					echo ' kurjerskaja dostavka';
				echo '</div>';
				echo '<div class="time">';
					echo ' vremja dostavki ';
				echo '</div>';
			echo '</div>';
			echo '<div class="price">';
				echo '<div class="plus">+</div>';
				echo '<div class="value">99.99</div>';
				echo '<div class="eur">eur</div>';
			echo '</div>';	
		echo '</div>';	
		
		
		echo '<div class="type" data-id="6" id="type=6">';
			echo '<div class="img vets">';
			echo '</div>';
			echo '<div class="information">';
				echo 'dopolniteljnaja informacija';
			echo '</div>';
			
			echo '<div class="name">';
				echo '<div class="post">';
					echo ' zabratj v magazine';
				echo '</div>';
				echo '<div class="time">';
					echo ' vremja dostavki ';
				echo '</div>';
			echo '</div>';
			echo '<div class="price">';
				echo '<div class="plus">+</div>';
				echo '<div class="value">99.99</div>';
				echo '<div class="eur">eur</div>';
			echo '</div>';	
			
		echo '</div>';	
			
			echo '<div class="adress" id="adress_1">';
				
				echo '!!!adress gde zabratj s pochti';	
				echo '<br>vibratj gorod';
				echo '<br>vibratj ulicu';
				echo '<br>vibratj nomer doma';
				echo '<br>neobjazateljno vibratj nomer kvartiri';			
			echo '</div>';
					
			echo '<div class="adress" id="adress_2">';
				echo 'adress gde zabratj ekspress pochtoj';
			echo '</div>';	
			echo '<div class="adress" id="adress_3">';
				echo 'adress gde zabratj dpd';
			echo '</div>';	
			echo '<div class="adress" id="adress_4">';
				echo 'zabratj v magazine';
			echo '</div>';	
									
	echo '</div>';
}//order_delivery

function order_next($_LANG){
	
	echo 'proverjaem zapolneni li vse polja';
	echo '<div class="next" onclick="order()">'.$_LANG['next'].'</div>';
	
}//end function order_Next;

function order_confirmed($_LANG){
	echo '<div class="confirmed">';
		echo 'zakaz sdelan, infa vislana na pochtu';
		echo 'proveritj zakaz mozhno po kodu';
		echo '<div id="code">kod 28214j5382h</div>';
	echo '</div>';

	
	
}//order_confirmed





?>