<?  session_start();  ?><head>
<script>banner_timer();</script>
</head>

<div class="content_right" id="content_right">
	<div class="content_right_field" id="fixed">   
	    <div class="content_right_box">
			<?	include 'date_to_month.php';
				include 'db.php';				
                
                $rand = rand(1,4);
               // $rand=1;
                $lang=$_SESSION['vets']['lang'];
                
                        switch ($rand) {
                            case 1:
                                $action='news';
                                $title=$_LANG['News'];
                                $more=$_LANG['More_news'];
								echo '<div class="title">'.$title.'</div><div class="arrow"></div>';
							
                                $query="SELECT `id`,`title`, `date` FROM `news` WHERE `lang`='$lang' ORDER BY `id` DESC LIMIT 0, 3";		
									if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
									while ($row = $result->fetch_object()){
										$title=$row->title;
										$id=$row->id;
										$GLOBALS['month']=substr($row->date, 5, 2);
										$day=substr($row->date, 8, 2);
							
								
										date_to_month($GLOBALS['month']);
							
							
											echo '<a class="ajax" href="'._LINK_PATH.$action.'/'.$id.'">    
													<div class="block">
														<div class="date">
															<div class="month">'.$month.'</div>
															<div class="day">'.$day.'</div>
														</div>    
														<div class="text">
															<div class="first">'.$title.'</div>
															<div class="second">'.$_LANG['Read_more'].'</div>
														</div>
													</div>	
											</a>';
                                }}
                                echo '<a class="ajax" href="'._LINK_PATH.$action.'"><div class="more">'.$_LANG['More'].' '.$more.'</div></a>';
                                break;
                            case 2:
                                $action='2'; //discount
								$path='discount';
                                $title=$_LANG['Discounts'];
                                $more=$_LANG['More_discount'];                                
								break;
                            case 3:
                                $action='3';//special
								$path='special';
                                $title=$_LANG['Special'];
                                $more=$_LANG['More_special'];										
								break;		
                            case 4:
                                $action='1'; //new
								$path='new';								
                                $title=$_LANG['New'];
                                $more=$_LANG['More_new'];                                
								break;
                        }	                

                        switch ($rand) {
                            case 1:break;
							default:
								echo '<div class="title">'.$title.'</div><div class="arrow"></div>';
									echo '<div class="banner">';

										$i=0;
										$query="SELECT `slider_pic` FROM `slider` WHERE `action_id`='$action' AND `lang`='$lang' ORDER BY `id` DESC LIMIT 5";							
											if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
											while ($row = $result->fetch_object()){
												$folger=$row->slider_pic;
												if ($i==0){$show=' show';}else{$show='';}
												if (!empty($folger)){$file='img/slider/'.$path.'/'.$folger.'/1.jpg';}else{$file='';}
												if (file_exists($file)) {			
													echo '<div class="picture'.$show.'" id="picture_'.$i.'"><img src="'.$file.'"></div>';	
												}
												$i++;
											}}
											
										$i=0;
										echo '<div class="field">';
											if ($result = $mysqli->query($query, MYSQLI_USE_RESULT) ) {
											while ($row = $result->fetch_object()){
												$folger=$row->slider_pic;
												if ($i==0){$show=' show';}else{$show='';}
												if (!empty($folger)){$file='img/slider/'.$path.'/'.$folger.'/1.jpg';}else{$file='';}
												if (file_exists($file)) {			
													echo '<div class="button'.$show.'" id="button_'.$i.'" data-id="'.$i.'"></div>';		
												}
												$i++;
											}}		
										echo '</div>';										
									echo '</div>'; //slider							
							break;
						}

                                //$query="SELECT `id`,`title`, `date` FROM `shop` WHERE `lang`='$lang' ORDER BY `id` DESC LIMIT 0, 3";
                
                ?>
        </div>
	</div>    
</div>