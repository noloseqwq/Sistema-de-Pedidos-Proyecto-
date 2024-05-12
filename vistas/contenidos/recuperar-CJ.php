<div class="main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Recuperación de contraseña</h3>
                    </div>

                    <div class="card-body">
                        <form action="" method="POST" class="form-signin">
                            <div class=" container-fluid">
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <div class="form-group">
                                            <label for="username" class="bmd-label-floating">Nombre de Usuario</label>
                                            <input type="text" class="form-control" id="UserName" name="usuario_rec" pattern="[a-zA-Z0-9]{3,35}" maxlength="35" <?php if (isset($_POST['usuario_rec'])) { 
                                                                            echo 'value="' . $_POST['usuario_rec'] . '"';
                                                                        }?> required="">
                                        </div>
                                    </div>

                                    <?php
                                    if (isset($_POST['usuario_rec'])) {
                                        $dato = $_POST['usuario_rec'];
                                        require_once "./controladores/loginControlador.php";
                                        $ins_usuario = new loginControlador;

                                        $dato_cuestionario = $ins_usuario->comprobar_usuario_controlador($dato);

                                        if ($dato_cuestionario->rowCount() == 1) {
                                            $campos = $dato_cuestionario->fetch();
                                    ?>

                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="usuario_pregunta1_up" class="">Pregunta N°1</label>
                                                    <h5 class="mt-3"><?php echo $campos['pregunta1'] ?></h5>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="usuario_pregunta2_up" class="">Pregunta N°2</label>
                                                    <h5 class="mt-3"><?php echo $campos['pregunta2'] ?></h5>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Respuesta N°1</label>
                                                    <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ?]{3,100}" class="form-control" name="usuario_respuesta1_rec" <?php if (isset($_POST['usuario_respuesta1_rec'])) { 
                                                                            echo 'value="' . $_POST['usuario_respuesta1_rec'] . '"';
                                                                        }?> maxlength="100" required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Respuesta N°2</label>
                                                    <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ?]{3,100}" class="form-control" name="usuario_respuesta2_rec" <?php if (isset($_POST['usuario_respuesta2_rec'])) { 
                                                                            echo 'value="' . $_POST['usuario_respuesta2_rec'] . '"';
                                                                        }?> maxlength="100" required>
                                                </div>
                                            </div>
                                    <?php }
                                    } ?>

                                    <?php
                                    if (isset($_POST['usuario_respuesta2_rec']) && isset($_POST['usuario_respuesta2_rec'])) {
                                        $respuesta1 = $_POST['usuario_respuesta1_rec'];
                                        $respuesta2 = $_POST['usuario_respuesta2_rec'];
                                        $usuario = $_POST['usuario_rec'];

                                        $datos = [
                                            "Respuesta1" => $respuesta1,
                                            "Respuesta2" => $respuesta2,
                                            "Usuario" => $usuario
                                        ];
                                        require_once "./controladores/loginControlador.php";
                                        $ins_usuario = new loginControlador;

                                        $dato_cuestionario = $ins_usuario->comprobar_respuesta_controlador($datos);
                                        if ($dato_cuestionario->rowCount() == 1) { ?>
                                            <div class="col-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="password" class="bmd-label-floating">Contraseña</label>
                                                    <input type="password" class="form-control" id="UserPassword" name="clave_rec" pattern="[a-zA-Z0-9$@.\-]{7,100}" maxlength="100" required="">
                                                </div>
                                            </div>

                                    <?php }
                                    } 
                                    
                                    
                                    
                                    ?>



</div>
</div>

<button type="submit" class="btn btn-login btn-info">Siguiente</button>


                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php
if(isset($_POST['clave_rec'])){
    require_once "./controladores/loginControlador.php";
    $ins_clave= new loginControlador;
    echo $ins_clave->recuperar_clave_controlador();

}

?>

