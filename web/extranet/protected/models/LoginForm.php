<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $email;
	public $senha;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that email and senha are required,
	 * and senha needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// email and senha are required
			array('email, senha', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// senha needs to be authenticated
			array('senha', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
		);
	}

	/**
	 * Authenticates the senha.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->email,$this->senha);
			if(!$this->_identity->authenticate())
				$this->addError('senha','Incorrect email or senha.');
		}
	}

	/**
	 * Logs in the user using the given email and senha in the model.
	 * @return boolean whether login is successful
	 */
	public function login($senha_encript = true)
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->email,$this->senha);
			$this->_identity->authenticate($senha_encript = true);
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}
