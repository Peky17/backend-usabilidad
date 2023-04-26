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
        $nombreGrupo = $_POST['nombreGrupo'];
        $idModerador = $_POST['idModerador'];
        // Verificamos que todos los datos entrantes tengan contenido
        if($nombreGrupo != '' && $idModerador != '')
        {
            if($nombreGrupo != '' || $idModerador != '')
            {
                // Realizar la inserción en la BD
                try
                {
                    //hacer uso de una declaración preparada para prevenir inyecciónes SQL
                    $stmt = $db->prepare("INSERT INTO grupos (nombreGrupo, moderador) 
                    VALUES (:nombreGrupo, :idModerador)");
                    // Ejecutamos el statement
                    echo ($stmt->execute(
                        array(
                            ':nombreGrupo' => $nombreGrupo,
                            ':idModerador' => $idModerador)
                        )) 
                        // instrucción if-else en la ejecución de nuestra declaración preparada
                        ? 'Grupo registrado correctamente' 
                        : 'Algo salió mal. No se puede agregar grupo';	
                }
            catch(PDOException $e)
            {
                echo($e->getMessage());
            } 
            } else {
                echo 'Porfavor ingrese todos los datos';
            }
        } else {
            echo 'Porfavor ingrese todos los datos';
        }

    }
    catch(PDOException $e)
    {
        echo ($e->getMessage());
    }
    //Cerrar la conexión
    $database->close();
?>