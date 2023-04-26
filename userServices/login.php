<?php
require "./php-jwt/vendor/autoload.php";
use \Firebase\JWT\JWT;
// Permitir CORS 
include_once('../configs/allowCors.php');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Max-Age: 3600");
error_reporting(0);
// Incluimos el archivo de funciones globales 
include_once('../configs/funciones.php');
// Incluimos la conexión con la BD
include_once('../configs/dbconect.php');

// Definimos las variables para el login
$email = '';
$password = '';
//Leemos los datos de entrada
$data = json_decode(file_get_contents("php://input"));
// Asignamos el tipo de entrada para esos datos
$email = $data->email;
$password = $data->password;

// Abrir conexión con la BD
$database = new Connection();
$db = $database->open(); 

// Consulta para obtener usuario
$query = "SELECT Id, Nombre, Apellidos, password 
FROM usuarios WHERE email = ? LIMIT 0,1";

// Generamos la cosulta preparada
$stmt = $db->prepare($query);
// Pasamos como parámetro el email
$stmt->bindParam(1, $email);
$stmt->execute();
// Contamos la cantidad de registros encontrados
$num = $stmt->rowCount();

// Sí se encontraron registros
if($num > 0){
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $id = $row['Id'];
    $nombreUsuario = $row['Nombre'];
    $Apellidos = $row['Apellidos'];
    $passwordUsuario = $row['password'];
    // Verificamos que las contraseñas coincidan
    if(password_verify($password, $passwordUsuario))
    {
        $secret_key = file_get_contents('resources/privateKey.php');
        $issuer_claim = "LOCALHOST"; // this can be the servername
        $audience_claim = "USUARIOS";
        $issuedat_claim = time(); // issued at
        $notbefore_claim = $issuedat_claim + 10; //not before in seconds
        $expire_claim = $issuedat_claim + 60; // expire time in seconds
        $token = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "data" => array(
                "id" => $id,
                "Nombre" => $nombreUsuario,
                "Apellidos" => $Apellidos,
                "Email" => $email
        ));

        http_response_code(200);

        $jwt = JWT::encode($token, $secret_key, 'RS256');
        echo json_encode(
            array(
                "message" => "Successful login.",
                "jwt" => $jwt,
                "email" => $email,
                "expireAt" => $expire_claim
            ));
    } else {
        http_response_code(401);
        echo json_encode(array("message" => "Login failed.", "password" => $password));
    }
}
?>