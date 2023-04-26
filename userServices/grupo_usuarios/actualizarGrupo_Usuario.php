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
    $grupo = $_POST['IdGrupo'];
    $usuario = $_POST['IdUsuario'];
    // Verificamos que todos los datos entrantes tengan contenido
	if($grupo != '' && $id != '' && $usuario != '')
	{ 
        if($grupo != '' || $id != '' || $usuario != ''){
            // Realizar la consulta
            $sql = "UPDATE grupo_usuarios SET 
            IdGrupo = '$grupo', usuario = '$usuario'
            WHERE Id = '$id'";
            //Enviamos el estatus del resultado de la consulta por la variable de session para mostrarla en Sweet Alert
            echo ( $db->exec($sql) ) 
            ? 'Registro actualizado correctamente'
            : 'No se pudo actualizar registro';
        } else {
            echo 'Porfavor complete el formulario de edición';
        }
	} else 
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
