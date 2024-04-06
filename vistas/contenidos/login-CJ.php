<div class="main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Inicar Sesion</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST" class="form-signin">
                            <div class="form-group">
                                <label for="username" class="bmd-label-floating">Nombre de Usuario</label>
                                <input type="text" class="form-control" id="UserName" name="usuario_log" pattern="[a-zA-Z0-9]{3,35}" maxlength="35" required="">
                            </div>
                            <div class="form-group">
                                <label for="password" class="bmd-label-floating">Contraseña</label>
                                <input type="password" class="form-control" id="UserPassword" name="clave_log" pattern="[a-zA-Z0-9$@.\-]{7,100}" maxlength="100" required="">
                            </div>
                            <button type="submit" class="btn btn-login btn-info">Iniciar Sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

<?php
if (isset($_POST['usuario_log']) && isset($_POST['clave_log'])) {
    require_once "./controladores/loginControlador.php";

    $ins_login = new loginControlador();

    echo $ins_login->iniciar_sesion_controlador();
}
?>