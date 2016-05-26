<head>
	<link href="<?php echo _LINK_PATH;?>css/admin.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo _LINK_PATH;?>js/admin.js"></script>
	<link rel="stylesheet" href="<?php echo _LINK_PATH;?>css/pickmeup.min.css" type="text/css" />
	<script type="text/javascript" src="<?php echo _LINK_PATH;?>js/jquery.pickmeup.min.js"></script>
</head>

<? 	/* udalitj vse fotki iz vremennoj papki */
		$dir = 'img/temp/';
		$file_list = glob("$dir*.jpg");
		$file_count= (count($file_list)>0)?(count($file_list)-1):0;
			if ($file_count>0){
				while ($file_count>=0){
				unlink($file_list[$file_count]);
				$file_count--;
				}
			}

?>

<? 
	if (empty($uri['list'][0])){		
		echo '<div class="main">';
			echo '<div class="menu">';
				echo'<a class="ajax" href="'._LINK_PATH.'login/order"><div class="order"></div></a>';
				echo'<a class="ajax" href="'._LINK_PATH.'login/email"><div class="email"></div></a>';
				echo'<a class="ajax" href="'._LINK_PATH.'login/db"><div class="db"></div></a>';
				echo'<a class="ajax" href="'._LINK_PATH.'login/calendar"><div class="calendar"></div></a>';				
				echo'<a class="ajax" href="'._LINK_PATH.'login/contacts"><div class="contact"></div></a>';
				echo'<a class="ajax" href="'._LINK_PATH.'login/note"><div class="note"></div></a>';
				echo'<a class="ajax" href="'._LINK_PATH.'login/remind"><div class="remind"></div></a>';
				
			echo'</div>';
		echo'</div>';
	}else{
		echo '<a href="'._LINK_PATH.'login"><div class="back_menu">Back to menu</div></a>';
		switch($uri['list'][0]){
			case "order":
				admin_order();
			break;
			case "email":
				admin_email();
			break;
			case "db":
				admin_db();
			break;
			case "calendar":
				admin_calendar();
			break;
			case "contacts":
				admin_contacts();
			break;
			case "note":
				admin_note();
			break;
			case "remind":
				admin_remind();
			break;			
		}				
	}



function admin_db(){
	echo '<iframe id="rFrame" name="rFrame" style="width:100%; height:250px;display: block"></iframe>';
	echo'<div class="admin_table">';
		echo'<div class="search">';
		   echo'<form method="POST" action="" onsubmit="return submit_handler(this)">';
			   echo'<input type="text" name="table_search" id="table_search" placeholder="search..."/>';	
				echo'<div class="button" onclick="table_search()">Search</div>';
				echo'<div class="table_search_by">';
					echo'<div class="id">id 0..9<input name="table_search_by" type="radio" value="0" checked="checked" /></div>';
					echo'<div class="id">id 9..0<input name="table_search_by" type="radio" value="1" /></div>';
				echo'</div>';
			echo'</form>';
		echo'</div>';
		echo'<div id="errors">errors</div>';
		echo'<div id="admin_table">';
			include 'admin_db.php';
		echo'</div>';
	echo'</div>';
}//end function admin_db

function admin_order(){
	echo 'upravlenie zakazami';
}//admin_order();

function admin_email(){
include 'db.php';	



		echo '<div class="modal" id="test-modal" style="display: none">';
            echo '<div class="close">&times;</div>';    
			echo '<div class="content">';               
				echo '<div class="email" id="email_reply"></div>';					
			echo '</div>';
        echo '</div>';
        
	echo '<div class="admin">';	
		$lang=array('ru','lv','en');
		$action=array('read','unread','answer','unanswer','all');
		$i = count($action)-1;
			while ($i>=0){
				echo '<div class="category" data-id="'.$action[$i].'">'.$action[$i].'</div>';
				$i--;	
			}
		
		$i = count($action)-1;
			while ($i>=0){
				$fields=array();
				echo '<div class="table_field" id="field_'.$action[$i].'">';
					echo '<table border="1">';
					
						echo '<tr>';
							$query="SHOW FIELDS FROM `message`";
							if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
							while ($row = $result->fetch_object()){	
								$field=$row->Field;
								$fields[]=$field;
								echo '<td>'.$field.'</td>';	
							}}
							echo '<td>';
								echo 'napisatj otvet';						
							echo '</td>';
							echo '<td>';
								echo 'udalitj';						
							echo '</td>';							
						echo '</tr>';						
						
						
						
						switch($action[$i]){
							case "all":
								$query="SELECT * FROM `message` ORDER BY `date` DESC LIMIT 0,20";
							break;	
							case "read":
								$query="SELECT * FROM `message` WHERE `read`>'0000-00-00 00:00:00' ORDER BY `date` DESC LIMIT 0,20";
							break;	
							case "unread":
								$query="SELECT * FROM `message` WHERE `read`='0000-00-00 00:00:00' ORDER BY `date` DESC LIMIT 0,20";
							break;	
							case "answer":
								$query="SELECT * FROM `message` WHERE `answer`>'0000-00-00 00:00:00' ORDER BY `date` DESC LIMIT 0,20";
							break;	
							case "unanswer":
								$query="SELECT * FROM `message` WHERE `answer`='0000-00-00 00:00:00' ORDER BY `date` DESC LIMIT 0,20";
							break;						
						}
						
								
							
							$count=count($fields);
							if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
							while ($row = $result->fetch_object()){
								$read=$row->read;
								$answer=$row->answer;
								$id=$row->id;
																
								if ($read=='0000-00-00 00:00:00'){$color=' blue';}
								else if ($answer!='0000-00-00 00:00:00'){$color=' green';}
								else {$color=' white';}
								
								echo '<tr class="row'.$color.'" data-row="'.$id.'">';
									$j=0;
									while ($j<$count){							
										echo '<td>';
											echo $row->$fields[$j];
										echo '</td>';
										$j++;
									}
									echo '<td>';
										echo '<div class="email">';
											echo '<span class="reply" data-id="'.$id.'" data-lang="ru">ru</span> ';
											echo '<span class="reply" data-id="'.$id.'" data-lang="lv">lv</span> ';
											echo '<span class="reply" data-id="'.$id.'" data-lang="en">en</span>';	
										echo '</div>';
									echo '</td>';
									echo '<td>';
										echo '<div class="delete" onclick="email_delete('.$id.')">delete</div>';						
									echo '</td>';
								echo '</tr>';
							}}
						

					echo '</table>';
				echo '</div>';	
			$i--;
			}
			
					
				echo 'upravlenie pochtoj';
		echo '<br>pokazatj prochitannie';
		echo '<br>pokazatj neprochitannie';	
		echo '<br>pokazatj otvechennie';
		echo '<br>pokazatj neotvechennie';

		
		
		echo '<div class="">';
		
		
		echo '</div>';
		
	echo '</div>';	
}//admin_email();

function admin_calendar(){
	
}//admin_calendar();

function admin_contacts(){
	
}//admin_contacts();

function admin_note(){
	
}//admin_note();

function admin_remind(){
	
}//admin_remind();
				
				
?>
