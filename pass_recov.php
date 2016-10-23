<?php require_once('parts/head.php') ?>
<div class="container">
    <div class="row">
        <div class="col-lg-6 col-xs-12 col-lg-offset-3">
            <form id="form-recovpass">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Recuperar Password</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group has-feedback">
                            <label class="control-label" for="email">Correo electrónico</label>
                            <input id="email" name="email" type="email" class="form-control" required="required" maxlength="100">
                        </div>
                        <div class="text-left">
                            Te enviaremos un correo electrónico con tu nuevo password.
                        </div>                        
                    </div>
                    <div class="panel-footer text-right">                        
                        <button type="submit" class="btn btn-success" data-loading-text="Enviando..." autocomplete="off">
                            Enviar
                        </button>                    
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once('parts/foot.php') ?>