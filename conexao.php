<?php
try {
    $pdo = new PDO(
        "mysql:host=localhost;port=3307;dbname=cardapio;charset=utf8mb4",
        "root",
        ""
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>