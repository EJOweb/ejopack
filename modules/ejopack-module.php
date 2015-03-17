<?php
/**
 * Parent class of EJOpack's modules
 *
 * @since  0.2.0
 */
abstract class EJOpack_Module 
{
	//* Holds the instance of this class.
	protected static $instance;

	//*
	final public static function get_slug( $file = '' )
	{
		if (!empty($file)) {
			return basename( $file, ".php" );
		}

		return $file;
	}

	//* Get version number
	protected static function get_version( $file = __FILE__ )
	{
		//* Get metadata of this plugin
		$plugin_data = get_file_data( $file, array('Version' => 'Version') );

		//* Return version number
		return $plugin_data['Version'];
	}

	//* Returns the instance.
	final public static function init() 
	{
		if ( !static::$instance )
			static::$instance = new static;

		return static::$instance;
	}

	//* Cloning would create a second instance of the Singleton class, so disallow it and trigger and error.
	final public function __clone() {
		trigger_error("Unable to clone singleton class __CLASS__", E_USER_ERROR);
	}

	//* Unserializing can create a second instance of the Singleton class, so disallow it and trigger and error.
	final public function __wakeup() {
		trigger_error("Unable to unserialize singleton class __CLASS__", E_USER_ERROR);
	}
}