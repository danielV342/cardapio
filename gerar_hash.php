<?php
// Altere a senha dentro das aspas para a desejada
$senha = '1234';
echo password_hash($senha, PASSWORD_DEFAULT);
?>