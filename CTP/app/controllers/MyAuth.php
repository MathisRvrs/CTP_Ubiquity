<?php
namespace controllers;
use models\User;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\orm\DAO;
use Ubiquity\utils\http\UResponse;
use Ubiquity\utils\http\USession;
use Ubiquity\utils\http\URequest;
use controllers\auth\files\MyAuthFiles;
use Ubiquity\controllers\auth\AuthFiles;

class MyAuth extends \Ubiquity\controllers\auth\AuthController{

	protected function onConnect($connected) {
		$urlParts=$this->getOriginalURL();
		USession::set($this->_getUserSessionKey(), $connected);
		if(isset($urlParts)){
			$this->_forward(implode("/",$urlParts));
		}else{
		}
	}

    /**
     * @return bool
     */
    public function isInvalid(): bool
    {
        return $this->_invalid;
    }

	protected function _connect() {
		if(URequest::isPost()){
			$email=URequest::post($this->_getLoginInputName());
			$password=URequest::post($this->_getPasswordInputName());
			$user=DAO::getOne(User::class,'email= ?', false, [$email]);
		}
        if ($user != null){
            USession::set('name', $user->getName());
            if (URequest::password_verify('password', $user->getPassword())){
                return $user;
            }
            return $user;
        }
		return;
	}

    /**
	 * {@inheritDoc}
	 * @see \Ubiquity\controllers\auth\AuthController::isValidUser()
	 */
	public function _isValidUser($action=null): bool {
		return USession::exists($this->_getUserSessionKey());
	}

	public function _getBaseRoute(): string {
		return '/MyAuth';
	}
	
	protected function getFiles(): AuthFiles{
		return new MyAuthFiles();
	}

}
