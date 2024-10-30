<?php
$this->breadcrumbs[$model->label(2)] = array('index');
if($this->hasRel()){
	$this->breadcrumbs[$model->label(2)] = array('rel'=>$this->getRel());
}
?><div class="row">
  <div class="col-md-12">
      <h3 class="panel-title"> <?=Util::formataTexto($model->label(2));?>          <?
          if(!Yii::app()->user->isGuest){
              $this->renderPartial("//layouts/caminho");
          }
          ?> 
      </h3>
      <hr/>
    </div>
</div>
<div class="row">
	
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
   		<form action="<?=$this->createUrl('index');?>">
        	<?
            $qtd_filtro = (isset($_GET['filtro']) && is_array($_GET['filtro'])) ? count($_GET['filtro']) : 0;
			?>
        	<div class="panel panel-filtros">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                             <label>Módulo</label>
                             <?
                             $controllers = Yii::app()->metadata->getControllers();
                             ?>
                             <select name="filtro[<?=$qtd_filtro?>][controller]" data-url="<?=$this->createUrl('site/actions',array('controller'=>''));?>" class="form-control filtro-controller">
                                <option value="">Selecione...</option>
                                <?
                                foreach($controllers as $controller_class){
                                    $class = str_replace("Controller","",$controller_class);
			  						$modulo = strtolower($class);
									if($modulo != 'site' && !Yii::app()->user->obj->perfil->temPermissaoController($modulo)){
										continue;
									}
									?>
                                    <option value="<?=$modulo?>"><?=Dicionario::modulo($modulo)?></option>
                                    <?
                                }
                                ?>
                             </select>   
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                             <label>Ações</label> 
                             <select name="filtro[<?=$qtd_filtro?>][action]" class="form-control filtro-action">
                                <option value="">Selecione o módulo...</option>
                             </select>   
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Usuário</label>
                            <?
                            $criteria_perfis = new CDbCriteria();
                            $criteria_perfis->order = 'nome';
                            $usuarios = Usuario::model()->findAll($criteria_perfis);
                            $usuarios_list = CHtml::listData($usuarios,'idusuario','nome');
                            ?>     
                            <select name="filtro[<?=$qtd_filtro?>][idusuario]" class="form-control ">
                                <option value="">Selecione...</option>
                                <?
                                foreach($usuarios as $usuario){
                                    ?>
                                    <option value="<?=$usuario->idusuario?>"><?=Util::formataTexto($usuario->nome)?> (<?=Util::formataTexto($usuario->email)?>)</option>
                                    <?
                                }
                                ?>
                            </select>   
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Texto</label>
                            <input name="filtro[<?=$qtd_filtro?>][texto]" type="text" class="form-control" placeholder="Digite..." />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-default col-md-12"><i class="fa fa-plus"></i> Adicionar filtro</button>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-12">
                        <?
                        if(is_array($_GET['filtro'])){
                            foreach($_GET['filtro'] as $i => $filtro){
                                
								
								$get_exclusao = array();
								foreach($_GET['filtro'] as $i_exclusao => $filtro_exclusao){
									if($i_exclusao != $i)
										$get_exclusao['filtro'][] = $filtro_exclusao;
								}
								
								
								?>
								<a class="btn btn-info btn-sm" href="<?=$this->createUrl('index',$get_exclusao);?>">
								<?
								$textos = array();
                                if(!empty($filtro['controller'])){
                                    $textos[] = 'Módulo: '.Dicionario::modulo($filtro['controller']);
									?>
									<input name="filtro[<?=$i?>][controller]" value="<?=$filtro['controller']?>" type="hidden" />
									<?
                                }
                                if(!empty($filtro['action'])){
                                    $textos[] = 'Ação: '.Dicionario::acao($filtro['action']);
									?>
									<input name="filtro[<?=$i?>][action]" value="<?=$filtro['action']?>" type="hidden" />
									<?
                                }
                                if(!empty($filtro['idusuario'])){
                                    $textos[] = 'Usuário: '.Util::formataTexto($usuarios_list[$filtro['idusuario']]);
									?>
									<input name="filtro[<?=$i?>][idusuario]" value="<?=$filtro['idusuario']?>" type="hidden" />
									<?
                                }
								if(!empty($filtro['texto'])){
                                    $textos[] = 'Texto: '.Util::formataTexto($filtro['texto']);
									?>
									<input name="filtro[<?=$i?>][texto]" value="<?=$filtro['texto']?>" type="hidden" />
									<?
                                }
								
                                ?>
                                	<?=implode(" | ",$textos);?> &nbsp;&nbsp;&nbsp; <i class="fa fa-remove"></i>
                                    
                                </a>
								<?
                            }
                        }
                        else{
                            ?>
                            <p class="text-muted">Nenhum filtro selecionado</p>
                            <?
                        
                        }
                        ?>
                    </div>
                </div>
            </div>
   		</form>
		<div class="panel panel-default">
		<? 
        if(count($dataProvider->data) > 0){
            ?>         
            <table class="table table-hover table-registros">
                <thead>
                    <tr>
                    	<?
                        $autorizacao_delete = Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'delete');
						$autorizacao_status = Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'status');
						if($autorizacao_status || $autorizacao_delete){
							?>
                            <th style="width:60px;">
								<label class="cr-styled cr-acoes">
								  <input name="select-all" class="select-all" value="select-all" type="checkbox"><i class="fa"></i>
							  </label>
							</th>
							<?
						}
                        foreach($this->getRepresentingFields() as $field){
                            $icon = "fa-sort";
                            $ordem = "asc";
                            if($_GET['f'] == $field){
                                if($_GET['o'] == "asc"){
                                    $ordem = "desc";
                                    $icon = " fa-sort-desc";
                                }
                                elseif($_GET['o'] == "desc"){
                                    $ordem = "asc";
                                    $icon = " fa-sort-asc";
                                }
                            }
                            ?>                            <th>
                                <a href="<?php echo $this->createUrlRel('index',array_merge($_GET,array('f'=>$field,'o'=>$ordem)));?>">
                                    <?=Util::formataTexto($model->getAttributeLabel($field));?> 
                                    <i class="fa <?=$icon;?>"></i> 
                                </a>
                            </th>
                            <?
                        }
                        ?>                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    foreach($dataProvider->data as $data){
                        $this->renderPartial('_view',array('data'=>$data));
                    }
                    ?>                </tbody>
            </table>
            <hr>
            <? 
            $this->renderPartial("//layouts/paginacao",array(
                'pagination' => $dataProvider->pagination,
            ));
        }
        else{
        	?>			<p class="alert alert-warning">Nenhum registro encontrado</p>
			<?
		       
        }
        ?>        </div> <!-- panel -->
    </div>
   
</div>