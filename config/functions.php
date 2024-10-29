<?php
include 'config.inc.php';

function getBaseUrl($environment) {
  switch ($environment) {
    case 'S':
      return BASE_URL_SANDBOX;
      break;
    case 'D':
      return BASE_URL_DEV;
      break;
    case 'T':
      return BASE_URL_TEST;
      break;
    case 'P':
      return BASE_URL_PROD;
      break;
    default:
      return BASE_URL_TEST;
      break;
  }
}

function getJsUrl($environment) {
  switch ($environment) {
    case 'S':
      return URL_JS_SANDBOX;
      break;
    case 'D':
      return URL_JS_DEV;
      break;
    case 'T':
      return URL_JS_TEST;
      break;
    case 'P':
      return URL_JS_PROD;
      break;
    default:
      return URL_JS_TEST;
      break;
  }
}

function generateToken($environment, $user, $password) {
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => getBaseUrl($environment).URL_SECURITY,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_HTTPHEADER => array(
      "Accept: */*",
      'Authorization: ' . 'Basic ' . base64_encode($user . ":" . $password)
    ),
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  return array(
    "url" => getBaseUrl($environment).URL_SECURITY,
    "request" => "",
    "response" => $response
  );
}

function generateSesion($environment, $amount, $token, $merchantId) {
  $url = getBaseUrl($environment).URL_SESSION.$merchantId;
  $session = array(
    'channel' => 'web',
    'amount' => $amount,
    'antifraud' => array(
      'clientIp' => $_SERVER['REMOTE_ADDR'],
      'merchantDefineData' => array(
        'MDD4' => "integraciones.guillermo@necomplus.com",
        'MDD32' => '250376',
        'MDD75' => 'Registrado',
        'MDD77' => '7'
      ),
    ),
    'dataMap' => array(
      'cardholderCity' => 'Lima',
      'cardholderCountry' => 'PE',
      'cardholderAddress' => 'Av Principal A-5. Campoy',
      'cardholderPostalCode' => '15046',
      'cardholderState' => 'LIM',
      'cardholderPhoneNumber' => '986322205'
    )
  );
  $json = json_encode($session);
  $response = json_decode(postRequest($url, $json, $token));
  return array(
    "url" => $url,
    "request" => $json,
    "response" => $response
  );
}

function generateAuthorization($amount, $purchaseNumber, $transactionToken, $token, $environment, $merchantId, $countable, $currency) {
  $url = getBaseUrl($environment).URL_AUTHORIZATION.$merchantId;
  $data = array(
    'channel' => 'web',
    'captureType' => 'manual',
    'countable' => $countable == 'A' ? true : false,
    'order' => array(
      'tokenId' => $transactionToken,
      'purchaseNumber' => $purchaseNumber,
      'amount' => $amount,
      'currency' => $currency
    ),
    'dataMap' => array(
      'urlAddress' => 'https://desarrolladores.niubiz.com.pe/',
      'partnerIdCode' => '',
      'serviceLocationCityName' => 'LIMA',
      'serviceLocationCountrySubdivisionCode' => 'LIMA',
      'serviceLocationCountryCode' => 'PER',
      'serviceLocationPostalCode' => '15046'
    )
  );
  $json = json_encode($data);
  $response = json_decode(postRequest($url, $json, $token));
  return array(
    "url" => $url,
    "request" => $json,
    "response" => $response
  );
}

function postRequest($url, $postData, $token)
{
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_HTTPHEADER => array(
      'Authorization: ' . $token,
      'Content-Type: application/json'
    ),
    CURLOPT_POSTFIELDS => $postData
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  return $response;
}

function generatePurchaseNumber()
{
  $archivo = "assets/purchaseNumber.txt";
  $purchaseNumber = 222;
  $fp = fopen($archivo, "r");
  $purchaseNumber = fgets($fp, 100);
  fclose($fp);
  ++$purchaseNumber;
  $fp = fopen($archivo, "w+");
  fwrite($fp, $purchaseNumber, 100);
  fclose($fp);
  return $purchaseNumber;
}
