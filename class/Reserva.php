<?php
require_once('ReservaSingleInstance.php');
class Reserva extends Connexio
{
    // Properties
    public $reserves = array(); // todas las reservas de la bdd

    // Methods
    function __construct()
    {
        parent::__construct();
        $sql = "select * from reserves;";
        $resultat = $this->consulta($sql);
        $all_reserves = array();
        while ($fila = $resultat->fetch_assoc()) {
            array_push($all_reserves, new ReservaSingleInstance($fila["data"], $fila["idpista"], $fila["idclient"]));
        }
        $this->reserves = $all_reserves;
    }

    function llistaReserves($dateFrom,$dateTo){

    }

    function afegirReserva($reserva){
        
    }

    function reservesPerUsuari($user){
        
    }
}
