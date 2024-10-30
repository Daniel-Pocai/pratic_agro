<?php

Yii::import('application.models._base.BaseUsuario');

class Usuario extends BaseUsuario
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function cryptoSenha($senha){
		return md5('&xh1%2as$(px827%-'.$senha);
	}
	
	public function senhaValida($senha,$senha_encript = false){
		if(!$senha_encript)
			return $this->cryptoSenha($senha) == $this->senha;
		return $senha == $this->senha;
	}
	
	public function beforeSave(){
		if ($this->senha != "") {
			$this->senha = $this->cryptoSenha($this->senha);
		}
		elseif(!$this->isNewRecord){
			unset($this->senha);
		}
		return parent::beforeSave();
	}
	
	public function enviarEmailRecuperarSenha() {
		
		$usuario_recupera_senha = new UsuarioRecuperaSenha();
		$usuario_recupera_senha->ip = $_SERVER["REMOTE_ADDR"];
		$usuario_recupera_senha->data_solicitacao = date('d/m/Y H:i:s');
		$usuario_recupera_senha->idusuario = $this->idusuario;
		$usuario_recupera_senha->email = $this->email;
		$usuario_recupera_senha->token = md5($this->email.time());
		$usuario_recupera_senha->data_validade = date('d/m/Y H:i:s', strtotime('+2 days'));
		
		if($usuario_recupera_senha->save()){
			$usuario_recupera_senha->refresh();
			
			$message = new YiiMailMessage;
			$message->view = 'recuperar_senha_usuario';
			$message->setBody(array('usuario' => $this, "usuario_recupera_senha"=> $usuario_recupera_senha),'text/html','latin1');
			$message->subject = 'Recuperação de Senha';
			$message->addTo($this->email);
			$message->setFrom(array(Yii::app()->mail->transportOptions['username'] => Yii::app()->name));
			Yii::app()->mail->send($message);
			
			
		}
		
    }
	

}