<?php 
$data_atual = date('Y-m-d H:i:s');

$criteria_banner = new CDbCriteria();
$criteria_banner->addCondition("t.habilitar = '1'");
$criteria_banner->addCondition("(t.data_entrada <= '".date('Y-m-d H:i:s')."' AND t.data_saida > '".date('Y-m-d H:i:s')."') ");
$criteria_banner->order = 'posicao asc';
$banners = Banner::model()->findAll($criteria_banner);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?php if (!Yii::app()->user->isGuest) {
                        $this->renderPartial("//layouts/caminho");
                    } ?>
                </h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <section class="text-center">
                <div class="slider-inicial swiper-container">
                    <div class="swiper-wrapper">
                        <?php if ($banners) {
                            foreach ($banners as $banner) { ?>
                                <div class="swiper-slide">
                                    <?php if ($banner->link != '') { ?>
                                        <a href="<?= $banner->link ?>" <?= $banner->nova_aba ? 'target="_blank"' : '' ?>>
                                    <?php } ?>
                                        <img src="../thumbnail/realise/1500x240/Banner/<?= $banner->imagem ?>" class="img-fluid" alt="<?= utf8_encode($banner->titulo) ?>" />
                                    <?php if ($banner->link != '') { ?>
                                        </a>
                                    <?php } ?>
                                </div>
                        <?php } } ?>
                    </div>
                    <!-- Adiciona os bot�es de navega��o -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                    <!-- Adiciona a pagina��o -->
                    <div class="swiper-pagination"></div>
                </div>
            </section>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-3">
            <!-- Menu Lateral -->
            <div class="col-md-12">
                <div class="widget-panel widget-style-br white-bg">
                    <i class="fa fa-5x fa-user text-success"></i>
                    <h2 class="m-0 counter"><?= CHtml::encode($representativeCount); ?></h2>
                    <small class="m-0 counter">representantes</small>
                </div>
                <div class="widget-panel widget-style-br white-bg">
                    <i class="fa fa-5x fa-user text-warning"></i>
                    <h2 class="m-0 counter"><?= CHtml::encode($clientCount); ?></h2>
                    <small class="m-0 counter">clientes</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <!-- Conte�do Principal -->
            <div class="row">
                <div class="col-md-6 col-sm-4">
                    <a href="../historicoVendas/index">
                        <?php $this->renderPartial('salesReport', ['data' => $data]); ?>
                    </a>
                    <div class="col-md-12 ">
                        <h3>Pratic <small>Agro Web</small></h3>
                        <span>Para alterar sua senha ou dados cadastrais <a href="<?= $this->createUrl('usuario/update', ['id' => Yii::app()->user->obj->idusuario]) ?>" class="text-info">clique aqui</a></span>
                        <h4 class="mt-3">Suporte</h4>
                        <p><i class="fa fa-phone"></i> (49) 3322-4539</p>
                        <p><i class="fa fa-envelope"></i> <a href="mailto:atendimento@praticagro.com.br" target="_blank">atendimento@praticagro.com.br</a></p>
                        <p><i class="fa fa-link"></i> <a href="http://www.praticagro.com.br/" target="_blank">http://www.praticagro.com.br/</a></p>
                    </div>
                </div>
                <div class="row mt-4 col-sm-4">
                    <?php $this->renderPartial("//layouts/log"); ?>   
                </div>
                
                
            </div>
        </div>
    </div>
</div>

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!-- Inicializa o Swiper -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var swiper = new Swiper('.swiper-container', {
            loop: true,
            autoplay: {
                delay: 5000,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            // Define width of swiper to prevent overlap
            width: document.querySelector('.swiper-container').clientWidth,
        });
    });
</script>
