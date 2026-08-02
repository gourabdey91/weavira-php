<?php
/**
 * Autoloader
 */
function gal_google_api_php_client_autoload( $className ) {

	$classPath = explode( '_', $className );

	if ( $classPath[0] !== 'GoogleGAL' ) {
		return;
	}

	if ( count( $classPath ) > 3 ) {
		// Maximum class file path depth in this project is 3.
		$classPath = array_slice( $classPath, 0, 3 );
	}

	$classPath = str_replace( 'GoogleGAL', 'Google', $classPath ); // Adjust back to Google's path
	$filePath  = __DIR__ . '/core/' . implode( '/', $classPath ) . '.php'; // was src -> now core

	if ( file_exists( $filePath ) ) {
		require_once $filePath;
	}
}

spl_autoload_register( 'gal_google_api_php_client_autoload' );
