<?php
class PluploadImagem extends CWidget {

    const ASSETS_DIR_NAME       = 'assets';
    const PLUPLOAD_FILE_NAME    = 'plupload.full.min.js';
    const JQUERYQUEUE_FILE_NAME = 'jquery.plupload.queue.min.js';
    const FLASH_FILE_NAME       = 'plupload.flash.swf';
    const DEFAULT_RUNTIMES      = 'flash';
    const PUPLOAD_CSS_PATH      = 'css3/plupload.queue.css';
    const INIT_FILE             = 'init.js';

    public $model;
    public $attribute;
    public $return_size = 200;

    public $folder = 'uploads';
    protected $class;
    protected $value;

    public function init() {

        $this->class = get_class($this->model);
        $attribute = $this->attribute;
        $this->value = $this->model->$attribute;


        $localPath = dirname(__FILE__) .'/'. self::ASSETS_DIR_NAME;
        $publicPath = Yii::app()->getAssetManager()->publish($localPath);

        Yii::app()->clientScript->registerScriptFile($publicPath .'/js/browserplus-min.js');
        Yii::app()->clientScript->registerScriptFile($publicPath .'/js/plupload.js');
        Yii::app()->clientScript->registerScriptFile($publicPath .'/js/plupload.gears.js');
        Yii::app()->clientScript->registerScriptFile($publicPath .'/js/plupload.silverlight.js');
        Yii::app()->clientScript->registerScriptFile($publicPath .'/js/plupload.flash.js');
        Yii::app()->clientScript->registerScriptFile($publicPath .'/js/plupload.browserplus.js');
        Yii::app()->clientScript->registerScriptFile($publicPath .'/js/plupload.html4.js');
        Yii::app()->clientScript->registerScriptFile($publicPath .'/js/plupload.html5.js');

        $initPath = $publicPath .'/'. self::INIT_FILE;
        Yii::app()->clientScript->registerScriptFile($initPath);

        $cssPath = $publicPath .'/'. self::PUPLOAD_CSS_PATH;
        Yii::app()->clientScript->registerCssFile($cssPath);

        $jqueryScript = "ativaUploaderImagem('".$this->class."','".$this->attribute."','".Yii::app()->createUrl('site/plupload')."');";

        $uniqueId = 'Yii.' . __CLASS__ . '#' . $this->id;
        Yii::app()->clientScript->registerScript($uniqueId, stripcslashes($jqueryScript), CClientScript::POS_READY);
    }

    public function run(){
        ?>
        <div id="<?=$this->attribute?>" style="width:100%;max-width:600px;">
            <input type="hidden" name="<?=$this->class;?>[<?=$this->attribute;?>]" value="<?=$this->value;?>" />
            <div>
                <div class="pull-left" >
                    <span style="font-size:11px;font-style:italic;">Somente arquivo png ou jpg</span>
                </div>
                <?
                if($this->value != ""){
					?>
					<div class="pull-right" >
					 <label class="" ><input type="checkbox" class="remove-value" data-field="<?=$this->attribute;?>"  name="<?=$this->class;?>[<?=$this->attribute;?>_delete]" value="1" /> Excluir imagem</label>
					</div>
					<?
				}
				?>
            </div>
            <br/>
            <div style="margin-top:10px;">
                <?
                $tipo = 'fill';
                if(strpos($this->return_size, 'x')){
                    $tipo = 'crop';
                }
                $src = Yii::app()->createAbsoluteUrl('thumbnail/'.$tipo.'/'.$this->return_size.'/'.$this->class).'/';
                $imagem= Yii::app()->createAbsoluteUrl('/').'/img/imagem_nao_cadastrada.png';
                if($this->value != ""){
                    $imagem = $src.$this->value;
                }
                ?>

                <img data-url="<?=$src?>" src="<?=$imagem?>" class="img-thumbnail img-responsive <?=$tipo?>-config" alt=""/>
                <em class="text center-block <?=$tipo=='fill'?'hidden':''?>"><i class="fa fa-crop"></i> Clique na imagem para editar a área de corte</em>
            </div>
        </div>
        <?
    }
}
?>
