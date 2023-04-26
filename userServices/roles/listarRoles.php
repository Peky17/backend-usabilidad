<?php
error_reporting(0);
// Permitir CORS 
include_once('../../configs/allowCors.php');
// Incluimos el archivo de funciones globales 
include_once('../../configs/funciones.php');
// Incluimos la conexión con la BD
include_once('../../configs/dbconect.php');
// Abrir conexión con la BD
$database = new Connection();
$db = $database->open();
//Realizar el listado de datos
try {
     // Consultamos todos los registros de la tabla usuarios
     $query = "SELECT * FROM roles";
     $search = $db->prepare($query, [
         PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL
     ]);
     // Ejecutamos la sentencia preparada
     $search->execute();
     // Almacenamos todos los registros en un array asociativo
     while ($result = $search->fetchAll(PDO::FETCH_ASSOC)) {
        echo json_encode($result);
     }
     
} 
catch (PDOException $ex){
    echo($ex->getMessage());
}
//Cerrar la conexión
$database->close()
?>