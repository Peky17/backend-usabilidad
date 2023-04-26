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
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $email = $_POST['correo'];
    $rolUsuario = $_POST['rolUsuario'];
    // Verificamos que todos los datos entrantes tengan contenido
	if(
        $nombre != '' && $apellidos != '' &&
        $telefono != '' && $email != '' &&
        $rolUsuario != '' && $id != ''
    )
	{
        // Verificamos que ninguno de los datos entrantes este vacío
        if(
            $nombre != '' || $apellidos != '' ||
            $telefono != '' || $email != '' ||
            $rolUsuario != '' || $id != ''
        )
        {   
            // Verificamos que el email cumpla con las caracteristicas necesarias
            if(is_valid_email($email) == true) {
                // Realizar la consulta
		        $sql = "UPDATE usuarios SET 
                    Nombre = '$nombre', 
                    Apellidos = '$apellidos',
                    phone = '$telefono',
                    email = '$email',
                    rol_usuario = '$rolUsuario' 
                WHERE Id = '$id'";
                //Enviamos el estatus del resultado de la consulta por la variable de session para mostrarla en Sweet Alert
                echo ( $db->exec($sql) ) 
                    ? 'Usuario actualizado correctamente'
                    : 'No se pudo actualizar usuario';
            } else {
                echo 'Correo electrónico Inválido. Porfavor ingrese un correo con formato válido';
            }
        } else {
            echo 'Porfavor complete el formulario de edición';
        }
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
