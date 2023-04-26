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
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $telefono = $_POST['telefono'];
        $email = $_POST['correo'];
        $rolUsuario = $_POST['rolUsuario'];
        $password = $_POST['password'];
        $confirmarPassword = $_POST['confirmarPassword'];
        // Verificamos que todos los datos entrantes tengan contenido
        if(
            $nombre != '' && $apellidos != '' &&
            $telefono != '' && $email != '' &&
            $rolUsuario != '' && $password != '' &&
            $confirmarPassword != ''
        )
        {
            // Verificamos que ninguno de los datos entrantes este vacío
            if(
                $nombre != '' || $apellidos != '' ||
                $telefono != '' || $email != '' ||
                $rolUsuario != '' || $password != '' ||
                $confirmarPassword != ''
            )
            {
                // Verificamos que el email cumpla con las caracteristicas necesarias
                if(is_valid_email($email) == true) {
                    // Verificamos que las contraseñas coincidan
                    if($password === $confirmarPassword){
                        //generamos un password hash para encriptar la contraseña
				        $passHash = password_hash($confirmarPassword,
                         PASSWORD_DEFAULT, array('cost' => 12));
                        // Realizar la inserción en la BD
                        try
				        {
					        //hacer uso de una declaración preparada para prevenir inyecciónes SQL
					        $stmt = $db->prepare("INSERT INTO usuarios (
                                    Nombre,
                                    Apellidos,
                                    phone,
                                    email,
                                    password,
                                    rol_usuario
                                ) 
                                VALUES (
                                    :nombre,
                                    :apellidos,
                                    :telefono,
                                    :correo,
                                    :passwordUser,
                                    :rolUsuario)"
                                );
					        // Ejecutamos el statement
					        echo ($stmt->execute(
                                array(
                                    ':nombre' => $nombre,
                                    ':apellidos' => $apellidos,
                                    ':telefono' => $telefono,
                                    ':correo' => $email, 
                                    ':passwordUser' => $passHash,
                                    ':rolUsuario' => $rolUsuario)
                                )) 
                                // instrucción if-else en la ejecución de nuestra declaración preparada
                                ? 'Usuario registrado correctamente' 
                                : 'Algo salió mal. No se puede agregar usuario';	
				        }
				        catch(PDOException $e)
				        {
					        echo($e->getMessage());
				        } 
                    } else {
                        echo 'Las contraseñas no coinciden';
                    }
                } else {
                    echo 'Correo electrónico Inválido. Porfavor ingrese un correo con formato válido';
                }
            } else {
                echo 'Porfavor complete';
            }
        } else {
            echo 'Porfavor complete el formulario';
        }

    }
    catch(PDOException $e)
    {
        echo ($e->getMessage());
    }
    //Cerrar la conexión
    $database->close();
?>