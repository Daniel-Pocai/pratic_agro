<?php
/* @var $this SiteController */
/* @var $data array */
/* @var $representativeCount int */
/* @var $clientCount int */
?>

<div class="portlet">
    <div class="portlet-heading">
        <h3 class="portlet-title text-dark text-uppercase">Relatório de Vendas</h3>
        <div class="clearfix"></div>
    </div>
    <div id="portlet2" class="panel-collapse collapse in">
        <div class="portlet-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Representante</th>
                            <th>Total de Vendas</th>
                            <th>Valor Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row): ?>
                            <tr>
                                <td><?php echo CHtml::encode($row['representante']); ?></td>
                                <td><?php echo CHtml::encode($row['total_vendas']); ?> Uni.</td>
                                <td>R$ <?php echo Util::formataFloatMoeda($row['valor_total']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
