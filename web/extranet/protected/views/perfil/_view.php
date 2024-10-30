<tr data-id="<?=$data->getPrimaryKey()?>">
  <td style="max-width:10px;" class="mail-select">
      <label class="cr-styled cr-acoes">
          <input name="id[]" class="operacao-id" data-name="<?=$data->representingName()?>" value="<?=$data->idperfil?>" type="checkbox"><i class="fa"></i>
      </label>
  </td>
  <?
  foreach($this->getRepresentingFields() as $field){
  	?>
	<td><?= Util::formataTexto($data->$field);?></td>
	<?
  }
  ?>
  <td>
  	<a class="btn btn-default" style="width:150px;" href="<?=$this->createUrl('usuario/index',array('idperfil'=>$data->idperfil));?>"><i class="fa fa-user"></i> Usuários (<?=count($data->usuarios)?>)</a>
  </td>
  <td class="text-right td-operacoes">
  	<span>
      <?
      if ($data->habilitar=="1"){
          if(Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'status')){
              ?><a href="<?php echo $this->createUrlRel('status',array('id'=>$data->idperfil,'habilitar' => 0));?>" data-base-url="<?php echo $this->createUrlRel('status',array('id'=>$data->idperfil));?>" title="Desabilitar Registro" class="btn  btn-default desativar btn-status"><i class="fa fa-check ativo"></i></a><?
          }
          else{
              ?>
              <span class="btn-default btn  disabled"><i class="fa fa-check ativo"></i></span>
              <?
          }
      }
      else{
          if(Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'status')){
              ?><a href="<?php echo $this->createUrlRel('status',array('id'=>$data->idperfil,'habilitar' => 1));?>" data-base-url="<?php echo $this->createUrlRel('status',array('id'=>$data->idperfil));?>" title="Habilitar Registro" class="btn  btn-default ativar btn-status"><i class="fa fa-ban inativo"></i></a><?
          }
          else{
              ?>
              <span class="btn-default btn  disabled"><i class="fa fa-ban inativo"></i></span>
              <?
          }
      }
      ?>
    </span>
      <div class="btn-group dropdown ">
          <?
          if(Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'update')){
			  ?>
			  <a class="btn btn-default" href="<?php echo $this->createUrlRel('update',array('id'=>$data->idperfil));?>"><i class="fa fa-pencil"></i> Editar</a>
			  <?
		  }
          $autorizacao_delete = Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'delete');
		  $autorizacao_view = Yii::app()->user->obj->perfil->temPermissaoAction($this->id,'view');
		  if($autorizacao_delete || $autorizacao_view){
			  ?>
			  <a href="#" aria-expanded="false" data-toggle="dropdown" class="btn btn-default" dropdown-toggle" type="button"><i class="caret"></i></a>
			  <ul role="menu" class="dropdown-menu">
				  <?
				  if($autorizacao_view){
					  ?>
					  <li><a href="<?php echo $this->createUrlRel('view',array('id'=>$data->idperfil));?>"><i class="fa fa-search"></i> Exibir</a></li>
					  <?
				  }
				  if($autorizacao_delete){
					  ?>
					  <li><a href="<?php echo $this->createUrlRel('delete',array('id'=>$data->idperfil));?>" class="btn-delete"><i class="fa fa-trash-o"></i> Excluir</a></li>
					  <?
				  }
				  ?>
			  </ul>
			  <?
		  }
		  ?>
      </div>
  </td>
</tr>