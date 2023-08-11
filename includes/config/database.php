<?php

function conectarDB() : mysqli{
    $db = mysqli_connect('localhost', 'root', '1951', 'bienesraices_crud');

    if(!$db){
        echo "No se puedo conectar a la base de datos";
        exit;
    }

    return $db;
}