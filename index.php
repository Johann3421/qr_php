<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <video src="" id="preview" width="100%"></video>
            </div>
            <div class="col-md-6">
            <form id="qrForm" class="form-horizontal">
    <label for="">ESCOGE UNA OPCIÓN</label>
    <select name="opcion" id="opcion" class="form-control">
        <option value="entrada">Entrada</option>
        <option value="salida">Salida</option>
        <option value="permiso">Permiso</option>
    </select>
    <label for="">ESCANEA EL QR</label>
    <input type="text" name="text" id="text" readonly="" placeholder="Escanea el código QR" class="form-control">
</form>
                </div>
        </div>
    </div>

    <script>
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {
            alert('No se encontraron cámaras.');
        }
    }).catch(function (e) {
        console.error(e);
    });

    scanner.addListener('scan', function (c) {
        // Obtener el valor del código QR
        let qrCodeValue = c;

        // Obtener el valor del campo de opción
        let opcionValue = document.getElementById('opcion').value;

        // Enviar datos al archivo insert.php mediante AJAX
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'insert.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Mostrar el mensaje como un popup
                var confirmed = window.confirm(xhr.responseText);

                // Puedes realizar acciones adicionales si se confirma
                if (confirmed) {
                    // Realizar alguna acción adicional después de la confirmación
                }
            }
        };

        // Construir la cadena de datos a enviar
        let data = 'opcion=' + opcionValue + '&qrCodeValue=' + encodeURIComponent(qrCodeValue);

        // Enviar la solicitud
        xhr.send(data);
    });
</script>


</body>
</html>