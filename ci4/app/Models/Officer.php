<?php

namespace App\Models;

/*
 * Officer
 *
 * @extends App\Models\Model
 *
 * @package App\Models
 */
final class Officer extends Model
{
	
	/*
	 * @inherit App\Models\Model
	 *
	 */
	protected function __construct()
	{
		parent::__construct( "officer" );
	}
	
}

?>