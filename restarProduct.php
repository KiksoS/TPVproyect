<?php 
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . "/php/autoloader.php";

$codProducto = $_POST['cod_producto'];
$codTicket = $_POST['cod_ticket'];

$repository = new TicketRepository;


$repository->restarProduct($codProducto, $codTicket);

header("Location: index.php");
exit();
