<?php

class Cabeceras{
    
    
    public function cabeceras(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Access-Control-Allow-Headers, Access-Control-Allow-Origin, Access-Control-Allow-Methods, Status, WeFindErrorCode, WeFindErrorDesc");
        header("Access-Control-Allow-Methods: OPTIONS, POST, GET");
        header('Content-type: application/json');
    }
}