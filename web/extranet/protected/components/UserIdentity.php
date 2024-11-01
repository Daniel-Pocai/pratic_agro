<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	 
	public function authenticate($senha_encript = false){
		
		$criteria = new CDbCriteria();
		$criteria->addCondition("email = '".$this->username."'");
		$criteria->addCondition("habilitar = '1'");
		$usuario = Usuario::model()->find($criteria);
	
		if(!is_object($usuario))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif(!$usuario->senhaValida($this->password,$senha_encript = false))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else{
			$this->setState('obj',$usuario);
			$this->setState('pageSize',Yii::app()->params['defaultPageSize']);
			$this->errorCode=self::ERROR_NONE;
		}
		return !$this->errorCode;
	}
}