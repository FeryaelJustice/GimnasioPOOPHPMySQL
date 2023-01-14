<?php
require_once(__DIR__ . '/Connexio.php');
class Pista extends Connexio {
    function __construct(){
        parent::__construct();
    }

    function getPistes(){
        // Retorna un array con estructura array[id]=nomPista
        $sql = "select * from pistes";
        $resultat = $this->query($sql);
        $pistes = array();
        while ($fila = $resultat->fetch_assoc()) {
            $pistes += [$fila["idpista"] => $fila["tipo"]];
        }
        return $pistes;
    }
}
?>