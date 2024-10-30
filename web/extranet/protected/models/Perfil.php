<?php

Yii::import('application.models._base.BasePerfil');

class Perfil extends BasePerfil{
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function beforeSave() {
		$this->permissao = CJSON::encode($this->permissao);
		return parent::beforeSave();
	}
	
	public function afterFind(){
		$this->permissao = CJSON::decode($this->permissao,true);
		if(!is_array($this->permissao))
			$this->permissao = array();
		return parent::afterFind();
	}
	
	public function trataString($string){
		return preg_replace("/[^a-z\s]/", "", strtolower($string));
	}
	
	public function temPermissaoController($controller){
		$array_permissoes = $this->permissao;
		return is_array($array_permissoes[$this->trataString($controller)]);
	}
	
	public function temPermissaoAction($controller,$action){
		$array_permissoes = $this->permissao;
		if(is_array($array_modulo = $array_permissoes[$this->trataString($controller)])){
			return in_array(strtolower($action),$array_modulo);
		}
		return false;
	}
	
	public function representingLabel(){
		$field = $this->representingColumn();
		return $this->$field;
	}
	
	public function getCriteriaLogs(){
		$criteria = new CDbCriteria();
		$array_conditions = array();
		$array_conditions[] = "controller = 'site'";
		foreach($this->permissao as $controller => $actions){
			foreach($actions as $action){
				$array_conditions[] = "(controller = '".$controller."' AND action = '".$action."')";
				
			}
		}
		$criteria->addCondition(implode(' OR ',$array_conditions));
		$criteria->addCondition("acesso_status = 'sucesso'");
		
		return $criteria;
	}
	
	
	public function traduzAcao($action){
		$array_acao = array(
			'view' => 'Visualização',
			'create' => 'Cadastro',
			'update' => 'Atualização',
			'delete' => 'Exclusão',
			'status' => 'Alteração de status',
			'index' => 'Listagem',
		);
		$rota = strtolower($action);
		if(isset($array_acao[$rota ])){
			return $array_acao[$rota ];
		}
		return $action;
	}
	
	public function traduzModulo($controller){
		$array_modulo = array(
			'site' => 'Inicial',
		);
		$modulo = strtolower($controller);
		if(isset($array_modulo[$modulo])){
			return $array_modulo[$modulo];
		}
		return $controller;
	}
	
	

}