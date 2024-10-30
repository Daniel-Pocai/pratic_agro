<div class="form">
	
	<?php $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'produto-form',
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
        <div class="col-md-4">
          <?php echo $form->labelEx($model,'idcategoria'); ?>
          <?php echo $form->dropDownList($model, 'idcategoria', GxHtml::listDataEx(Categoria::model()->findAllAttributes(null, true)), array('class' => 'form-control','empty'=>'Selecione...')); ?>
        </div>
        <div class="col-md-4">
          <?php echo $form->labelEx($model,'tipo'); ?>
            <?php echo $form->dropDownList($model, 'tipo',$model->getTipoArray(), array('class' => 'form-control','empty'=>'Selecione...')); ?>
        </div>
        <div class="col-md-4">
          <?php echo $form->labelEx($model,'nome'); ?>
          <?php echo $form->textField($model, 'nome', array('maxlength' => 100,'class' => 'form-control')); ?>
        </div>
      </div>
    </div>
    <!-- row -->
  
    <!-- row -->
    <div class="form-group">    
      <?php echo $form->labelEx($model,'subtitulo'); ?>
      <?php echo $form->textField($model, 'subtitulo',array('rows'=>'10','class'=>'form-control')); ?>
    </div>
    <!-- row -->
        	    
    
        	    
    <div class="form-group">
		<?php echo $form->labelEx($model,'descricao'); ?>
        <?php $this->widget('ext.imperavi-redactor-widget.ImperaviRedactorWidget',array(
			'model'=>$model,
			'attribute'=>'descricao',
		  )); ?>
    </div>
    <!-- row -->

    <div class="form-group">    
      <div class="row">
      <div class="col-md-4">
        <?php echo $form->labelEx($model, 'apresentacao'); ?>
        <?php echo $form->textField($model, 'apresentacao', array('maxlength' => 100, 'class' => 'form-control', 'placeholder' => 'Separe os tipos por vírgula')); ?>
    </div>
        <div class="col-md-4">
          <?php echo $form->labelEx($model,'embalagem'); ?>
          <?php echo $form->textField($model, 'embalagem', array('maxlength' => 100,'class' => 'form-control')); ?>
        </div>
        <div class="col-md-4">
          <?php echo $form->labelEx($model,'principio_ativo'); ?>
          <?php echo $form->dropDownList($model, 'principio_ativo',$model->getPrincipioAtivoArray(), array('class' => 'form-control','empty'=>'Selecione...')); ?>
        </div>
      </div>
    </div>
    <!-- row -->
    <div class="form-group">
      <?php echo $form->labelEx($model,'dados_produto'); ?>
      <?php echo $form->textArea($model, 'dados_produto',array('rows'=>'10','class'=>'form-control')); ?>
    </div>
    <!-- row -->	    
     
    <div class="form-group">    
      <div class="row">
        <div class="col-md-4">
          <?php echo $form->labelEx($model,'preco_liquido'); ?>
          <?php echo $form->textField($model, 'preco_liquido', array('class' => 'form-control')); ?>
        </div>
        <div class="col-md-4">
          <?php echo $form->labelEx($model,'preco_bruto'); ?>
          <?php echo $form->textField($model, 'preco_bruto', array('class' => 'form-control')); ?>
        </div>
        <div class="col-md-4">
          <?php echo $form->labelEx($model,'diluicao'); ?>
          <?php echo $form->textField($model, 'diluicao', array('class' => 'form-control')); ?>
        </div>
      </div>
    </div>
    <!-- row -->

    <div class="form-group">    
      <div class="row">
        <div class="col-md-4">
          <?php echo $form->labelEx($model,'foto'); ?>
            <?php $this->widget('application.extensions.PluploadImagem.PluploadImagem', array(
          'model' => $model,
          'attribute' => 'foto',
          //'return_size' => 250 //default = 200;
          )); ?>
        </div>
        <div class="col-md-6">
          <?php echo $form->labelEx($model,'baixar_pdf'); ?>
              <?php $this->widget('application.extensions.Plupload.PluploadWidget', array(
            'model' => $model,
            'attribute' => 'baixar_pdf',
            )); ?>
        </div>
      </div>
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