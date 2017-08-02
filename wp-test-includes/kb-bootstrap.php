<?php

require_once dirname( __FILE__ ) . '/../data/vendor/antecedent/patchwork/Patchwork.php';
require_once dirname( __FILE__ ) . '/../data/vendor/autoload.php';
require_once dirname( dirname( __FILE__ ) ) . '/wp-test-includes/functions.php';


use tad\FunctionMocker\FunctionMocker;

function _manually_load_environment() {
	
	// Add your theme …
	switch_theme('empty-theme');
	
	// Update array with plugins to include ...
	$plugins_to_active = array(
		'acf-extentions/acf-extentions.php',
		'language-support/language-support.php'
	);

	update_option( 'active_plugins', $plugins_to_active );
	
	FunctionMocker::init();
}
tests_add_filter( 'muplugins_loaded', '_manually_load_environment' );

require dirname( dirname( __FILE__ ) ) . '/wp-test-includes/bootstrap.php';