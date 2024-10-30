<div class="form">
	
	<?php $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'categoria-form',
        'enableAjaxValidation' => false,
        'htmlOptions'=> array (
            'class' => 'form-horizontal',
            'enctype' => 'multipart/form-data',
			'action' => $this->createUrlRel($this->action->id),
        )
    ));
    ?> 
	<? 
    $this->renderPartial("//layouts/erros",array(
        'model' => $model,
    ));
    ?>
      <?php
            if (!is_numeric($model->posicao)) {
                echo $form->hiddenField($model, 'posicao', array('value' => $model->getLast()));
            } else {
                echo $form->hiddenField($model, 'posicao', array('value' => $model->posicao));
            }
        ?>
    <!-- row -->
        	    
    <div class="form-group">
		<?php echo $form->labelEx($model,'nome'); ?>
        <?php echo $form->textField($model, 'nome', array('maxlength' => 100,'class' => 'form-control')); ?>
    </div>
    <!-- row -->
        	    
    <div class="form-group">
		<?php echo $form->labelEx($model,'descricao'); ?>
        <?php echo $form->textArea($model, 'descricao',array('rows'=>'10','class'=>'form-control')); ?>
    </div> 	    
    
    <!-- row -->
            
        
    
	<?
	if(Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'status')){
		?>
		<div class="form-group">
			<?php echo $form->labelEx($model,'habilitar'); ?>
			<div class="clear"></div>
			<label class="cr-styled">
				<?php echo $form->checkBox($model, 'habilitar'); ?> <i class="fa"></i>
			</label>   
		</div>
        <!-- row -->
		
		<?
	}
	?>
    	
    
    <br>
    <div class="clearfix"></div>
    	<button class="btn pull-right btn-success"  type="submit"><?=Util::formataTexto("Salvar");?></button>
    <div class="clearfix"></div>
    
    <? 
	$this->endWidget(); 
	?>
	
</div>
<!-- form -->