<?php
include('../data/DBConn.php');
include('../models/Cliente.php');
include('../models/Telefone.php');

$db = DBconn::getInstance();
$cliente = new Cliente($_POST['nome'], $_POST['obeservacao']);
$telefone = new Telefone($_POST['telefone']);
$db->insert($cliente, $telefone );
header('location: index.php');

