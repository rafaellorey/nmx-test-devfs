    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="shared/js/jquery-3.1.1.min.js"><\/script>')</script>    
    <script src="shared/js/bootstrap.min.js"></script>
    <script src="shared/js/sweetalert.min.js"></script>
    <script src="shared/js/jquery.uploadfile.min.js"></script>
    <script src="shared/js/validate.min.js"></script>
    <script src="shared/lib/colorbox/jquery.colorbox-min.js"></script>
    <script src="shared/lib/toastr/toastr.js"></script>
    <script src="shared/js/main.js"></script>
    <?php
    //AUTO CARGA DE JS
    $cP = pageName($_SERVER['PHP_SELF']);
    if(file_exists(ROOT .'shared/js/inc/'.$cP.'.js')):
    ?>
    <script src="shared/js/inc/<?php echo($cP);?>.js"></script>
    <?php endif;?>
    </body>
</html>