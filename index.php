<?php
include 'config/functions.php';
$purchaseNumber = generatePurchaseNumber();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="shortcut icon" href="assets/img/favicon.png">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <!--Agregado-->
  <link rel="stylesheet" href="assets/css/style.css">
  <title>Botón de Pago Web</title>
</head>

<body>
  <div class="p-3 mb-2 bg-primary text-white">
    <h1><center><b>BOTÓN DE PAGO WEB</b></center></h1>
  </div>
  <form action="<?php echo BASE_PROJECT_URL; ?>boton.php" method="POST">
    <div class="container mt-3">
      <div class="card">
        <div class="card-header">Configuración general</div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="environment">Entorno (*)</label>
                <select name="environment" id="environment" class="form-control" required>
                  <option value="S" selected>Sandbox</option>
                  <!--option value="D">Dev</option-->
                  <option value="T">Test</option>
                  <option value="P">Producción</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="merchantId">Código comercio (*)</label>
                <input type="text" name="merchantId" id="merchantId" class="form-control" required value="456879852">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="user">Usuario (*)</label>
                <input type="text" name="user" id="user" class="form-control" required value="integraciones@niubiz.com.pe">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="password">Contraseña (*)</label>
                <input type="text" name="password" id="password" class="form-control" required value="_7z3@8fF">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="currency">Moneda (*)</label>
                <select name="currency" id="currency" class="form-control" required>
                  <option value="PEN" selected>Soles</option>
                  <option value="USD">Dólares</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="countable">Liquidación (*)</label>
                <select name="countable" id="countable" class="form-control" required>
                  <option value="A" selected>Automática</option>
                  <option value="M">Manual</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="amount">Importe (*)</label>
                <input type="number" name="amount" id="amount" class="form-control" step=".01" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="purchaseNumber">Número de pedido (*)</label>
                <input type="number" name="purchaseNumber" id="purchaseNumber" class="form-control" required value="<?php echo $purchaseNumber; ?>">
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-3">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              Información del tarjetahabiente
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="cardHolderName">Nombre</label>
                    <input type="text" name="cardHolderName" id="cardHolderName" class="form-control" value="Integraciones">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="cardHolderLastName">Apellido</label>
                    <input type="text" name="cardHolderLastName" id="cardHolderLastName" class="form-control" value="Necomplus">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="cardHolderEmail">Correo electrónico</label>
                    <input type="text" name="cardHolderEmail" id="cardHolderEmail" class="form-control" value="integraciones.niubiz@necomplus.com">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              Configuración del botón
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="buttonSize">Tamaño del botón</label>
                    <select name="buttonSize" id="buttonSize" class="form-control">
                      <option value="SMALL">Pequeño</option>
                      <option value="MEDIUM">Mediano</option>
                      <option value="LARGE">Grande</option>
                      <option value="DEFAULT" selected>Por defecto</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="buttoncolor">Color del botón de pago</label>
                    <select name="buttoncolor" id="buttoncolor" class="form-control">
                      <option value="NAVY" selected>Azul</option>
                      <option value="GRAY">Gris</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="formButtonColor">Color del botón pagar</label>
                    <input type="color" name="formButtonColor" id="formButtonColor" class="form-control" value="#FF0000">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="showAmount">Mostrar importe a pagar</label>
                    <select name="showAmount" id="showAmount" class="form-control">
                      <option value="TRUE" selected>Si</option>
                      <option value="FALSE">No</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="hideXbutton">Ocultar botón cerrar</label>
                    <select name="hideXbutton" id="hideXbutton" class="form-control">
                      <option value="true">Si</option>
                      <option value="false" selected>No</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="userToken">User token</label>
                    <input type="text" name="userToken" id="userToken" class="form-control">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="row mt-3 mb-5">
        <div class="col-md-3">
          <button type="submit" class="btn btn-primary btn-block">Generar botón</button>
        </div>
      </div>
    </div>
  </form>

</body>

</html>