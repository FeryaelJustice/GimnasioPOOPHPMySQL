<?php
require_once(__DIR__.'/ReservaSingleInstance.php');
require_once(__DIR__.'/Connexio.php');
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

    function llistaReserves($dateFrom,$dateTo){
        $sql = "select * from reserves where data BETWEEN $dateFrom AND $dateTo";
        $resultat = $this->query($sql);
        $all_reserves = array();
        while ($fila = $resultat->fetch_assoc()) {
            array_push($all_reserves, new ReservaSingleInstance($fila["data"], $fila["idpista"], $fila["idusuari"]));
        }
        return $all_reserves;
    }

    function afegirReserva($reserva){
        try {
        $stmt = $this->connection->prepare("INSERT INTO reserves (data, idpista, idusuari) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $reserva->date, $reserva->idpista, $reserva->idusuari);
        $stmt->execute();
        }catch(Exception $e){
            echo "Create transaction failed";
        }finally{
            $stmt->close();
        }
    }

    function reservesPerUsuari($iduser){
        $sql = "select * from reserves where idusuari = $iduser";
        $resultat = $this->query($sql);
        $all_reserves = array();
        while ($fila = $resultat->fetch_assoc()) {
            // Filtrar per reserves actives
            if($fila["data"] > date("Y-m-d")){
                array_push($all_reserves, new ReservaSingleInstance($fila["data"], $fila["idpista"], $fila["idusuari"]));
            }
        }
        return $all_reserves;
    }
}
