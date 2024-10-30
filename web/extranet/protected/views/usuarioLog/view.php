<?php
$this->breadcrumbs[$model->label(2)] = array('index');
if($this->hasRel()){
	$this->breadcrumbs[$model->label(2)] = array('rel'=>$this->getRel());
}
$this->breadcrumbs[] = Yii::t('app','Visualizar');

$form = new GxActiveForm();


if(isset($_GET['success'])){
	
	$msg = "Cadastro atualizado com sucesso!";
	if($_GET['success'] == 'create'){
		$msg = "Cadastro realizado com sucesso!";
	}
	
	Yii::app()->clientScript->registerScript('helpers', '                                                           
		swal("'.$msg.'", "Confira os dados", "success");                                                                                                          
	',2);
}

?><div class="row">
  <div class="col-md-12">
      <h3 class="panel-title"> Visualizar <?=Util::formataTexto($model->label(1));?>          <?
          if(!Yii::app()->user->isGuest){
              $this->renderPartial("//layouts/caminho");
          }
          ?> 
      </h3>
      <hr/>
    </div>
</div>
<div class="row">
	<div class="col-md-9 col-sm-12">
    
    	
		<div class="panel panel-default">
        
          <div class="panel-heading">
              <h3 class="panel-title">Sessão</h3>
          </div>
          <div class="grid-structure" style="margin-top:10px;">
              <div class="row">
                <div class="col-md-4">
                  <?=Util::formataTexto($model->getAttributeLabel('data'));?></dt>
                  <div class="grid-container">
                      <?=Util::formataTexto($model->data)?>                 	
                  </div>
                </div>
                <div class="col-md-4">
                  <?=Util::formataTexto($model->getAttributeLabel('ip'));?></dt>
                  <div class="grid-container">
                      <?=Util::formataTexto($model->ip)?>
                   </div>
                </div>
                <div class="col-md-4">
                  <?=Util::formataTexto($model->getAttributeLabel('session_id'));?></dt>
                  <div class="grid-container">
                      <?=Util::formataTexto($model->session_id)?>
                   </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <?=Util::formataTexto($model->getAttributeLabel('Usuário'));?></dt>
                  <div class="grid-container">
                      <?=Util::formataTexto($model->usuario_nome)?> (<?=Util::formataTexto($model->usuario_email)?>)               	
                  </div>
                </div>
                <div class="col-md-4">
                  <?=Util::formataTexto($model->getAttributeLabel('controller'));?></dt>
                  <div class="grid-container">
                      <?=Dicionario::modulo($model->controller)?>                 	</div>
                </div>
                <div class="col-md-4">
                  <?=Util::formataTexto($model->getAttributeLabel('action'));?></dt>
                  <div class="grid-container">
                      <?=Dicionario::acao($model->action)?>                 	
                   </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <?=Util::formataTexto($model->getAttributeLabel('navegador_nome'));?></dt>
                  <div class="grid-container">
                      <?=Util::formataTexto($model->navegador_nome)?>                 	
                   </div>
                </div>
                <div class="col-md-4">
                  <?=Util::formataTexto($model->getAttributeLabel('navegador_versao'));?></dt>
                  <div class="grid-container">
                      <?=Util::formataTexto($model->navegador_versao)?>                 	
                  </div>
                </div>
                <div class="col-md-4">
                  <?=Util::formataTexto($model->getAttributeLabel('so'));?></dt>
                  <div class="grid-container">
                      <?=Util::formataTexto($model->so)?>                 	
                   </div>
                </div>
              </div>
       	 </div>  
         
          <div class="panel-heading" style="margin-top:30px;">
              <h3 class="panel-title">Registro</h3>
          </div>
          <div class="grid-structure" style="margin-top:10px;">
              <div class="row">
                <div class="col-md-12">
                  <?=Util::formataTexto($model->getAttributeLabel('registro_nome'));?></dt>
                  <div class="grid-container">
                      <?=Util::formataTexto($model->registro_nome)?>                 	</div>
                </div>
              </div>
              
              <div class="row">
                <div class="col-md-12">
                  <?=Util::formataTexto($model->getAttributeLabel('registro_id'));?></dt>
                  <div class="grid-container">
                      <?=Util::formataTexto($model->registro_id)?>                 	</div>
                </div>
              </div>
              
              <div class="row">
                <div class="col-md-12">
                  <?=Util::formataTexto($model->getAttributeLabel('registro_dados'));?></dt>
                  <pre><? print_r(CJSON::decode($model->registro_dados))?></pre> 
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <?=Util::formataTexto($model->getAttributeLabel('registro_erro'));?></dt>
                  <div class="grid-container">
                      <?
                      if(!empty($model->registro_erro)){
                          ?>
                          <div class="alert alert-danger"><?=$model->registro_erro?></div>
                          <?
                      }
                      else{
                          ?>
                          <div class="text-mute">Não registrado</div>
                          <?
                      }
                      ?>             	
                  </div>
                </div>
              </div>
           </div>
            
          <div class="panel-heading requisicao-heading" style="margin-top:30px;">
              <div class="row">
              	<div class="col-md-10">
                	<h3 class="panel-title">Requisição</h3>
                </div>
                <div class="col-md-2 text-right">
                	<a href="#" class="btn btn-default btn-xs pull-right requisicao-btn">
                        <i class="ion-plus-round"></i>
                    </a>
                </div>
              </div>
          </div>
          
          <div class="grid-structure requisicao-div hide" style="margin-top:10px;">  
           
               <div class="row">
                  <div class="col-md-12">
				  	<?=Util::formataTexto($model->getAttributeLabel('get'));?></dt>
                    <pre><? print_r(CJSON::decode($model->get))?></pre>
               	  </div>
           		</div>
               
               <div class="row">
                  <div class="col-md-12">
				  	<?=Util::formataTexto($model->getAttributeLabel('post'));?></dt>
                    <pre><? print_r(CJSON::decode($model->post))?></pre>
               	  </div>
           		</div>
                    		                  <div class="row">
                  <div class="col-md-12">
				  	<?=Util::formataTexto($model->getAttributeLabel('server'));?></dt>
                    <pre><? print_r(CJSON::decode($model->server))?></pre>
               	  </div>
           		</div>
                    		                  <div class="row">
                  <div class="col-md-12">
				  	<?=Util::formataTexto($model->getAttributeLabel('session'));?></dt>
                    <pre><? print_r(CJSON::decode($model->session))?></pre>    
               	  </div>
           		</div>
                
               <div class="row">
                  <div class="col-md-12">
				  	<?=Util::formataTexto($model->getAttributeLabel('cookies'));?></dt>
                    <pre><? print_r(CJSON::decode($model->cookies))?></pre>    
               	  </div>
           		</div>
         </div>
         
         
        
        </div>
	</div>
</div>
