<div class="crop-modal modal fade"  aria-labelledby="modalLabel" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
 
          <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Selecione o corte da imagem</h4>
              </div>
          
          <div class="modal-body" >
          	<?/* 
            <div class="row" id=actions>
            	<div class="col-md-12 docs-buttons">
		             <div class="btn-group">
		                <label class="btn btn-primary btn-upload" for="inputImage" title="Escolher arquivo">
		                  <input type="file" class="sr-only" id="inputImage" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
		                  <span class="docs-tooltip" data-toggle="tooltip" title="Escolher arquivo">
		                    <span class="fa fa-upload"></span>
		                  </span>
		                </label>
		                <button type="button" class="btn btn-default" data-method="reset" title="Restaurar">
		                  <span class="docs-tooltip" data-toggle="tooltip" title="Restaurar">
		                    <span class="fa fa-refresh"></span>
		                  </span>
		                </button>
		              </div>
		              <div class="btn-group">
		                <button type="button" class="btn btn-default" data-method="zoom" data-option="0.1" title="Zoom In">
		                  <span class="docs-tooltip" data-toggle="tooltip" title="Zoom In">
		                    <span class="fa fa-search-plus"></span>
		                  </span>
		                </button>
		                <button type="button" class="btn btn-default" data-method="zoom" data-option="-0.1" title="Zoom Out">
		                  <span class="docs-tooltip" data-toggle="tooltip" title="Zoom Out">
		                    <span class="fa fa-search-minus"></span>
		                  </span>
		                </button>
		              </div>
		              <div class="btn-group">
		                <button type="button" class="btn btn-default" data-method="move" data-option="-10" data-second-option="0" title="Mover para esquerda">
		                  <span class="docs-tooltip" data-toggle="tooltip" title="Mover para esquerda">
		                    <span class="fa fa-arrow-left"></span>
		                  </span>
		                </button>
		                <button type="button" class="btn btn-default" data-method="move" data-option="10" data-second-option="0" title="Mover para direita">
		                  <span class="docs-tooltip" data-toggle="tooltip" title="Mover para direita">
		                    <span class="fa fa-arrow-right"></span>
		                  </span>
		                </button>
		                <button type="button" class="btn btn-default" data-method="move" data-option="0" data-second-option="-10" title="Mover para cima">
		                  <span class="docs-tooltip" data-toggle="tooltip" title="Mover para cima">
		                    <span class="fa fa-arrow-up"></span>
		                  </span>
		                </button>
		                <button type="button" class="btn btn-default" data-method="move" data-option="0" data-second-option="10" title="Mover para baixo">
		                  <span class="docs-tooltip" data-toggle="tooltip" title="Mover para baixo">
		                    <span class="fa fa-arrow-down"></span>
		                  </span>
		                </button>
		              </div>
		              <div class="btn-group">
		                <button type="button" class="btn btn-default" data-method="rotate" data-option="-45" title="Girar 45° para esquerda">
		                  <span class="docs-tooltip" data-toggle="tooltip" title="Girar 45° para esquerda">
		                    <span class="fa fa-rotate-left"></span>
		                  </span>
		                </button>
		                <button type="button" class="btn btn-default" data-method="rotate" data-option="45" title="Girar 45° para direita">
		                  <span class="docs-tooltip" data-toggle="tooltip" title="Girar 45° para direita">
		                    <span class="fa fa-rotate-right"></span>
		                  </span>
		                </button>
		              </div>
		              <div class="btn-group">
		                <button type="button" class="btn btn-default" data-method="scaleX" data-option="-1" title="Flip Horizontal">
		                  <span class="docs-tooltip" data-toggle="tooltip" title="Flip Horizontal">
		                    <span class="fa fa-arrows-h"></span>
		                  </span>
		                </button>
		                <button type="button" class="btn btn-default" data-method="scaleY" data-option="-1" title="Flip Vertical">
		                  <span class="docs-tooltip" data-toggle="tooltip" title="Flip Vertical">
		                    <span class="fa fa-arrows-v"></span>
		                  </span>
		                </button>
              </div>
            </div>
            
            */?>
            
      
            <div class="m-t-10" style="height:500px;text-align:center;">
              <img style="width:100%;display:none;" class="crop-modal-img" src="#" alt="Picture">
            </div>
          </div>
          <div class="modal-footer">
          	<a hfre="#" class="crop-modal-save btn btn-default pull-left">
          		<i class="fa fa-loading fa-refresh fa-spin" style="display: none;"></i> <i class="fa fa-save fa-check"></i> Salvar
          	</a>
          
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
     </div>
</div>
<?
$cid = time();
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/crop/cropper.css?v='.$cid);
Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl.'/crop/cropper.js');
Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl.'/crop/main.js?v='.$cid );
