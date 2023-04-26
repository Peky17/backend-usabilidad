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
    $passwordActual = $_POST['passwordActual'];
    $newPassword = $_POST['newPassword'];
    $confirmarNewPassword = $_POST['confirmarPassword'];
    // Verificamos que todos los datos entrantes tengan contenido
	if(
        $id != '' && $passwordActual != '' &&
        $newPassword != '' && $confirmarNewPassword != ''
    )
	{
        // Verificamos que ninguno de los datos entrantes este vacío
        if(
            $id != '' || $passwordActual != '' ||
            $newPassword != '' || $confirmarNewPassword != ''
        )
        {
            // Consultar la contraseña de el usuario solicitado
            $query = "SELECT password FROM usuarios WHERE Id='" . $id . "'";
            $search = $db->prepare($query, [
                PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL
            ]);
            // Ejecutamos la sentencia preparada
            $search->execute();
            // Obtenemos la contraseña del usuario en cuestión
            if ($result = $search->fetchObject()) {
                $passBD = $result->password;
                // Comparamos la contraseña en la BD con la que ingreso el usuario
                if (password_verify($passwordActual, $passBD)) {
                    // Verificar que las contraseñas coincidan
                    if($newPassword === $confirmarNewPassword){
                        //generamos un password hash para encriptar la contraseña
				        $passHash = password_hash($newPassword,
                        PASSWORD_DEFAULT, array('cost' => 12));
                        // Realizar la consulta
		                $sql = "UPDATE usuarios SET 
                            password = '$passHash' 
                        WHERE Id = '$id'";
                        //Enviamos el estatus del resultado de la consulta por la variable de session para mostrarla en Sweet Alert
                        echo ( $db->exec($sql) ) 
                            ? 'Password actualizado correctamente'
                            : 'No se pudo actualizar password';
                    } else {
                        echo 'La nueva contraseña ingresada no coinciden';
                    }
                } else {
                    echo 'Las contraseña actual de esta cuenta no coincide con la ingresada';
                }
            }
        } else {
            echo 'Porfavor complete el formulario';
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
