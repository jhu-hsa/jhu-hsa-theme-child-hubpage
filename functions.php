<?php
/* child theme styles */
function child_scripts_styles() {
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri().'/style.css');
}
add_action( 'wp_enqueue_scripts', 'child_scripts_styles' );

add_filter('acf/settings/save_json', function() {
	return get_stylesheet_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function($paths) {
	$paths = array(get_template_directory() . '/acf-json');

	if(is_child_theme())
	{
		$paths[] = get_stylesheet_directory() . '/acf-json';
	}

	return $paths;
});


?>