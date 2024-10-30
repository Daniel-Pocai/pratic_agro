<?php

Yii::import('application.models._base.BaseUsuarioLog');

class UsuarioLog extends BaseUsuarioLog
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function beforeSave(){
		
		$this->ip = getenv("REMOTE_ADDR");
		$this->data = date('Y-m-d H:i:s');
		
		if(!Yii::app()->user->isGuest){
			$this->idusuario = Yii::app()->user->obj->idusuario;
			$this->usuario_nome = Yii::app()->user->obj->nome; 
			$this->usuario_email = Yii::app()->user->obj->email;
		}
		
		$this->session_id = session_id();
		
		//{{beforeSave}}
		$get = $_GET;
		$post = $_POST;
		$session = $_SESSION;
		$server = $_SERVER;
		$cookies = $_COOKIE;
		
		UsuarioLog::removerSenha($get);
		UsuarioLog::removerSenha($post);
		UsuarioLog::removerSenha($session);
		UsuarioLog::removerSenha($server);
		UsuarioLog::removerSenha($cookies);
		
		$this->get = CJSON::encode($get);
		$this->post = CJSON::encode($post);
		$this->session = CJSON::encode($session);
		$this->server = CJSON::encode($server);
		$this->cookies = CJSON::encode($cookies);
		
		$dados_cliente = $this->getDadosCliente();
		
		$this->so = $dados_cliente['platform'];
		$this->navegador_agent = $dados_cliente['userAgent'];
		$this->navegador_nome = $dados_cliente['name'];
		$this->navegador_versao = $dados_cliente['version'];
		
		return parent::beforeSave();
	}
	
	
	
	public function afterFind(){
		if($this->data != "")
			$this->data = Util::formataDataHoraApp($this->data);
		//{{afterFind}}
		return parent::afterFind();
	}
	
	public static function removerSenha(&$input,$name = NULL) {
		if (!is_array($input) && !is_object($input)) {
			if($name == 'senha' || strpos($name, '_senha') !== false || strpos($name, 'senha_') !== false){
				$input = "*****";
			}
		} 
		elseif (is_array($input)) {
			foreach ($input as $name => &$value) {
				UsuarioLog::removerSenha($value,$name);
			}
			unset($value);
		}
	}
	
	public function getDadosCliente() {
		
			$ip = $_SERVER['REMOTE_ADDR'];
			$u_agent = $_SERVER['HTTP_USER_AGENT'];
			$bname = 'Unknown';
			$platform = 'Unknown';
			$version= "";
		
			if (preg_match('/linux/i', $u_agent)) {
				$platform = 'Linux';
			}
			elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
				$platform = 'Mac';
			}
			elseif (preg_match('/windows|win32/i', $u_agent)) {
				$platform = 'Windows';
			}
		
			if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
			{
				$bname = 'Internet Explorer';
				$ub = "MSIE";
			}
			elseif(preg_match('/Firefox/i',$u_agent))
			{
				$bname = 'Mozilla Firefox';
				$ub = "Firefox";
			}
			elseif(preg_match('/Chrome/i',$u_agent))
			{
				$bname = 'Google Chrome';
				$ub = "Chrome";
			}
			elseif(preg_match('/AppleWebKit/i',$u_agent))
			{
				$bname = 'AppleWebKit';
				$ub = "Opera";
			}
			elseif(preg_match('/Safari/i',$u_agent))
			{
				$bname = 'Apple Safari';
				$ub = "Safari";
			}
		
			elseif(preg_match('/Netscape/i',$u_agent))
			{
				$bname = 'Netscape';
				$ub = "Netscape";
			}
		
			$known = array('Version', $ub, 'other');
			$pattern = '#(?<browser>' . join('|', $known) .
			')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
			if (!preg_match_all($pattern, $u_agent, $matches)) {
			}
		
		
			$i = count($matches['browser']);
			if ($i != 1) {
				if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
					$version= $matches['version'][0];
				}
				else {
					$version= $matches['version'][1];
				}
			}
			else {
				$version= $matches['version'][0];
			}
		
			// check if we have a number
			if ($version==null || $version=="") {$version="?";}
		
			return array(
				'userAgent' => $u_agent,
				'name'      => $bname,
				'version'   => $version,
				'platform'  => $platform,
				'pattern'    => $pattern
			);
		}
	
}