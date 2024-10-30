<?php

Yii::import('application.models._base.BaseBanner');

class Banner extends BaseBanner
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
    
    
    public function init(){
		$this->data = date('d/m/Y H:i:s');
		$this->data_entrada = date('d/m/Y H:i:s');
		$this->data_saida = date('d/m/Y H:i:s');
  
    }
    
    public function beforeSave(){
		if($this->data != "")
				$this->data= Util::formataDataHoraBanco($this->data);
		if($this->data_entrada != "")
				$this->data_entrada= Util::formataDataHoraBanco($this->data_entrada);
		if($this->data_saida != "")
				$this->data_saida= Util::formataDataHoraBanco($this->data_saida);
		//{{beforeSave}}
		return parent::beforeSave();
	}
	
	public function afterFind(){
		if($this->data != "")
				$this->data = Util::formataDataHoraApp($this->data);
		if($this->data_entrada != "")
				$this->data_entrada = Util::formataDataHoraApp($this->data_entrada);
		if($this->data_saida != "")
				$this->data_saida = Util::formataDataHoraApp($this->data_saida);
		//{{afterFind}}
		return parent::afterFind();
	}
    
    public function behaviors(){
    	return array(
        	
        );
    }
    
    //local
	public function getLocalArray(){
		return array(
			'site-inicial' => 'Inicial-Site',
		);
	}
	public function getLocal(){
		$array = $this->getLocalArray();
		return $array[$this->local];
	}

	public function getBanners($local){
		$array_banner = array();
		$data_atual = date('Y-m-d H:i:s');

		$criteria = new CDbCriteria();
		$criteria->addCondition("t.habilitar = '1'");
		$criteria->addCondition("t.local = :local");
		$criteria->addCondition("data_entrada <= '".$data_atual."'");
		$criteria->addCondition("t.data_saida IS NULL OR t.data_saida >= '".$data_atual."'");
		$criteria->order = 't.posicao asc';
		$criteria->params = array(":local"=>$local);
		if($local=='site-inicial'){
			$dados = Banner::model()->findAll($criteria);
			if($dados){

				foreach ($dados as $dado) {
					$array_banner[] = array(
						'titulo'=>$dado->titulo,
						'imagem'=>'extranet/uploads/Banner/'.$dado->imagem,
						'link'=>$dado->link,
						'target'=>$dado->nova_aba?'_blank':'',
					);
				}
			}
		}

		return $array_banner;
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