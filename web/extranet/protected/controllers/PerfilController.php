<?php

class PerfilController extends GxController {
	
	public function getRepresentingFields(){
		return array('nome');
	}
	
	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Perfil'),
		));
	}

	public function actionCreate() {
		
		$model = new Perfil;	
		$this->model = $model;

		if (isset($_POST['Perfil'])) {
			$model->setAttributes($_POST['Perfil']);
			
			if ($model->save()) {
				Yii::app()->user->obj->refresh();
				
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					return true;
				else
					$this->redirect($this->createUrl('view',array('id' => $model->idperfil,'success'=>'create')));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Perfil');

		if (isset($_POST['Perfil'])) {
			$model->setAttributes($_POST['Perfil']);

			if ($model->save()) {
				Yii::app()->user->obj->refresh();
				$this->redirect($this->createUrl('view',array('id' => $model->idperfil,'success'=>'update')));
			}
		}

		$this->render('update', array(
			'model' => $model,
		));
	}
	

	public function actionDelete($id) {
		
		if($_GET['confirm'] == 1){		
			
			$model = $this->loadModel($id, 'Perfil');
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
					'class' => 'Perfil',
					'ids' => $explode_ids,
					'model' => new Perfil,
				));
			}
			else{
				$model = $this->loadModel($explode_ids[0], 'Perfil');
				$this->renderPartial("//site/delete_console", array(
					'model' => $model,
				));
			}
		}
	}
	
	public function actionStatus($id) {
		$model = $this->loadModel($id, 'Perfil');
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
		
		//Códgio de busca
		if(isset($_GET['q'])){
			$model = new Perfil();
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
				$criteria->addCondition($field." = '".$value."'");
			}
		}
		
		$dataProvider = new CActiveDataProvider('Perfil', array(
            'criteria'=>$criteria,
			'pagination' => array(
				'pageSize'=> Yii::app()->user->pageSize,
				'pageVar'=>'p',
			),
    	));
		
		$this->render('index', array(
			'dataProvider' => $dataProvider,
			'model' => Perfil::model(),
			
		));
	}
	
	public function afterAction($action){
		Yii::app()->user->returnUrl = Yii::app()->request->requestUri;
		return parent::afterAction($action);
	}
	
	public function beforeAction($action){

		return parent::beforeAction($action);
	}

}