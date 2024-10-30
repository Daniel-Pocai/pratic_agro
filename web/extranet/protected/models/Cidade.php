<?php

Yii::import('application.models._base.BaseCidade');

class Cidade extends BaseCidade
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
    
        
}