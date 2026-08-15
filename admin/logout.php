<?php
// clientes/Relpps-Cosméticos/site/admin/logout.php
require_once __DIR__ . '/../includes/auth.php';
$_SESSION = [];
session_destroy();
header('Location: login.php');
exit;
