<div class="form">
	
	<?='<?php $form = $this->beginWidget(\'GxActiveForm\', array(
        \'id\' => \''.$this->class2id($this->modelClass).'-form\',
        \'enableAjaxValidation\' => false,
        \'htmlOptions\'=> array (
            \'class\' => \'form-horizontal\',
            \'enctype\' => \'multipart/form-data\',
			\'action\' => $this->createUrlRel($this->action->id),
        )
    ));
    ?>'?>
 
	<?='<? 
    $this->renderPartial("//layouts/erros",array(
        \'model\' => $model,
    ));
    ?>
    '?>
    
    <? 
	Yii::import('system.gii.generators.model.ModelCode'); 
	$model_code = new ModelCode();
	?>
    <?php foreach ($this->tableSchema->columns as $column): ?>
	<?php if (!$column->autoIncrement && $column->name != 'excluido' && $column->name != 'habilitar'): ?>
    
    <div class="form-group">
		<?php echo "<?php echo " . $this->generateActiveLabel($this->modelClass, $column) . "; ?>\n"; ?>
        <?
        if ($column->size == 1){
			echo "<div class=\"clear\"></div>
		<label class=\"cr-styled\">
			<?php echo \$form->checkBox(\$model, '".$column->name."'); ?> <i class=\"fa\"></i>
		</label>\n";
		}
		elseif ($column->size == 120){
			echo "<?php " . $this->generateActiveField($this->modelClass, $column) . "; ?>\n";
			echo "<img style=\"margin-top:10px;\" class=\"img-thumbnail\" src=\"<?php echo Yii::app()->request->baseUrl; ?>/<?=\$model->". $model_code->generateClassName($column->name)."->getAttachment('p');?>\" />";
			echo "<?
		if(!empty(\$model->".$column->name.")){
			?>
			<div class=\"clear\"></div>
			<label style=\"margin-top:10px;\" class=\"cr-styled\"><?php echo \$form->checkbox(\$model,'".$column->name."_delete'); ?> <i class=\"fa\"></i> Excluir imagem</label>
			<?
		}
		?>\n";
		}
		else{
			echo "<?php " . $this->generateActiveField($this->modelClass, $column) . "; ?>\n";
		}
		?>
    </div>
    <!-- row -->
    <?php endif; ?>
    <?php endforeach; ?>
    
    <?php /*?><?php foreach ($this->getRelations($this->modelClass) as $relation): ?>
	<?php if ($relation[1] == GxActiveRecord::HAS_MANY || $relation[1] == GxActiveRecord::MANY_MANY): ?>
            <label><?php echo '<?php'; ?> echo GxHtml::encode($model->getRelationLabel('<?php echo $relation[0]; ?>')); ?></label>
            <?php echo '<?php ' . $this->generateActiveRelationField($this->modelClass, $relation) . "; ?>\n"; ?>
    <?php endif; ?>
    <?php endforeach; ?><?php */?>
    
    <?='
	<?
	if(Yii::app()->user->obj->perfil->temPermissaoAction($this->id,\'status\')){
		?>
		'?><div class="form-group">
			<?='<?php echo $form->labelEx($model,\'habilitar\'); ?>
			'?><div class="clear"></div>
			<label class="cr-styled">
				<?='<?php echo $form->checkBox($model, \'habilitar\'); ?>'?> <i class="fa"></i>
			</label>   
		</div>
        <!-- row -->
		<?='
		<?
	}
	?>
    '?>
	
    
    <br>
    <div class="clearfix"></div>
    	<button class="btn pull-right btn-success"  type="submit"><?='<?=Util::formataTexto("Salvar");?>'?></button>
    <div class="clearfix"></div>
    
    <?='<? 
	$this->endWidget(); 
	?>
	
'?>
</div>
<!-- form -->