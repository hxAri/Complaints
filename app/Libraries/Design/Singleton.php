<?php

namespace App\Libraries\Design;

use TypeError;

/*
 * Singleton
 * 
 * @package App\Libraries\Design\Singleton
 */
abstract class Singleton
{

	/*
	 * Singleton class instance stack.
	 *
	 * @access Static Private
	 *
	 * @values Array
	 */
	static private $instances = [];
	
	/*
	 * Construct method of class Singleton.
	 * Is not allowed to call from outside to
	 * prevent from creating multiple instances.
	 *
	 * @access Protected
	 *
	 * @return Void
	 */
	protected function __construct() {}
	
	/*
	 * Prevent the instance from being cloned.
	 *
	 * @access Protected
	 *
	 * @return Void
	 */
	final protected function __clone() {}

	/*
	 * Prevent from being unserialized.
	 * Or which would create a second instance of it.
	 *
	 * @access Public
	 *
	 * @return Void
	 *
	 * @throws TypeError
	 */
	final public function __wakeup()
	{
		throw new TypeError( sprintf( "Cannot unserialize %s", $this::class ) );
	}
	
	/*
	 * Gets the instance via lazy initialization.
	 *
	 * @access Public Static
	 *
	 * @return App\Libraries\Design\Singleton
	 */
	final public static function self()
	{
		// Current singleton class is not exists.
		if( isset( static::$instances[static::class] ) === False )
		{
			static::$instances[static::class] = new Static( ...func_get_args() );
		}
		return( static::$instances[static::class] );
	}
	
}

?>