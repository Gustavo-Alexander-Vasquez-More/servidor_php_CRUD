<?php

declare(strict_types=1);

require 'flight/Flight.php';

Flight::register('db','PDO', array('mysql:host=localhost;dbname=apirest','root',''));
Flight::route('GET /productos', function(){
$sentencia= Flight::db()->prepare("SELECT * FROM `productos`");
$sentencia ->execute();
$datos=$sentencia->fetchAll();
Flight::json($datos);
});
Flight::route('POST /productos', function(){
    try {
     $nombre = Flight::request()->data->nombre;
     $foto = Flight::request()->data->foto; // Asumiendo que este es el campo para la foto
     $descripcion = Flight::request()->data->descripcion;
     $precio = Flight::request()->data->precio;
     $categoria = Flight::request()->data->categoria;
     $sql = "INSERT INTO productos (nombre, foto, descripcion, precio, categoria) VALUES (?, ?, ?, ?, ?)";
     $sentencia = Flight::db()->prepare($sql);
     $sentencia->bindParam(1, $nombre);
     $sentencia->bindParam(2, $foto);
     $sentencia->bindParam(3, $descripcion);
     $sentencia->bindParam(4, $precio);
     $sentencia->bindParam(5, $categoria);
     $sentencia->execute();
     Flight::jsonp(["Producto agregado"]);
    } catch (Exception $error) {
     Flight::jsonp(["Producto no agregado por falta de datos"]);
    }
 });
Flight::start();
