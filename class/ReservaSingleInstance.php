<?php
class ReservaSingleInstance {
    public $date;
    public $id_pista;
    public $id_client;

    function __construct($date,$id_pista,$id_client)
    {
        $this->date = $date;
        $this->id_pista = $id_pista;
        $this->id_client = $id_client;
    }
}
