<?php

namespace App\Models;

use App\Libraries\Design;
use CodeIgniter\Database;
use CodeIgniter\Database\MySQLi;
use Config;

/*
 * Model
 *
 * @extends App\Libraries\Design
 *
 * @package App\Models
 */
abstract class Model extends Design\Singleton
{
	
	/*
	 * Database instance.
	 *
	 * @access Protected Readonly
	 *
	 * @values CodeIgniter\Database\ConnectionInterface
	 */
	protected Readonly Database\ConnectionInterface $driver;
	
	/*
	 * Model table instance.
	 *
	 * @access Public Readonly
	 *
	 * @values CodeIgniter\Database\MySQLi\Builder
	 */
	public Readonly MySQLi\Builder $table;
	
	/*
	 * @inherit App\Libraries\Design\Singleton
	 *
	 */
	protected function __construct( String $table )
	{
		$this->driver = Config\Database::connect();
		$this->table = $this->driver->table(
			$table
		);
	}
	
	/*
	 * Return if record exists.
	 * 
	 * @access Public Static
	 * 
	 * @params Array|String $column
	 * @params Mixed $value
	 * 
	 * @return Bool
	 */
	public static function exists( Array | String $column, Mixed $value = Null ): Bool
	{
		return( self::self() )->table->where( $column, $value )->get()->getRowArray() ? True : False;
	}
	
	public static function delete( Array $where ): Bool
	{
		return( self::self() )->table->where( ...$where )->delete();
	}
	
	/*
	 * Insert new record.
	 *
	 * @access Public Static
	 *
	 * @params Array $column
	 *
	 * @return Bool
	 */
	public static function insert( Array $column ): Bool
	{
		return( self::self() )->table->insert( $column );
	}
	
	public static function select( Array $where, Array | String $column = [], Int $limit = 100 ): Array
	{
		if( $where !== [] )
		{
			self::self()->table->where( ...$where );
		}
		return( self::selectAll( $column, $limit ) );
	}
	
	public static function selectAll( Array | String $column = [], Int $limit = 100 ): Array
	{
		return( self::self() )->table->select( $column !== [] ? $column : "*" )->limit( $limit )->get()->getResult();
	}
	
	public static function update( Array $where, Array | String $column ): Bool
	{
		return( self::self() )->table->where( ...$where )->set( $column )->update();
	}
	
}

?>