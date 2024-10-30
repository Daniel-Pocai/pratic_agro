<!DOCTYPE html>
<html lang="pt-br"><head>
        <?
		$baseUrl = Yii::app()->baseUrl; 
        Yii::app()->clientScript->registerCssFile($baseUrl."/css/bootstrap.min.css");
        Yii::app()->clientScript->registerCssFile($baseUrl."/css/bootstrap-reset.css");
        Yii::app()->clientScript->registerCssFile($baseUrl."/css/animate.css");
        Yii::app()->clientScript->registerCssFile($baseUrl."/assets-template/font-awesome/css/font-awesome.css");
        Yii::app()->clientScript->registerCssFile($baseUrl."/assets-template/ionicon/css/ionicons.min.css");
        Yii::app()->clientScript->registerCssFile($baseUrl."/assets-template/morris/morris.css");
        Yii::app()->clientScript->registerCssFile($baseUrl."/css/style.css");
        Yii::app()->clientScript->registerCssFile($baseUrl."/css/helper.css");
        ?>
    </head>
    <body>
        <div class="wrapper-page animated fadeInDown">

            <div class="ex-page-content animated flipInX text-center">
                <h2 class="font-light"><?=$erro?></h2><br>
                <a class="btn btn-purple" href="<?=$this->createUrl('site/login');?>"><i class="fa fa-angle-left"></i> Inicial</a>
            </div>
            
        </div>
        <?
		Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/jquery.js');
		Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/bootstrap.min.js');
		Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/pace.min.js');
		Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/wow.min.js');
		Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/jquery.app.js');
		?>
</html>
		
