<?='<?php
$this->breadcrumbs[$model->label(2)] = array(\'index\');
if($this->hasRel()){
	$this->breadcrumbs[$model->label(2)] = array(\'rel\'=>$this->getRel());
}
$this->breadcrumbs[] = Yii::t(\'app\',\'Visualizar\');

$form = new GxActiveForm();


if(isset($_GET[\'success\'])){
	
	$msg = "Cadastro atualizado com sucesso!";
	if($_GET[\'success\'] == \'create\'){
		$msg = "Cadastro realizado com sucesso!";
	}
	
	Yii::app()->clientScript->registerScript(\'helpers\', \'                                                           
		swal("\'.$msg.\'", "Confira os dados", "success");                                                                                                          
	\',2);
}

?>'?>
<div class="row">
  <div class="col-md-12">
      <h3 class="panel-title"> Visualizar <?='<?=Util::formataTexto($model->label(1));?>'?>
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
        
        
        <div class="grid-structure">
          
          <?='<?
		  if(Yii::app()->user->obj->perfil->temPermissaoAction($this->id,\'create\')){
			  ?>'?>
			  <div style="margin-bottom:20px;">
				  <a href="<?='<?=$this->createUrlRel(\'create\');?>'?>" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar <?='<?=$model->label(1);?>'?></a>
			  </div>
			  <?='<?
		  }
		  ?>'?>
          
           
          <?php foreach ($this->tableSchema->columns as $column): ?>
		  <?php if (!$column->autoIncrement && $column->name != 'excluido' && $column->name != 'habilitar'): ?>
                <div class="row">
                  <div class="col-md-12">
				  	<?='<?=Util::formataTexto($model->getAttributeLabel(\''.$column->name.'\'));?>'?></dt>
                    <div class="grid-container">
				  		<?=$this->generateDetailView($this->modelClass, $column);?>
                 	</div>
               	  </div>
           		</div>
          <?php endif; ?>
          <?php endforeach; ?>

           
           
           
           <div class="row">
              <div class="col-md-12">
              	  <?='<?php echo $form->labelEx($model,\'habilitar\'); ?>'?>
                  <div class="grid-container">
                  	<?='<?=Util::formataTexto($model->habilitar == 1 ? \'Sim\' : \'Não\' );?>'?>	
                  </div>
               </div>
          </div>
         
         
         
         
         <?php foreach (GxActiveRecord::model($this->modelClass)->relations() as $relationName => $relation): ?>
		<?php if ($relation[0] == GxActiveRecord::HAS_MANY || $relation[0] == GxActiveRecord::MANY_MANY): ?>
        
        <?php echo "	<?\n";?>
            if(Yii::app()->user->obj->perfil->temPermissaoAction('<?=strtolower($relation[1]);?>','index')){
                <?php echo "?>\n"; ?>
                <div class="row">
              		<div class="col-md-12">
			    	<?php echo '<?php'; ?> echo GxHtml::encode($model->getRelationLabel('<?php echo $relationName; ?>')); ?></dt>
                    <div class="grid-container">
                    <?php echo "<?php\n"; ?>
                    if(count($model-><?php echo $relationName; ?>) > 0){
                                echo GxHtml::openTag('ul');
                        foreach($model-><?php echo $relationName; ?> as $relatedModel) {
                            echo GxHtml::openTag('li');
                            echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('<?php echo strtolower($relation[1][0]) . substr($relation[1], 1); ?>/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
                            echo GxHtml::closeTag('li');
                        }
                        echo GxHtml::closeTag('ul');
                    }
                    else{
                        echo '<i>Nenhum registro encontrado</i>';
                    }
                    <?php echo "?>\n"; ?>
                    </div>
               	</div>
           </div>
        <?php echo "		<?\n"; ?>
            }
        <?php echo '	?>'; ?>
        <?php endif; ?>
        
        <?php endforeach; ?>
         
            
            <?='<?
            if(Yii::app()->user->obj->perfil->temPermissaoAction($this->id,\'update\')){
                ?>'?>
                <br>
                <div class="clearfix"></div>
                    <a class="btn btn-success pull-right"  href="<?='<?php echo $this->createUrlRel(\'update\',array(\'id\'=>$model->getPrimaryKey()));?>'?>"><i class="fa fa-pencil"></i> Editar</a>
                <div class="clearfix"></div>
                <?='<?
            }
            ?>'?>
        	</div>
        </div>
	</div>
</div>
