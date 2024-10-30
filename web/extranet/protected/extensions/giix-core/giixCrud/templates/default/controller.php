<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseControllerClass; ?> {

<?php 
	$authpath = 'ext.giix-core.giixCrud.templates.default.auth.';
	Yii::app()->controller->renderPartial($authpath . $this->authtype);
?>
	
    public function getRepresentingFields(){
		return <?php echo $this->modelClass; ?>::representingColumn();
	}
    
	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, '<?php echo $this->modelClass; ?>'),
		));
	}

	public function actionCreate() {
		$model = new <?php echo $this->modelClass; ?>;
        //Registro do model no log
		$this->model = $model;
<?php if ($this->enable_ajax_validation): ?>
		$this->performAjaxValidation($model, '<?php echo $this->class2id($this->modelClass)?>-form');
<?php endif; ?>
		if (isset($_POST['<?php echo $this->modelClass; ?>'])) {
			$model->setAttributes($_POST['<?php echo $this->modelClass; ?>']);
<?php if ($this->hasManyManyRelation($this->modelClass)): ?>
			$relatedData = <?php echo $this->generateGetPostRelatedData($this->modelClass, 4); ?>;
<?php endif; ?>

<?php if ($this->hasManyManyRelation($this->modelClass)): ?>
			if ($model->saveWithRelated($relatedData)) {
<?php else: ?>
			if ($model->save()) {
<?php endif; ?>
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					return true;
				else
					$this->redirect($this->createUrlRel('view',array('id' => $model-><?php echo $this->tableSchema->primaryKey; ?>,'success'=>'create')));
			}
		}
        else{
			$model->setAttributes($this->rel_conditions);
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, '<?php echo $this->modelClass; ?>');

<?php if ($this->enable_ajax_validation): ?>
		$this->performAjaxValidation($model, '<?php echo $this->class2id($this->modelClass)?>-form');
<?php endif; ?>
		if (isset($_POST['<?php echo $this->modelClass; ?>'])) {
			$model->setAttributes($_POST['<?php echo $this->modelClass; ?>']);
<?php if ($this->hasManyManyRelation($this->modelClass)): ?>
			$relatedData = <?php echo $this->generateGetPostRelatedData($this->modelClass, 4); ?>;
<?php endif; ?>

<?php if ($this->hasManyManyRelation($this->modelClass)): ?>
			if ($model->saveWithRelated($relatedData)) {
<?php else: ?>
			if ($model->save()) {
<?php endif; ?>
                $this->redirect($this->createUrlRel('view',array('id' => $model-><?php echo $this->tableSchema->primaryKey; ?>,'success'=>'update')));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
        if($_GET['confirm'] == 1){		
			$model = $this->loadModel($id, '<?php echo $this->modelClass; ?>');
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
					'class' => '<?php echo $this->modelClass; ?>',
					'ids' => $explode_ids,
					'model' => new <?php echo $this->modelClass; ?>,
				));
			}
			else{
				$model = $this->loadModel($explode_ids[0], '<?php echo $this->modelClass; ?>');
				$this->renderPartial("//site/delete_console", array(
					'model' => $model,
				));
			}
		}
        
	}
	
	public function actionStatus($id) {
		$model = $this->loadModel($id, '<?php echo $this->modelClass; ?>');
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
		$model = new <?php echo $this->modelClass; ?>();
		//Códgio de busca
		if(isset($_GET['q'])){
			$model = new <?php echo $this->modelClass; ?>();
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
        	$criteria->order = '<?=$this->getCrudOrder($this->tableSchema);?>';
        }
		
		if(count($this->rel_conditions) > 0){
			foreach($this->rel_conditions as $field => $value){
				$criteria->addCondition($field." = '".$value."'");
			}
		}
		
		$dataProvider = new CActiveDataProvider('<?php echo $this->modelClass; ?>', array(
            'criteria'=>$criteria,
			'pagination' => array(
				'pageSize'=> Yii::app()->user->pageSize,
				'pageVar'=>'p',
			),
    	));
		
		$this->render('index', array(
			'dataProvider' => $dataProvider,
			'model' => <?php echo $this->modelClass; ?>::model(),
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