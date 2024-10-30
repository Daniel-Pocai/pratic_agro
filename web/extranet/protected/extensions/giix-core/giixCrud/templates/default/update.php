<?='<?php
$this->breadcrumbs[$model->label(2)] = array(\'index\');
if($this->hasRel()){
	$this->breadcrumbs[$model->label(2)] = array(\'rel\'=>$this->getRel());
}
$this->breadcrumbs[] = Yii::t(\'app\',\'Atualizar\');
?>'?>
<div class="row">
  <div class="col-md-12">
      <h3 class="panel-title"> Atualizar <?='<?=Util::formataTexto($model->label(1));?>'?>
          <?='<?
          if(!Yii::app()->user->isGuest){
              $this->renderPartial("//layouts/caminho");
          }
          ?>'?> 
      </h3>
      <hr/>
    </div>
</div>
<div class="row">
	<div class="col-md-9 col-sm-12">
		<div class="panel panel-default">
			<?='<?php
            $this->renderPartial(\'_form\', array(\'model\' => $model,\'buttonLabel\' => Yii::t(\'app\',\'Atualizar\')));
            ?>'?>
		</div>
	</div>
</div>