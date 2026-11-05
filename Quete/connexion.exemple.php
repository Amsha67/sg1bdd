<?php

// Remplacer par les bonnes valeurs

$pdo = new PDO(
    'mysql:host=localhost;port=3306;dbname=nom_base;charset=utf8mb4',
    'utilisateur',
    'mot_de_passe',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);
