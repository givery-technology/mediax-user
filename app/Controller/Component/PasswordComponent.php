<?php 
App::uses('Component', 'Controller');

class PasswordComponent extends Component {

	var $password_length = 8;
	var $password_charlist = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$";

	public function getRandomPassword(){
		do{
			$password = $this->createRandomPassword();
		} while ( $this->isVulnerable($password) === true );
		return $password;
	}

	private function createRandomPassword(){
		return substr(str_shuffle($this->password_charlist), 0, $this->password_length);
	}

	private function isVulnerable( $password ){
		if( preg_match("/[0-9]{1,}/", $password) &&
			preg_match("/[a-z]{1,}/", $password) &&
			preg_match("/[A-Z]{1,}/", $password)){
			return false;
		} else {
			return true;
		}
	}
}
?>