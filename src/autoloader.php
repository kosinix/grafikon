<?php
// Autoloader
function grafikon_autoloader( $class_name ) {
	if ( 0 === strpos( $class_name, 'Grafikon' ) ) {

		$src = dirname( __FILE__ ) . '/';
		$class  = str_replace( '_', '/', $class_name ) . '.php';

		require_once $src . $class;
	}
}

spl_autoload_register( 'grafikon_autoloader' );