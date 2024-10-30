<?php

Yii::import('application.models._base.BaseCliente');

class Cliente extends BaseCliente
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

	public static function countEnabledClients() {
        return self::model()->countByAttributes(array('habilitar' => '1'));
    }
	    
}