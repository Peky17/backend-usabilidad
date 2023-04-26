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
    // Si no hay inconvenientes con la BD, Realizamos el servicio  
    try
    {   
        // Almacenamos los datos entrantes por el metodo POST 
        $rolUser = $_POST['nombreRol'];
        // Verificamos que todos los datos entrantes tengan contenido
        if($rolUser != '')
        {
            // Realizar la inserción en la BD
            try
            {
                //hacer uso de una declaración preparada para prevenir inyecciónes SQL
                $stmt = $db->prepare("INSERT INTO roles (nombreRol) VALUES (:nombreRol)");
                // Ejecutamos el statement
                echo ($stmt->execute(
                    array(
                        ':nombreRol' => $rolUser)
                    )) 
                    // instrucción if-else en la ejecución de nuestra declaración preparada
                    ? 'Rol de usuario registrado correctamente' 
                    : 'Algo salió mal. No se puede agregar rol de usuario';	
            }
            catch(PDOException $e)
            {
                echo($e->getMessage());
            } 
        } else {
            echo 'Porfavor ingrese un rol de usuario válido';
        }

    }
    catch(PDOException $e)
    {
        echo ($e->getMessage());
    }
    //Cerrar la conexión
    $database->close();
?>