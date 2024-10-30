<?
class Dicionario{
	
	public static $array_modulo = array(
		'site' => 'Inicial',
	);
	
	public static $array_acao = array(
		'view' => 'Visualização',
		'create' => 'Cadastro',
		'update' => 'Atualização',
		'delete' => 'Exclusão',
		'status' => 'Alteração de status',
		'index' => 'Listagem',
	);
	
	public static function modulo($controller){
		
		if(isset(self::$array_modulo[$controller])){
			return self::$array_modulo[$controller];
		}
		
		$class = str_replace("Controller","",$controller);
		if (is_file(Yii::app()->basePath.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.$class.".php")) {
			$model_permissao = new $class();
			$modulo = $model_permissao->label(2);
		}
		else{
			$modulo = $class;
		}
		return $modulo;
	}
	
	public static function acao($action){
		$rota = strtolower($action);
		if(isset(self::$array_acao[$rota])){
			return self::$array_acao[$rota];
		}
		return $action;
	}
	
}