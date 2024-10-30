<?
Yii::app()->clientScript->registerScript('helpers', '
	var baseUrl = "'.(Yii::app()->baseUrl).'";
',0);





Yii::app()->clientScript->registerCoreScript('jquery');
/*Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl.'/js/jquery.js');*/
Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl.'/js/bootstrap.js');

/*
Yii::app()->clientScript->registerScriptFile('http://code.jquery.com/jquery-migrate-1.1.1.js');*/



Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl.'/js/pace.min.js');
Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl.'/js/modernizr.min.js');
Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl.'/js/wow.min.js');
Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl.'/js/jquery.nicescroll.js');

Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl.'/js/jquery.mask.js');

Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl.'/assets-template/sweet-alert/sweet-alert.min.js');
Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl.'/assets-template/sweet-alert/sweet-alert.init.js');

Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl.'/assets-template/notifications/notify.min.js');
Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl.'/assets-template/notifications/notify-metro.js');
Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl.'/assets-template/notifications/notifications.js');

Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl.'/js/jquery-ui-1.10.1.custom.min.js');


Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl.'/js/jquery.cookie.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl.'/js/jquery.app.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/init.js', CClientScript::POS_END);
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-72196639-1', 'auto');
  ga('send', 'pageview');

</script>
