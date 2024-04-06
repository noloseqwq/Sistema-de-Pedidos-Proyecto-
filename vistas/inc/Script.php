<!--=============================================
	=            Include JavaScript files           =
	==============================================-->
<!-- jQuery V3.4.1 -->
<script src="<?php echo SERVER_URL; ?>vistas/js/jquery-3.4.1.min.js"></script>

<!-- popper -->
<script src="<?php echo SERVER_URL; ?>vistas/js/popper.min.js"></script>

<!-- Bootstrap V4.3 -->
<script src="<?php echo SERVER_URL; ?>vistas/js/bootstrap.min.js"></script>

<!-- jQuery Custom Content Scroller V3.1.5 -->
<script src="<?php echo SERVER_URL; ?>vistas/js/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- Bootstrap Material Design V4.0 -->
<script src="<?php echo SERVER_URL; ?>vistas/js/bootstrap-material-design.min.js"></script>
    <script>
        $(document).ready(function() {
            $('body').bootstrapMaterialDesign();
        });
    </script>
<script>
    const pressed = [];
    const secretCode = "elao";

    window.addEventListener("keyup", (e) => {
        pressed.push(e.key);
        pressed.splice(-secretCode.length - 1, pressed.length - secretCode.length);
        console.log(pressed);
        if (pressed.join("").includes(secretCode)) {
            elao();
        }
    })

    function elao() {
        Swal.fire({
            title: '@nolose',
            imageUrl: '<?php echo SERVER_URL ?>vistas/assets/img/helao.jpeg',
            imageWidth: 500,
            imageHeight: 400,
            imageAlt: 'Custom image',
        })
    }
</script>
<script src="<?php echo SERVER_URL; ?>vistas/js/main.js"></script>

<script src="<?php echo SERVER_URL; ?>vistas/js/alertas.js"></script>