<?php require_once('parts/head.php') ?>
<div class="container-fluid">
    <div class="row">
        <?php if (count($items) > 0) : ?>
        <?php foreach ($items as $item) : ?> 
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
            <div class="thumbnail">
                <img src="<?php eh($item['archivo']); ?>">
                <center>
                    <hr><a href="#" class="btn btn-success" role="button">Compartir</a>
                </center>
            </div>
        </div>        
        <?php endforeach ?>
        <?php else : ?>
        <div class="col-xs-12">
            <center>No GIFs que mostrar aún.</center>
        </div>                
        <?php endif ?>            
    </div>
</div>
<?php require_once('parts/foot.php') ?>