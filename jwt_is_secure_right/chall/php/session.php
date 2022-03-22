<?php

include 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = file_get_contents("/jwt_secret");
$jwt = "";

function createSession() {
    global $key, $jwt;

    $payload = array(
        "qsession" => bin2hex(random_bytes(32))
    );
    $jwt = JWT::encode($payload, $key, 'HS256');
    # 1 hour expiry
    setcookie("QSESSION", $jwt, time() + 3600, "/");
}

function getAlg($jwt) {
    $tks = \explode('.', $jwt);
    if (\count($tks) != 3) {
        throw new UnexpectedValueException('Wrong number of segments');
    }
    list($headb64, $bodyb64, $cryptob64) = $tks;
    $headerRaw = JWT::urlsafeB64Decode($headb64);
    if (null === ($header = JWT::jsonDecode($headerRaw))) {
        throw new UnexpectedValueException('Invalid header encoding');
    }
    if (empty($header->alg)) {
        throw new UnexpectedValueException('Empty algorithm');
    }
    return $header->alg;
}

function getContents($jwt) {
    $tks = \explode('.', $jwt);
    if (\count($tks) != 3) {
        throw new UnexpectedValueException('Wrong number of segments');
    }
    list($headb64, $bodyb64, $cryptob64) = $tks;
    $payloadRaw = JWT::urlsafeB64Decode($bodyb64);
    if (null === ($payload = JWT::jsonDecode($payloadRaw))) {
        throw new UnexpectedValueException('Invalid claims encoding');
    }
    if (!$payload instanceof stdClass) {
        throw new UnexpectedValueException('Payload must be a JSON object');
    }
    return $payload;
}

if(!isset($_COOKIE["QSESSION"])) {
    createSession();
} else {
    $jwt = $_COOKIE["QSESSION"];
}

try{
    $alg = getAlg($jwt);
    if (strcmp($alg, 'none') === 0) {
        $decoded = getContents($jwt)->qsession;
    } else {
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'))->qsession;
    }
} catch(Exception $e) {
    // echo "Invalid session cookie!";
    createSession();
    $decoded = JWT::decode($jwt, new Key($key, 'HS256'))->qsession;
}

// echo "QSESSION: " . $decoded;
$QSESSION = $decoded;

?>