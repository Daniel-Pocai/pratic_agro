<div class="form">
	
	<?php $form = $this->beginWidget('GxActiveForm', array(
        'id' => 'historico-vendas-form',
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
            <div class="col-md-4">
		        <?php echo $form->labelEx($model,'data_venda'); ?>
                <?php $this->widget('CJuiDateTimePicker',array(
                        'model'=>$model, //Model object
                        'attribute'=>'data_venda', //attribute name
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
            <div class="col-md-4">
                <?php echo $form->labelEx($model, 'idrepresentante'); ?>
                <?php echo $form->dropDownList($model, 'idrepresentante', GxHtml::listDataEx(Representante::model()->findAllAttributes(null, true)), array(
                    'class' => 'form-control',
                    'empty' => 'Selecione...',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => CController::createUrl('historicoVendas/filtrarClientes'),
                        'update' => '#' . CHtml::activeId($model, 'idcliente'),
                        'data' => array('idrepresentante' => 'js:this.value'),
                    ),
                )); ?>
            </div>
            <div class="col-md-4">
                <?php echo $form->labelEx($model, 'idcliente'); ?>
                <?php echo $form->dropDownList($model, 'idcliente', array(), array('class' => 'form-control', 'empty' => 'Selecione...')); ?>
            </div>
        </div>
    </div>
    <!-- row -->   	    	    	    
    
    <div class="form-group">
		<?php echo $form->labelEx($model,'idproduto'); ?>
        <?php echo $form->dropDownList($model, 'idproduto', GxHtml::listDataEx(Produto::model()->findAllAttributes(null, true)), array('class' => 'form-control','empty'=>'Selecione...')); ?>
    </div>
    <!-- row -->
    <div class="form-group">    
        <div class="row">
            <div class="col-md-4">
                <?php echo $form->labelEx($model,'quantidade'); ?>
                <?php echo $form->textField($model, 'quantidade', array('class' => 'form-control')); ?>
            </div>
            <div class="col-md-4">
                <?php echo $form->labelEx($model,'valor_unitario'); ?>
                <?php echo $form->textField($model, 'valor_unitario', array('class' => 'form-control')); ?>
            </div>
            <div class="col-md-4">
                <?php echo $form->labelEx($model,'valor_total'); ?>
                <?php echo $form->textField($model, 'valor_total', array('class' => 'form-control')); ?>
            </div>
        </div>
    </div>
    <!-- row -->
            
        
    
	
    	
    
    <br>
    <div class="clearfix"></div>
    	<button class="btn pull-right btn-success"  type="submit"><?=Util::formataTexto("Salvar");?></button>
    <div class="clearfix"></div>
    
    <? 
	$this->endWidget(); 
	?>
	
</div>
<!-- form -->