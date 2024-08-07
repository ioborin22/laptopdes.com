<?php
function optionsframework_option_name() {

	$themename = wp_get_theme();
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

function optionsframework_options() {

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );


	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';

	$options = array();
	
	// TAB GENERAL
	$options[] = array( "name" => "Skins",
						"type" => "heading");
	
	$options[] = array( "name" => "Logo",
						"desc" => "",
						"id" => "logo",
						"type" => "upload");
						
	$options[] = array( "name"	=> "Favicon",
						"desc"	=> "",
						"id"	=> "favicon",
						"type"	=> "upload");
						
	$options[] = array(	'name' => "Theme Skins",
						'desc' => "",
						'id' => "skins",
						'std' => "2skins",
						'type' => "images",
						'options' => array(
							'1skins' => $imagepath . '1skins.jpg',
							'2skins' => $imagepath . '2skins.jpg',
							'3skins' => $imagepath . '3skins.jpg',
							'4skins' => $imagepath . '4skins.jpg'));

	return $options;
}