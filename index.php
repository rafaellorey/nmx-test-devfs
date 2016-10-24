<?php require_once('parts/head.php') ?>
<?php if (count($items) > 0) : ?>
    <div class="container">
        <div class="row">
            <div id="btns-vistas" class="col-lg-6 col-lg-offset-3 col-xs-12 text-center">
                <label class="hidden-xs">Ver como:</label>
                <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn btn-success btn-lg" data-show="cuadricula">
                        <i class="glyphicon glyphicon-th"></i>&nbsp;&nbsp;&nbsp;Cuadricula
                    </button>
                    <button type="button" class="btn btn-default btn-lg" data-show="carrusel">
                        <i class="glyphicon glyphicon-film"></i>&nbsp;&nbsp;&nbsp;Carrusel
                    </button>
                </div>
                <hr>
            </div>
        </div>
    </div>    
    <div class="container-fluid vistas" id="cuadricula">
        <div class="row">        
            <?php foreach ($items as $item) : ?> 
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                    <div class="thumbnail">
                        <center>
                            <a href="<?php eh($item['archivo']); ?>" class="cbox_single" title="<?php echo 'GIF Animado #' . $item['id']; ?>">
                                <img class="img-responsive" src="<?php eh($item['archivo']); ?>" alt="<?php echo 'GIF Animado #' . $item['id']; ?>">
                            </a>

                            <hr>
                            <a data-pin-do="buttonPin" 
                               href="https://www.pinterest.com/pin/create/button/?
                               url=<?php echo urlencode(URL) ?>
                               &media=<?php echo urlencode(URL . $item['archivo']); ?>
                               &description=GIF%20Animado%20<?php eh($item['id']); ?>" 
                               data-pin-config="beside"></a>                   
                        </center>
                    </div>
                </div>        
            <?php endforeach ?>         
        </div>
    </div>
    <div class="container vistas" id="carrusel" style="display: none;">
        <div class="row">
            <div class="col-lg-12">
                <div id="homeCarousel" class="carousel">
                    <div class="carousel-inner">
                    </div>
                    <a class="carousel-control left" href="#homeCarousel" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
                    <a class="carousel-control right" href="#homeCarousel" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
                </div>        
            </div>
        </div>
    </div>
    <script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>
<?php else : ?>
    <div class="container">
        <div class="row">  
            <div class="col-xs-12 text-center">
                <h3>No hay GIFs que mostrar aún.</h3>
                <p>Se el primero en subir un GIF animado <a href="sube-imagen.php">Aquí</a></p>
            </div>             
        </div>
    </div>    
<?php endif ?>   
<?php require_once('parts/foot.php') ?>