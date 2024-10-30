<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<?
        $this->renderPartial("//layouts/header");
		?>
    </head>
    <body>
		<?
        $this->renderPartial("//layouts/menu");
		?>
        <section class="content">
			<?
			if(!Yii::app()->user->isGuest){
				$this->renderPartial("//layouts/topo");
			}
			?>
            <div class="wraper container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>
            <?
			$this->renderPartial("//layouts/rodape");
			?>
        </section>
		<div id="dialog" class="modal-block mfp-hide">
            <section class="panel panel-info panel-color">
                <header class="panel-heading">
                    <h2 class="panel-title">Voc&ecirc; tem certeza?</h2>
                </header>
                <div class="panel-body">
                    <div class="modal-wrapper">
                        <div class="modal-text">
                            <p>Voc&ecirc; tem certeza que quer deletar esse item?</p>
                        </div>
                    </div>
                    <div class="row m-t-20">
                        <div class="col-md-12 text-right">
                            <button id="dialogConfirm" class="btn btn-primary">Sim</button>
                            <button id="dialogCancel" class="btn btn-default">Cancelar</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Modal -->
        <div class="modal fade modal-main" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
              </div>
              <div class="modal-body">
                ...
              </div>
              <div class="modal-footer"></div>
            </div>
          </div>
        </div>

        <?
        $this->renderPartial("//layouts/crop");
		$this->renderPartial("//layouts/scripts");		
		?>
	</body>
</html>
