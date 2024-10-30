<?php

class UsuarioController extends GxController {

	
    public function getRepresentingFields(){
		return array('nome','perfil');
	}
    
	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Usuario'),
		));
	}

	public function actionCreate() {
		$model = new Usuario;
		$this->model = $model;

		if (isset($_POST['Usuario'])) {
			$model->setAttributes($_POST['Usuario']);

			if ($model->save()) {
				$model->afterFind();
				
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					return true;
				else
					$this->redirect($this->createUrl('view',array('id' => $model->idusuario,'success'=>'update')));
			}
		}
		else{
			$model->setAttributes($this->rel_conditions);
		}
		
		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id){
		
		if(!Yii::app()->user->obj->perfil->temPermissaoAction('usuario','create') && $id != Yii::app()->user->obj->idusuario){
			$this->render("//site/error", array(
				'code' => '405',
				'message' => "Você não tem permissão para acessar esta opção.",
			));
			return true;
		}
		
		$model = $this->loadModel($id, 'Usuario');
	
		if (isset($_POST['Usuario'])) {
			$model->setAttributes($_POST['Usuario']);

			if ($model->save()) {
                $this->redirect($this->createUrl('view',array('id' => $model->idusuario,'success'=>'create')));
			}
		}

		$this->render('update', array(
				'model' => $model,
		));
	}

	public function actionDelete($id) {
		
		if($_GET['confirm'] == 1){		
			
			$model = $this->loadModel($id, 'Usuario');
			$retorno_exclusao = $model->deleteRecursive();
			$retorno_exclusao = true;
			if($retorno_exclusao){
				echo CJSON::encode(array(
				'status'=>true
				));
				return true;
			}
			
			echo CJSON::encode(array(
				'status'=>false,
				'msg' => 'Não foi possível realizar a exclusão, contate o suporte: Código D'.$model->idperfil,
			));
			return true;
			
		}
		else{
			
			$explode_ids = explode(',',$id);
			if(count($explode_ids) > 1){
				$this->renderPartial("//site/delete_console_multiplos", array(
					'class' => 'Usuario',
					'ids' => $explode_ids,
					'model' => new Usuario,
				));
			}
			else{
				$model = $this->loadModel($explode_ids[0], 'Usuario');
				$this->renderPartial("//site/delete_console", array(
					'model' => $model,
				));
			}
		}
	}
	
	public function actionStatus($id) {
		$model = $this->loadModel($id, 'Usuario');
		$model->habilitar = $_GET['habilitar'];
		$model->update(array('habilitar'));
		
		if(isset($_GET['ajax_nocache'])){
			echo CJSON::encode(array(
				'status' => true,
				'habilitar' => $_GET['habilitar'],
			));
			return true;
		}
		
		$this->redirect(Yii::app()->user->returnUrl);
	}

	public function actionIndex() {
		$criteria = new CDbCriteria;
		$model = new Usuario();
		//Códgio de busca
		if(isset($_GET['q'])){
			
			$atributos = $model->tableSchema->columns;
			foreach($atributos as $att){
				if($att->name != 'habilitar' && !$att->isPrimaryKey && !$att->isForeignKey)
					$or_string[] = 't.'.$att->name." like '%".$_GET['q']."%'";
			}
			
			$criteria->addCondition(implode(' OR ',$or_string));
		}
		
		
		if(isset($_GET['o']) && isset($_GET['f']) ){
			$relations = $model->relations();
			$relations_array = array_keys($relations);
			if(in_array($_GET['f'],$relations_array)){
				$criteria->with[] = $_GET['f'];
				$criteria->together = true; 
				$model_class = $relations[$_GET['f']][1];
				$obj_class = new $model_class();
				$representing_column = $obj_class->representingColumn();
				if(is_array($representing_column)){
					$representing_column = $representing_column[0];
				}
				$criteria->order = $_GET['f'].".".$representing_column." ".$_GET['o'];
			}
			else{
				$criteria->order = $_GET['f']." ".$_GET['o'];
			}
		}
		else{
			$criteria->order = 'nome';
		}
		
		if(count($this->rel_conditions) > 0){
			foreach($this->rel_conditions as $field => $value){
				$criteria->addCondition("t.".$field." = '".$value."'");
			}
		}
		
		$dataProvider = new CActiveDataProvider('Usuario', array(
            'criteria'=>$criteria,
			'pagination' => array(
				'pageSize'=> Yii::app()->user->pageSize,
				'pageVar'=>'p',
			),
    	));
		
		
		$this->render('index', array(
			'dataProvider' => $dataProvider,
			'model' => Usuario::model(),
			
		));
	}
    
    public function afterAction($action){
		Yii::app()->user->returnUrl = Yii::app()->request->requestUri;
		return parent::afterAction($action);
	}
	
	public function beforeAction($action){
		
        if(is_numeric($_GET['idperfil'])){
			$perfil = Perfil::model()->findByPk($_GET['idperfil']);
			$this->rel_conditions['idperfil'] = $_GET['idperfil'];
			$this->rel_link['idperfil'] = $_GET['idperfil'];
			if(Yii::app()->user->obj->perfil->temPermissaoAction('perfil','index')){
				$this->breadcrumbs[$perfil->label(2)] = array('perfil/index');
				$this->breadcrumbs[$perfil->nome] = array('perfil/view','id'=>$perfil->idperfil);
			}
			else{
				$this->breadcrumbs[] = Perfil::label(2);
				$this->breadcrumbs[] = $perfil->nome;
			}
		}
		return parent::beforeAction($action);
	}

}