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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<body>
    <div class="container">
    <nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">WebsiteName</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Page 1-1</a></li>
                    <li><a href="#">Page 1-2</a></li>
                    <li><a href="#">Page 1-3</a></li>
                </ul>
            </li>
            <li><a href="#">Page 2</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
        </ul>
    </div>
</nav>

    <div class="row">
    <div class="col-md-6">
    <button id="startScanButton">Escanear</button>
    <video src="" id="preview" width="100%" style="display: none;"></video>
</div>
            <div class="col-md-6">
            <form id="qrForm" class="form-horizontal">
    <label for="cargo">ESCOGE UN CARGO</label>
    <select name="cargo" id="cargo" class="form-control">
        <option value="docente">Docente</option>
        <option value="estudiante">Estudiante</option>
        <option value="otro">Otro</option>
    </select>
    <label for="opcion">ESCOGE UNA OPCIÓN</label>
    <select name="opcion" id="opcion" class="form-control">
        <option value="entrada">Entrada</option>
        <option value="salida">Salida</option>
        <option value="permiso">Permiso</option>
    </select>
    <label for="text">ESCANEA EL QR</label>
    <input type="text" name="text" id="text" readonly="" placeholder="Escanea el código QR" class="form-control">
</form>
<table class="table table-bordered">
    <thead>
        <tr>
            <td>ID</td>
            <td>STUDENT</td>
            <td>TIMEIN</td>
            <td>OPCION</td>
            <td>CARGO</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $server = "localhost";
        $username = "root";
        $password = "";
        $dbname = "qrcodebd";

        $conn = new mysqli($server, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $sql = "SELECT ID, STUDENTID, TIMEIN, OPCION, CARGO FROM table_attendance";
        $query = $conn->query($sql);
        while ($row = $query->fetch_assoc()) {
        ?>
            <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo $row['STUDENTID']; ?></td>
                <td><?php echo $row['TIMEIN']; ?></td>
                <td><?php echo $row['OPCION']; ?></td>
                <td><?php echo $row['CARGO']; ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

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

        // Obtener el valor del campo de cargo
        let cargoValue = document.getElementById('cargo').value;

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
        let data = 'opcion=' + opcionValue + '&qrCodeValue=' + encodeURIComponent(qrCodeValue) + '&cargo=' + cargoValue;

        // Enviar la solicitud
        xhr.send(data);
    });
</script>
<script>
    document.getElementById('startScanButton').addEventListener('click', function () {
        startScan();
    });

    function startScan() {
        let videoElement = document.getElementById('preview');

        // Comprobar si las cámaras están disponibles
        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                // Mostrar el video
                videoElement.style.display = 'block';

                // Iniciar el escáner en la primera cámara encontrada
                scanner.start(cameras[0]);
            } else {
                alert('No se encontraron cámaras.');
            }
        }).catch(function (e) {
            console.error(e);
        });
    }
</script>


</body>
</html>