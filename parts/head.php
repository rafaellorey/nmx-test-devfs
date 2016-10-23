<?php
require_once('ini.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Ejercicio de Evaluación Técnica">
        <meta name="author" content="Rafael López Reyes">       
        <link rel="shortcut icon" href="shared/images/favicon.png">        
        <title>NMX Evaluación, Desarrollador FS</title>
        <link href="shared/css/bootstrap.min.css" rel="stylesheet">
        <link href="shared/css/sweetalert.css" rel="stylesheet">
        <link href="shared/lib/colorbox/colorbox.css" rel="stylesheet">
        <link href="shared/lib/toastr/toastr.css" rel="stylesheet">
        <?php
        //AUTO CARGA DE CSS
        $cP = pageName($_SERVER['PHP_SELF']);
        if(file_exists(ROOT .'shared/css/inc/'.$cP.'.css')):
        ?>
        <link href="shared/css/inc/<?php echo($cP);?>.css" rel="stylesheet">
        <?php endif;?>        
        <link href="shared/css/main.css" rel="stylesheet">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php require_once('parts/navbar.php'); ?>