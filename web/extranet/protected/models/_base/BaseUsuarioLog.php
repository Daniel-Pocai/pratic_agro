<?php

/**
 * This is the model base class for the table "usuario_log".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "UsuarioLog".
 *
 * Columns in table "usuario_log" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $habilitar
 * @property string $ip
 * @property string $data
 * @property integer $idusuario
 * @property string $usuario_nome
 * @property string $usuario_email
 * @property string $controller
 * @property string $action
 * @property string $get
 * @property string $post
 * @property string $acesso_status
 *
 */
abstract class BaseUsuarioLog extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'usuario_log';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Log|Logs', $n);
	}

	public static function representingColumn() {
		return array('habilitar');
	}

	public function rules() {
		return array(
			array('idusuario', 'numerical', 'integerOnly'=>true),
			array('habilitar', 'length', 'max'=>1),
			array('ip, usuario_nome, usuario_email, controller, action, acesso_status', 'length', 'max'=>100),
			array('data, get, post', 'safe'),
			array('habilitar, ip, data, idusuario, usuario_nome, usuario_email, controller, action, get, post, acesso_status', 'default', 'setOnEmpty' => true, 'value' => null),
			array('habilitar, ip, data, idusuario, usuario_nome, usuario_email, controller, action, get, post, acesso_status', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'usuario' => array(self::BELONGS_TO, 'Usuario', 'idusuario'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'habilitar' => Yii::t('app', 'Habilitar'),
			'ip' => Yii::t('app', 'IP'),
			'data' => Yii::t('app', 'Data'),
			'idusuario' => Yii::t('app', 'Idusuario'),
			'usuario_nome' => Yii::t('app', 'Usuario'),
			'usuario_email' => Yii::t('app', 'Usuario Email'),
			'controller' => Yii::t('app', 'M�dulo'),
			'action' => Yii::t('app', 'A��o'),
			'get' => Yii::t('app', 'GET'),
			'post' => Yii::t('app', 'POST'),
			'session' => Yii::t('app', 'SESSION'),
			'server' => Yii::t('app', 'SEVER'),
			'acesso_status' => Yii::t('app', 'Status do acesso'),
			
			
			'navegador_nome' => Yii::t('app', 'Navegador'),
			'navegador_versao' => Yii::t('app', 'Navegador (Vers�o)'),
			'so' => Yii::t('app', 'Sistema Operacional'),
			
			'registro_nome' => Yii::t('app', 'Nome'),
			'registro_dados' => Yii::t('app', 'Dados'),
			'registro_erro' => Yii::t('app', 'Erro'),
			'registro_id' => Yii::t('app', 'ID'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('habilitar', $this->habilitar, true);
		$criteria->compare('ip', $this->ip, true);
		$criteria->compare('data', $this->data, true);
		$criteria->compare('idusuario', $this->idusuario);
		$criteria->compare('usuario_nome', $this->usuario_nome, true);
		$criteria->compare('usuario_email', $this->usuario_email, true);
		$criteria->compare('controller', $this->controller, true);
		$criteria->compare('action', $this->action, true);
		$criteria->compare('get', $this->get, true);
		$criteria->compare('post', $this->post, true);
		$criteria->compare('acesso_status', $this->acesso_status, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}