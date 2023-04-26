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
// Si no hay inconvenientes con la BD -> actualizamos el usuario
try
{
    // Almacenamos los datos entrantes por el metodo POST 
    $id = $_POST['Id'];
    $nombrePermiso = $_POST['nombrePermiso'];
    // Verificamos que todos los datos entrantes tengan contenido
	if($nombrePermiso != '' && $id != '')
	{ 
        // Realizar la consulta
        $sql = "UPDATE permisos SET 
        nombrePermiso = '$nombrePermiso'
        WHERE Id = '$id'";
        //Enviamos el estatus del resultado de la consulta por la variable de session para mostrarla en Sweet Alert
        echo ( $db->exec($sql) ) 
        ? 'Permiso actualizado correctamente'
        : 'No se pudo actualizar permiso';
	}
	else 
	{
		echo 'Porfavor complete el formulario de edición';
	}		
}
catch(PDOException $e)
{
	echo($e->getMessage());
}
//Cerrar la conexión
$database->close();
?>
