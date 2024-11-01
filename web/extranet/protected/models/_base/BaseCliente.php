<?php

/**
 * This is the model base class for the table "cliente".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Cliente".
 *
 * Columns in table "cliente" available as properties of the model,
 * followed by relations of table "cliente" available as properties of the model.
 *
 * @property integer $idcliente
 * @property string $habilitar
 * @property string $nome
 * @property string $cpf_cnpj
 * @property string $foto
 * @property string $email
 * @property string $telefone
 * @property string $celular
 * @property string $endereco_completo
 * @property string $cep
 * @property integer $idcidade
 * @property integer $idestado
 * @property integer $idrepresentante
 * @property string $uf
 *
 * @property Cidade $cidade
 * @property Estado $estado
 * @property Representante $representante
 * @property HistoricoVendas[] $historicoVendases
 */
abstract class BaseCliente extends GxActiveRecord {
	
    
        
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'cliente';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Cliente|Clientes', $n);
	}

	public static function representingColumn() {
		return array('nome');
	}


	public function rules() {
		return array(
			array('habilitar, idestado, idrepresentante', 'required'),
			array('idcidade, idestado, idrepresentante', 'numerical', 'integerOnly'=>true),
			array('habilitar', 'length', 'max'=>1),
			array('nome, cpf_cnpj, email, telefone, celular, cep', 'length', 'max'=>100),
			array('foto', 'length', 'max'=>160),
			array('uf', 'length', 'max'=>2),
			array('endereco_completo', 'safe'),
			array('nome, cpf_cnpj, foto, email, telefone, celular, endereco_completo, cep, idcidade, idestado, uf', 'default', 'setOnEmpty' => true, 'value' => null),
			array('idcliente, habilitar, nome, cpf_cnpj, foto, email, telefone, celular, endereco_completo, cep, idcidade, idestado, idrepresentante, uf', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'cidade' => array(self::BELONGS_TO, 'Cidade', 'idcidade'),
			'estado' => array(self::BELONGS_TO, 'Estado', 'idestado'),
			'representante' => array(self::BELONGS_TO, 'Representante', 'idrepresentante'),
			'historicoVendases' => array(self::HAS_MANY, 'HistoricoVendas', 'idcliente'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'idcliente' => Yii::t('app', 'Idcliente'),
			'habilitar' => Yii::t('app', 'Habilitar'),
			'nome' => Yii::t('app', 'Nome'),
			'cpf_cnpj' => Yii::t('app', 'Cpf/Cnpj'),
			'foto' => Yii::t('app', 'Foto'),
			'email' => Yii::t('app', 'Email'),
			'telefone' => Yii::t('app', 'Telefone'),
			'celular' => Yii::t('app', 'Celular'),
			'endereco_completo' => Yii::t('app', 'Endere�o Completo'),
			'cep' => Yii::t('app', 'Cep'),
			'idcidade' => null,
			'idestado' => null,
			'uf' => Yii::t('app', 'Uf'),
			'idrepresentante' => null,
			'cidade' => null,
			'estado' => null,
			'representante' => null,
			'historicoVendases' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idcliente', $this->idcliente);
		$criteria->compare('habilitar', $this->habilitar, true);
		$criteria->compare('nome', $this->nome, true);
		$criteria->compare('cpf_cnpj', $this->cpf_cnpj, true);
		$criteria->compare('foto', $this->foto, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('telefone', $this->telefone, true);
		$criteria->compare('celular', $this->celular, true);
		$criteria->compare('endereco_completo', $this->endereco_completo, true);
		$criteria->compare('cep', $this->cep, true);
		$criteria->compare('idcidade', $this->idcidade);
		$criteria->compare('idestado', $this->idestado);
		$criteria->compare('idrepresentante', $this->idrepresentante);
		$criteria->compare('uf', $this->uf, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}