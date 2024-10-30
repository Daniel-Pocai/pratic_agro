
<div class="row">
    <div class="col-md-4 col-sm-4 col-xs-4">
        
        
        <div class="row">
        	
            <div class="col-md-4 col-sm-12 menu-superior-table">
            
            <div class="btn-group ">
                 
                  <a href="#" aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">Selecione&nbsp;<i class="caret"></i></a>
                  <ul role="menu" class="dropdown-menu">
                    <li><a class="operacao-em-massa-habilitar" href="#"><i class="fa fa-check"></i> Habilitar</a></li>
                    <li><a class="operacao-em-massa-desabilitar" href="#"><i class="fa fa-ban"></i> Desabilitar</a></li>
                    <li><a class="operacao-em-massa-excluir" data-url="<?=$this->createUrl("delete");?>" href="#"><i class="fa fa-trash-o"></i> Excluir</a></li>
                  </ul>
             </div>
         
         </div>
         
         <div class="col-md-8 col-sm-12">
          
            <div class="pull-left">
              <form method="get" action="<?=$this->createUrl('index');?>">
                <div class="input-group">
                    <input type="text" id="example-input2-group2" name="q" value="<?=$_GET['q'];?>" class="form-control" placeholder="Buscar">
                    <span class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </span>
                </div>
              </form>
            </div>
            </div>
        
         </div>
        
    </div>
    
    
    <div class="col-md-8 col-sm-8 col-xs-8">
        <div class="m-b-30 text-right pull-right">
        	&nbsp;
        	<?
            if(Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'create')){
				?>
				<a href="<?=$this->createUrlRel('create');?>" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar <?=$model->label(1);?></a>
				<?
			}
            ?>
        </div>
    </div>
</div>
