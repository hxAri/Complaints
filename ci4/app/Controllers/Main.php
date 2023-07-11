<?php

namespace App\Controllers;

use App\Models;
use CodeIgniter\HTTP;

/*
 * Main
 *
 * @extends App\Constrollers\BaseController
 *
 * @package App\Controllers
 */
final class Main extends BaseController
{
	
	/*
	 * Instance of Action controller.
	 *
	 * @access Private Readonly
	 *
	 * @values App\Controllers\Action
	 */
	private Readonly Action $action;
	
	/*
	 * Construct method of class Main.
	 *
	 * @access Public Instance
	 *
	 * @return Void
	 */
	public function __construct()
	{
		$this->action = new Action();
	}
	
	/*
	 * Return application view.
	 *
	 * @access Public
	 *
	 * @return Mixed
	 */
	public function main(): Mixed
	{
		$data = [
			"login" => [
				"level" => Null,
				"session" => Null
			],
			"profile" => [
				"id" => 0,
				"nik" => null,
				"avatar" => null,
				"fullname" => null,
				"username" => null,
				"callable" => null
			],
			"account" => [
				"officer" => [],
				"publics" => []
			],
			"reports" => [
				"pending" => [],
				"process" => [],
				"finish" => [],
				"commons" => []
			]
		];
		
		// Check if user has authenticate.
		if( $this->action->auth() )
		{
			$data['login'] = [
				"level" => session()->get( "level" ) ?? get_cookie( "level" ),
				"session" => session()->get( "login" ) ?? get_cookie( "login" )
			];
			
			// If current login session is Publics.
			if( $this->action->isPublics() )
			{
				// Get Publics by username.
				$user = Models\Publics::select(
					where: [[
						"username" => $data['login']['session']
					]]
				);
				
				// If user is exsists.
				if( $user = $user[0] ?? False )
				{
					$data['profile'] = [
						"id" => 0,
						"nik" => $user->nik,
						"avatar" => $user->avatar,
						"fullname" => $user->fullname,
						"username" => $user->username,
						"callable" => $user->callable
					];
					$data['reports'] = [
						"pending" => Models\Complaint::self()->select([
							[
								"status" => "pending",
								"publics" => $user->nik
							]
						]),
						"process" => Models\Complaint::self()->select([
							[
								"status" => "process",
								"publics" => $user->nik
							]
						]),
						"finish" => Models\Complaint::self()->select([
							[
								"status" => "success",
								"publics" => $user->nik
							]
						]),
					];
				}
				else {
					$this->action->logout();
					$data['login'] = [
						"level" => Null,
						"session" => Null
					];
				}
			}
			else {
				
				// Get officer by username and level.
				$officer = Models\Officer::select([
					[
						"level" => Action::LEVELS[$data['login']['level']],
						"username" => $data['login']['session']
					]
				]);
				
				// If officer is available.
				if( $officer = $officer[0] ?? False )
				{
					$data['profile'] = [
						"id" => $officer->id,
						"nik" => Null,
						"avatar" => $officer->avatar,
						"fullname" => $officer->fullname,
						"username" => $officer->username,
						"callable" => $officer->callable
					];
					$data['reports'] = [
						"pending" => Models\Complaint::self()->select([
							"status",
							"pending"
						]),
						"process" => Models\Complaint::self()->select([
							"status",
							"process"
						])
					];
					
					// If current login session of officer is Admin.
					if( $this->action->isAdmin() )
					{
						$data['account'] = [
							"publics" => Models\Publics::self()->selectAll([
								"nik",
								"avatar",
								"fullname",
								"username",
								"callable",
							]) ?? [],
							"officer" => Models\Officer::self()->select(
								column: [
									"id",
									"avatar",
									"fullname",
									"username",
									"callable",
									"level"
								],
								where: [
									"level",
									"officer"
								]
							) ?? []
						];
					}
				}
				else {
					$this->action->logout();
					$data['login'] = [
						"level" => Null,
						"session" => Null
					];
				}
			}
		}
		
		// Get all validated reports.
		$data['reports']['commons'] = Models\Complaint::self()->select(
			where: [[
				"status" => "success"
			]]
		);
		
		// Return view application.
		return( view( "main", [ "data" => json_encode( $data, JSON_INVALID_UTF8_IGNORE | JSON_INVALID_UTF8_SUBSTITUTE ) ] ) );
	}
	
	/*
	 * @inherit App\Controllers\Action
	 *
	 * @return CodeIgniter\HTTP\RedirectResponse
	 */
	public function logout(): HTTP\RedirectResponse
	{
		return([ $this->action->logout(), redirect()->to( base_url( "/signin?trigger=info&&text=Session+has+been+deleted" ) ) ][1]);
	}
	
}

?>