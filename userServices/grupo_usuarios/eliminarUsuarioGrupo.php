<?php 
// Eliminar usuario de un grupo mediante id de usuario y id de grupo 
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
// Si no hay inconvenientes con la BD -> actualizamos
try
{
    // Almacenamos los datos entrantes por el metodo POST 
    $idUsuario = $_POST['IdUsuario'];
    $idGrupo = $_POST['IdGrupo'];
    // Verificamos que todos los datos entrantes tengan contenido
	if($idUsuario != '' && $idGrupo != '')
	{ 
        // Realizar la consulta
        $sql = "DELETE FROM grupo_usuarios WHERE IdGrupo = '$idGrupo' 
        AND usuario = '$idUsuario'";
        //Enviamos el estatus del resultado de la consulta por la variable de session para mostrarla en Sweet Alert
        echo ( $db->exec($sql) ) 
        ? 'Registro eliminado correctamente'
        : 'No se pudo eliminar registro';
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
