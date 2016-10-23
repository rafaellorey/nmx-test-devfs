<?php
$cP = pageName($_SERVER['PHP_SELF']);
?>
<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>            
            <a class="navbar-brand" href="#">
                <img alt="Nurum" src="shared/images/favicon.png">&nbsp;GIFs
            </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li <?php echo($cP == "index" ? 'class="active"' : ''); ?>>
                    <a href="index.php">
                        <i class="glyphicon glyphicon-home"></i>&nbsp;&nbsp;Galer&iacute;a
                    </a>
                </li>                
                <li <?php echo($cP == "sube-imagen" ? 'class="active"' : ''); ?>>
                    <a href="sube-imagen.php">
                        <i class="glyphicon glyphicon-upload"></i>&nbsp;&nbsp;Subir Gif
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if(Session::has('CMS_id')): ?>
                <li <?php echo($cP == "admin" ? 'class="active"' : ''); ?>>
                    <a href="admin.php">
                        <i class="glyphicon glyphicon-check"></i>&nbsp;&nbsp;Aprobar GIFs
                    </a>
                </li>  
                <li>
                    <a href="javascript:void(0);" class="logOff">
                        <i class="glyphicon glyphicon-off"></i>&nbsp;&nbsp;Salir
                    </a>
                </li>
                <?php else:?>
                <li <?php echo($cP == "registro-login" ? 'class="active"' : ''); ?>>
                    <a href="registro-login.php">
                        <i class="glyphicon glyphicon-lock"></i>&nbsp;&nbsp;Registro / Login
                    </a>
                </li>
                <?php endif;?>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>