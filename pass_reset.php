<?php require_once('parts/head.php') ?>
<div class="container">
    <div class="row">
        <div class="col-lg-6 col-xs-12 col-lg-offset-3">
            <form id="form-resetpass">
                <?php Html::hidden("tk",Input::get('tk')); ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Cambiar mi Contraseña</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group has-feedback">
                            <label class="control-label" for="pass">Contraseña</label>                       
                            <input id="pass" name="pass" type="password" class="form-control" required="required" maxlength="20" autocomplete="off">                        
                        </div>
                        <div class="form-group has-feedback">
                            <label class="control-label" for="repeat_pass">Repita la Contraseña</label>                       
                            <input id="repeat_pass" name="repeat_pass" type="password" class="form-control" required="required" maxlength="20">                        
                        </div>                      
                        <div class="text-left">
                            Captura los datos para cambiar tu contraseña.
                        </div>                        
                    </div>
                    <div class="panel-footer text-right">                        
                        <button type="submit" class="btn btn-success" data-loading-text="Cambiando..." autocomplete="off">
                            Cambiar
                        </button>                    
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once('parts/foot.php') ?>