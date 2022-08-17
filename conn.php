<?php
$dsn = 'mysql:host=localhost:3306;dbname:market_db';
$user = 'root';
$pass = '%ronnie100';
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
);
try {
    $conn = new PDO($dsn, $user, $pass, $option);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo 'connected!';

}catch (PDOException $e){
    echo $e->getMessage();
}