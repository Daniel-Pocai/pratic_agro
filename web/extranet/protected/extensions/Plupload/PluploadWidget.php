<?php
class PluploadWidget extends CWidget {

    const ASSETS_DIR_NAME       = 'assets';
    const PLUPLOAD_FILE_NAME    = 'plupload.full.min.js';
    const JQUERYQUEUE_FILE_NAME = 'jquery.plupload.queue.min.js';
    const FLASH_FILE_NAME       = 'plupload.flash.swf';
    const DEFAULT_RUNTIMES      = 'flash';
    const PUPLOAD_CSS_PATH      = 'css3/plupload.queue.css';
	const INIT_FILE             = 'init.js';
	
	public $model;
	public $attribute;
	
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

        $jqueryScript = "ativaUploaderArquivos('".$this->class."','".$this->attribute."','".Yii::app()->createUrl('site/plupload')."');";
		
        $uniqueId = 'Yii.' . __CLASS__ . '#' . $this->id;
        Yii::app()->clientScript->registerScript($uniqueId, stripcslashes($jqueryScript), CClientScript::POS_READY);
    }

    public function run(){	
		?>
		<div id="<?=$this->attribute?>" style="max-width:50%;">
            <input type="hidden" name="<?=$this->class;?>[<?=$this->attribute;?>]" value="<?=$this->value;?>" />
			<div style="margin-top:10px;">
			<?
			echo CHtml::link($this->value != "" ? ' <span class="file-name"><i class="fa fa-download"></i> '.$this->value.'</span>' : '<span class="file-name"></span>',Yii::app()->createAbsoluteUrl($this->folder.'/'.$this->class.'/'.$this->value),array('target' => '_blank','class' => 'btn-link btn-file'));
			?>
            </div>
		</div>
		<?
    }
}
?>
