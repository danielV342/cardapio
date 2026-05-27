<?php

try {

    $pdo = new PDO(
        "mysql:host=127.0.0.1;port=3306;dbname=cardapio;charset=utf8mb4",
        "root",
        ""
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexão realizada com sucesso!";

} catch (PDOException $e) {


}