<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RecuperarSenhaForm extends CFormModel
{
	public $email;

	/**
	 * Declares the validation rules.
	 * The rules state that email and senha are required,
	 * and senha needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// email and senha are required
			array('email', 'required'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email'=>'E-mail',
		);
	}
	
	public function enviarEmail(){
		$usuario = Usuario::model()->findByAttributes(array('email'=>$this->email));
		
		if(is_object($usuario)){
			$message = new YiiMailMessage;
			$message->view = 'recuperar_senha';
			$message->setBody(array('usuario' => $usuario),'text/html','latin1');
			$message->subject = 'Recuperação de Senha'.' - '.date('d/m/Y H:i:s');
			$message->setTo($usuario->email);
			$message->setFrom(array('danielpocai@gmail.com.br'  => 'PraticAgro'));
			if(Yii::app()->mail->send($message)){
				return true;
			}
			$this->addError('email','E-mail encontrado, porém não foi possível realizar o envio, tente mais tarde.');
			return false;
		}
		
		$this->addError('email','E-mail não encontrado');
		return false;
	}

	
}
