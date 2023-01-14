<?php
require_once(__DIR__ . '/ReservaSingleInstance.php');
require_once(__DIR__ . '/Connexio.php');
// Clase para hacer todas las operaciones con Reservas, pero no representa UNA RESERVA, sino el conjunto, la clase para UNA reserva es ReservaSingleInstance
class Reserva extends Connexio
{
    // Properties
    public $reserves = array(); // todas las reservas de la bdd

    // Methods
    function __construct()
    {
        parent::__construct();
        $sql = "select * from reserves";
        $resultat = $this->query($sql);
        $all_reserves = array();
        while ($fila = $resultat->fetch_assoc()) {
            array_push($all_reserves, new ReservaSingleInstance($fila["data"], $fila["idpista"], $fila["idusuari"]));
        }
        $this->reserves = $all_reserves;
    }

    function llistaReserves($dateFrom, $dateTo)
    {
        $dateFromFormatted = date("Y-m-d",strtotime($dateFrom)); // Convert to unix timestamp and after to only get date from that timestamp (H:i:s to add time)
        $dateToFormatted = date("Y-m-d",strtotime("+ 1 day", strtotime($dateTo))); // Because between in TO doesn't include the value
        $sql = "select * from reserves where data BETWEEN '$dateFromFormatted' AND '$dateToFormatted'";
        $resultat = $this->query($sql);
        $all_reserves = array();
        while ($fila = $resultat->fetch_assoc()) {
            array_push($all_reserves, new ReservaSingleInstance($fila["data"], $fila["idpista"], $fila["idusuari"]));
        }
        return $all_reserves;
    }

    function afegirReserva($reserva)
    {
        $success = false;
        try {
            $stmt = $this->connection->prepare("INSERT INTO reserves (data, idpista, idusuari) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $reserva->date, $reserva->id_pista, $reserva->id_client);
            $stmt->execute();
            $success = true;
        } catch (Exception $e) {
            echo " Create transaction failed ";
        } finally {
            $stmt->close();
        }
        return $success;
    }

    function reservesPerUsuari($iduser)
    {
        $sql = "select * from reserves where idusuari = $iduser order by data asc";
        $resultat = $this->query($sql);
        $all_reserves = array();
        while ($fila = $resultat->fetch_assoc()) {
            // Filtrar per reserves actives
            if ($fila["data"] > date("Y-m-d")) {
                array_push($all_reserves, new ReservaSingleInstance($fila["data"], $fila["idpista"], $fila["idusuari"]));
            }
        }
        return $all_reserves;
    }

    function checkSiExisteReserva($date, $tipus)
    {
        // Check si ya existe
        $existe = false;
        $sql = "SELECT * FROM reserves";
        $result = $this->query($sql);
        if ($result->num_rows > 0) {
            while ($valores = $result->fetch_assoc()) {
                if (($valores["idpista"] == $tipus) && ($valores["data"] == $date)) {
                    $existe = true;
                    break;
                }
            }
        }
        $result->free();
        return $existe;
    }
}
