<div class="form">
	
	<?php $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'banner-form',
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
		<div class="row">
			<div class="col-md-6">
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
			<div class="col-md-2">
				<?php echo $form->labelEx($model,'nova_aba'); ?>
				<div class="clear"></div>
				<label class="cr-styled">
					<?php echo $form->checkBox($model, 'nova_aba'); ?> <i class="fa"></i>
				</label>
			</div>
		</div>
	</div>
    <!-- row -->
        	    
	<div class="form-group">
        <div class="row">
            <?php
            if (!is_numeric($model->posicao)) {
                echo $form->hiddenField($model, 'posicao', array('value' => $model->getLast()));
            } else {
                echo $form->hiddenField($model, 'posicao', array('value' => $model->posicao));
            }
        ?>
		</div>
	</div>
	<div class="form-group">    
		<div class="row">
			<div class="col-md-6">
                <?php echo $form->labelEx($model,'local'); ?>
                <?php echo $form->dropDownList($model, 'local',$model->getLocalArray(), array('class' => 'form-control','empty'=>'Selecione...')); ?>
            </div>
			<div class="col-md-6">
				<?php echo $form->labelEx($model,'titulo'); ?>
				<?php echo $form->textField($model, 'titulo', array('maxlength' => 100,'class' => 'form-control')); ?>
			</div>
		</div>
	</div>
    <!-- row -->
    <div class="form-group">    
		<div class="row">
			<div class="col-md-6">
				<?php echo $form->labelEx($model,'data_entrada'); ?>
				<?php $this->widget('CJuiDateTimePicker',array(
							'model'=>$model, //Model object
							'attribute'=>'data_entrada', //attribute name
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
			<div class="col-md-6">
				<?php echo $form->labelEx($model,'data_saida'); ?>
				<?php $this->widget('CJuiDateTimePicker',array(
						'model'=>$model, //Model object
						'attribute'=>'data_saida', //attribute name
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
		</div>
	</div>
    <!-- row -->
        	    
    <div class="form-group">
		<?php echo $form->labelEx($model,'link'); ?>
        <?php echo $form->textField($model, 'link', array('maxlength' => 200,'class' => 'form-control')); ?>
    </div>
    <!-- row -->
        	    
    <div class="form-group">
		<?php echo $form->labelEx($model,'imagem'); ?>
        <?php $this->widget('application.extensions.PluploadImagem.PluploadImagem', array(
			'model' => $model,
			'attribute' => 'imagem',
			//'return_size' => 250 //default = 200;
		  )); ?>
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