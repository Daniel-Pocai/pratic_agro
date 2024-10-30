<?php

class UsuarioLogController extends GxController {

	
    public function getRepresentingFields(){
		return array('data','usuario_nome','controller','action','registro_nome');
	}
    
	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'UsuarioLog'),
		));
	}
	
	public function actionIndex() {
		$criteria = Yii::app()->user->obj->perfil->getCriteriaLogs();
		$model = new UsuarioLog();
		
		
		//Códgio de busca
		if(is_array($_GET['filtro'])){
			/*echo '<pre>';
			print_r($_GET['filtro']);
			echo '</pre>';*/
			
        	foreach($_GET['filtro'] as $i => $filtro){
				$condicao_filtro = array();
				$filtro['texto'] = trim($filtro['texto']);
				if(!empty($filtro['controller'])){
					$condicao_filtro[] = "(controller = '".$filtro['controller']."')";
				}
				if(!empty($filtro['action'])){
					$condicao_filtro[] = "(action = '".$filtro['action']."')";
				}
				if(!empty($filtro['idusuario'])){
					$condicao_filtro[] = "(idusuario = '".$filtro['idusuario']."')";
				}
				if(!empty($filtro['texto'])){
					$condicao_filtro[] = "(registro_dados like '%".$filtro['texto']."%' OR post like '%".$filtro['texto']."%' OR get like '%".$filtro['texto']."%')";
				}
				
				$condicao_geral[] = '('.implode(" AND ",$condicao_filtro).')';
				
			}
			
			$criteria->addCondition(implode(" OR ",$condicao_geral));
			
			/*$model = new UsuarioLog();
			$atributos = $model->tableSchema->columns;
					
			foreach($atributos as $att){
				if($att->name != 'habilitar' && !$att->isPrimaryKey && !$att->isForeignKey)
					$criteria->addCondition($att->name." like '%".$_GET['q']."%'", "OR");
			}*/
		}
        
        if(isset($_GET['o']) && isset($_GET['f']) ){
			$relations = $model->relations();
			$relations_array = array_keys($relations);
			if(in_array($_GET['f'],$relations_array)){
				$criteria->with = array($_GET['f']);
				$criteria->together = true; 
				$model_class = $relations[$_GET['f']][1];
				$representing_column = $model_class::model()->representingColumn();
				$criteria->order = $_GET['f'].".".$representing_column." ".$_GET['o'];
			}
			else{
				$criteria->order = $_GET['f']." ".$_GET['o'];
			}
		}
		else{
        	$criteria->order = 'idusuario_log desc';
        }
		
		if(count($this->rel_conditions) > 0){
			foreach($this->rel_conditions as $field => $value){
				$criteria->addCondition($field." = '".$value."'");
			}
		}
		
		$dataProvider = new CActiveDataProvider('UsuarioLog', array(
            'criteria'=>$criteria,
			'pagination' => array(
				'pageSize'=> Yii::app()->user->pageSize,
				'pageVar'=>'p',
			),
    	));
		
		$this->render('index', array(
			'dataProvider' => $dataProvider,
			'model' => UsuarioLog::model(),
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