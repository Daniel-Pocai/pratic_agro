<?php
header("Content-type:text/html;charset=iso-8859-1");
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	public $rel=array();

	public $rel_conditions = array();
	public $rel_link = array();

	public $model;
	public $idusuario_log;

	public function beforeAction($action){
        
		if($this->id!='thumbnail'){
            InjectionBlocker::run(false);
        }

		$usuario_log = new UsuarioLog();
		$usuario_log->controller = $this->id;
		$usuario_log->action = $action->id;
		$usuario_log->acesso_status = 'erro';

		if(is_numeric($_GET['n_reg']) && $_GET['n_reg'] != 0){
			Yii::app()->user->pageSize = $_GET['n_reg'];
		}

		$routes_public = array(
			'site/login',
			'site/esqueci_senha',
			'site/recuperacao_senha',
			'site/logout',
			'site/cidades',
            'site/error',
			'thumbnail/*',
		);

		$routes_no_log = array(
			'thumbnail/*',
		);

		$routes_logged = array(
			'site/index',
			'site/actions',
			'site/upload',
			'site/plupload',
			'site/base64upload',
			'*/ordenacao'
		);

		$current_route = $this->id.'/'.$this->action->id;

		//Rota pública
		//if(in_array($current_route,$routes_public)){
		if(in_array($this->id.'/*',$routes_public)|| in_array('*/'.$this->action->id,$routes_public) || in_array($current_route,$routes_public)){
			$usuario_log->acesso_status = 'sucesso';

			if(!in_array($this->id.'/*',$routes_no_log) && !in_array($current_route,$routes_no_log)){
				$usuario_log->save();
			}

			$this->idusuario_log = $usuario_log->idusuario_log;
			return parent::beforeAction($action);
		}

		//Se não é uma rota publica e não está logado, envia para tela de login
		if(Yii::app()->user->isGuest){
			$usuario_log->acesso_status = 'erro';


			if(!in_array($this->id.'/*',$routes_no_log) && !in_array($current_route,$routes_no_log)){
				$usuario_log->save();
			}

			Yii::app()->user->returnUrl = $this->createUrl($current_route);
			$this->redirect($this->createUrl("site/login"));
			return false;
		}

		//Se está logado e rota necessita login, porém, não necessita de permissão
		//if(in_array($current_route,$routes_logged)){
		if(in_array($this->id.'/*',$routes_logged) || in_array('*/'.$this->action->id,$routes_logged) || in_array($current_route,$routes_logged)){

			$usuario_log->acesso_status = 'sucesso';

			if(!in_array($this->id.'/*',$routes_no_log) && !in_array($current_route,$routes_no_log)){
				$usuario_log->save();
			}

			$this->idusuario_log = $usuario_log->idusuario_log;
			return parent::beforeAction($action);
		}

		//Rota precisa de um permissão específica e o usuário possui
		if(Yii::app()->user->obj->perfil->temPermissaoAction($this->id,$this->action->id)){
			$usuario_log->acesso_status = 'sucesso';
			if(!in_array($this->id.'/*',$routes_no_log) && !in_array($current_route,$routes_no_log)){
				$usuario_log->save();
			}
			$this->idusuario_log = $usuario_log->idusuario_log;
			return parent::beforeAction($action);
		}



		//Está logado, porém, sem permissão
		$usuario_log->acesso_status = 'erro';
		if(!in_array($this->id.'/*',$routes_no_log) && !in_array($current_route,$routes_no_log)){
			$usuario_log->save();
		}
		$this->render("//site/error", array(
		  'code' => '405',
		  'message' => "Você não tem permissão para acessar esta opção.",
		));
		return false;

	}

	public function afterAction($action){
		$this->registrarModel();
		return parent::afterAction($action);
	}

	public function redirect($url,$terminate=true,$statusCode=302){
		$this->registrarModel();
		return parent::redirect($url,$terminate=true,$statusCode=302);
	}

	public function registrarModel(){
		if(is_object($this->model)){

			if($this->model->beforeSaveExecuted){
				$this->model->afterFind();
			}

			$attributes = $this->model->attributes;
			UsuarioLog::removerSenha($attributes);
			UsuarioLog::model()->updateByPk($this->idusuario_log,array(
				'registro_nome' => $this->model->representingName(),
				'registro_model' => get_class($this->model),
				'registro_dados' => CJSON::encode($attributes),
				'registro_erro' =>  CHtml::errorSummary($this->model),
				'registro_id' => $this->model->getPrimaryKey()
			));
		}
	}

	public function hasRel($id = ""){
		if($id != "")
			return count($this->rel[$id]) > 0;
		return count($this->rel) > 0;
	}

	public function setRel($rel){
		if(is_array($rel))
			$this->rel = $rel;
	}

	public function getRel($id = ""){
		if($id != "")
			return $this->rel[$id];
		return $this->rel;
	}

	public function createUrlRel($route,$params=array()){
		if(count($this->rel_link) > 0){
			$params = array_merge($params,$this->rel_link);
		}
		return parent::createUrl($route,$params);
	}


}
