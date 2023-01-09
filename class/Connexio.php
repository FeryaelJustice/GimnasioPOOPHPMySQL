<?php
class Connexio
{
    // Properties
    private $host;
    private $db;
    private $user;
    private $password;
    private $dsn; // Nombre de origen de datos
    protected $connection;

    // Functions
    function __construct()
    {
        $this->host = "localhost";
        $this->db = "gimnaspoo";
        $this->user = "root";
        $this->password = "";
        $this->connection = $this->createConnection();
    }

    private function createConnection()
    {
        try {
            $connection = new mysqli($this->host, $this->user, $this->password, $this->db);
            if ($connection->connect_error) {
                die('Connect Error (' . $connection->connect_errno . ') ' . $connection->connect_error);
            }
        } catch (PDOException $ex) {
            die("Error en la conexión: mensaje: " . $ex->getMessage());
        }
        return $connection;
    }

    public function consulta($sql)
    {
        $result =  $this->connection->query($sql)  or die("<h4>Operació Incorrecta. Consulta:$sql</h4>");
        return $result;
    }
}
