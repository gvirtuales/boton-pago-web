<?php
// print_r($_POST);
include 'config/functions.php';
$environment = $_POST["environment"];
$merchantId = $_POST["merchantId"];
$user = $_POST["user"];
$password = $_POST["password"];
$amount = $_POST["amount"];
$currency = $_POST["currency"];
$countable = $_POST["countable"];
$purchaseNumber = $_POST["purchaseNumber"];

$cardHolderName = $_POST["cardHolderName"];
$cardHolderLastName = $_POST["cardHolderLastName"];
$cardHolderEmail = $_POST["cardHolderEmail"];

$tokenResponse = generateToken($environment, $user, $password);
$sesionResponse = generateSesion($environment, $amount, $tokenResponse['response'], $merchantId);

setcookie("environment", $environment);
setcookie("merchantId", $merchantId);
setcookie("token", $tokenResponse['response']);
setcookie("currency", $currency);
setcookie("countable", $countable);

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="shortcut icon" href="assets/img/favicon.png">
  <title>Botón de Pago Web</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
<div class="p-3 mb-2 bg-primary text-white">
    <h1><center><b>BOTÓN DE PAGO</b></center></h1>
  </div>
  <p></p>
    <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for=""><b>API Seguridad</b></label>
          <input type="text" name="" id="" class="form-control" value="<?php echo $tokenResponse['url'] ?>" disabled>
          <div class="form-group mt-2">
            <label for="">Response</label>
            <textarea name="" id="" cols="30" rows="8" class="form-control" disabled><?php echo $tokenResponse['response']; ?></textarea>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label for=""><b>API Sesión</b></label>
          <input type="text" name="" id="" class="form-control" value="<?php echo $sesionResponse['url'] ?>" disabled>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mt-2">
                <label for="">Request</label>
                <textarea name="" id="" cols="30" rows="10" class="form-control" disabled><?php echo json_encode(json_decode($sesionResponse['request']), JSON_PRETTY_PRINT); ?></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mt-2">
                <label for="">Response</label>
                <textarea name="" id="" cols="30" rows="10" class="form-control" disabled><?php echo json_encode($sesionResponse['response'], JSON_PRETTY_PRINT); ?></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-md-6">
      <img src="../niubiz.pagoweb/assets/img/tarjetas.png" height="40">
    </div>

    <div class="col-md-6">
  <br>
 <input type="checkbox" name="ckbTerms" id="ckbTerms" onclick="visaNetEc3()"> 
 <label for="ckbTerms">Acepto los <a href="terminosycondiciones.php" target="_blank">Términos y condiciones</a></label>
    <br>
    <form id="frmVisaNet" action="<?php echo BASE_PROJECT_URL; ?>finalizar.php?amount=<?php echo $amount; ?>&purchaseNumber=<?php echo $purchaseNumber ?>">
      <script src="<?php echo getJsUrl($environment) ?>"
        data-sessiontoken="<?php echo $sesionResponse['response']->sessionKey; ?>"
        data-channel="web"
        data-merchantid="<?php echo $merchantId ?>"
        data-merchantlogo="<?php echo BASE_PROJECT_URL; ?>assets/img/logo.png"
        data-purchasenumber="<?php echo $purchaseNumber; ?>"
        data-amount="<?php echo $amount; ?>"
        data-expirationminutes="5"
        data-timeouturl="<?php echo BASE_PROJECT_URL; ?>"
        data-cardholdername="<?php echo $cardHolderName;?>"
        data-cardholderlastname="<?php echo $cardHolderLastName;?>"
        data-cardholderemail="<?php echo $cardHolderEmail;?>"
        data-buttonsize="<?php echo $_POST['buttonSize'];?>"
        data-buttoncolor="<?php echo $_POST['buttoncolor'];?>"
        data-formbuttoncolor="<?php echo $_POST['formButtonColor'];?>"
        data-showamount="<?php echo $_POST['showAmount'];?>"
        data-hidexbutton="<?php echo $_POST['hideXbutton'];?>"
        data-usertoken="<?php echo $_POST['userToken'];?>"
      >
      </script>
    </form>
  </div>
</div>
  <br>
</body>
<script src="assets/js/script.js"></script> 

</html>