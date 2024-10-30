
        <aside class="left-panel <?=$_COOKIE['menu-modo'] == 'retrair' ? ' collapsed' : '' ;?> <?=$_COOKIE['menu-modo']?>">
            <div class="logo text-center">
                <a href="<?=$this->createUrl('site/index');?>" class="logo-expanded text-center">
                    <span><img src="<?=Yii::app()->baseUrl?>/img/logo-publisher-small.png" alt="Publisher" class="img-responsive center-block"></span>
                    <span class="nav-label"><img src="<?=Yii::app()->baseUrl?>/img/logo-publisher.png" alt="Publisher" class="img-responsive center-block"></span>
                </a>
            </div>
            
            <nav class="navigation">
                <ul class="list-unstyled">
                    <li class="<?=$this->id == "site" ? "active": "" ?>"><a href="<?=$this->createUrl('site/index')?>"><i class="fa fa-home"></i> <span class="nav-label">Inicial</span></a></li>
                    <?
                    if (Yii::app()->user->obj->perfil->temPermissaoController('banner')) {
                    ?>
                        <li class="<?= $this->id == "banner" ? "active" : "" ?>"><a href="<?= $this->createUrl('banner/index') ?>"><i class="fa fa-picture-o"></i> <span class="nav-label">Banner</span></a></li>
                    <?
                    }
                    if (Yii::app()->user->obj->perfil->temPermissaoController('categoria')) {
                    ?>
                        <li class="<?= $this->id == "categoria" ? "active" : "" ?>"><a href="<?= $this->createUrl('categoria/index') ?>"><i class="fa fa-list"></i> <span class="nav-label">Categoria</span></a></li>
                    <?
                    }
                    if (Yii::app()->user->obj->perfil->temPermissaoController('produto')) {
                    ?>
                        <li class="<?= $this->id == "produto" ? "active" : "" ?>"><a href="<?= $this->createUrl('produto/index') ?>"><i class="fa fa-barcode"></i> <span class="nav-label">Produto</span></a></li>
                    <?
                    }
                    if (Yii::app()->user->obj->perfil->temPermissaoController('representante')) {
                    ?>
                        <li class="<?= $this->id == "representante" ? "active" : "" ?>"><a href="<?= $this->createUrl('representante/index') ?>"><i class="fa fa-user"></i> <span class="nav-label">Representante</span></a></li>
                    <?
                    }
                    if (Yii::app()->user->obj->perfil->temPermissaoController('cliente')) {
                    ?>
                        <li class="<?= $this->id == "cliente" ? "active" : "" ?>"><a href="<?= $this->createUrl('cliente/index') ?>"><i class="fa fa-users"></i> <span class="nav-label">Cliente</span></a></li>
                    <?
                    }
                    if (Yii::app()->user->obj->perfil->temPermissaoController('historicoVendas')) {
                    ?>
                        <li class="<?= $this->id == "historicoVendas" ? "active" : "" ?>"><a href="<?= $this->createUrl('historicoVendas/index') ?>"><i class="fa fa-file-o"></i> <span class="nav-label">Historico de vendas</span></a></li>
                    <?
                    }
					/*if(Yii::app()->user->obj->perfil->temPermissaoController('noticia')){
						?>
						<li class="<?=$this->id == "noticia" ? "active": "" ?>"><a href="<?=$this->createUrl('noticia/index')?>"><i class="fa fa-newspaper-o"></i> <span class="nav-label">Notícias</span></a></li>
						<?
					}*/
					?>
					                
                </ul>
            </nav>
            
			
            
        </aside>