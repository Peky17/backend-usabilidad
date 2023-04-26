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
        $permisoUser = $_POST['nombrePermiso'];
        // Verificamos que todos los datos entrantes tengan contenido
        if($permisoUser != '')
        {
            // Realizar la inserción en la BD
            try
            {
                //hacer uso de una declaración preparada para prevenir inyecciónes SQL
                $stmt = $db->prepare("INSERT INTO permisos (nombrePermiso) VALUES (:nombrePermiso)");
                // Ejecutamos el statement
                echo ($stmt->execute(
                    array(
                        ':nombrePermiso' => $permisoUser)
                    )) 
                    // instrucción if-else en la ejecución de nuestra declaración preparada
                    ? 'Permiso registrado correctamente' 
                    : 'Algo salió mal. No se puede agregar permiso';	
            }
            catch(PDOException $e)
            {
                echo($e->getMessage());
            } 
        } else {
            echo 'Porfavor ingrese un permiso válido';
        }

    }
    catch(PDOException $e)
    {
        echo ($e->getMessage());
    }
    //Cerrar la conexión
    $database->close();
?>