<?php

//COnexion
require 'includes/config/database.php';
$db = conectarDB();

//Crear mail y password
$email = "gasparortmann@gmail.com";
$password = "1";

$passwordHash = password_hash($password, PASSWORD_BCRYPT);

//Query para crear el usuario
$query = "INSERT INTO usuarios (email, password) VALUES ('${email}', '${passwordHash}');";

//agregarlo a la base de datps
mysqli_query($db, $query);