<?php
/* Script para obtener todos los usuarios 
que pertenecen a un grupo mediante el ID del grupo */

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
    //Almacenar Id del rol en una variable
    $id = $_POST['Id'];
    // Verificar que el email no esté vacio
    if($id != ''){
        // Consultamos todos los registros de la tabla usuarios
        $query = "SELECT usuarios.Nombre, usuarios.Apellidos, usuarios.email, usuarios.phone 
        FROM usuarios INNER JOIN grupo_usuarios 
        ON usuarios.Id = grupo_usuarios.usuario 
        INNER JOIN grupos 
        ON grupos.Id = grupo_usuarios.IdGrupo 
        WHERE grupos.Id = '$id'";
        $search = $db->prepare($query, [
          PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL
        ]);
        // Ejecutamos la sentencia preparada
        $search->execute();
        // Almacenamos todos los registros en un array asociativo
        while ($result = $search->fetchAll(PDO::FETCH_ASSOC)) {
            echo json_encode($result);
        }
    } else {
        echo 'Ingrese el id del rol que busca para ver sus permisos';
    }    
} 
catch (PDOException $ex){
    echo($ex->getMessage());
}
//Cerrar la conexión
$database->close()
?>
