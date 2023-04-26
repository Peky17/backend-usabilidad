<?php
/* Script para obtener todos los permisos 
que tiene un rol de usuario */ 

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
        $query = " SELECT permisos.nombrePermiso FROM permisos 
        INNER JOIN rol_permiso ON rol_permiso.permiso = permisos.Id 
        INNER JOIN roles ON roles.Id = rol_permiso.rol
        WHERE roles.Id = '$id'";
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
