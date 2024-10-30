<?php

Yii::import('application.models._base.BaseRepresentante');

class Representante extends BaseRepresentante
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

	//regiao_atuacao
	public function getRegiaoAtuacaoArray(){
		return array(
			'saoPaulo' => 'SP',
			'norte' => 'NO/NE/ ES /CO',
			'centroSul' => 'MG/PR/SC/RS/RJ'
		);
	}
	public function getRegiaoAtuacao(){
		$array = $this->getRegiaoAtuacaoArray();
		return $array[$this->regiao_atuacao];
	}
    
	public static function countEnabledRepresentatives() {
        return self::model()->countByAttributes(array('habilitar' => '1'));
    }
        
}