<?php
    function conexionDB(){
        $db_url=getenv('DATABASE_URL');

        $db_opts=parse_url($db_url);

        $host = $db_opts['host'];
        $port = $db_opts['port'];
        $db =ltrim($db_opts['path'],'/');
        $user = $db_opts['user'];
        $pass = $db_opts['pass'];

        $dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";

        try{
            $conexion = new PDO([
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
            return $conexion;
        }catch (PDOException $e){
            error_log("El error esta" . $e->getMessage());
            return false;
        }
    }
?>