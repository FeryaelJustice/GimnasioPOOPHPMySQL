<?php
class Usuari extends Connexio
{
    // Properties
    public $user;
    private $valid = false;

    // Methods
    function __construct()
    {
        parent::__construct();
    }

    public function getValid()
    {
        return $this->valid;
    }

    public function createUsuari($user, $pwd, $email)
    {
        if (!($this->checkUser($user, $pwd))) {

            try {
                $stmt = $this->connection->prepare("INSERT INTO usuaris (user, password, email) VALUES (?, SHA2(?), ?)");
                $stmt->bind_param("sss", $user, $pwd, $email);
                $stmt->execute();
            } catch (Exception $e) {
                echo "Create user transaction failed";
                die();
            } finally {
                $stmt->close();
            }

            /*
            $consulta = 'insert into usuaris values("' . $user . '",SHA2("' . $pwd . '",256),"' . $email . '","user");';
            try {
                $this->connection->query($consulta);
            } catch (PDOException $ex) {
                die("Error al agregar usuario: " . $ex->getMessage());
            }
            */
        } else {
            return false;
        }
    }

    public function updateUsuari($user, $pwd)
    {
        $consulta = 'update usuaris set password=sha2("' . $pwd . '",256) where usuari="' . $user . '";';
        try {
            $this->connection->query($consulta);
        } catch (Exception $ex) {
            die("Error al modificar password: " . $ex->getMessage());
        }
    }

    public function deleteUsuari($email)
    {
        $consulta = 'delete from usuaris where email="' . $email . '";';
        try {
            $this->connection->query($consulta);
        } catch (Exception $ex) {
            die("Error al modificar password: " . $ex->getMessage());
        }
    }

    private function checkUser($user, $pwd)
    {
        $consulta = 'select count(*) as total from usuaris where usuari="' . $user . '" and password=sha2("' . $pwd . '",256);';
        $data = $this->connection->query($consulta)->fetch_assoc();
        if ($data['total'] > 0) {
            $this->user = $user;
            $this->valid = true;
            return true;
        } else {
            $this->valid = false;
            return false;
        }
    }
}
