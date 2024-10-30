<div class="form">
	
	<?php $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'usuario-log-form',
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
        
        	    	    	    
    <div class="form-group">
		<?php echo $form->labelEx($model,'ip'); ?>
        <?php echo $form->textField($model, 'ip', array('maxlength' => 100,'class' => 'form-control')); ?>
    </div>
    <!-- row -->
        	    
    <div class="form-group">
		<?php echo $form->labelEx($model,'data'); ?>
        <?php $this->widget('CJuiDateTimePicker',array(
					'model'=>$model, //Model object
					'attribute'=>'data', //attribute name
					'language' => 'pt',
					'mode'=>'datetime', //use 'time','date' or 'datetime' (default)
					'htmlOptions' =>array(
						'class' => 'form-control',
					),
					'options'=>array(
						'readonly' => 'readonly',
						'class' => 'form-control',
						'changeYear' => true,
						'changeMonth' => true,
					)
				)
			); ?>
    </div>
    <!-- row -->
        	    
    <div class="form-group">
		<?php echo $form->labelEx($model,'idusuario'); ?>
        <?php echo $form->textField($model, 'idusuario', array('class' => 'form-control')); ?>
    </div>
    <!-- row -->
        	    
    <div class="form-group">
		<?php echo $form->labelEx($model,'usuario_nome'); ?>
        <?php echo $form->textField($model, 'usuario_nome', array('maxlength' => 100,'class' => 'form-control')); ?>
    </div>
    <!-- row -->
        	    
    <div class="form-group">
		<?php echo $form->labelEx($model,'usuario_email'); ?>
        <?php echo $form->textField($model, 'usuario_email', array('maxlength' => 100,'class' => 'form-control')); ?>
    </div>
    <!-- row -->
        	    
    <div class="form-group">
		<?php echo $form->labelEx($model,'controller'); ?>
        <?php echo $form->textField($model, 'controller', array('maxlength' => 100,'class' => 'form-control')); ?>
    </div>
    <!-- row -->
        	    
    <div class="form-group">
		<?php echo $form->labelEx($model,'action'); ?>
        <?php echo $form->textField($model, 'action', array('maxlength' => 100,'class' => 'form-control')); ?>
    </div>
    <!-- row -->
        	    
    <div class="form-group">
		<?php echo $form->labelEx($model,'get'); ?>
        <?php echo $form->textArea($model, 'get',array('rows'=>'10','class'=>'form-control')); ?>
    </div>
    <!-- row -->
        	    
    <div class="form-group">
		<?php echo $form->labelEx($model,'post'); ?>
        <?php echo $form->textArea($model, 'post',array('rows'=>'10','class'=>'form-control')); ?>
    </div>
    <!-- row -->
        	    
    <div class="form-group">
		<?php echo $form->labelEx($model,'acesso_status'); ?>
        <?php echo $form->textField($model, 'acesso_status', array('maxlength' => 100,'class' => 'form-control')); ?>
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