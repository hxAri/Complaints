<?php

namespace App\Models;

use DateTime;
use DateTimeZone;

/*
 * Complaint
 *
 * @extends App\Models\Model
 *
 * @package App\Models
 */
final class Complaint extends Model
{
	
	/*
	 * @inherit App\Models\Model
	 *
	 */
	protected function __construct()
	{
		parent::__construct( "complaint" );
	}
	
	/*
	 * @inherit App\Models\Model
	 *
	 */
	public static function select( Array $where, Array | String $column = [], Int $limit = 100 ): Array
	{
		return( self::resolve( parent::select( $where, $column, $limit ) ) );
	}
	
	/*
	 * @inherit App\Models\Model
	 *
	 */
	public static function selectAll( Array | String $column = [], Int $limit = 100 ): Array
	{
		return( self::resolve( parent::selectAll( $column, $limit ) ) );
	}
	
	/*
	 * Resolve column results.
	 *
	 * @access Private Static
	 *
	 * @params Array $results
	 *
	 * @return Array
	 */
	private static function resolve( Array $results ): Array
	{
		foreach( $results As $result )
		{
			$result->date = new DateTime( "now", new DateTimeZone( "Asia/Jakarta" ) );
			$result->date = $result->date->setTimestamp( $result->timestamp )->format( "d, M-Y H:i" );
			$result->response = Response::select([ "complaint", $result->id ])[0] ?? False;
			$result->complainer = Publics::select([ "nik", $result->publics ], [
				"avatar",
				"fullname",
				"username"
			])[0];
		}
		return( $results );
	}
	
}

?>