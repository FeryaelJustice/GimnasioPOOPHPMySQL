<?php
require_once(__DIR__ . '/Connexio.php');
class Usuari extends Connexio
{
    // Properties
    public $id;
    public $nom;
    public $llinatges;
    public $telefon;
    public $username;
    public $password;

    // Methods
    function __construct()
    {
        parent::__construct();
        $this -> id = "";
        $this -> nom = "";
        $this -> llinatges = "";
        $this -> telefon = "";
        $this -> username = "";
        $this -> password = "";
    }

    public function createUsuari($name, $surnames, $phone, $username, $pwd)
    {
        if (!($this->checkUser($username, $pwd))) {
            echo"user not exists";
            try {
                $insert = "INSERT INTO usuaris (nom, llinatges, telefon, username, password) VALUES (?, ?, ?, ?, SHA2(?,256))";
                $stmt = $this->preparedInsert($insert);
                $stmt->bind_param("sssss", $name, $surnames,  $phone, $username, $pwd);
                $stmt->execute();
                return true;
            } catch (Exception $e) {
                return false;
            } finally {
                $stmt->close();
            }
        } else {
            echo "user exists";
            return false;
        }
    }

    public function updateUsuari($id, $nom, $llinatges, $telefon, $username, $pwd)
    {
        // Asegurarnos que no hay ningun dato vacio
        if ($id != '' && $nom != '' && $llinatges != '' && $telefon != '' && $username != '' &&  $pwd != '') {
            $consulta = "UPDATE usuaris SET nom='$nom', llinatges='$llinatges', telefon='$telefon', username='$telefon', password=SHA2('$pwd',256) WHERE idusuari = $id";
            try {
                $this->query($consulta);
                return true;
            } catch (Exception $ex) {
                return false;
            }
        } else {
            return false;
        }
    }

    public function deleteUsuari($id)
    {
        $reservaUtil = new Reserva();
        // Si no tiene reservas
        if (count($reservaUtil->reservesPerUsuari($id)) <= 0) {
            $consulta = "delete from usuaris where idusuari='$id'";
            try {
                $this->query($consulta);
                return true;
            } catch (Exception $ex) {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getUsuari($username, $password)
    {
        $consulta = "select * from usuaris where username='$username' and password=SHA2('$password',256)";
        $data = $this->query($consulta);
        if ($data->num_rows > 0) {
            while ($rowData = $data->fetch_assoc()) {
                $this->id = $rowData["idusuari"];
                $this->nom = $rowData["nom"];
                $this->llinatges = $rowData["llinatges"];
                $this->telefon = $rowData["telefon"];
                $this->username = $rowData["username"];
                $this->password = $rowData["password"];
            }
            return true;
        } else {
            return false;
        }
    }

    public function checkUser($username, $password)
    {
        $consulta = "select count(*) as total from usuaris where username='$username' and password=SHA2('$password',256)";
        $data = $this->query($consulta)->fetch_assoc();
        if ($data['total'] > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function __toString() {
        return "$this->nom $this->llinatges";
    }
}
