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
        $rol = $_POST['IdRol'];
        $permiso = $_POST['IdPermiso'];
        // Verificamos que todos los datos entrantes tengan contenido
        if($rol != '' && $permiso != '')
        {
            if($rol != '' || $permiso != ''){
                // Realizar la inserción en la BD
            try
            {
                //hacer uso de una declaración preparada para prevenir inyecciónes SQL
                $stmt = $db->prepare("INSERT INTO rol_permiso (permiso, rol) 
                VALUES (:permiso, :rol)");
                // Ejecutamos el statement
                echo ($stmt->execute(
                    array(
                        ':permiso' => $permiso,
                        ':rol' => $rol)
                    )) 
                    // instrucción if-else en la ejecución de nuestra declaración preparada
                    ? 'Se ha asignado el permiso al rol de usuario ingresado' 
                    : 'Algo salió mal. No se puede asignar el permiso al rol de usuario ingresado';	
            }
            catch(PDOException $e)
            {
                echo($e->getMessage());
            } 
            }
        } else {
            echo 'Porfavor ingrese los datos completos';
        }

    }
    catch(PDOException $e)
    {
        echo ($e->getMessage());
    }
    //Cerrar la conexión
    $database->close();
?>