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
            <div class="panel panel-color panel-inverse">
                <div class="panel-heading">
                	<img src="<?=$baseUrl?>/img/logo-publisher-inteira.png" alt="Publisher" width="180" height="33" class="img-responsive center-block">
                </div>
                
                <?
				if(!empty($erro)){
					?>
					<div class="alert alert-danger" style="max-width:500px;margin-top:20px;" ><?=Util::formataTexto($erro);?></div>
					<?
				}
				if(!empty($_GET['msg_sucesso'])){
					?>
					<div class="alert alert-success" style="max-width:500px;margin-top:20px;" role="alert"><?=Util::formataTexto($_GET['msg_sucesso']);?></div>
					<?
				}
				
                $form=$this->beginWidget('CActiveForm', array(
					  'id'=>'login-form',
					  'enableClientValidation'=>true,
					  'htmlOptions' => array('class' => 'form-horizontal m-t-40'),
					  'clientOptions'=>array(
						  'validateOnSubmit'=>true,
					   ),
				  ));
				?>                  
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input type="password" class="form-control" autocomplete="off" name="RecuperarSenha[senha]" value="<?=$_POST['RecuperarSenha']['senha']?>" placeholder="Nova senha">
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input type="password" class="form-control" name="RecuperarSenha[senha_confirma]" value="<?=$_POST['RecuperarSenha']['senha_confirma']?>" placeholder="Repita a nova senha">
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <div class="col-xs-12">
                            <button class="btn btn-inverse w-md" type="submit">Alterar</button>
                        </div>
                    </div>
                    <div class="form-group m-t-30">
                        <div class="col-sm-7">
                            <a href="<?=$this->createUrl('login');?>"><i class="fa fa-lock m-r-5"></i> Login</a>
                        </div>
                    </div>
                <?php $this->endWidget(); ?>
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