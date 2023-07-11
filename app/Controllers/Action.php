<?php

namespace App\Controllers;

use App\Models;
use CodeIgniter\HTTP;
use DateTime;
use DateTimeZone;
use Error;
use Throwable;

/*
 * Action
 *
 * @extends App\Controllers\BaseController
 *
 * @package App\Controllers
 */
final class Action extends BaseController
{
	
	/*
	 * Default avatars.
	 *
	 * @access Public Static
	 *
	 * @values String
	 */
	public const AVATAR = "/dist/img/1681439839;68jqGs2jcp.png";
	public const AVATAR_ADMIN = "/dist/img/1681439839;f7WYVV7.mG.png";
	public const AVATAR_OFFICER = "/dist/img/1681439839;ddLgSJGhL..png";
	
	/*
	 * Officer enum index.
	 *
	 * @access Public Static
	 *
	 * @values Array
	 */
	public const LEVELS = [
		"admin" => 1,
		"officer" => 2
	];
	
	/*
	 * Return if user has authenticated.
	 *
	 * @access Public
	 *
	 * @return Bool
	 */
	public function auth(): Bool
	{
		if( session()->has( "level" ) &&
			session()->has( "login" ) )
		{
			return( True );
		}
		else {
			if( has_cookie( "level" ) &&
				has_cookie( "login" ) )
			{
				return([ session()->set([ "level" => get_cookie( "level" ), "login" => get_cookie( "login" ) ]), True ][1]);
			}
		}
		return( False );
	}
	
	/*
	 * Authenticate user.
	 *
	 * @access Public
	 *
	 * @params String $login
	 * @params String $level
	 *
	 * @return Void
	 */
	public function authenticate( String $login, String $level ): Void
	{
		set_cookie( "level", $level, expire: 360, path: "/" );
		set_cookie( "login", $login, expire: 360, path: "/" );
		session()->set([
			"level" => $level,
			"login" => $login
		]);
	}
	
	/*
	 * Delete officer and publics account.
	 *
	 * @access Public
	 *
	 * @return CodeIgniter\HTTP\RedirectResponse
	 */
	public function deleteAccount(): HTTP\RedirectResponse
	{
		// Check if current login session is Officer or Publics.
		if( $this->isPublics() || 
			$this->isOfficer() && $this->isAdmin() === False )
		{
			try
			{
				// If current login session is Publics.
				if( $this->isPublics() )
				{
					 // Check if account successfull deleted.
					 if( Models\Publics::delete([ "nik", $this->request->getPost( "nik" ) ]) )
					 {
					 	return([ $this->logout(), redirect()->to( base_url( "/signin?trigger=info&&text=Akun+berhasil+dihapus" ) ) ][1]);
					 }
				}
				else {
					
					// Check if account successfull deleted.
					if( Models\Officer::delete([ "id", $this->request->getPost( "id" ) ]) )
					{
						return([ $this->logout(), redirect()->to( base_url( "/signin/officer?trigger=info&&text=Akun+berhasil+dihapus" ) ) ][1]);
					}
				}
				throw new Error( "Terjadi kesalahan saat menghapus akun" );
			}
			catch( Throwable $e )
			{
				return( redirect() )->to( base_url( "/?tab=profile&&trigger=error&&text=" . $e->getMessage() ) );
			}
		}
		else {
			return( redirect() )->to( base_url( uri_string() ) );
		}
	}
	
	/*
	 * Delete officer account.
	 *
	 * @access Public
	 *
	 * @return CodeIgniter\HTTP\RedirectResponse
	 */
	public function deleteOfficer(): HTTP\RedirectResponse
	{
		// Check if current login session is Admin.
		if( $this->isAdmin() )
		{
			try
			{
				// Check if officer successfull deleted.
				if( Models\Officer::delete([ "username", $this->request->getPost( "username" ) ]) )
				{
					return( redirect() )->to( base_url( "/?tab=officer&&trigger=success&&text=Petugas+berhasil+dihapus" ) );
				}
				throw new Error( "Terjadi kesalahan saat menghapus petugas" );
			}
			catch( Throwable $e )
			{
				return( redirect() )->to( base_url( "/?tab=officer&&trigger=error&&text=" . $e->getMessage() ) );
			}
		}
		else {
			return( redirect() )->to( base_url( uri_string() ) );
		}
	}
	
	/*
	 * Delete publics account.
	 *
	 * @access Public
	 *
	 * @return CodeIgniter\HTTP\RedirectResponse
	 */
	public function deletePublics(): HTTP\RedirectResponse
	{
		// Check if current login session is Admin.
		if( $this->isAdmin() )
		{
			try
			{
				// Check if publics successfull deleted.
				if( Models\Publics::delete([ "username", $this->request->getPost( "username" ) ]) )
				{
					return( redirect() )->to( base_url( "/?tab=publics&&trigger=success&&text=Masyarakat+berhasil+dihapus" ) );
				}
				throw new Error( "Terjadi kesalahan saat menghapus masyarakat" );
			}
			catch( Throwable $e )
			{
				return( redirect() )->to( base_url( "/?tab=publics&&trigger=error&&text=" . $e->getMessage() ) );
			}
		}
		else {
			return( redirect() )->to( base_url( uri_string() ) );
		}
	}
	
	/*
	 * Insert new complaint record.
	 *
	 * @access Public
	 *
	 * @return CodeIgniter\HTTP\RedirectResponse
	 */
	public function insertComplaint(): HTTP\RedirectResponse
	{
		// Check if current login session is Publics.
		if( $this->isPublics() )
		{
			// Get uploaded file.
			$picturef = $this->request->getFile( "picture" );
			
			// Replace double newline in the contents.
			$contents = $this->request->getPost( "content" ) ?? "";
			
			// Check if file is corrupt.
			if( $picturef->getError() )
			{
				return( redirect() )->to( base_url( "/?tab=report-make&&trigger=warning&&text=Gambar+rusak+atau+cacat" ) );
			}
			else {
				
				try
				{
					// Get publics NIK.
					$nik = Models\Publics::select([ "username", session()->get( "login" ) ])[0] ?? False;
					
					// If successfull get publics NIK.
					if( $nik )
					{
						$nik = $nik->nik;
					}
					else {
						return([ $this->logout(), redirect()->to( base_url( "/signin?trigger=warning&&text=Pengguna+tidak+ditemukan+atau+sesi+login+tidak+sah" ) ) ][1]);
					}
					
					// Get current timestamp.
					$datetime = new DateTime( "now", new DateTimeZone( "Asia/Jakarta" ) );
					$timestamp = $datetime->getTimestamp();
					
					// Split picture name.
					$picture = explode( ".", $picturef->getName() );
					
					// Create new picture name.
					$picture = sprintf( "/dist/img/%d;%s.%s", $timestamp, bin2hex( random_bytes( 8 ) ), array_pop( $picture ) );
					
					// Move uploaded file into front controller path.
					if( move_uploaded_file( $picturef->getTempName(), FCPATH . $picture ) )
					{
						// Save complaint into database record.
						$insert = Models\Complaint::insert([
							"publics" => $nik,
							"status" => "pending",
							"picture" => $picture,
							"contents" => $contents,
							"timestamp" => $timestamp
						]);
						
						// If data inserted.
						if( $insert )
						{
							return( redirect() )->to( base_url( "/?tab=report-make&&trigger=success&&text=Laporan+berhasil+dikirimkan" ) );
						}
						throw new Error( "Terjadi kesalahan saat mengirim laporan" );
					}
					throw new Error( "Terjadi kesalahan saat memindahkan gambar" );
				}
				catch( Throwable $e )
				{
					return( redirect() )->to( base_url( "/?tab=report-make&&trigger=error&&text=" . $e->getMessage() ) );
				}
			}
		}
		else {
			return( redirect() )->to( base_url( uri_string() ) );
		}
	}
	
	/*
	 * Insert new response record.
	 *
	 * @access Public
	 *
	 * @return CodeIgniter\HTTP\RedirectResponse
	 */
	public function insertResponse(): HTTP\RedirectResponse
	{
		// Check if current login session is Officer.
		if( $this->isOfficer() )
		{
			// Get current timestamp.
			$datetime = new DateTime( "now", new DateTimeZone( "Asia/Jakarta" ) );
			$timestamp = $datetime->getTimestamp();
			
			try
			{
				// Insert new response.
				$insert = Models\Response::insert([
					"officer" => $this->request->getPost( "id-officer" ),
					"complaint" => $this->request->getPost( "id-report" ),
					"response" => $this->request->getPost( "response" ),
					"timestamp" => $timestamp
				]);
				
				// Check if response successfull inserted.
				if( $insert )
				{
					return( redirect() )->to( base_url( "/?tab=report-validate&&trigger=success&&text=Tanggapan+laporan+telah+disimpan" ) );
				}
				throw new Error( "Terjadi kesalahan saat menambahkan tanggapan" );
			}
			catch( Throwable $e )
			{
				return( redirect() )->to( base_url( "/?tab=report-validate&&trigger=error&&text=" . $e->getMessage() ) );
			}
		}
		else {
			return( redirect() )->to( base_url( uri_string() ) );
		}
	}
	
	/*
	 * Insert new officer account.
	 *
	 * @access Public
	 *
	 * @return CodeIgniter\HTTP\RedirectResponse
	 */
	public function insertOfficer(): HTTP\RedirectResponse
	{
		// Check if current login session is Admin.
		if( $this->isAdmin() )
		{
			try
			{
				// Create officer payload.
				$payload = [
					
					"fullname" => $this->request->getPost( "fullname" ),
					"username" => strtolower( $this->request->getPost( "username" ) ),
					"callable" => $this->request->getPost( "callable" ),
					
					// Hashing password.
					"password" => password_hash(
						
						// Get password from post request.
						$this->request->getPost( "password" ),
						
						// Use default hashing algorithm.
						PASSWORD_DEFAULT
					)
				];
				
				// Check if username is exsists.
				if( Models\Officer::exists([ "username" => $payload['username'] ]) )
				{
					return( redirect() )->to( base_url( "/?tab=officer&&trigger=warning&&text=Nama+Pengguna+telah+digunakan" ) );
				}
				
				// Check if officer successfull signup.
				if( Models\Officer::insert( $payload ) )
				{
					return( redirect() )->to( base_url( "/?tab=officer&&trigger=success&&text=Petugas+berhasil+ditambahkan" ) );
				}
				throw new Error( "Terjadi kesalahan saat menambahkan petugas" );
			}
			catch( Throwable $e )
			{
				return( redirect() )->to( base_url( "/?tab=officer&&trigger=error&&text=" . $e->getMessage() ) );
			}
		}
		else {
			return( redirect() )->to( base_url( uri_string() ) );
		}
	}
	
	/*
	 * Return if current login session is Admin.
	 *
	 * @access Public
	 *
	 * @return Bool
	 */
	public function isAdmin(): Bool
	{
		return( $this->auth() && session()->get( "level" ) === "admin" );
	}
	
	/*
	 * Return if current login session is Guest.
	 *
	 * @access Public
	 *
	 * @return Bool
	 */
	public function isGuest(): Bool
	{
		return( $this->auth() === False );
	}
	
	/*
	 * Return if current login session is Officer.
	 *
	 * @access Public
	 *
	 * @return Bool
	 */
	public function isOfficer(): Bool
	{
		return( $this->auth() && session()->get( "level" ) === "officer" || $this->isAdmin() );
	}
	
	/*
	 * Return if current login session is Publics.
	 *
	 * @access Public
	 *
	 * @return Bool
	 */
	public function isPublics(): Bool
	{
		return( $this->auth() && session()->get( "level" ) === "publics" );
	}
	
	/*
	 * Logout from current session.
	 *
	 * @access Public
	 *
	 * @return Void
	 */
	public function logout(): Void
	{
		delete_cookie( "level", path: "/" );
		delete_cookie( "login", path: "/" );
		session()->remove([
			"level",
			"login"
		]);
	}
	
	/*
	 * Handle publics and officer signin.
	 *
	 * @access Public
	 *
	 * @return CodeIgniter\HTTP\RedirectResponse
	 */
	public function signin(): HTTP\RedirectResponse
	{
		// Check if user has authenticated.
		if( $this->auth() )
		{
			return( redirect() )->to( base_url( "/" ) );
		}
		else {
			
			$username = strtolower( $this->request->getPost( "username" ) );
			$password = $this->request->getPost( "password" );
			$signin = $this->request->getPost( "signin" ) ?? "publics";
			
			try
			{
				// If signin method is publics account.
				if( $signin === "publics" )
				{
					$user = Models\Publics::select([ "username", $username ])[0] ?? False;
				}
				else {
					$user = Models\Officer::select([ "username", $username ])[0] ?? False;
				}
				
				// Check if user is exists.
				if( $user )
				{
					// Check if password is invalid.
					if( password_verify( $password, $user->password ) === False )
					{
						throw new Error( "Kata sandi yang dimasukan salah" );
					}
				}
				else {
					throw new Error( sprintf( "Nama pengguna %s tidak ditemukan", $username ) );
				}
				$this->authenticate(
					login: $username,
					level: $user->level ?? "publics"
				);
				return( redirect() )->to( base_url( "/" ) );
			}
			catch( Throwable $e )
			{
				return( redirect() )->to( base_url( sprintf( "/%s?trigger=error&&text=%s", uri_string(), $e->getMessage() ) ) );
			}
		}
	}
	
	/*
	 * Handle publics signup.
	 *
	 * @access Public
	 *
	 * @return CodeIgniter\HTTP\RedirectResponse
	 */
	public function signup(): HTTP\RedirectResponse
	{
		// Check if user has authenticated.
		if( $this->auth() )
		{
			return( redirect() )->to( base_url( "/" ) );
		}
		else {
			
			// Create publics payload.
			$payload = [
				
				"nik" => $this->request->getPost( "nik" ),
				"fullname" => $this->request->getPost( "fullname" ),
				"username" => strtolower( $this->request->getPost( "username" ) ),
				"callable" => $this->request->getPost( "callable" ),
				
				// Hashing password.
				"password" => password_hash(
					
					// Get password from post request.
					$this->request->getPost( "password" ),
					
					// Use default hashing algorithm.
					PASSWORD_DEFAULT
				)
			];
			
			// Check if NIK is exsists.
			if( Models\Publics::exists([ "nik" => $payload['nik'] ]) )
			{
				return( redirect() )->to( base_url( "/signup?trigger=warning&&text=NIK+telah+digunakan+oleh+masyarakat+lain" ) );
			}
			
			// Check if username is exsists.
			if( Models\Publics::exists([ "username" => $payload['username'] ]) )
			{
				return( redirect() )->to( base_url( "/signup?trigger=warning&&text=Nama+Pengguna+telah+digunakan" ) );
			}
			
			try
			{
				// Check if publics successfull signup.
				if( Models\Publics::insert( $payload ) )
				{
					// Authenticate publics.
					$this->authenticate(
						login: $payload['username'],
						level: "publics"
					);
					return( redirect() )->to( base_url( "/" ) );
				}
				throw new Error( "Terjadi kesalahan saat melakukan pendaftaran" );
			}
			catch( Throwable $e )
			{
				return( redirect() )->to( base_url( "/signup?trigger=error&&text=" . $e->getMessage() ) );
			}
		}
	}
	
	/*
	 * Update officer and publics password.
	 *
	 * @access Public
	 *
	 * @return CodeIgniter\HTTP\RedirectResponse
	 */
	public function updatePassword(): HTTP\RedirectResponse
	{
		// Check if user has authenticated.
		if( $this->auth() )
		{
			// Get user username.
			$username = session()->get( "login" );
			
			try
			{
				// Get passwords.
				$password_new = $this->request->getPost( "password-new" );
				$password_old = $this->request->getPost( "password-old" );;
				
				// Create payload.
				$payload = [
					"password" => password_hash( $password_new, PASSWORD_DEFAULT )
				];
				
				// If current login session is Officer.
				if( $this->isOfficer() )
				{
					$user = Models\Officer::select([ "username", $username ])[0] ?? False;
				}
				else {
					$user = Models\Publics::select([ "username", $username ])[0] ?? False;
				}
				
				// Check if user is exists.
				if( $user )
				{
					// Check if password is invalid.
					if( password_verify( $password_old, $user->password ) === False )
					{
						throw new Error( "Kata sandi yang dimasukan salah" );
					}
					
					// Check if password is not changed.
					if( password_verify( $password_new, $user->password ) )
					{
						throw new Error( "Kata sandi harus berbeda dengan yang sebelumnya" );
					}
					
					// If current login session is Officer.
					if( $this->isOfficer() )
					{
						$update = Models\Officer::update( [ "username", $username ], $payload );
					}
					else {
						$update = Models\Publics::update( [ "username", $username ], $payload );
					}
					
					// If password updated successfully.
					if( $update )
					{
						return( redirect() )->to( base_url( "/?tab=profile&&trigger=success&&text=Password+berhasil+diperbarui" ) );
					}
					throw new Error( "Terjadi kesalahan saat memperbarui passwors" );
				}
				else {
					return([ $this->logout(), redirect()->to( base_url( "/signin?trigger=warning&&text=Pengguna+tidak+ditemukan+atau+sesi+login+tidak+sah" ) ) ][1]);
				}
			}
			catch( Throwable $e )
			{
				return( redirect() )->to( base_url( "/?tab=profile&&trigger=error&&text=" . $e->getMessage() ) );
			}
		}
		else {
			return( redirect() )->to( base_url( uri_string() ) );
		}
	}
	
	/*
	 * Update officer and publics profile.
	 *
	 * @access Public
	 *
	 * @return CodeIgniter\HTTP\RedirectResponse
	 */
	public function updateProfile(): HTTP\RedirectResponse
	{
		// Check if user has authenticated.
		if( $this->auth() )
		{
			$payload = [];
			$request = $this->request;
			
			// ...
			if( $fullname = $request->getPost( "fullname" ) ) $payload['fullname'] = $fullname;
			if( $callable = $request->getPost( "callable" ) ) $payload['callable'] = $callable;
			
			try
			{
				// If username change.
				if( ( $username = $request->getPost( "username" ) ) &&
					$username !== session()->get( "login" ) )
				{
					// If current login session is Officer.
					if( $this->isOfficer() )
					{
						// Check if username is exists.
						if( Models\Officer::exists([ "username" => $username ]) )
						{
							throw new Error( "Nama pengguna telah digunakan" );
						}
					}
					else {
						
						// Check if username is exists.
						if( Models\Publics::exists([ "username" => $username ]) )
						{
							throw new Error( "Nama pengguna telah digunakan" );
						}
					}
					$payload['username'] = $username;
				}
				
				// Reset profile picture.
				if( $avatar = $this->request->getPost( "avatar-name" ) )
				{
					// Avoid blob url from `URL.createObjectURL`
					if( $avatar === self::AVATAR && $this->isPublics() ||
						$avatar === self::AVATAR_ADMIN && $this->isAdmin() ||
						$avatar === self::AVATAR_OFFICER && $this->isOfficer() )
					{
						$payload['avatar'] = $avatar;
					}
					else {
						
						// If avatar change.
						if( $avatarf = $this->request->getFile( "avatar-file" ) )
						{
							// Check if file is corrupt.
							if( $avatarf->getError() )
							{
								return( redirect() )->to( base_url( "/?tab=profile&&trigger=warning&&text=Gambar+rusak+atau+cacat" ) );
							}
							
							// Get current timestamp.
							$datetime = new DateTime( "now", new DateTimeZone( "Asia/Jakarta" ) );
							$timestamp = $datetime->getTimestamp();
							
							// Split picture name.
							$avatar = explode( ".", $avatarf->getName() );
							
							// Create new picture name.
							$avatar = sprintf( "/dist/img/%d;%s.%s", $timestamp, bin2hex( random_bytes( 8 ) ), array_pop( $avatar ) );
							
							// Move uploaded file into front controller path.
							// When something wrong or error Error will thrown.
							if( move_uploaded_file( $avatarf->getTempName(), FCPATH . $avatar ) === False )
							{
								throw new Error( "Terjadi kesalahan saat memindahkan gambar" );
							}
							$payload['avatar'] = $avatar;
						}
					}
				}
				
				// If something has changes.
				if( count( $payload ) )
				{
					// Get user username.
					$username = session()->get( "login" );
					
					// If current login session is Officer.
					if( $this->isOfficer() )
					{
						$update = Models\Officer::update( [ "username", $username ], $payload );
					}
					else {
						$update = Models\Publics::update( [ "username", $username ], $payload );
					}
					
					// If profile updated successfully.
					if( $update )
					{
						// Update user authentication.
						$this->authenticate(
							level: $this->isPublics() ? "publics" : ( $this->isAdmin() ? "admin" : "officer" ),
							login: $payload['username'] ?? $username
						);
						return( redirect() )->to( base_url( "/?tab=profile&&trigger=success&&text=Profil+berhasil+diperbarui" ) );
					}
					throw new Error( "Terjadi kesalahan saat memperbarui profile" );
				}
			}
			catch( Throwable $e )
			{
				return( redirect() )->to( base_url( "/?tab=profile&&trigger=error&&text=" . $e->getMessage() ) );
			}
		}
		else {
			return( redirect() )->to( base_url( uri_string() ) );
		}
	}
	
	/*
	 * Update or verify publics complaint.
	 *
	 * @access Public
	 *
	 * @return CodeIgniter\HTTP\RedirectResponse
	 */
	public function updateVerifyReport(): HTTP\RedirectResponse
	{
		// If current login session is Officer.
		if( $this->isOfficer() )
		{
			try
			{
				// Check if complaint successfull verify.
				if( Models\Complaint::update( [ "id", $this->request->getPost( "id" ) ], [ "status" => "process" ] ) )
				{
					return( redirect() )->to( base_url( "/?tab=report-verify&&trigger=success&&text=Laporan+pengaduan+telah+di+verifikasi" ) );
				}
				throw new Error( "Terjadi kesalahan saat melakukan verifikasi laporan pengaduan" );
			}
			catch( Throwable $e )
			{
				return( redirect() )->to( base_url( "/?tab=report-verify&&trigger=error&&text=" . $e->getMessage() ) );
			}
		}
		else {
			return( redirect() )->to( base_url( uri_string() ) );
		}
	}
	
}

?>