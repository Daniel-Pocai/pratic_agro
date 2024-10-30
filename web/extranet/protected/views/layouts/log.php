<?
if (isset(Yii::app()->user->obj) && isset(Yii::app()->user->obj->perfil) && Yii::app()->user->obj->perfil->temPermissaoAction('usuarioLog', 'index')) {
	
	$criteria_logs = Yii::app()->user->obj->perfil->getCriteriaLogs();
	$criteria_logs->order = 'data desc';
	$criteria_logs->limit = 10;
	$criteria_logs->addCondition("usuario_nome != ''");
	if(is_object($model)){
		$criteria_logs->addCondition("controller = '".$this->id."'");
	}
	
	$usuario_logs = UsuarioLog::model()->findAll($criteria_logs);
	
	?>
	<h4>Log de <?=is_object($model) ? $model->label(2) : 'usuários' ;?> </h4>
	<div class="timeline-2">
	<?
	$controllers = Yii::app()->metadata->getControllers(); 
	$perfil = new Perfil();
	foreach($usuario_logs as  $usuario_log){							
		?>
		<div class="time-item">
            <div class="item-info">
                <div class="text-muted"><?=$usuario_log->data?></div>
                <p><strong><span class="text-info"><?=Util::formataTexto($usuario_log->usuario_nome)?></span></strong> acessou <?=Dicionario::acao($usuario_log->action);?> em <strong><?=Dicionario::modulo($usuario_log->controller)?></strong></p>
            </div>
        </div>
		<?
	}
	?>
    </div>
    <?
    $array_get = array();
	if(is_object($model)){
		$array_get = array('filtro[0][controller]'=>$this->id);
	}
	?>
	<a href="<?=$this->createUrl('usuarioLog/index',$array_get);?>" style="margin-left:5px;font-size:12px;" class="btn-link" ><i class="ion ion-more"></i> Ver todos os logs</a>
	<?
}
?>