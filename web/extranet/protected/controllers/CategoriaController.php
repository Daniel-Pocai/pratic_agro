<?php

class CategoriaController extends GxController {

	
    public function getRepresentingFields(){
		return array('nome' , 'descricao');
	}

	public function actionOrdenacao() {
        if (is_array($_GET['listItem'])) {
            $pagina = $_GET['num_pagina'];
            $page_size = $_GET['page_size'];
            $pagination = $page_size * ($pagina-1);
            $itens = $_GET['listItem'];
            foreach ($itens as $posicao => $id) {
                $new_posicao = $pagination+($posicao+1);
                Categoria::model()->updateByPk($id, array('posicao' => $new_posicao));
            }
        }
        exit;
    }
    
	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Categoria'),
		));
	}

	public function actionCreate() {
		$model = new Categoria;
        //Registro do model no log
		$this->model = $model;
		if (isset($_POST['Categoria'])) {
			$model->setAttributes($_POST['Categoria']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					return true;
				else
					$this->redirect($this->createUrlRel('view',array('id' => $model->idcategoria,'success'=>'create')));
			}
		}
        else{
			$model->setAttributes($this->rel_conditions);
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Categoria');

		if (isset($_POST['Categoria'])) {
			$model->setAttributes($_POST['Categoria']);

			if ($model->save()) {
                $this->redirect($this->createUrlRel('view',array('id' => $model->idcategoria,'success'=>'update')));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
        if($_GET['confirm'] == 1){		
			$model = $this->loadModel($id, 'Categoria');
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
					'class' => 'Categoria',
					'ids' => $explode_ids,
					'model' => new Categoria,
				));
			}
			else{
				$model = $this->loadModel($explode_ids[0], 'Categoria');
				$this->renderPartial("//site/delete_console", array(
					'model' => $model,
				));
			}
		}
        
	}
	
	public function actionStatus($id) {
		$model = $this->loadModel($id, 'Categoria');
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
		$model = new Categoria();
		//Cï¿½dgio de busca
		if(isset($_GET['q'])){
			$model = new Categoria();
			$atributos = $model->tableSchema->columns;
					
			foreach($atributos as $att){
				if($att->name != 'habilitar' && !$att->isPrimaryKey && !$att->isForeignKey)
					$criteria->addCondition($att->name." like '%".$_GET['q']."%'", "OR");
			}
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
        	$criteria->order = 'posicao asc';
        }
		
		if(count($this->rel_conditions) > 0){
			foreach($this->rel_conditions as $field => $value){
				$criteria->addCondition($field." = '".$value."'");
			}
		}
		
		$dataProvider = new CActiveDataProvider('Categoria', array(
            'criteria'=>$criteria,
			'pagination' => array(
				'pageSize'=> Yii::app()->user->pageSize,
				'pageVar'=>'p',
			),
    	));
		
		$this->render('index', array(
			'dataProvider' => $dataProvider,
			'model' => Categoria::model(),
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