<?php require_once('parts/head.php') ?>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <form id="form-login">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Inicia sesión con tu cuenta</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group has-feedback">
                            <label class="control-label" for="email">Correo electrónico</label>
                            <input id="email" name="email" type="email" class="form-control" required="required" maxlength="100">
                        </div>
                        <div class="form-group has-feedback">
                            <label class="control-label" for="pass">Contraseña</label>                       
                            <input id="pass" name="pass" type="password" class="form-control" required="required" maxlength="20">                        
                        </div>
                        <div class="text-center">
                            <a href="pass_recov.php">¿Olvidaste tu contraseña?</a>
                        </div>                        
                    </div>
                    <div class="panel-footer text-right">
                        <p class="pull-left">* Todos los campos son requeridos.</p>
                        <button type="submit" class="btn btn-success" data-loading-text="Iniciando..." autocomplete="off">
                            Iniciar sesión
                        </button>                    
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-6">
            <form id="form-signin">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Crea una cuenta para iniciar sesión</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group has-feedback">
                            <label class="control-label" for="name">Nombre</label>
                            <input id="name" name="name" type="text" class="form-control" required="required" maxlength="75">
                        </div>                        
                        <div class="form-group has-feedback">
                            <label class="control-label" for="mail">Correo electrónico</label>
                            <input id="mail" name="mail" type="email" class="form-control" required="required" maxlength="100" autocomplete="off">
                        </div>
                        <div class="form-group has-feedback">
                            <label class="control-label" for="pass">Contraseña</label>                       
                            <input id="pass" name="pass" type="password" class="form-control" required="required" maxlength="20" autocomplete="off">                        
                        </div>
                        <div class="form-group has-feedback">
                            <label class="control-label" for="repeat_password">Repita la Contraseña</label>                       
                            <input id="repeat_password" name="repeat_password" type="password" class="form-control" required="required" maxlength="20">                        
                        </div>                        
                    </div>
                    <div class="panel-footer text-right">
                        <p class="pull-left">* Todos los campos son requeridos.</p>
                        <button type="submit" class="btn btn-info" data-loading-text="Creando..." autocomplete="off">
                            Crear cuenta
                        </button>                    
                    </div>
                </div>
            </form>
        </div>        
    </div>
</div>
<?php require_once('parts/foot.php') ?>