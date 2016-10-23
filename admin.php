<?php require_once('parts/head.php') ?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <?php if (count($items) > 0) : ?>
                <table class="table table-striped">
                    <caption>
                        <strong><?php eh(count($items)); ?></strong> GIFs registrados en el sistema.
                    </caption>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-center">GIF (Click para ver)</th>
                            <th class="hidden-xs">Fecha Hora de registro</th>
                            <th class="text-center">Aceptado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item) : ?> 
                            <tr data-id="<?php eh($item['id']); ?>">
                                <th scope="row"><?php eh($item['id']); ?></th>
                                <?php Html::tdImg($item['archivo'])?>
                                <td class="hidden-xs"><?php eh($item['create_date']); ?></td>
                                <td align="center">
                                    <?php Html::onSiNo('sw_'.$item['id'], $item['estatus'], 'class="upStat"')?>                    
                                </td>  
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>            
            <?php else : ?>
                <center>No hay GIFs que mostrar aún.</center>
            <?php endif ?>                 
        </div>
    </div>
</div>
<?php require_once('parts/foot.php') ?>