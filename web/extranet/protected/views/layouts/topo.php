            <!-- Header -->
            <header class="top-head container-fluid">
                <button type="button" class="navbar-toggle menu-toggle pull-left" style="margin-right:0px;">
                    <span class="sr-only">Menu</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                <?php /*?><!-- Search -->
                <form role="search" class="navbar-left app-search pull-left hidden-xs">
                  <input type="text" placeholder="Busque..." class="form-control">
                </form><?php */?>
                
                <!-- Left navbar -->
                <nav class=" navbar-default hidden-xs" role="navigation" style="margin-left:0px;">
                    <ul class="nav navbar-nav">
                        <li><a href="<?php echo $this->createUrl('site/index'); ?>">Sistema administrativo</a></li>
                    </ul>
                </nav>
                
                <!-- Right navbar -->
                <ul class="list-inline navbar-right top-menu top-right-menu">  
                    <!-- Notification -->
                    <?
                    if(Yii::app()->user->obj->perfil->temPermissaoController('perfil') || Yii::app()->user->obj->perfil->temPermissaoController('usuario')){
						?>
						<li class="dropdown">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="fa fa-users"></i>
							</a>
							<ul class="dropdown-menu extended fadeInUp animated nicescroll" tabindex="5002">
								<li class="noti-header">
									<p>Administrativo</p>
								</li>
                                <?
								if(Yii::app()->user->obj->perfil->temPermissaoController('perfil')){
									?>
                                    <li>
                                        <a href="<?php echo $this->createUrl('perfil/index'); ?>">
                                            <span class="pull-left"><i class="fa fa-wrench fa-2x text-info"></i></span>
                                            <span>Perfis<br><small class="text-muted">Perfil/Permissão de Usuários</small></span>
                                        </a>
                                    </li>
                                    <?
								}
								if(Yii::app()->user->obj->perfil->temPermissaoController('usuario')){
									?>
									<li>
										<a href="<?php echo $this->createUrl('usuario/index'); ?>">
											<span class="pull-left"><i class="fa fa-user-plus fa-2x text-info"></i></span>
											<span>Usuários<br><small class="text-muted">Administração de Usuários</small></span>
										</a>
									</li>
									<?
								}
								?>
							</ul>
						</li>
						<!-- /Notification -->
						<?
					}
					?>

                    <!-- user login dropdown start-->
                    <li class="dropdown text-center">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="username"><?=Util::formataTexto(Yii::app()->user->obj->nome);?></span> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu extended pro-menu fadeInUp animated" tabindex="5003" style="overflow: hidden; outline: none;">
                            <li><a href="<?php echo $this->createUrl('usuario/update',array('id'=>Yii::app()->user->obj->idusuario)); ?>"><i class="fa fa-briefcase"></i>Meu Cadastro</a></li>
                            <li><a href="<?php echo $this->createUrl('site/logout'); ?>"><i class="fa fa-sign-out"></i> Sair</a></li>
                        </ul>
                    </li>    
                </ul>
            </header>
            <!-- Header Ends -->
