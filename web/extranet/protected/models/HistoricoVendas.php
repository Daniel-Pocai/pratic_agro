<?php

Yii::import('application.models._base.BaseHistoricoVendas');

class HistoricoVendas extends BaseHistoricoVendas
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
    
    
    public function init(){
		$this->data_venda = date('d/m/Y H:i:s');
  
    }
    
    public function beforeSave(){
		if($this->data_venda != "")
				$this->data_venda= Util::formataDataHoraBanco($this->data_venda);
		//{{beforeSave}}
		return parent::beforeSave();
	}
	
	public function afterFind(){
		if($this->data_venda != "")
				$this->data_venda = Util::formataDataHoraApp($this->data_venda);
		//{{afterFind}}
		return parent::afterFind();
	}
    
    public function behaviors(){
    	return array(
        	//{{behaviors}}
        );
    }
    
	
}