
    <ol class="breadcrumb pull-right">
        <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Inicial</a></li>
        <?
        if(isset($this->breadcrumbs)){
            foreach($this->breadcrumbs as $label=>$url){
                if(is_string($label) || is_array($url)){
                    ?>
                    <li>
                        <a href="<?=$this->createUrlRel($url[0],array_splice($url,1)); ?>"><?=Util::formataTexto($label); ?></a>
                    </li>
                    <?	
                }
                else{
                    ?>
                    <li>
                        <?=Util::formataTexto($url); ?>
                    </li>
                    <?	
                }
            } 
        }
        ?>
        <li><a href="javascript:history.back(-1);" data-original-title="Voltar" title="" data-placement="left" data-toggle="tooltip" class="pull-right"><i class="fa fa-fw fa-level-up fa-rotate-270"></i></a></li>
    </ol> 
