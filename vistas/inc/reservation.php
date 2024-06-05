<script>
    /*-------- buscar cliente --------*/
    function buscar_cliente() {
        let input_cliente = document.querySelector('#input_cliente').value;

        input_cliente = input_cliente.trim();

        if (input_cliente != "") {
            let datos = new FormData();
            datos.append("buscar_cliente", input_cliente);
            fetch("<?php echo SERVER_URL ?>ajax/pedidoAjax.php", {
                    method: 'POST',
                    body: datos,

                })
                .then(respuesta => respuesta.text())
                .then(respuesta => {
                    let tabla_cliente = document.querySelector('#tabla_clientes');
                    tabla_cliente.innerHTML = respuesta;
                });
        } else {
            Swal.fire({
                title: 'Ocurrio un error',
                text: 'Debes introducir el RIF, Razon social o Telefono',
                type: 'error',
                confirmButtonText: 'Aceptar',
            });
        }

    }

    /*-------- agregar cliente --------*/
    function agregar_cliente(id) {
        $('#ModalCliente').modal('hide');
        Swal.fire({
            title: '¿Quieres agregar este cliente?',
            text: 'Se va a agregar este cliente al pedido',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Agregar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                let datos = new FormData();
                datos.append("id_agregar_cliente", id);
                fetch("<?php echo SERVER_URL ?>ajax/pedidoAjax.php", {
                        method: 'POST',
                        body: datos,

                    })
                    .then(respuesta => respuesta.json())
                    .then(respuesta => {
                        return alertas_ajax(respuesta)
                    });
            } else {
                $('#ModalCliente').modal('show');
            }
        });
    }

    /*-------- Buscar producto --------*/
    function buscar_producto() {
        let input_producto = document.querySelector('#input_producto').value;

        input_producto = input_producto.trim();

        if (input_producto != "") {
            let datos = new FormData();
            datos.append("buscar_producto", input_producto);
            fetch("<?php echo SERVER_URL ?>ajax/pedidoAjax.php", {
                    method: 'POST',
                    body: datos,

                })
                .then(respuesta => respuesta.text())
                .then(respuesta => {
                    let tabla_producto = document.querySelector('#tabla_productos');
                    tabla_producto.innerHTML = respuesta;
                });
        } else {
            Swal.fire({
                title: 'Ocurrio un error',
                text: 'Debes introducir el Codigo o el nombre del producto',
                type: 'error',
                confirmButtonText: 'Aceptar',
            });
        }
    }

    /*-------- modales del producto --------*/
    function modal_agregar_producto(id) {
        $('#ModalProducto').modal('hide');
        $('#ModalAgregarProducto').modal('show');

        document.querySelector('#id_agregar_producto').setAttribute("value", id);

    }

    function modal_buscar_producto(id){
        $('#ModalAgregarProducto').modal('hide');
        $('#ModalProducto').modal('show');
        
        document.querySelector('#id_agregar_producto').setAttribute("value",id);
    }



</script>