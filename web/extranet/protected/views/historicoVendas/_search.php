
<div class="row">
    <div class="col-md-8 col-sm-7 col-xs-10">
        
        
        
        	
            <?
            $autorizacao_delete = Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'delete');
		 	$autorizacao_status = Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'status');
			if($autorizacao_delete || $autorizacao_status){
			?>            <div class="col-md-4 col-sm-5 col-xs-3 menu-superior-table">
                          
                <div class="btn-group ">
                      <a href="#" aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">Selecione&nbsp;<i class="caret"></i></a>
                      <ul role="menu" class="dropdown-menu">
                        <?
                        if($autorizacao_status){
							?>							<li><a class="operacao-em-massa-habilitar" href="#"><i class="fa fa-check"></i> Habilitar</a></li>
							<li><a class="operacao-em-massa-desabilitar" href="#"><i class="fa fa-ban"></i> Desabilitar</a></li>
							<?
						}
						if($autorizacao_delete){
							?>							<li><a class="operacao-em-massa-excluir" data-url="<?=$this->createUrl("delete");?>" href="#"><i class="fa fa-trash-o"></i> Excluir</a></li>
							<?
						}
						?>                      </ul>
                 </div>
             </div>
             <?
			}
			 ?>         
         <div class="col-md-8 col-sm-7 col-xs-9">
          
            <div class="pull-left">
              <?php echo CHtml::beginForm(array($this->id.'/'.$this->action->id), 'get', array('class'=>'form-inline')); ?>                <div class="input-group">
                    <input type="text" id="example-input2-group2" name="q" value="<?=$_GET['q'];?>" class="form-control" placeholder="Buscar">
                    <span class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </span>
                </div>
              <?php echo CHtml::endForm(); ?>            </div>
         </div>
        
        
        
    </div>
    
    
    <div class="col-md-4 col-sm-5 col-xs-2">
        <div class="m-b-30 text-right pull-right">
        	&nbsp;
        	<?
            if(Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'create')){
				?>				<a href="<?=$this->createUrlRel('create');?>" class="btn btn-success"><i class="fa fa-plus"></i> <span class="hidden-xs">Adicionar <?=$model->label(1);?></span></a>
				<?
			}
            ?>        </div>
    </div>
</div>
