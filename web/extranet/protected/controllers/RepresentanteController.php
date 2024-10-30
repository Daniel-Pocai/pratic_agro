<?php

class RepresentanteController extends GxController {

	
    public function getRepresentingFields(){
		return array('foto','nome','regiao_atuacao');
	}
    
	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Representante'),
		));
	}

	public function actionCreate() {
		$model = new Representante;
        //Registro do model no log
		$this->model = $model;
		if (isset($_POST['Representante'])) {
			$model->setAttributes($_POST['Representante']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					return true;
				else
					$this->redirect($this->createUrlRel('view',array('id' => $model->idrepresentante,'success'=>'create')));
			}
		}
        else{
			$model->setAttributes($this->rel_conditions);
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Representante');

		if (isset($_POST['Representante'])) {
			$model->setAttributes($_POST['Representante']);

			if ($model->save()) {
                $this->redirect($this->createUrlRel('view',array('id' => $model->idrepresentante,'success'=>'update')));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
        if($_GET['confirm'] == 1){		
			$model = $this->loadModel($id, 'Representante');
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
				'msg' => 'N�o foi poss�vel realizar a exclus�o, contate o suporte: C�digo D'.$model->idperfil,
			));
			return true;
			
		}
		else{
			
			$explode_ids = explode(',',$id);
			if(count($explode_ids) > 1){
				$this->renderPartial("//site/delete_console_multiplos", array(
					'class' => 'Representante',
					'ids' => $explode_ids,
					'model' => new Representante,
				));
			}
			else{
				$model = $this->loadModel($explode_ids[0], 'Representante');
				$this->renderPartial("//site/delete_console", array(
					'model' => $model,
				));
			}
		}
        
	}
	
	public function actionStatus($id) {
		$model = $this->loadModel($id, 'Representante');
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
		$model = new Representante();
		//C�dgio de busca
		if(isset($_GET['q'])){
			$model = new Representante();
			$atributos = $model->tableSchema->columns;
					
			foreach($atributos as $att){
				if($att->name != 'habilitar' && !$att->isPrimaryKey && !$att->isForeignKey)
					$criteria->addCondition($att->name." like '%".$_GET['q']."%'", "OR");
			}
			$representativeCount = Representante::countEnabledRepresentatives();
			$this->render('index', array(
				'representativeCount' => $representativeCount,
			));
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
        	$criteria->order = 'idrepresentante desc';
        }
		
		if(count($this->rel_conditions) > 0){
			foreach($this->rel_conditions as $field => $value){
				$criteria->addCondition($field." = '".$value."'");
			}
		}
		
		$dataProvider = new CActiveDataProvider('Representante', array(
            'criteria'=>$criteria,
			'pagination' => array(
				'pageSize'=> Yii::app()->user->pageSize,
				'pageVar'=>'p',
			),
    	));
		
		$this->render('index', array(
			'dataProvider' => $dataProvider,
			'model' => Representante::model(),
		));
	}
    
    public function afterAction($action){
		Yii::app()->user->returnUrl = Yii::app()->request->requestUri;
		return parent::afterAction($action);
	}
	
	public function beforeAction($action){
		/*
        if(is_numeric($_GET['idlinha'])){
			$linha = Linha::model()->findByPk($_GET['idlinha']);
			$this->rel_conditions['idlinha'] = $_GET['idlinha'];
			$this->rel_link['idlinha'] = $_GET['idlinha'];
			if(Yii::app()->user->obj->perfil->temPermissaoAction('linha','index')){
				$this->breadcrumbs[$linha->label(2)] = array('linha/index');
				$this->breadcrumbs[$linha->nome] = array('linha/view','id'=>$linha->idlinha);
			}
			else{
				$this->breadcrumbs[] = Linha::label(2);
				$this->breadcrumbs[] = $linha->nome;
			}
		}
        */
        
		return parent::beforeAction($action);
	}

}