<?php require_once('parts/head.php') ?>
<div class="container-fluid">
    <div class="row">
        <?php if (count($items) > 0) : ?>
        <?php foreach ($items as $item) : ?> 
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
            <div class="thumbnail">
                <a href="<?php eh($item['archivo']); ?>" class="cbox_single" title="<?php echo basename($item['archivo']); ?>">
                    <img src="<?php eh($item['archivo']); ?>">
                </a>
                <center>
                    <hr><a href="#" class="btn btn-success" role="button">Compartir</a>
                </center>
            </div>
        </div>        
        <?php endforeach ?>
        <?php else : ?>
        <div class="col-xs-12 text-center">
            <h3>No hay GIFs que mostrar aún.</h3>
            <p>Se el primero en subir un GIF animado <a href="sube-imagen.php">Aquí</a></p>
        </div>                
        <?php endif ?>            
    </div>
</div>
<?php require_once('parts/foot.php') ?>