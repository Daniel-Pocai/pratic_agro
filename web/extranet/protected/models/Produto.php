<?php

Yii::import('application.models._base.BaseProduto');

class Produto extends BaseProduto
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
    
    
    public function init(){
  
    }
    
    public function beforeSave(){
		if (parent::beforeSave()) {
			// Converte o campo "apresentacao" em uma lista separada por vírgulas
			$this->apresentacao = implode(',', array_map('trim', explode(',', $this->apresentacao)));
			return true;
		}
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

	//tipo

	public function getTipoArray(){
		return array(
			'suino'=>'Suinocultura',
			'ave'=>'Avicultura',
			'suinoAve'=>'Suinocultura/Avicultura',
			'higiene'=>'Higiene pessoal',
		);
	}
	public function getTipo(){
		$array = $this->getTipoArray();
		return $array[$this->tipo];
	}
	
	
    
    //principio_ativo
	public function getPrincipioAtivoArray(){
		return array(
			'amonia'=>'Amônia quartenária',
			'desinfeccao'=>'Desinfecção a Gás',
			'detergente'=>'Detergentes',
			'dicloro'=>'Dicloro',
			'fenolico'=>'Fenólicos',
			'glutaraldeido'=>'Glutaraldeído',
			'probiotico'=>'Probióticos',
			'triclosano'=>'Triclosano',
		);
	} 
	
	public function getPrincipioAtivo(){
		$array = $this->getPrincipioAtivoArray();
		return $array[$this->principio_ativo];
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