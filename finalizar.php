<?php
  include 'config/functions.php';
  $transactionToken = $_POST["transactionToken"];
  $email = $_POST["customerEmail"];
  $channel = $_POST["channel"];
  $amount = $_GET["amount"];
  $purchaseNumber = $_GET["purchaseNumber"];
  $url = '';

  $token = $_COOKIE['token'];
  $environment = $_COOKIE['environment'];
  $merchantId = $_COOKIE['merchantId'];
  $countable = $_COOKIE['countable'];
  $currency = $_COOKIE['currency'];

    if ($channel == 'web') {
        $authorizationResponse = generateAuthorization($amount, $purchaseNumber, $transactionToken, $token, $environment, $merchantId, $countable, $currency);
        $data = $authorizationResponse['response'];
    } else if ($channel == 'pagoefectivo') {
        $url = $_POST["url"];
    }
?>

<!DOCTYPE html>
  <html lang="es">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="assets/img/favicon.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Respuesta de pago</title>
  </head>

  <body>
    <div class="p-3 mb-2 bg-primary text-white">
      <h1><center><b>RESPUESTA DE PAGO</b></center></h1>
    </div>
    <br>
    <div class="container">

      <div class="row mt-3">
        
        <div class="col-md-4">
          <div class="form-group">
            <label for="transactionToken">
              <?php
                if ($url == '') {
                  echo 'Transaction token';
                } else echo 'CIP';
              ?>
            </label>
            <input type="text" name="transactionToken" id="transactionToken" class="form-control" value="<?php echo $transactionToken; ?>" disabled>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label for="channel">Channel</label>
            <input type="text" name="channel" id="channel" class="form-control" value="<?php echo $channel; ?>" disabled>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="form-group">
            <label for="customerEmail">Customer Email</label>
            <input type="text" name="customerEmail" id="customerEmail" class="form-control" value="<?php echo $email; ?>" disabled>
          </div>
        </div>
        
        <?php
          if ($url != '') {
            echo '
              <div class="col-md-12">
                <div class="form-group">
                  <label for="urlPagoEfectivo">URL PagoEfectivo</label>
                  <input type="text" name="urlPagoEfectivo" id="urlPagoEfectivo" class="form-control" value="'.$url.'" disabled>
                </div>
              </div>
            ';
          }
        ?>
      </div>

      <?php
        if ($url == '') {
      ?>

      <div class="row mt-3 mb-3">
        <div class="col-md-12">
          <div class="form-group">
            <label for=""><b>API Autorización</b></label>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Request</label>
                  <textarea name="" id="" cols="30" rows="15" class="form-control" disabled><?php echo json_encode(json_decode($authorizationResponse['request']), JSON_PRETTY_PRINT); ?></textarea>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Response</label>
                  <textarea name="" id="" cols="30" rows="15" class="form-control" disabled><?php echo json_encode($authorizationResponse['response'], JSON_PRETTY_PRINT); ?></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
          
      <hr>
          
      <?php
        if (isset($data->dataMap)) {
          if ($data->dataMap->ACTION_CODE == "000") {
            $c = preg_split('//', $data->dataMap->TRANSACTION_DATE, -1, PREG_SPLIT_NO_EMPTY);
            ?>
            <div class="alert alert-success" role="alert">
              <?php echo $data->dataMap->ACTION_DESCRIPTION; ?>
            </div>
                
            <div class="row">
              <div class="col-md-12">
                <b>Número de pedido: </b> <?php echo $purchaseNumber; ?>
              </div>
              <div class="col-md-12">
                <b>Fecha y hora del pedido: </b> <?php echo $c[4] . $c[5] . "/" . $c[2] . $c[3] . "/" . $c[0] . $c[1] . " " . $c[6] . $c[7] . ":" . $c[8] . $c[9] . ":" . $c[10] . $c[11]; ?>
              </div>
              <div class="col-md-12">
                <b>Tarjeta: </b> <?php echo $data->dataMap->CARD . " (" . $data->dataMap->BRAND . ")"; ?>
              </div>
              <div class="col-md-12">
                <b>Importe pagado: </b> <?php echo $data->order->amount . " " . $data->order->currency; ?>
              </div>
            </div>
             <?php
              }
          } else {
                $c = preg_split('//', $data->data->TRANSACTION_DATE, -1, PREG_SPLIT_NO_EMPTY);
                ?>
                <div class="alert alert-danger" role="alert">
                  <?php echo $data->data->ACTION_DESCRIPTION; ?>
                </div>
          
                <div class="row">
                  <div class="col-md-12">
                    <b>Número de pedido: </b> <?php echo $purchaseNumber; ?>
                  </div>
                  <div class="col-md-12">
                    <b>Fecha y hora del pedido: </b> <?php echo $c[4] . $c[5] . "/" . $c[2] . $c[3] . "/" . $c[0] . $c[1] . " " . $c[6] . $c[7] . ":" . $c[8] . $c[9] . ":" . $c[10] . $c[11]; ?>
                  </div>
                  <div class="col-md-12">
                    <b>Tarjeta: </b> <?php echo $data->data->CARD . " (" . $data->data->BRAND . ")"; ?>
                  </div>
                </div>
            <?php
            }
            ?>
      </div>
      <?php
        }
    ?>

    <br>

    <!--div class="container">
      <div class="row">
        <div class="col-sm-6 col-md-4 mb-2">
          <a href="<?php echo BASE_PROJECT_URL;?>" class="btn btn-secondary btn-block">Inicio</a>
        </div>
        <div class="col-sm-6 col-md-4 mb-2">
          <a target="_blank" href="http://bdp.evirtuales.shop?purchase=<?php echo $purchaseNumber;?>" class="btn btn-primary btn-block">API's Complementarias</a>
        </div>
      </div>
    </div-->

    <br>
    <br>

  </body>
</html>