<?php
require __DIR__ . '../userServices/php-jwt/vendor/autoload.php';
//require "../userServices/php-jwt/vendor/autoload.php";
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

// Permitir CORS 
include_once('../configs/allowCors.php');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

error_reporting(0);

// Recibimos el email
$email = $_POST['email'];
// Recibimos el token
$jwt = $_POST['token'];

if($jwt != '' && $email != ''){
    if($jwt != '' || $email != ''){
        try {
            $secret_key = file_get_contents('resources/privateKey.php');
            $decoded = JWT::decode($jwt, new Key($secret_key, 'RS256'));
            // El acceso es permitido
            echo json_encode(array(
                "message" => "Acceso permitido",
                "error" => $e->getMessage()
            ));
        }catch (Exception $e){
            http_response_code(401);
            echo json_encode(array(
                "message" => "Acceso denegado.",
                "error" => $e->getMessage()
            ));
        }
    } else {
        echo 'Porfavor mande el token y el email del usuario';
    }   
} else {
    echo 'Porfavor mande el token y el email del usuario';
}
?>