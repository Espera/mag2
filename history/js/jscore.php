<?php
	header( "Content-Type: application/javascript" );

	$module_name = isset( $_GET['module'] ) ? $_GET['module'] : '';
?>

$(function(){
<?php
	if ( $module_name == "demo" ) {
?>
	//alert("Hello World!");
<?php
	}
?>
});