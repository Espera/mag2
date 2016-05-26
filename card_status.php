
<?

function card_status($_LANG, $action){
echo 'card_status.php';
	echo '<div class="card_info">';
		echo '<div class="title">';
			echo $_LANG[$action];
		echo '</div>';
						
			// massiv s adresami
			// masiv s nazvanijami
			//count = colichestvo 
			
			echo '<div class="status">';
				echo '<div class="center">';
					if ($action=='card'){$active=' active';}else{$active='';}
						echo '<div class="point'.$active.'">korzina</div>';
								
					if ($action=='order'){$active=' active';}else{$active='';}
						echo '<div class="point'.$active.'">oformlenie</div>';	
							
					if ($action=='shipping'){$active=' active';}else{$active='';}
						echo '<div class="point'.$active.'">dostavka</div>';
								
					if ($action=='pay'){$active=' active';}else{$active='';}
						echo '<div class="point'.$active.'">oplata</div>';					
				echo '</div>';
				
				echo '<a class="ajax" href="'._LINK_PATH.'shop/all"><div class="left">prodolzhitj zakupatsja</div></a>';
				echo '<a class="ajax" href="'._LINK_PATH.'order"><div class="right">'.$_LANG['order'].'</div></a>';
					
			echo '</div>';
		echo '</div>';	
	
}//card_status
?>