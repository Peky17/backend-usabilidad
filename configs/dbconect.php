<?php

Class Connection
{ 
	private $server = "mysql:host=localhost;dbname=modelo_ilustrativo";
	private $username = "root";
	private $password = "";
	private $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
	protected $conn;
 	
	//Funcion para abrir la conexión con la BD
	public function open()
	{
 		try
		{
 			$this->conn = new PDO($this->server, $this->username, $this->password, $this->options);
 			return $this->conn;
 		}
 		catch (PDOException $e){
 			echo "Hubo un problema con la conexión: " . $e->getMessage();
 		}
    }
	// Función para cerrar la conexión cin la BD
	public function close()
	{
   		$this->conn = null;
 	}
}
 
?>