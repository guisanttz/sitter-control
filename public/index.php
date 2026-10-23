<?php
// Redireciona automaticamente para a raiz mantendo a query string caso o usuário acesse /public/
$queryString = !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '';
header('Location: ../index.php' . $queryString, true, 301);
exit;
