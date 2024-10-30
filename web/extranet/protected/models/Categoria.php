<?php

Yii::import('application.models._base.BaseCategoria');

class Categoria extends BaseCategoria
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
    
    
    public function init(){
  
    }
    
    public function beforeSave(){
		//{{beforeSave}}
		return parent::beforeSave();
	}
	
	public function afterFind(){
		//{{afterFind}}
		return parent::afterFind();
	}
    
    public function behaviors(){
    	return array(
        	//{{behaviors}}
        );
    }

	public function getLast()
	{
		$pos = 1;
		$obj = $this->find(array('order' => 'posicao desc'));
		if (is_object($obj)) {
			$pos = $obj->posicao + 1;
		}
		return $pos;
	}
    
        
}