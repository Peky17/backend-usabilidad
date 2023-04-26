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
        $grupo = $_POST['IdGrupo'];
        $usuario = $_POST['IdUsuario'];
        // Verificamos que todos los datos entrantes tengan contenido
        if($grupo != '' && $usuario != '')
        {
            if($grupo != '' || $usuario != ''){
                // Realizar la inserción en la BD
            try
            {
                //hacer uso de una declaración preparada para prevenir inyecciónes SQL
                $stmt = $db->prepare("INSERT INTO grupo_usuarios (IdGrupo, usuario) 
                VALUES (:grupo, :usuario)");
                // Ejecutamos el statement
                echo ($stmt->execute(
                    array(
                        ':grupo' => $grupo,
                        ':usuario' => $usuario)
                    )) 
                    // instrucción if-else en la ejecución de nuestra declaración preparada
                    ? 'Se ha agregado el usuario ID: ' . $usuario . ' Al grupo ingresado' 
                    : 'Algo salió mal. No se puede asignar el ususario ingresado a un grupo';	
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